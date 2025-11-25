<?php

class Embalaje
{
    private $id;
    private $repuestoId;
    private $tipo;
    private $dimensiones;
    private $pesoMaximo;

    public function __construct($id, $repuestoId, $tipo, $dimensiones, $pesoMaximo)
    {
        $this->id = $id;
        $this->repuestoId = $repuestoId;
        $this->tipo = $tipo;
        $this->dimensiones = $dimensiones;
        $this->pesoMaximo = $pesoMaximo;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getRepuestoId()
    {
        return $this->repuestoId;
    }

    public function setRepuestoId($repuestoId)
    {
        $this->repuestoId = $repuestoId;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function getDimensiones()
    {
        return $this->dimensiones;
    }

    public function setDimensiones($dimensiones)
    {
        $this->dimensiones = $dimensiones;
    }

    public function getPesoMaximo()
    {
        return $this->pesoMaximo;
    }

    public function setPesoMaximo($pesoMaximo)
    {
        $this->pesoMaximo = $pesoMaximo;
    }
}
