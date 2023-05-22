<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class ReservasModel extends \Com\Daw2\Core\BaseModel {       
    
   public function add(string $email, string $nombre, string $fecha_llegada, string $fecha_salida, int $habitacion): bool {
    try {
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
    } catch (\PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}


    public function getHabitaciones(){
        $stmt = $this->pdo->query('SELECT id_habitacion,nombre_habitacion FROM habitaciones');
        return $stmt->fetchAll();
    }
}
