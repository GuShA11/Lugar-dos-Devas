<?php
namespace Com\Daw2\Helpers;

class Rol{
    private $id_rol;
    private $nombre_rol;
     
    
    public function __construct(int $id_rol, string $nombre_rol) {
        $this->id_rol = $id_rol;
        $this->nombre_rol = $nombre_rol;
    }
    public function getIdRol() {
        return $this->id_rol;
    }

    public function getNombreRol() {
        return $this->nombre_rol;
    }

    public function setId_rol($id_rol): void {
        $this->id_rol = $id_rol;
    }

    public function setNombre_rol($nombre_rol): void {
        $this->nombre_rol = $nombre_rol;
    }

}