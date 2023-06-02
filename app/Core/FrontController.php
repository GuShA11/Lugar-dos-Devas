<?php

namespace Com\Daw2\Core;

use Steampixel\Route;

class FrontController {

    static function main() {
        session_start();
        //si no hay session es porque eres un usario default y ves index reservas restaurantes contacto login
        if (!isset($_SESSION['usuario'])) {

            //login GET
            Route::add(
                    '/login',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\UsuarioSistemaController();
                        $controlador->login();
                    },
                    'get'
            );

            //login POST
            Route::add(
                    '/login',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\UsuarioSistemaController();
                        $controlador->loginProcess();
                    },
                    'post'
            );

            //index
            Route::add(
                    '/',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\IndexController();
                        $controlador->index();
                    },
                    'get'
            );

            //showReserva escoger fechas
            Route::add(
                    '/reservas',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\ReservasController();
                        $controlador->showForm();
                    },
                    'get'
            );
            //showReserva enseñar formulario para la reserva
            Route::add(
                    '/reservas',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\ReservasController();
                        $controlador->checkAvailability();
                    },
                    'post'
            );
            //reservas add cuando se pudo añadir
            Route::add(
                    '/reservas/add',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\ReservasController();
                        $controlador->add();
                    },
                    'post'
            );
            //restaurante
            Route::add(
                    '/restaurante',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\IndexController();
                        $controlador->restaurante();
                    },
                    'get'
            );
            //contacto
            Route::add(
                    '/contacto',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\IndexController();
                        $controlador->contacto();
                    },
                    'get'
            );

            //si hay session es porque eres admin y solo vas a ver lo de admin y borrarSession
        } else {

            //usuariosAdmin
            //permisos ver
            Route::add(
                    '/usuariosAdmin',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\UsuarioSistemaController();
                        $controlador->mostrarTodos();
                    },
                    'get'
            );

            //permisos borrar
            Route::add('/usuariosAdmin/delete/([A-Za-z0-9]+)',
                    function ($id) {
                        $controlador = new \Com\Daw2\Controllers\UsuarioSistemaController();
                        $controlador->delete($id);
                    }
                    , 'get');

            Route::add('/usuariosAdmin/baja/([A-Za-z0-9]+)',
                    function ($id) {
                        $controlador = new \Com\Daw2\Controllers\UsuarioSistemaController();
                        $controlador->baja($id);
                    }
                    , 'get');

            //permisos escritura
            Route::add('/usuariosAdmin/edit/([A-Za-z0-9]+)',
                    function ($id) {
                        $controlador = new \Com\Daw2\Controllers\UsuarioSistemaController();
                        $controlador->mostrarEdit($id);
                    }
                    , 'get');

            Route::add('/usuariosAdmin/edit/([A-Za-z0-9]+)',
                    function ($id) {
                        $controlador = new \Com\Daw2\Controllers\UsuarioSistemaController();
                        $controlador->edit($id);
                    }
                    , 'post');

            Route::add('/usuariosAdmin/add',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\UsuarioSistemaController();
                        $controlador->mostrarAdd();
                    }
                    , 'get');

            Route::add('/usuariosAdmin/add',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\UsuarioSistemaController();
                        $controlador->add();
                    }
                    , 'post');

            //habitacionesAdmin
            Route::add(
                    '/habitacionesAdmin',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\IndexController();
                        $controlador->habitaciones();
                    },
                    'get'
            );

            //reservasAdmin
            Route::add(
                    '/reservasAdmin',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\IndexController();
                        $controlador->reservas();
                    },
                    'get'
            );
            //borrarSession
            Route::add('/session/borrar',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\SessionController();
                        $controlador->borrarVariableSession();
                    }
                    , 'get');
        }
        //rutas para los dos
        //path not found error404
        Route::pathNotFound(
                function () {
                    $controller = new \Com\Daw2\Controllers\ErroresController();
                    $controller->error404();
                }
        );
        Route::run();
    }

}
