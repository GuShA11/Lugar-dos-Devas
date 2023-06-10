<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class HabitacionesModel extends \Com\Daw2\Core\BaseModel {

    public function add($post, $files): bool {
        if ($files == '') {
            $post['src'] = 'default.png';
        } else {
            $post['src'] = $files;
        }
        $stmt = $this->pdo->prepare('INSERT INTO habitaciones (nombre_habitacion, precio_noche, src, descripcion) values (?,?,?,?)');
        $stmt->execute([$post['nombre_habitacion'], $post['precio_noche'], $post['src'], $post['descripcion']]);
        return true;
    }

    public function getAll() {
        $stmt = $this->pdo->query('SELECT * FROM habitaciones');
        return $stmt->fetchAll();
    }

    function loadHabitacion(string $id): array {
        $stmt = $this->pdo->prepare('SELECT * FROM habitaciones WHERE id_habitacion=?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    function size(): int {
        $stmt = $this->pdo->query('SELECT COUNT(*) as total FROM habitaciones');
        return $stmt->fetchColumn(0);
    }

    function delete(string $id): bool {
        $stmt = $this->pdo->prepare('DELETE FROM habitaciones WHERE id_habitacion=?');
        $stmt->execute([$id]);
        return ($stmt->rowCount() == 1);
    }

    function update(array $data, $files, int $id): bool {
        if ($files == '') {
            $data['src'] = 'default.png';
        } else {
            $data['src'] = $files;
        }
        $stmt = $this->pdo->prepare('UPDATE habitaciones SET nombre_habitacion=?, precio_noche=?, src=?, descripcion=? WHERE id_habitacion=?');
        return $stmt->execute([$data['nombre_habitacion'], $data['precio_noche'], $data['src'], $data['descripcion'], $id]);
    }

    function countByNombreNotUser(string $nombre, int $id_habitacion): int {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM habitaciones WHERE nombre_habitacion = ? AND id_habitacion != ?');
        $stmt->execute([$nombre, $id_habitacion]);
        return $stmt->fetchColumn(0);
    }

    public function getSources() {
        $src_query = $this->pdo->query('SELECT DISTINCT src FROM habitaciones');
        $src_array = $src_query->fetchAll();
        var_dump($src_array);
        $clean_src_array = [];
        if (count($src_array) > 0) {
            foreach ($src_array as $src['src']) {
                $clean_src_array[] = substr($src['src']['src'], 0, -4);
            }
        }
        return $clean_src_array;
    }

}
