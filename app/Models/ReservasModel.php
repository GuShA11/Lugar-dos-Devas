<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class ReservasModel extends \Com\Daw2\Core\BaseModel {

    public function add(string $email, string $nombre, string $fecha_llegada, string $fecha_salida, int $habitacion): bool {
        $precio_noche_query = $this->pdo->prepare('SELECT precio_noche FROM habitaciones WHERE id_habitacion = ?');
        $precio_noche_query->execute([$habitacion]);
        $precio_noche = $precio_noche_query->fetchColumn();

        $duracion_query = $this->pdo->prepare('SELECT DATEDIFF(?, ?)');
        $duracion_query->execute([$fecha_salida, $fecha_llegada]);
        $duracion = $duracion_query->fetchColumn();

        $precio_total = (int) $precio_noche * (int) $duracion;

        $stmt = $this->pdo->prepare('INSERT INTO reservas (email, nombre, precio_total, fecha_llegada, fecha_salida, habitacion) values (?,?,?,?,?,?)');
        $stmt->execute([$email, $nombre, $precio_total, $fecha_llegada, $fecha_salida, $habitacion]);
        return true;
    }

    public function getHabitaciones() {
        $stmt = $this->pdo->query('SELECT id_habitacion,nombre_habitacion FROM habitaciones');
        return $stmt->fetchAll();
    }

    public function checkHabitacionesAvailable($fecha_llegada, $fecha_salida) {
        $stmt1 = $this->pdo->prepare('
SELECT habitacion
FROM reservas
WHERE (fecha_llegada < :fecha_llegada AND :fecha_llegadaa < fecha_salida)
OR (fecha_llegada < :fecha_salida AND :fecha_salidaa < fecha_salida)
OR (:fecha_llegadaaa <= fecha_llegada AND fecha_salida <= :fecha_salidaaa)
');

        $stmt1->execute([
            'fecha_llegada' => $fecha_llegada,
            'fecha_llegadaa' => $fecha_llegada,
            'fecha_llegadaaa' => $fecha_llegada,
            'fecha_salida' => $fecha_salida,
            'fecha_salidaa' => $fecha_salida,
            'fecha_salidaaa' => $fecha_salida,
        ]);

        $ocupadas = $stmt1->fetchAll();
        $ocupadas2 = [];
        for ($i = 0; $i < count($ocupadas); $i++) {
            $ocupadas2[] = $ocupadas[$i]['habitacion'];
        }

        $stmt2 = $this->pdo->prepare('
SELECT * FROM habitaciones 
WHERE NOT id_habitacion in (' . substr(str_repeat(',?', count($ocupadas2)), 1) . ');
');
        $stmt2->execute(
                $ocupadas2
        );
        return $stmt2->fetchAll();
    }

}
