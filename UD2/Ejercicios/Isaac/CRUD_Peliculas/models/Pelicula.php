<?php 
class Pelicula{

    private $id;
    private $titulo;
    private $sinopsis;
    private $nota;
    private $comentarios;

    public function __construct($id, $titulo, $sinopsis, $nota=null, $comentarios=null) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->sinopsis = $sinopsis;
        $this->nota = $nota;
        $this->comentarios = $comentarios;
    }

    public function getId(){
        return $this->id;
    }

    public function getTitulo(){
        return $this->titulo;
    }

    public function getSinopsis(){
        return $this->sinopsis;
    }

    public function getNota(){
        return $this->nota;
    }

    public function getComentarios(){
        return $this->comentarios;
    }
}