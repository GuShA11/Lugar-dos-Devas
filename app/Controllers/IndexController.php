<?php

namespace Com\Daw2\Controllers;

class IndexController extends \Com\Daw2\Core\BaseController {

    public function index() {
        $data = [];
        $data['seccion'] = '/index';
        $this->view->showViews(array('templates/header.view.php', 'index.view.php', 'templates/footer.view.php'), $data);
    }

    public function reservas() {
        $data = [];
        $data['seccion'] = '/reservas/admin';
        $this->view->showViews(array('templates/header.view.php', 'reservasAdmin.view.php', 'templates/footer.view.php'), $data);
    }

    public function habitaciones() {
        $data = [];
        $data['seccion'] = '/habitaciones/admin';
        $this->view->showViews(array('templates/header.view.php', 'habitacionesAdmin.view.php', 'templates/footer.view.php'), $data);
    }

    public function usuarios() {
        $data = [];
        $data['seccion'] = '/usuarios/admin';
        $this->view->showViews(array('templates/header.view.php', 'usuariosAdmin.view.php', 'templates/footer.view.php'), $data);
    }

    public function restaurante() {
        $data = [];
        $data['seccion'] = '/restaurante';
        $this->view->showViews(array('templates/header.view.php', 'restaurante.view.php', 'templates/footer.view.php'), $data);
    }

    public function contacto() {
        $data = [];
        $data['seccion'] = '/contacto';
        $this->view->showViews(array('templates/header.view.php', 'contacto.view.php', 'templates/footer.view.php'), $data);
    }

}
