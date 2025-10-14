<?php
class Animales {
    // Atributos
    public $nombre;
    public $edad;
    public $raza;
    public $sexo;

    // Constructor
    public function __construct($nombre, $edad, $raza, $sexo) {
        $this->nombre = $nombre;
        $this->edad = $edad;
        $this->raza = $raza;
        $this->sexo = $sexo;
    }

    // Métodos
    public function ladrar() {
        $ladrido = "";
     
            $ladrido = "Guau Guau";

     
        return $ladrido;
    }

    public function calcularEdadHumana() {
        return $this->edad * 7;
    }

    public function __toString()
    {
        return "Nombre: " . $this->nombre . ", Edad: " . $this->edad . ", Raza: " . $this->raza . ", Sexo: " . $this->sexo;
    }
}


// Crear instancia de la clase Animales
$miAnimal = new Animales("Francisco", 3, "Labrador", "Macho");
$miAnimal2 = new Animales("Adolfo", 2, "Pastor Alemán", "Hembra");

echo $miAnimal;
echo "<br>" . $miAnimal->nombre . " dice: " . $miAnimal->ladrar();
echo "<br>Edad en años humanos: " . $miAnimal->nombre . " tiene " . $miAnimal->calcularEdadHumana() . " años<br>";

echo $miAnimal2;
echo "<br>" . $miAnimal2->nombre . " dice: " . $miAnimal2->ladrar();
echo "<br>Edad en años humanos: " . $miAnimal2->nombre . " tiene " . $miAnimal2->calcularEdadHumana() . " años<br>";




