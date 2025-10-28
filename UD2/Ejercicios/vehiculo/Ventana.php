<?php

class Ventana{
    private $abierta;

    public function __construct() {
        $this->abierta = false;
    }

    public function abrirCerrar(){
        $this->abierta = !$this->abierta;
    }

    public function __toString(){
        return "Ventana " . $this->abierta ? "abierta" : "cerrada";
    }
}
