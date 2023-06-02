<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

class UsuarioSistemaController extends \Com\Daw2\Core\BaseController {

    const ADMINISTRADOR = 1;
    const AUDITOR = 2;

    public function login() {
        $this->view->show('login.view.php');
    }

    public function loginProcess() {
        $usuarioSistemaModel = new \Com\Daw2\Models\UsuarioSistemaModel();
        $user = $usuarioSistemaModel->login($_POST['user'], $_POST['pass']);
        $_vars = [];
        if (is_null($user)) {
            $_vars['loginError'] = 'Datos de acceso incorrectos';
            $this->view->show('login.view.php', $_vars);
        } else {
            $_SESSION['usuario'] = $user;
            $_SESSION['permisos'] = $this->getPermisos($user['id_rol']);
            $data = [];
            $data['titulo'] = 'Bienvenido ' . $_SESSION['usuario']['nombre'];
            $data['seccion'] = '/usuariosAdmin';
            $modelo = new \Com\Daw2\Models\UsuarioSistemaModel();
            $data['usuarios_sistema'] = $modelo->getAll();
            $this->view->showViews(array('templates/header.view.php', 'usuariosAdmin.view.php', 'templates/footer.view.php'), $data);
        }
    }

    private function getPermisos(int $idRol): array {
        $permisos = array(
            'reservas' => '',
            'usuarios_sistema' => '');

        if (self::ADMINISTRADOR == $idRol) {
            $permisos['reservas'] = 'rwd';
            $permisos['usuarios_sistema'] = 'rwd';
        } else if (self::AUDITOR == $idRol) {
            $permisos['reservas'] = 'r';
            $permisos['usuarios_sistema'] = 'r';
        }
        return $permisos;
    }

    function mostrarTodos() {
        $data = [];
        $data['titulo'] = 'Todos los usuarios del sistema';
        $data['seccion'] = '/usuariosAdmin';

        $modelo = new \Com\Daw2\Models\UsuarioSistemaModel();
        $data['usuarios_sistema'] = $modelo->getAll();

        if (isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            unset($_SESSION['mensaje']);
        }

        $this->view->showViews(array('templates/header.view.php', 'usuariosAdmin.view.php', 'templates/footer.view.php'), $data);
    }

    function delete(string $id) {
        if ($_SESSION['usuario']['id_usuario'] == $id) {
            $_SESSION['mensaje'] = array(
                'class' => 'warning',
                'texto' => 'No está permitido eliminarse a uno mismo.'
            );
            header('Location: /usuariosAdmin');
        } else {
            $modelo = new \Com\Daw2\Models\UsuarioSistemaModel();
            $result = $modelo->delete($id);
            if ($result) {
                header('Location: /usuariosAdmin');
            } else {
                $_SESSION['mensaje'] = array(
                    'class' => 'warning',
                    'texto' => 'Error indeterminado al guardar.'
                );
                header('Location: /usuariosAdmin');
            }
        }
    }

    function baja(string $id) {
        if ($_SESSION['usuario']['id_usuario'] == $id) {
            $_SESSION['mensaje'] = array(
                'class' => 'warning',
                'texto' => 'No está permitido darse de baja a uno mismo.'
            );
            header('Location: /usuariosAdmin');
        } else {
            $modelo = new \Com\Daw2\Models\UsuarioSistemaModel();
            $result = $modelo->baja($id);
            if ($result) {
                header('Location: /usuariosAdmin');
            } else {
                $_SESSION['mensaje'] = array(
                    'class' => 'danger',
                    'text' => 'Error indeterminado al cambiar el estado.'
                );
            }
        }
    }

    function mostrarAdd() {
        $data = [];
        $data['titulo'] = 'Nuevo usuario del sistema';
        $data['tituloDiv'] = "Alta usuario";
        $data['seccion'] = '/usuariosAdmin/add';
        $modeloRol = new \Com\Daw2\Models\AuxRolModel();
        $data['roles'] = $modeloRol->getAll();
        $this->view->showViews(array('templates/header.view.php', 'edit.usuariosAdmin.view.php', 'templates/footer.view.php'), $data);
    }

    public function add(): void {
        $errores = $this->checkForm($_POST);
        if (count($errores) == 0) {
            $modelo = new \Com\Daw2\Models\UsuarioSistemaModel();
            if ($modelo->insert($_POST)) {
                header('location: /usuariosAdmin');
            } else {
                $data = [];
                $input = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
                $data['titulo'] = 'Alta usuario';
                $data['tituloDiv'] = "Alta usuario";
                $rolesModel = new \Com\Daw2\Models\AuxRolModel();
                $data['roles'] = $rolesModel->getAll();
                $data['seccion'] = '/usuariosAdmin/add';
                $data['input'] = $input;
                $data['errores'] = ['nombre' => 'Error indeterminado al guardar'];

                $this->view->showViews(array('templates/header.view.php', 'edit.usuariosAdmin.view.php', 'templates/footer.view.php'), $data);
            }
        } else {
            $data = [];
            $input = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data['titulo'] = 'Alta usuario';
            $data['tituloDiv'] = "Alta usuario";
            $rolesModel = new \Com\Daw2\Models\AuxRolModel();
            $data['roles'] = $rolesModel->getAll();
            $data['seccion'] = '/usuariosAdmin/add';
            $data['input'] = $input;
            $data['errores'] = $errores;

            $this->view->showViews(array('templates/header.view.php', 'edit.usuariosAdmin.view.php', 'templates/footer.view.php'), $data);
        }
    }

    function mostrarEdit($id) {
        $data = [];
        $modelo = new \Com\Daw2\Models\UsuarioSistemaModel();
        $user = $modelo->loadUsuario($id);
        $data['titulo'] = 'Usuario ' . $user['nombre'] . ' con ID: ' . $id;
        $data['tituloDiv'] = "Editando $user[nombre]";
        $rolesModel = new \Com\Daw2\Models\AuxRolModel();
        $data['roles'] = $rolesModel->getAll();
        $data['seccion'] = '/usuariosAdmin/edit/' . $id;

        $data['input'] = $user;

        $this->view->showViews(array('templates/header.view.php', 'edit.usuariosAdmin.view.php', 'templates/footer.view.php'), $data);
    }

    function edit(int $id): void {
        $errores = $this->checkForm($_POST, false, $id);
        if (count($errores) == 0) {
            $modelo = new \Com\Daw2\Models\UsuarioSistemaModel();
            if ($modelo->update($_POST, $id)) {
                if ($_POST['pass'] != '') {
                    $modelo->updatePass($id, $_POST['pass']);
                }
                header('location: /usuariosAdmin');
            } else {
                $data = [];
                $input = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
                $data['titulo'] = 'Usuario ' . $input['nombre'] . ' con ID: ' . $id;
                $rolesModel = new \Com\Daw2\Models\AuxRolModel();
                $data['roles'] = $rolesModel->getAll();
                $data['seccion'] = '/usuariosAdmin/edit/' . $id;
                $data['input'] = $input;
                $data['errores'] = ['nombre' => 'Error indeterminado al guardar'];

                $this->view->showViews(array('templates/header.view.php', 'edit.usuariosAdmin.view.php', 'templates/footer.view.php'), $data);
            }
        } else {
            $data = [];
            $input = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data['titulo'] = 'Usuario ' . $input['nombre'] . ' con ID: ' . $id;
            $rolesModel = new \Com\Daw2\Models\AuxRolModel();
            $data['roles'] = $rolesModel->getAll();
            $data['seccion'] = '/usuariosAdmin/edit/' . $id;
            $data['input'] = $input;
            $data['errores'] = $errores;

            $this->view->showViews(array('templates/header.view.php', 'edit.usuariosAdmin.view.php', 'templates/footer.view.php'), $data);
        }
    }

    function checkForm(array $post, bool $esAlta = true, int $id = 0): array {
        $errores = [];
        if (empty($post['nombre'])) {
            $errores['nombre'] = "Campo obligatorio";
        }

        if ($esAlta || $post['pass'] != '') {
            if (empty($post['pass'])) {
                $errores['pass'] = "Campo obligatorio";
            } else if (!preg_match('/.*[a-zA-Z0-9].*/', $post['pass'])) {
                $errores['pass'] = "El password debe estar compuesto por letras y numeros y una longitud mayor que 0";
            }
        }

        if (empty($post['user'])) {
            $errores['user'] = "Campo obligatorio";
        } else {
            $userModel = new \Com\Daw2\Models\UsuarioSistemaModel();
            if ($userModel->countByEmailNotUser($post['user'], $id) > 0) {
                $errores['user'] = 'El user seleccionado ya está en uso';
            }
        }

        if (empty($post['id_rol'])) {
            $errores['id_rol'] = "Campo obligatorio";
        } else if (!filter_var($post['id_rol'], FILTER_VALIDATE_INT)) {
            $errores['id_rol'] = 'Inserte un rol válido';
        } else {
            $rolModel = new \Com\Daw2\Models\AuxRolModel();
            $rol = $rolModel->loadRol((int) $post['id_rol']);
            if (is_null($rol)) {
                $errores['id_rol'] = 'Seleccione un rol válido';
            }
        }
        return $errores;
    }

}
