<?php

class Rating
{
    private $id;
    private $puntuacion;
    private $usuarioId;
    private $peliculaId;
    private $usuarioNombre;
    private $peliculaTitulo;

    public function __construct($id, $puntuacion, $usuarioId, $peliculaId)
    {
        $this->id = $id;
        $this->puntuacion = $puntuacion;
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

    public function getPuntuacion()
    {
        return $this->puntuacion;
    }

    public function setPuntuacion($puntuacion)
    {
        $this->puntuacion = $puntuacion;
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
        return "Puntuación: $this->puntuacion/10";
    }
}
