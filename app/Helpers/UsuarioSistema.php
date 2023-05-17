<?php
namespace Com\Daw2\Helpers;


class UsuarioSistema{
    private $idUsuario;
    private $rol;
    private $email;
    private $nombre;
    private $idioma;
    private $baja;
        
    public function __construct(?int $idUsuario, Rol $rol, string $email, string $nombre, string $idioma, string $baja){
        $this->idUsuario = $idUsuario;
        $this->rol = $rol;
        $this->email = $email;
        $this->nombre = $nombre;
        $this->idioma = $idioma;
        $this->baja = $baja;
    }        
    
    public function getIdUsuario() : int{
        return $this->idUsuario;
    }

    public function getRol() : Rol {
        return $this->rol;
    }
    
    public function getEmail() : string{
        return $this->email;
    }

    public function getNombre() : string {
        return $this->nombre;
    }

    public function getIdioma() : string{
        return $this->idioma;
    }

    public function getBaja() : bool{
        return $this->baja;
    }

    public function setRol(Rol $rol): void {
        $this->rol = $rol;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    public function setIdioma(string $idioma): void {
        $this->idioma = $idioma;
    }

    public function setBaja(bool $baja): void {
        $this->baja = $baja;
    }

}

