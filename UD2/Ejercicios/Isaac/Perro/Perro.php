<?php

class Perro{
    private $nombre;
    private $edad;
    private $raza;
    private $sexo;

    public function __construct($nombre="", $edad=0, $raza="", $sexo="") {
        $this->nombre = $nombre;
        $this->edad = $edad;
        $this->raza = $raza;
        $this->sexo = $sexo;
    }

    public function ladrar(){
        echo "GUAU GUAU CHAVAL";
    }

    public function calcularEdadHumana(){
        return $this->edad * 7;
    }

    public function __toString(){
        $edadHumana = $this->calcularEdadHumana();
        
        return "$this->nombre es un perro de raza $this->raza y tiene $this->edad años ($edadHumana años humanos) y es $this->sexo";
    }
}

$miPerraso = new Perro("Firulais", 4, "Perrazo supremo", "indefinido");
$miOtroPerraso = new Perro("Firulais II", raza:"Perrazo supremo");

print_r($miOtroPerraso);

$miPerraso->ladrar();

echo "<br> Estos son los datos de mi perro: $miPerraso";