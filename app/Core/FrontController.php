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
            //formulario reserva
            Route::add(
                    '/reservas',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\ReservasController();
                        $controlador->add(false);
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

            //si hay session eres admin o auditor
        } else {
            //permisos lectura
            if (strpos($_SESSION['permisos']['usuarios_sistema'], 'r') !== false) {
                //usuariosAdmin
                Route::add(
                        '/usuariosAdmin',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\UsuarioSistemaController();
                            $controlador->mostrarTodos();
                        },
                        'get'
                );
                //reservasAdmin
                Route::add(
                        '/reservasAdmin',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\ReservasController();
                            $controlador->mostrarTodos();
                        },
                        'get'
                );
                //habitacionesAdmin
                Route::add(
                        '/habitacionesAdmin',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\HabitacionesController();
                            $controlador->mostrarTodos();
                        },
                        'get'
                );
            }

            //permisos borrar
            if (strpos($_SESSION['permisos']['usuarios_sistema'], 'd') !== false) {
                //usuariosAdmin
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
                //reservasAdmin
                Route::add('/reservasAdmin/delete/([A-Za-z0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\ReservasController();
                            $controlador->delete($id);
                        }
                        , 'get');
                //habitacionesAdmin
                Route::add('/habitacionesAdmin/delete/([A-Za-z0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\HabitacionesController();
                            $controlador->delete($id);
                        }
                        , 'get');
            }
            //permisos escritura
            if (strpos($_SESSION['permisos']['usuarios_sistema'], 'w') !== false) {
                //usuariosAdmin
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
                //reservasAdmin
                Route::add('/reservasAdmin/edit/([A-Za-z0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\ReservasController();
                            $controlador->mostrarEdit($id);
                        }
                        , 'get');

                Route::add('/reservasAdmin/edit/([A-Za-z0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\ReservasController();
                            $controlador->edit($id);
                        }
                        , 'post');

                Route::add('/reservasAdmin/add',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\ReservasController();
                            $controlador->mostrarAdd();
                        }
                        , 'get');

                Route::add('/reservasAdmin/add',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\ReservasController();
                            $controlador->add(true);
                        }
                        , 'post');
                //habitacionesAdmin
                Route::add('/habitacionesAdmin/edit/([A-Za-z0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\HabitacionesController();
                            $controlador->mostrarEdit($id);
                        }
                        , 'get');

                Route::add('/habitacionesAdmin/edit/([A-Za-z0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\HabitacionesController();
                            $controlador->edit($id);
                        }
                        , 'post');

                Route::add('/habitacionesAdmin/add',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\HabitacionesController();
                            $controlador->mostrarAdd();
                        }
                        , 'get');

                Route::add('/habitacionesAdmin/add',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\HabitacionesController();
                            $controlador->add();
                        }
                        , 'post');
            }
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
