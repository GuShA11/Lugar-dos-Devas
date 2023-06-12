<?php

namespace Com\Daw2\Controllers;

class ReservasController extends \Com\Daw2\Core\BaseController {

    //showForm usuario
    public function showForm() {
        $data = [];
        $data['seccion'] = '/reservas';
        if (isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            unset($_SESSION['mensaje']);
        }
        $this->view->showViews(array('templates/header.view.php', 'show.reservasAdmin.view.php', 'templates/footer.view.php'), $data);
    }

    public function add(bool $esAdmin) {
        $data = [];
        if ($esAdmin) {
            $data['seccion'] = '/reservasAdmin';
        } else {
            $data['seccion'] = '/reservas';
        }

        $data['errores'] = $this->checkFecha($_POST);
        $reservasModel = new \Com\Daw2\Models\ReservasModel();
        if (count($data['errores']) === 0) {
            $data['habitacionesAvailable'] = $reservasModel->checkHabitacionesAvailable($_POST['fecha-llegada'], $_POST['fecha-salida']);
            $data['fecha-llegada'] = $_POST['fecha-llegada'];
            $data['llegada'] = $_POST['fecha-salida'];
            if (count($data['habitacionesAvailable']) === 0) {
                $errores['fecha'] = 'No existen habitaciones para esas fechas lo sentimos, contacte con nosotros para mas informacion';
                $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
                $data['errores'] = $errores;
                $this->view->showViews(array('templates/header.view.php', 'show.reservasAdmin.view.php', 'templates/footer.view.php'), $data);
            } else {
                if ((isset($_POST['email'])) || (isset($_POST['nombre'])) || (isset($_POST['habitacion']))) {
                    $modelo = new \Com\Daw2\Models\HabitacionesModel();
                    $habitaciones = $modelo->getAll();
                    foreach ($habitaciones as $habitacion) {
                        $arrHabitaciones[] = $habitacion['id_habitacion'];
                    }
                    $data['errores'] = $this->checkFormAdd($_POST, $arrHabitaciones);
                    if (count($data['errores']) === 0) {
                        $result = $reservasModel->add($_POST['email'], $_POST['nombre'], $_POST['fecha-llegada'], $_POST['fecha-salida'], $_POST['habitacion']);
                        if ($result == 1) {
                            $data = [];
                            $_SESSION['mensaje'] = array(
                                'class' => 'success',
                                'texto' => 'Se ha creado la reserva correctamente!'
                            );
                            if ($esAdmin) {
                                $modelo = new \Com\Daw2\Models\ReservasModel();
                                $data['reservas'] = $modelo->getAll();
                                header('Location: /reservasAdmin');
                            } else {
                                header('Location: /');
                            }
                            exit;
                        } else if ($result == 0) {
                            if ($esAdmin) {
                                header('Location: /reservasAdmin');
                            } else {
                                header('Location: /reservas');
                            }
                            exit;
                        } else {
                            header('Location: methodNotAllowed');
                            exit;
                        }
                    } else {
                        $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
                        $this->view->showViews(array('templates/header.view.php', 'add.reservasAdmin.view.php', 'templates/footer.view.php'), $data);
                    }
                } else {
                    $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
                    $this->view->showViews(array('templates/header.view.php', 'add.reservasAdmin.view.php', 'templates/footer.view.php'), $data);
                }
            }
        } else {
            $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $this->view->showViews(array('templates/header.view.php', 'show.reservasAdmin.view.php', 'templates/footer.view.php'), $data);
        }
    }

    function checkFormAdd(array $post, array $rooms): array {
        $errores = [];
        if (empty($post['nombre'])) {
            $errores['nombre'] = "Campo obligatorio";
        } else if (!preg_match("/^[a-zA-Z\s]+$/", $post['nombre'])) {
            $errores['nombre'] = "El nombre debe estar compuesto solo de letras sin espacios o caracteres especiales.";
        }
        if (empty($post['email'])) {
            $errores['email'] = "Campo obligatorio";
        } else if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
            $errores['email'] = "El email debe cumplir el formato de un email normal \"ejemplo@gmail.com\"";
        }
        if (isset(($post['habitacion']))) {
            if (($post['habitacion']) < 1) {
                if (!(in_array($post['habitacion'], $rooms))) {
                    $errores['habitacion'] = "Por favor seleccione una habitacion";
                }
            }
        } else {
            $errores['habitacion'] = "Por favor seleccione una habitacion";
        }
        return $errores;
    }

    private function checkFecha($post): array {
        $errores = [];
        $arrivalDate = $post['fecha-llegada'];
        $departureDate = $post['fecha-salida'];
        $arrivalTimestamp = strtotime($arrivalDate);
        $departureTimestamp = strtotime($departureDate);
        $currentDate = strtotime('today');

        if (empty($arrivalDate) || empty($departureDate) || $arrivalDate == '' || $departureDate == '') {
            $errores['fecha'] = "Campo obligatorio";
        } elseif ($arrivalTimestamp >= $departureTimestamp) {
            $errores['fecha'] = "La fecha de la estadia es inválida, por favor elija una estadía válida.";
        } elseif ($arrivalTimestamp < $currentDate || $departureTimestamp < $currentDate) {
            $errores['fecha'] = "La fecha de la estadia es inválida, por favor elija una estadía válida.";
        } elseif ($arrivalTimestamp == $departureTimestamp && $departureTimestamp <= strtotime('tomorrow')) {
            $errores['fecha'] = "La fecha de la estadia es inválida, por favor elija una estadía válida.";
        } elseif ($arrivalDate === $departureDate) {
            $errores['fecha'] = "La fecha de llegada no puede ser la misma que la de salida.";
        }
        return $errores;
    }

    //parte admin
    function mostrarTodos() {
        $data = [];
        $data['titulo'] = 'Todos los usuarios del sistema';
        $data['seccion'] = '/reservasAdmin';

        $modelo = new \Com\Daw2\Models\ReservasModel();
        $data['reservas'] = $modelo->getAll();

        if (isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            unset($_SESSION['mensaje']);
        }
        $this->view->showViews(array('templates/header.view.php', 'reservasAdmin.view.php', 'templates/footer.view.php'), $data);
    }

    function mostrarAdd() {
        $data = [];
        $data['titulo'] = 'Nueva reserva del sistema';
        $data['tituloDiv'] = "Alta reserva";
        $data['seccion'] = '/reservasAdmin/add';
        $this->view->showViews(array('templates/header.view.php', 'show.reservasAdmin.view.php', 'templates/footer.view.php'), $data);
    }

    function delete(string $id) {
        $modelo = new \Com\Daw2\Models\ReservasModel();
        $result = $modelo->delete($id);
        if ($result) {
            $_SESSION['mensaje'] = array(
                'class' => 'success',
                'texto' => 'Se ha borrado la reserva correctamente!'
            );
            header('Location: /reservasAdmin');
        } else {
            $_SESSION['mensaje'] = array(
                'class' => 'warning',
                'texto' => 'Error indeterminado al borrar.'
            );
            header('Location: /reservasAdmin');
        }
    }

    function mostrarEdit($id) {
        $data = [];
        $modelo = new \Com\Daw2\Models\ReservasModel();
        $reserva = $modelo->loadReserva($id);
        $data['titulo'] = 'Reserva con ID: ' . $id;
        $data['tituloDiv'] = "Editando $id";
        $data['seccion'] = '/reservasAdmin/edit/' . $id;

        $data['input'] = $reserva;

        $this->view->showViews(array('templates/header.view.php', 'edit.reservasAdmin.view.php', 'templates/footer.view.php'), $data);
    }

    function edit(int $id): void {
        $errores = $this->checkFormEdit($_POST);
        if (count($errores) == 0) {
            $modelo = new \Com\Daw2\Models\ReservasModel();
            if ($modelo->update($_POST, $id)) {
                $_SESSION['mensaje'] = array(
                    'class' => 'success',
                    'texto' => 'Se ha actualizado la reserva correctamente!'
                );
                header('location: /reservasAdmin');
            } else {
                $data = [];
                $input = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
                $data['titulo'] = 'Reserva con ID: ' . $id;
                $data['tituloDiv'] = "Editando $id";
                $data['seccion'] = '/reservasAdmin/edit/' . $id;
                $data['input'] = $input;
                $_SESSION['mensaje'] = array('texto' => 'Ha ocurrido un error a la hora de editar la reserva!');

                $this->view->showViews(array('templates/header.view.php', 'edit.reservasAdmin.view.php', 'templates/footer.view.php'), $data);
            }
        } else {
            $data = [];
            $input = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data['titulo'] = 'Reserva con ID: ' . $id;
            $data['tituloDiv'] = "Editando $id";
            $data['seccion'] = '/reservasAdmin/edit/' . $id;
            $data['input'] = $input;
            $data['errores'] = $errores;

            $this->view->showViews(array('templates/header.view.php', 'edit.reservasAdmin.view.php', 'templates/footer.view.php'), $data);
        }
    }

    function checkFormEdit(array $post): array {
        $errores = [];
        if (empty($post['nombre'])) {
            $errores['nombre'] = "Campo obligatorio";
        } else if (!preg_match("/^[a-zA-Z\s]+$/", $post['nombre'])) {
            $errores['nombre'] = "El nombre debe estar compuesto solo de letras sin espacios o caracteres especiales.";
        }
        if (empty($post['email'])) {
            $errores['email'] = "Campo obligatorio";
        } else if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
            $errores['email'] = "El email debe cumplir el formato de un email normal \"ejemplo@gmail.com\"";
        }
        return $errores;
    }

}
