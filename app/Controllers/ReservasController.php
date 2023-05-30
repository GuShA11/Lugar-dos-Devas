<?php

namespace Com\Daw2\Controllers;

class ReservasController extends \Com\Daw2\Core\BaseController {

    public function showForm() {
        $data = [];
        $data['seccion'] = '/reservas';
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
        $data['errores'] = $this->checkFormAdd($_POST, $arrHabitaciones);
        if (count($data['errores']) === 0) {
            $result = $reservasModel->add($_POST['email'], $_POST['nombre'], $_POST['fecha-llegada'], $_POST['fecha-salida'], $_POST['habitacion']);
            if ($result == 1) {
                header('Location: /index');
                exit;
            } else if ($result == 0) {
                header('Location: /reservas');
                exit;
            } else {
                header('Location: methodNotAllowed');
                exit;
            }
        } else {
            $_POST['tesst'] = 'etst';
            $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data['errores'] = $errores;
            $data['habitacionesAvailable'] = $reservasModel->checkHabitacionesAvailable($_POST['fecha-llegada'], $_POST['fecha-salida']);
            $this->view->showViews(array('templates/header.view.php', 'reservasAdd.view.php', 'templates/footer.view.php'), $data);
        }
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
        if (isset(($post['habitacion']))) {
            if (($post['habitacion']) < 1) {
                if (!(in_array($post['habitacion'], $rooms))) {
                    $errores['habitacion'] = "Por favor seleccione una habitacion";
                }
            }
        } else {
            $errores['habitacion'] = "Por favor seleccione una habitacion";
        }
        return $errores;
    }

    public function checkAvailability() {
        $data = [];
        $data['seccion'] = '/reservas';
        $data['errores'] = $this->checkFecha($_POST);
        $reservasModel = new \Com\Daw2\Models\ReservasModel();
        if (count($data['errores']) === 0) {
            $data['habitacionesAvailable'] = $reservasModel->checkHabitacionesAvailable($_POST['fecha-llegada'], $_POST['fecha-salida']);
            $data['fecha-llegada'] = $_POST['fecha-llegada'];
            $data['llegada'] = $_POST['fecha-salida'];
            var_dump(count($data['habitacionesAvailable']));
            var_dump(count($data['habitacionesAvailable']));
            var_dump(count($data['habitacionesAvailable']));
            var_dump(count($data['habitacionesAvailable']));
            var_dump(count($data['habitacionesAvailable']));
            if (count($data['habitacionesAvailable']) === 0) {
                $errores['fecha'] = 'No existen habitaciones para esas fechas lo sentimos, contacte con nosotros para mas informacion';
                $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
                $data['errores'] = $errores;
                $this->view->showViews(array('templates/header.view.php', 'reservas.view.php', 'templates/footer.view.php'), $data);
            } else {
                if ((isset($_POST['email'])) || (isset($_POST['nombre'])) || (isset($_POST['habitacion']))) {
                    $habitaciones = $reservasModel->getHabitaciones();
                    foreach ($habitaciones as $habitacion) {
                        $arrHabitaciones[] = $habitacion['id_habitacion'];
                    }
                    $data['errores'] = $this->checkFormAdd($_POST, $arrHabitaciones);
                if (count($data['errores']) === 0) {
                    $result = $reservasModel->add($_POST['email'], $_POST['nombre'], $_POST['fecha-llegada'], $_POST['fecha-salida'], $_POST['habitacion']);
                    if ($result == 1) {
                        $data=[];
                        $data['reservaCreada'] = true;
                        $this->view->showViews(array('templates/header.view.php', 'index.view.php', 'templates/footer.view.php'), $data);
                        exit;
                        exit;
                    } else if ($result == 0) {
                        header('Location: /reservas');
                        exit;
                    } else {
                        header('Location: methodNotAllowed');
                        exit;
                    }
                }
                else {
                    $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
                    $this->view->showViews(array('templates/header.view.php', 'reservasAdd.view.php', 'templates/footer.view.php'), $data);
                }
                } else {
                    $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
                    $this->view->showViews(array('templates/header.view.php', 'reservasAdd.view.php', 'templates/footer.view.php'), $data);
                }
            }
        } else {
            $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $this->view->showViews(array('templates/header.view.php', 'reservas.view.php', 'templates/footer.view.php'), $data);
        }
    }

    private function checkFecha($post): array {
        $errores = [];
        $arrivalDate = $post['fecha-llegada'];
        $departureDate = $post['fecha-salida'];
        $arrivalTimestamp = strtotime($arrivalDate);
        $departureTimestamp = strtotime($departureDate);
        $currentDate = strtotime('today');

        if (empty($arrivalDate) || empty($departureDate) || $arrivalDate == '' || $departureDate == '') {
            $errores['fecha'] = "Campo obligatorio";
        } elseif ($arrivalTimestamp >= $departureTimestamp) {
            $errores['fecha'] = "La fecha de la estadia es inválida, por favor elija una estadía válida.";
        } elseif ($arrivalTimestamp < $currentDate || $departureTimestamp < $currentDate) {
            $errores['fecha'] = "La fecha de la estadia es inválida, por favor elija una estadía válida.";
        } elseif ($arrivalTimestamp == $departureTimestamp && $departureTimestamp <= strtotime('tomorrow')) {
            $errores['fecha'] = "La fecha de la estadia es inválida, por favor elija una estadía válida.";
        } elseif ($arrivalDate === $departureDate) {
            $errores['fecha'] = "La fecha de llegada no puede ser la misma que la de salida.";
        }

        return $errores;
    }

}
