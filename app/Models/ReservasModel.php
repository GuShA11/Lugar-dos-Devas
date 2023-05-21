<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class ReservasModel extends \Com\Daw2\Core\BaseModel {       
    
    public function add(string $id, string $nombre, string $idPadre): bool {
        try {
            if ($idPadre !== null && $idPadre !== '') {
                $stmt = $this->pdo->prepare('INSERT INTO categoria(id_categoria, nombre_categoria, id_padre) values (?,?,?)');
                $stmt->execute([
                    $id, $nombre, $idPadre]
                );
            } else {
                $stmt = $this->pdo->prepare('INSERT INTO categoria(id_categoria, nombre_categoria) values (?,?)');
                $stmt->execute([
                    $id, $nombre]
                );
            }
            
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
