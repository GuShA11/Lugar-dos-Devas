<?php

namespace Com\Daw2\Controllers;

class SessionController extends \Com\Daw2\Core\BaseController {
      
    public function borrarVariableSession(){
        $_vars = array(
            'titulo' => 'Sesión Cerrada',
            'seccion' => '/session/borrar'
        );
        session_destroy();
        header('location: /');
    }
}
