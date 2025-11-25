<?php

class Pedido
{
    private $id;
    private $usuarioId;
    private $repuestoId;
    private $cantidad;
    private $fecha;
    private $estado;

    public function __construct($id, $usuarioId, $repuestoId, $cantidad, $fecha, $estado)
    {
        $this->id = $id;
        $this->usuarioId = $usuarioId;
        $this->repuestoId = $repuestoId;
        $this->cantidad = $cantidad;
        $this->fecha = $fecha;
        $this->estado = $estado;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUsuarioId()
    {
        return $this->usuarioId;
    }

    public function setUsuarioId($usuarioId)
    {
        $this->usuarioId = $usuarioId;
    }

    public function getRepuestoId()
    {
        return $this->repuestoId;
    }

    public function setRepuestoId($repuestoId)
    {
        $this->repuestoId = $repuestoId;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }
}
