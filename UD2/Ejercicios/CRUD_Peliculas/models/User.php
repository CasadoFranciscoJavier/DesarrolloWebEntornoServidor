<?php


class User
{
    private $id;
    private $nombre;
    private $contrasenia;
    private $rol;
   

    public function __construct($id = null, $nombre = "", $contrasenia = null, $rol = null)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->contrasenia = $contrasenia;
        $this->rol = $rol;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getnombre()
    {
        return $this->nombre;
    }

    public function getContrasenia()
    {
        return $this->contrasenia;
    }

    public function getRol()
    {
        return $this->rol;
    }

  

    public function setnombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setContrasenia($contrasenia)
    {
        $this->contrasenia = $contrasenia;
    }

    public function setRol($rol)
    {
        $this->rol = $rol;
    }

   

    public function __toString()
    {
        return "ID: {$this->id}, nombre: {$this->nombre}, Contrasenia: {$this->contrasenia}, Rol: {$this->rol} ";
    }
}
