<?php

class Comment
{
    private $id;
    private $contenido;
    private $usuario_id;
    private $pelicula_id;

    private $usuario_nombre;
    private $pelicula_titulo;

    public function __construct($id = null, $contenido = "", $usuario_id = null, $pelicula_id = null)
    {
        $this->id = $id;
        $this->contenido = $contenido;
        $this->usuario_id = $usuario_id;
        $this->pelicula_id = $pelicula_id;
    }

    public function getId() { return $this->id; }
    public function getContenido() { return $this->contenido; }
    public function getUsuarioId() { return $this->usuario_id; }
    public function getPeliculaId() { return $this->pelicula_id; }
    public function getUsuarioNombre() { return $this->usuario_nombre; }
    public function getPeliculaTitulo() { return $this->pelicula_titulo; }

    public function setContenido($contenido) { $this->contenido = $contenido; }
    public function setUsuarioId($usuario_id) { $this->usuario_id = $usuario_id; }
    public function setPeliculaId($pelicula_id) { $this->pelicula_id = $pelicula_id; }
    public function setUsuarioNombre($nombre) { $this->usuario_nombre = $nombre; }
    public function setPeliculaTitulo($titulo) { $this->pelicula_titulo = $titulo; }

    public function __toString()
    {
        return "ID: {$this->id}, Contenido: {$this->contenido}, Usuario ID: {$this->usuario_id}, Película ID: {$this->pelicula_id}, Usuario: {$this->usuario_nombre}, Película: {$this->pelicula_titulo}";
    }
}
