<?php

class Movie
{
    private $id;
    private $titulo;
    private $sinopsis;
    private $anio;
    private $genero;

    public function __construct($id, $titulo, $sinopsis, $anio, $genero)
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

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTitulo()
    {
        return $this->titulo;
    }

    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    public function getSinopsis()
    {
        return $this->sinopsis;
    }

    public function setSinopsis($sinopsis)
    {
        $this->sinopsis = $sinopsis;
    }

    public function getAnio()
    {
        return $this->anio;
    }

    public function setAnio($anio)
    {
        $this->anio = $anio;
    }

    public function getGenero()
    {
        return $this->genero;
    }

    public function setGenero($genero)
    {
        $this->genero = $genero;
    }

    public function __tostring()
    {
        return "<a href='view/detalles.php?id=$this->id'>$this->titulo</a> ($this->anio)";
    }
}
