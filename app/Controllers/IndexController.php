<?php

namespace Com\Daw2\Controllers;

class IndexController extends \Com\Daw2\Core\BaseController {

    public function index() {
        $data = [];
        $data['seccion'] = '/';
        $modelo = new \Com\Daw2\Models\HabitacionesModel();
        $data['habitaciones'] = $modelo->getAll();
        if (isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            unset($_SESSION['mensaje']);
        }
        $this->view->showViews(array('templates/header.view.php', 'index.view.php', 'templates/footer.view.php'), $data);
    }

    public function restaurante() {
        $data = [];
        $data['seccion'] = '/restaurante';
        $this->view->showViews(array('templates/header.view.php', 'restaurante.view.php', 'templates/footer.view.php'), $data);
    }

    public function contacto() {
        $data = [];

        if (isset($_GET['nombre'])) {
            $_SESSION['mensaje'] = array(
                'class' => 'success',
                'texto' => 'Se ha enviado correctamente!'
            );
            unset($_GET['nombre']);
            header('Location: /contacto');
            exit;
        }

        if (isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            unset($_SESSION['mensaje']);
        }

        $data['seccion'] = '/contacto';
        $this->view->showViews(array('templates/header.view.php', 'contacto.view.php', 'templates/footer.view.php'), $data);
    }

}
