<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use \PDOException;

class UsuarioSistemaModel extends \Com\Daw2\Core\BaseModel {       
    
    public function login(string $email, string $password): ?array {
        $stmt = $this->pdo->prepare("SELECT usuario_sistema.*, aux_rol.nombre_rol FROM usuario_sistema LEFT JOIN aux_rol ON aux_rol.id_rol = usuario_sistema.id_rol WHERE email=? and baja=0");
        $stmt->execute([$email]);
        if($stmt->rowCount() == 1) {
            $userData = $stmt->fetchAll()[0];

            if(password_verify($password, $userData['pass'])){
                unset($userData['pass']);
                return $userData;
            }
        } 
        return NULL;
    }
}
