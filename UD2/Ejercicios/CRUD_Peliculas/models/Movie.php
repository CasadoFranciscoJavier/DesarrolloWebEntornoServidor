<?php

class Movie
{
    private $id;
    private $titulo;
    private $sinopsis;
    private $anio;
    private $genero;

    public function __construct($id = null, $titulo = "", $sinopsis = null, $anio = null, $genero = null)
    {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->sinopsis = $sinopsis;
        $this->anio = $anio;
        $this->genero = $genero;
    }

    public function getId()
    {
        return $this->id;
    }

    public function gettitulo()
    {
        return $this->titulo;
    }

    public function getSinopsis()
    {
        return $this->sinopsis;
    }

    public function getAnio()
    {
        return $this->anio;
    }

    public function getGenero()
    {
        return $this->genero;
    }

    public function settitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    public function setSinopsis($sinopsis)
    {
        $this->sinopsis = $sinopsis;
    }

    public function setAnio($anio)
    {
        $this->anio = $anio;
    }

    public function setGenero($genero)
    {
        $this->genero = $genero;
    }

    public function __toString()
    {
        return "ID: {$this->id}, titulo: {$this->titulo}, Sinopsis: {$this->sinopsis}, Año: {$this->anio}, Género: {$this->genero}";
    }
}
