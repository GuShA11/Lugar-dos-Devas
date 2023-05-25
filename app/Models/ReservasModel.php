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
        $stmt = $this->pdo->query('SELECT id_habitacion FROM habitaciones');
        return $stmt->fetchAll();
    }

    public function checkHabitacionesAvailable($fecha_llegada, $fecha_salida) {
        //query que devuelve las ocupcadas
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

        $ocupadasConsulta = $stmt1->fetchAll();

        //dar valor a $ocupadas
        $ocupadas = [];
        for ($i = 0; $i < count($ocupadasConsulta); $i++) {
            $ocupadas[] = $ocupadasConsulta[$i]['habitacion'];
        }

        $todasHabitacionesConsulta = $this->getHabitaciones();
        //dar valor a $todasHabitaciones
        $todasHabitaciones = [];
        if (count($todasHabitacionesConsulta) > 0) {
            for ($i = 0; $i < count($todasHabitacionesConsulta); $i++) {
                $todasHabitaciones[] = $todasHabitacionesConsulta[$i]['id_habitacion'];
            }
        }

        $libres = array_values((array_diff($todasHabitaciones, $ocupadas))); // Ensure the array keys are consecutive

        $placeholders = implode(',', array_fill(0, count($libres), '?'));

        $stmt = $this->pdo->prepare("SELECT id_habitacion, nombre_habitacion FROM habitaciones WHERE id_habitacion IN ($placeholders)");
        $stmt->execute($libres);
        return $stmt->fetchAll();
    }

}
