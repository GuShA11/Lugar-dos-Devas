<?php

namespace Com\Daw2\Controllers;

class ReservasController extends \Com\Daw2\Core\BaseController {

    public function showForm() {
        $data = [];
        $data['seccion'] = '/reservas';
        $reservasModel = new \Com\Daw2\Models\ReservasModel();
        $data['habitaciones'] = $reservasModel->getHabitaciones();
        $this->view->showViews(array('templates/header.view.php', 'reservas.view.php', 'templates/footer.view.php'), $data);
    }
    
    function add(): void {
        $data = [];
        $data['seccion'] = '/reservas';
        $reservasModel = new \Com\Daw2\Models\ReservasModel();
        $habitaciones = $reservasModel->getHabitaciones();
        foreach ($habitaciones as $habitacion) {
            $arrHabitaciones[] = $habitacion['id_habitacion'];
        }
        $errores = $this->checkFormAdd($_POST, $arrHabitaciones);

        if (count($errores) === 0) {
            $result = $reservasModel->add($_POST['email'], $_POST['nombre'], $_POST['fecha-llegada'], $_POST['fecha-salida'], $_POST['habitacion']);
            if ($result == 1) {
                header('Location: /');
                exit;
            } else if ($result == 0) {
                header('Location: /reservas');
                exit;
            } else {
                header('Location: methodNotAllowed');
                exit;
            }
        }

        $data['input'] = $_POST;
        $data['errores'] = $errores;
        $data['habitaciones'] = $habitaciones;
        $this->view->showViews(array('templates/header.view.php', 'reservasAdd.view.php', 'templates/footer.view.php'), $data);
    }

    function checkFormAdd(array $post, array $rooms): array {
        $errores = [];
        if (empty($post['nombre'])) {
            $errores['nombre'] = "Campo obligatorio";
        } else if (!preg_match("/^[a-zA-Z\s]+$/", $post['nombre'])) {
            $errores['nombre'] = "El nombre debe estar compuesto solo de letras sin espacios o caracteres especiales.";
        }
        if (empty($post['email'])) {
            $errores['email'] = "Campo obligatorio";
        } else if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
            $errores['email'] = "El email debe cumplir el formato de un email normal \"ejemplo@gmail.com\"";
        }
        if (($post['habitacion']) < 1) {
            if (!(in_array($post['habitacion'], $rooms))) {
                $errores['habitacion'] = "Por favor seleccione una habitacion";
            }
        }
        return $errores;
    }

    public function checkAvailability() {
        $errores = [];
        $arrivalDate = $_POST['fecha-llegada'];
        $departureDate = $_POST['fecha-salida'];
        $arrivalTimestamp = strtotime($arrivalDate);
        $departureTimestamp = strtotime($departureDate);
        $currentTimestamp = time();
        if (empty($arrivalDate) || empty($departureDate)) {
            $errores['fecha'] = "Campo obligatorio";
        } else if (($arrivalDate == '') || ($departureDate == '')) {
            $errores['fecha'] = "Campo obligatorio";
        } else if ($arrivalTimestamp >= $departureTimestamp) {
            $errores['fecha'] = "La fecha de la estadia es invalida, por favor elija una estadia válida1";
        } else if ($arrivalTimestamp < $currentTimestamp || $departureTimestamp < $currentTimestamp) {
            $errores['fecha'] = "La fecha de la estadia es invalida, por favor elija una estadia válida2";
        } else if ($arrivalTimestamp > $departureTimestamp) {
            $errores['fecha'] = "La fecha de la estadia es invalida, por favor elija una estadia válida3";
        } else if ($arrivalTimestamp == $departureTimestamp && $departureTimestamp <= strtotime('tomorrow')) {
            $errores['fecha'] = "La fecha de la estadia es invalida, por favor elija una estadia válida4";
        } else if ($arrivalDate === $departureDate) {
            $errores['fecha'] = "La fecha de llegada no puede ser la misma que la de salida";
        }

        $data = [];
        $reservasModel = new \Com\Daw2\Models\ReservasModel();
        if (count($errores) === 0) {
            $data['habitacionesAvailable'] = $reservasModel->checkHabitacionesAvailable($_POST['fecha-llegada'], $_POST['fecha-salida']);
            $data['fecha-llegada'] = $_POST['fecha-llegada'];
            $data['llegada'] = $_POST['fecha-salida'];
            if (count($data['habitacionesAvailable']) === 0) {
                $errores['fecha'] = 'No existen habitaciones para esas fechas lo sentimos, contacte con nosotros para mas informacion';
                $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
                $data['errores'] = $errores;
                $this->view->showViews(array('templates/header.view.php', 'reservas.view.php', 'templates/footer.view.php'), $data);
            } else {

                $this->view->showViews(array('templates/header.view.php', 'reservasAdd.view.php', 'templates/footer.view.php'), $data);
            }
        } else {
            $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data['errores'] = $errores;
            $this->view->showViews(array('templates/header.view.php', 'reservas.view.php', 'templates/footer.view.php'), $data);
        }
    }

}
