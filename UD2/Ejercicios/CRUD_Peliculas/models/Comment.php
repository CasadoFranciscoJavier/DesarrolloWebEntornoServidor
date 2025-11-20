<?php

class Comment
{
    private $id;
    private $contenido;
    private $usuarioId;
    private $peliculaId;
    private $usuarioNombre;
    private $peliculaTitulo;

    public function __construct($id, $contenido, $usuarioId, $peliculaId)
    {
        $this->id = $id;
        $this->contenido = $contenido;
        $this->usuarioId = $usuarioId;
        $this->peliculaId = $peliculaId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getContenido()
    {
        return $this->contenido;
    }

    public function setContenido($contenido)
    {
        $this->contenido = $contenido;
    }

    public function getUsuarioId()
    {
        return $this->usuarioId;
    }

    public function setUsuarioId($usuarioId)
    {
        $this->usuarioId = $usuarioId;
    }

    public function getPeliculaId()
    {
        return $this->peliculaId;
    }

    public function setPeliculaId($peliculaId)
    {
        $this->peliculaId = $peliculaId;
    }

    public function getUsuarioNombre()
    {
        return $this->usuarioNombre;
    }

    public function setUsuarioNombre($usuarioNombre)
    {
        $this->usuarioNombre = $usuarioNombre;
    }

    public function getPeliculaTitulo()
    {
        return $this->peliculaTitulo;
    }

    public function setPeliculaTitulo($peliculaTitulo)
    {
        $this->peliculaTitulo = $peliculaTitulo;
    }

    public function __tostring()
    {
        return "$this->usuarioNombre: $this->contenido";
    }
}
