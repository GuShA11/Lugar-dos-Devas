<?php

namespace Com\Daw2\Core;

use Steampixel\Route;

class FrontController
{

    static function main()
    {
        session_start();

        //login
        Route::add(
            '/login',
            function () {
                $controlador = new \Com\Daw2\Controllers\UsuarioSistemaController();
                $controlador->login();
            },
            'get'
        );
                    
        //login
        Route::add(
            '/login',
            function () {
                $controlador = new \Com\Daw2\Controllers\UsuarioSistemaController();
                $controlador->loginProcess();
            },
            'post'
        );

        //path not found
        Route::pathNotFound(
            function () {
                $controller = new \Com\Daw2\Controllers\ErroresController();
                $controller->error404();
            }
        );
        
        Route::add(
                '/',
                function () {
                    $controlador = new \Com\Daw2\Controllers\IndexController();
                    $controlador->index();
                },
                'get'
            );

        //reservas
        Route::add(
            '/reservas',
            function () {
                $controlador = new \Com\Daw2\Controllers\ReservasController();
                $controlador->showForm();
            },
            'get'
        );
          //reservas
          Route::add(
            '/reservas/add',
            function () {
                $controlador = new \Com\Daw2\Controllers\ReservasController();
                $controlador->add();
            },
            'post'
        );
          //reservas
          Route::add(
            '/reservas/admin',
            function () {
                $controlador = new \Com\Daw2\Controllers\ReservasController();
                $controlador->checkAvailability();
            },
            'get'
        );
        

        //si no hay session se ve el index y las de fuera, /login y pathnotFOund
        if (!isset($_SESSION['usuario'])) {
            Route::add(
                '/',
                function () {
                    $controlador = new \Com\Daw2\Controllers\IndexController();
                    $controlador->index();
                },
                'get'
            );

            //si hay session es que eres admin y ves cosas de admin + borrar session
        } else {
            Route::add('/session/borrar',
            function () {
                $controlador = new \Com\Daw2\Controllers\SessionController();
                $controlador->borrarVariableSession();
            }
            , 'get');
            Route::add(
                '/',
                function () {
                    $controlador = new \Com\Daw2\Controllers\IndexController();
                    $controlador->index();
                },
                'get'
            );
        }
        Route::run();
    }
}
