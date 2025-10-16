<?php

require_once 'Ventana.php';
require_once 'Puerta.php';
class Vehiculo {
    // Atributos
    public $numeroDePuertas;
    public $puertas; // array de Puerta
    public $tipoMotor;
    public $potencia;
    public $etiquetaMedioambiental;

    // Constructor
    // En php no deja poner un constructor por defecto vacçio, por lo que podemos ponerle valores por defecto a los parámetros y así simular un constructor vacío
    public function __construct($numeroDePuertas=0, $puertas=[], $tipoMotor="", $potencia=0, $etiquetaMedioambiental="") {
        $this->numeroDePuertas = $numeroDePuertas;
        $this->puertas = $puertas;
        $this->tipoMotor = $tipoMotor;
        $this->potencia = $potencia;
        $this->etiquetaMedioambiental = $etiquetaMedioambiental;
    }

  

  

    // Métodos
    public function encenderApagar() {
      $encendido = false;
      $mensaje = "";
      if ($this->$encendido == "false") {
          $encendido = true;
            $mensaje = "Encendiendo vehículo";
      } else {
          $encendido = true;
            $mensaje = "Apagando vehículo";
      }
    }

     public function cerrarVehiculo() {
      $cerrado = false;
      if ($this->$cerrado == "encendido") {
          $cerrado = "apagado";
      } else {
          $cerrado = "encendido";
      }
    }

    public function puedeEntrarZBE() {
        $puedeEntrar = false;
        if ($this->etiquetaMedioambiental == "C" || $this->etiquetaMedioambiental == "ECO" || $this->etiquetaMedioambiental == "0") {
            $puedeEntrar = true;
        }
        return $puedeEntrar;
    }

    public function __toString()
    // Muestra el Vehículo y el estado de sus puertas (y ventanas)
    {
        return "Vehículo con " . $this->numeroDePuertas . " puertas, tipo de motor: " . $this->tipoMotor . ", potencia: " . $this->potencia . " CV, etiqueta medioambiental: " . $this->etiquetaMedioambiental; // siempre debe devolver un string, no podemos usar un echo, tambien podemos usar etiquetas html.
    }

    
}


// Crear instancia de la clase Vehiculo





