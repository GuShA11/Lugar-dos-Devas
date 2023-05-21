<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

class UsuarioSistemaController extends \Com\Daw2\Core\BaseController {

    const ADMINISTRADOR = 1;
    const AUDITOR = 2;
    
    public function login() {
        $modelo = new \Com\Daw2\Models\UsuarioSistemaModel();
        $data['productos'] = $modelo->getHabitaciones();
        var_dump($data);
        $this->view->show('login.view.php');
    }

    public function loginProcess() {
        $usuarioSistemaModel = new \Com\Daw2\Models\UsuarioSistemaModel();
        $user = $usuarioSistemaModel->login($_POST['email'], $_POST['pass']);
        $_vars = [];
        if (is_null($user)) {
            $_vars['loginError'] = 'Datos de acceso incorrectos';
            $this->view->show('login.view.php', $_vars);
        } else {            
            $_SESSION['usuario'] = $user;            
            $_SESSION['permisos'] = $this->getPermisos($user['id_rol']);
            $usuarioSistemaModel->updateLoginData($user['id_usuario']);
            $data = [];
            $data['titulo'] = 'Bienvenido '.$_SESSION['usuario']['nombre'];
            $data['seccion'] = '/';
            $this->view->showViews(array('templates/header.view.php', 'index.view.php', 'templates/footer.view.php'), $data);
        }
        
    }
    
    private function getPermisos(int $idRol) : array{
        $permisos = array(
                'reservas' => '',
                'usuarios_sistema' => '');
        
        if(self::ADMINISTRADOR == $idRol){
            $permisos['reservas'] = 'rwd';
            $permisos['usuarios_sistema'] = 'rwd';
        }
        else if(self::AUDITOR == $idRol){
            $permisos['reservas'] = 'r';
            $permisos['usuarios_sistema'] = 'r';
        }
        return $permisos;
    }
}
