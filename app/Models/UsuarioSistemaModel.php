<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class UsuarioSistemaModel extends \Com\Daw2\Core\BaseModel {

    public function login(string $nombre, string $password): ?array {
        $stmt = $this->pdo->prepare("SELECT usuario_sistema.*, aux_rol.nombre_rol FROM usuario_sistema LEFT JOIN aux_rol ON aux_rol.id_rol = usuario_sistema.id_rol WHERE nombre=? and baja=0");
        $stmt->execute([$nombre]);
        if ($stmt->rowCount() == 1) {
            $userData = $stmt->fetchAll()[0];

            if (password_verify($password, $userData['pass'])) {
                unset($userData['pass']);
                return $userData;
            }
        }
        return NULL;
    }

    function getAll(): array {
        $stmt = $this->pdo->query('SELECT usuario_sistema.*, aux_rol.nombre_rol FROM usuario_sistema LEFT JOIN aux_rol ON aux_rol.id_rol = usuario_sistema.id_rol');
        return $stmt->fetchAll();
    }

    function loadUsuario(string $id): array {
        $stmt = $this->pdo->prepare('SELECT usuario_sistema.*, aux_rol.nombre_rol FROM usuario_sistema LEFT JOIN aux_rol ON aux_rol.id_rol = usuario_sistema.id_rol WHERE id_usuario=?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    function size(): int {
        $stmt = $this->pdo->query('SELECT COUNT(*) as total FROM usuario_sistema');
        return $stmt->fetchColumn(0);
    }

    function delete(string $id): bool {
        #if everything was ok return 1
        $stmt = $this->pdo->prepare('DELETE FROM usuario_sistema WHERE id_usuario=?');
        $stmt->execute([$id]);
        return ($stmt->rowCount() == 1);
    }

    function baja(string $id): bool {
        $prev = $this->pdo->prepare('SELECT baja FROM usuario_sistema WHERE id_usuario=?');
        $prev->execute([$id]);
        $actual = $prev->fetchAll();
        $baja = $actual[0];
        $stmt = $this->pdo->prepare('UPDATE usuario_sistema SET baja=? WHERE id_usuario=?');
        if ($baja['baja'] == 0) {
            return $stmt->execute(['1', $id]);
        } else {
            return $stmt->execute(['0', $id]);
        }
    }

    function insert(array $data): bool {
        $stmt = $this->pdo->prepare('INSERT INTO usuario_sistema(id_rol, pass, nombre, baja) values (?,?,?,?)');
        $pass = password_hash($data['pass'], PASSWORD_DEFAULT);
        return $stmt->execute([$data['id_rol'], $pass, $data['nombre'], 0]);
    }

    function update(array $data, int $id): bool {
        $stmt = $this->pdo->prepare('UPDATE usuario_sistema SET nombre=?, id_rol=? WHERE id_usuario=?');
        return $stmt->execute([$data['nombre'], $data['id_rol'], $id]);
    }

    function updatePass(int $idUsuario, string $pass): bool {
        $stmt = $this->pdo->prepare('UPDATE usuario_sistema SET pass=? WHERE id_usuario=?');
        $passEnc = password_hash($pass, PASSWORD_DEFAULT);
        return $stmt->execute([$passEnc, $idUsuario]);
    }

    function countByEmailNotUser(string $nombre, int $id_user): int {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM usuario_sistema WHERE nombre = ? AND id_usuario != ?');
        $stmt->execute([$nombre, $id_user]);
        return $stmt->fetchColumn(0);
    }

}
