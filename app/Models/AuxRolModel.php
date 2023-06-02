<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class AuxRolModel extends \Com\Daw2\Core\BaseModel {

    function getAll(): array {
        $stmt = $this->pdo->query('SELECT * FROM aux_rol ORDER BY nombre_rol');
        return $stmt->fetchAll();
    }

    function loadRol(int $id): ?array {
        $stmt = $this->pdo->prepare('SELECT * FROM aux_rol WHERE id_rol=?');
        $stmt->execute([$id]);
        if ($row = $stmt->fetch()) {
            return $row;
        } else {
            return null;
        }
    }

}
