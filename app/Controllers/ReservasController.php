<?php

namespace Com\Daw2\Controllers;


class ReservasController extends \Com\Daw2\Core\BaseController {

    public function showForm() {
        $data = [];
        $data['seccion'] = '/reservas';
        $usuarioSistemaModel = new \Com\Daw2\Models\ReservasModel();
        $data['productos'] = $usuarioSistemaModel->getHabitaciones();
        var_dump($data);
        
        $this->view->showViews(array('templates/header.view.php', 'reservas.view.php', 'templates/footer.view.php'),$data);
    }

    function add(): void {
        $data = [];
        $data['seccion'] = '/reservas/add';
        $data['errores'] = $this->checkFormAdd($_POST);
        if (count($data['errores']) === 0) {
        $modelo = new \Com\Daw2\Models\ReservasModel();
           $result = $modelo->add($_POST['nombre'], $_POST['email'], $_POST['fecha-llegada'], $_POST['fecha-salida'], $_POST['habitacion']);

            if ($result == 1) {
                header('Location: /reservas');
            } else if ($result == 0) {
                header('Location: /reservas/cant_add');
            } else {
                header('location: methodNotAllowed');
            }
        } else {
            $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $this->view->showViews(array('templates/header.view.php', 'reservas.view.php', 'templates/footer.view.php'),$data);
        }
    }

    function cant_add() {
        $data = [];
        $data['seccion'] = '/reservas/cant_add';
        $this->view->showViews(array('templates/header.view.php', 'reservas.view.php', 'templates/footer.view.php'),$data);
    }
    function checkFormAdd(array $post): array {
        var_dump($post);
        $errores = [];
        if (empty($post['nombre'])) {
            $errores['nombre'] = "Campo obligatorio";
        } else if (!preg_match("/^[a-zA-Z]+$/", $post['nombre'])) {
            $errores['nombre'] = "El nombre debe estar compuesto solo de letras sin espacios o caracteres especiales.";
        }
        if (empty($post['email'])) {
            $errores['email'] = "Campo obligatorio";
        } else if (filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
            $errores['email'] = "El email debe cumplir el formato de un email normal \"ejemplo@gmail.com\"";
        }
        $arrivalDate = $post['fecha-llegada'];
        $departureDate = $post['fecha-salida'];
        if (empty($arrivalDate) || empty($departureDate)) {
            $errores['fecha'] = "Campo obligatorio";
        }else{
            $arrivalTimestamp = strtotime($arrivalDate);
            $departureTimestamp = strtotime($departureDate);
        
        if ($arrivalTimestamp >= $departureTimestamp) {
            $errores['fecha'] = "La fecha de la estadia es invalida, por favor elija una estadia válida";
        }

        } 

        return $errores;
    }

      function checkAvailability() {
        $data = [];
        $data['seccion'] = '/reservas';
        $this->view->showViews(array('templates/header.view.php', 'reservasAdmin.view.php', 'templates/footer.view.php'),$data);

      }
}
