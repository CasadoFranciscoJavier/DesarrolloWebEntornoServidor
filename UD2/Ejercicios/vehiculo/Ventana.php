<?php
class Ventana {
    // Atributos
    public $abierta;
  

    // Constructor
    // En php no deja poner un constructor por defecto vacçio, por lo que podemos ponerle valores por defecto a los parámetros y así simular un constructor vacío
    public function __construct() { // si ponemos como parametro $abierta=false, permitimos que le pueda pasar tambien true y no queremos
        $this->abierta = false;
       
    }



    public function abrirCerrar() {
        $mensaje = "";
       if ($this->abierta == true) {
        $this->abierta = false;
        $mensaje = "Cerrando ventana";
       } else {
        $this->abierta = true;
        $mensaje = "Abriendo ventana";
         }
       return $mensaje;
    }


    public function __toString()
    {
        return "La ventana está: " . ($this->abierta ? "abierta." : "cerrada.");
    }
       
}