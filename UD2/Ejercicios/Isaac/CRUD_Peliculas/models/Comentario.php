<?php
class Comentario{

    private $id;
    private $idPelicula;
    private $usuario;
    private $texto;

    public function __construct($id, $idPelicula, $usuario, $texto) {
        $this->id = $id;
        $this->idPelicula = $idPelicula;
        $this->usuario = $usuario;
        $this->texto = $texto;
    }

    public function getIdPelicula(){
        return $this->idPelicula;
    }

    public function getUsuario(){
        return $this->usuario;
    }

    public function getTexto(){
        return $this->texto;
    }

    public function setId($id){
        return $this->id = $id;
    }

}