<?php

require_once "Conector.php";
require_once "Movie.php";
require_once "User.php";

class Comment
{
    private $id;
    private $contenido;
    private $usuario_id;
    private $pelicula_id;

    public function __construct($id = null, $contenido = "", $usuario_id = null, $pelicula_id = null)
    {
        $this->id = $id;
        $this->contenido = $contenido;
        $this->usuario_id = $usuario_id;
        $this->pelicula_id = $pelicula_id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getContenido()
    {
        return $this->contenido;
    }

    public function getUsuarioId()
    {
        return $this->usuario_id;
    }

    public function getPeliculaId()
    {
        return $this->pelicula_id;
    }

    public function setContenido($contenido)
    {
        $this->contenido = $contenido;
    }

    public function setUsuarioId($usuario_id)
    {
        $this->usuario_id = $usuario_id;
    }

    public function setPeliculaId($pelicula_id)
    {
        $this->pelicula_id = $pelicula_id;
    }

    public function __toString()
    {
        return "ID: {$this->id}, Contenido: {$this->contenido}, Usuario: {$this->usuario_id}, Película: {$this->pelicula_id}";
    }
}
