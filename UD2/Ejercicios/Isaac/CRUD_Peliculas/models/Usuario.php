<?php 
class Usuario{

    private $id;
    private $nombre;
    private $email;
    private $password;
    private $rol;

    public function __construct($id, $nombre, $email, $password, $rol="USUARIO") {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->password = $password;
        $this->rol = $rol;
    }

    public function getId(){
        return $this->id;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getRol(){
        return $this->rol;
    }


}