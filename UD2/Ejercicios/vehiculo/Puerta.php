<?php

require_once "Ventana.php";

class Puerta{
    private $ventana;
    private $abierta;

    public function __construct() {
        $this->abierta = false;
        $this->ventana = new Ventana;
    }

    public function getAbierta(){
        return $this->abierta;
    }

    public function getVentana(){
        return $this->ventana;
    }

    public function abrirCerrar(){
        $this->abierta = !$this->abierta;
    }

    public function abrirCerrarVentana(){
        $this->ventana->abrirCerrar();
    }

    public function __toString(){
        return "Puerta " . ($this->abierta ? "abierta" : "cerrada")
              ." | Ventana de la puerta: $this->ventana";
    }
}