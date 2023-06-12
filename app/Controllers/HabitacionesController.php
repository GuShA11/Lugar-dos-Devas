<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

class HabitacionesController extends \Com\Daw2\Core\BaseController {

    function mostrarTodos() {
        $data = [];
        $data['titulo'] = 'Todos los usuarios del sistema';
        $data['seccion'] = '/habitacionesAdmin';
        $modelo = new \Com\Daw2\Models\HabitacionesModel();
        $data['habitaciones'] = $modelo->getAll();

        if (isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            unset($_SESSION['mensaje']);
        }

        $this->view->showViews(array('templates/header.view.php', 'habitacionesAdmin.view.php', 'templates/footer.view.php'), $data);
    }

    function delete(string $id) {
        $modeloReservas = new \Com\Daw2\Models\ReservasModel();
        $numeroReservas = $modeloReservas->hasReservas($id);
        var_dump($numeroReservas);
        if ($numeroReservas == 0) {
            $modelo = new \Com\Daw2\Models\HabitacionesModel();
            $result = $modelo->delete($id);
            if ($result) {
                $_SESSION['mensaje'] = array(
                    'class' => 'success',
                    'texto' => 'Se ha borrado correctamente!'
                );
                header('Location: /habitacionesAdmin');
            } else {
                $_SESSION['mensaje'] = array(
                    'class' => 'warning',
                    'texto' => 'Error indeterminado al guardar.'
                );
                header('Location: /habitacionesAdmin');
            }
        } else {
            $_SESSION['mensaje'] = array(
                'class' => 'danger',
                'texto' => 'No se puede borrar la habitación, primero borre las reservas pendientes de esa habitacion'
            );
            header('Location: /habitacionesAdmin');
        }
    }

    function mostrarAdd() {
        $data = [];
        $data['titulo'] = 'Nuevo Habitacion del sistema';
        $data['tituloDiv'] = "Alta Habitacion";
        $data['seccion'] = '/habitacionesAdmin/add';
        $this->view->showViews(array('templates/header.view.php', 'edit.habitacionesAdmin.view.php', 'templates/footer.view.php'), $data);
    }

    public function add(): void {
        $errores = $this->checkForm($_POST);
        if (count($errores) == 0) {
            $modelo = new \Com\Daw2\Models\HabitacionesModel();
            $src_array = $modelo->getSources();
            if ($modelo->add($_POST, $_FILES['src']['name'])) {
                if (!in_array($_FILES['src']['name'], $src_array)) {

                    $target_file = 'assets/img/' . ($_FILES['src']['name']);

                    if ($_FILES['src']['error'] == 0) {
                        move_uploaded_file($_FILES["src"]["tmp_name"], $target_file);
                    }
                }
                $_SESSION['mensaje'] = array(
                    'class' => 'success',
                    'texto' => 'Se ha creado la habitación correctamente!'
                );
                header('location: /habitacionesAdmin');
            } else {
                $data = [];
                $input = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
                $data['titulo'] = 'Alta habitacion';
                $data['tituloDiv'] = "Alta habitacion";
                $data['seccion'] = '/habitacionesAdmin/add';
                $data['input'] = $input;
                $data['errores'] = ['nombre' => 'Error indeterminado al guardar'];

                $this->view->showViews(array('templates/header.view.php', 'edit.habitacionesAdmin.view.php', 'templates/footer.view.php'), $data);
            }
        } else {
            $data = [];
            $input = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data['titulo'] = 'Alta habitacion';
            $data['tituloDiv'] = "Alta habitacion";
            $rolesModel = new \Com\Daw2\Models\AuxRolModel();
            $data['roles'] = $rolesModel->getAll();
            $data['seccion'] = '/habitacionesAdmin/add';
            $data['input'] = $input;
            $data['errores'] = $errores;

            $this->view->showViews(array('templates/header.view.php', 'edit.habitacionesAdmin.view.php', 'templates/footer.view.php'), $data);
        }
    }

    function mostrarEdit($id) {
        $data = [];
        $modelo = new \Com\Daw2\Models\HabitacionesModel();
        $habitacion = $modelo->loadHabitacion($id);
        $data['titulo'] = 'Habitacion ' . $habitacion['nombre_habitacion'] . ' con ID: ' . $id;
        $data['tituloDiv'] = 'Editando ' . $habitacion['nombre_habitacion'] . '';
        $data['seccion'] = '/habitacionesAdmin/edit/' . $id;

        $data['input'] = $habitacion;
        $data['input']['src'] = '/assets/img/' . $data['input']['src'];
        $this->view->showViews(array('templates/header.view.php', 'edit.habitacionesAdmin.view.php', 'templates/footer.view.php'), $data);
    }

    function edit(int $id): void {
        $errores = $this->checkForm($_POST, $id);
        $modelo = new \Com\Daw2\Models\HabitacionesModel();
        $habitacion = $modelo->loadHabitacion($id);
        if (count($errores) == 0) {
            $src_array = $modelo->getSources();
            if (isset($_POST['foto'])) {//en el caso de ya tener foto el valor es 
                $_FILES['src']['name'] = substr($_POST['foto'], 12);
            }
            if ($modelo->update($_POST, $_FILES['src']['name'], $id)) {
                if (!in_array($_FILES['src']['name'], $src_array)) {
                    $target_file = 'assets/img/' . ($_FILES['src']['name']);
                    if ($_FILES['src']['error'] == 0) {
                        move_uploaded_file($_FILES["src"]["tmp_name"], $target_file);
                    }
                }
                $_SESSION['mensaje'] = array(
                    'class' => 'success',
                    'texto' => 'Se ha actualizado la habitación correctamente!'
                );
                header('location: /habitacionesAdmin');
            } else {
                $data = [];
                $input = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
                $data['titulo'] = 'Habitacion ' . $habitacion['nombre_habitacion'] . ' con ID: ' . $id;
                $data['seccion'] = '/habitacionesAdmin/edit/' . $id;
                $data['tituloDiv'] = 'Editando ' . $habitacion['nombre_habitacion'] . '';
                $data['input'] = $input;
                $data['errores'] = ['nombre' => 'Error indeterminado al guardar'];

                $this->view->showViews(array('templates/header.view.php', 'edit.habitacionesAdmin.view.php', 'templates/footer.view.php'), $data);
            }
        } else {
            $data = [];
            $input = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data['titulo'] = 'Habitacion ' . $habitacion['nombre_habitacion'] . ' con ID: ' . $id;
            $data['seccion'] = '/usuariosAdmin/edit/' . $id;
            $data['tituloDiv'] = 'Editando ' . $habitacion['nombre_habitacion'] . '';
            $data['input'] = $input;
            $data['errores'] = $errores;

            $this->view->showViews(array('templates/header.view.php', 'edit.habitacionesAdmin.view.php', 'templates/footer.view.php'), $data);
        }
    }

    private function checkForm(array $post, int $id = 0): array {
        $errores = [];
        if (empty($post['nombre_habitacion']) || $post['nombre_habitacion'] === '') {//regex not spaces allowed
            $errores['nombre_habitacion'] = "Campo obligatorio.";
        } else {
            $habitacionModel = new \Com\Daw2\Models\HabitacionesModel();
            if ($habitacionModel->countByNombreNotUser($post['nombre_habitacion'], $id)) {
                $errores['nombre_habitacion'] = 'El nombre seleccionado ya está en uso.';
            }
        }

        if (empty($post['precio_noche'])) {
            $errores['precio_noche'] = "Campo obligatorio.";
        } else if (!is_numeric($post['precio_noche'])) {
            $errores['precio_noche'] = "El campo debe ser un numero.";
        } else if ($post['precio_noche'] <= 0) {
            $errores['precio_noche'] = "El valor de precio noche debe ser mayor que 0";
        }

        if (empty($post['descripcion']) || $post['descripcion'] === '') {//regex de los espacios
            $errores['descripcion'] = "Campo obligatorio.";
        }
        if ($_FILES['src']['name'] != '') {
            if ($_FILES['src']["error"] == 0) {
                $allowedExtensions = ['jpg', 'png'];
                $extension = strtolower(pathinfo($_FILES['src']["name"], PATHINFO_EXTENSION));
                if (getimagesize($_FILES['src']["tmp_name"]) == false) {
                    $errores['src'] = "El archivo no es una imagen.";
                } else if ($_FILES['src']["size"] > 5000000) {
                    $errores['src'] = "No se permiten imagenes de mas de 5 MB.";
                } else if (!in_array($extension, $allowedExtensions)) {
                    $errores['src'] = "La extension $extension no esta permitida.";
                }
            }
        }
        return $errores;
    }

}
