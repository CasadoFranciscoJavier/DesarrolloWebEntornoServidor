<?php
require_once 'Ventana.php';
class Puerta {
    // Atributos
    public $ventana;  // todas las puertas tienen una ventana
    public $abierta;
  

    // Constructor
    // En php no deja poner un constructor por defecto vacçio, por lo que podemos ponerle valores por defecto a los parámetros y así simular un constructor vacío
    public function __construct($abierta=false) {
        // Inicializa la ventana como una nueva instancia de Ventana
        $this->ventana = new Ventana();
        $this->abierta = $abierta; 
    }



    public function abrirCerrar() {
        $mensaje = "";
       if ($this->abierta == true) {
        $this->abierta = false;
        $mensaje = "...cerrando puerta";
       } else {
        $this->abierta = true;
        $mensaje = "...abriendo puerta";
         }
       return $mensaje;
    }


    public function __toString()
    {
        return "La puerta está: " . ($this->abierta ? "abierta." : "cerrada.");
    }
       
}