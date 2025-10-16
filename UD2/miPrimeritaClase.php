<?php
class Animales {
    // Atributos
    public $nombre;
    public $edad;
    public $raza;
    public $sexo;

    // Constructor
    // En php no deja poner un constructor por defecto vacçio, por lo que podemos ponerle valores por defecto a los parámetros y así simular un constructor vacío
    public function __construct($nombre="", $edad=0, $raza="", $sexo="") {
        $this->nombre = $nombre;
        $this->edad = $edad;
        $this->raza = $raza;
        $this->sexo = $sexo;
    }

  

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    // Métodos
    public function ladrar() {
        $ladrido = "";
     
            $ladrido = "Guau Guau";

     
        return $ladrido;
       // echo "guau guau";
    }

    public function calcularEdadHumana() {
        return $this->edad * 7;
    }

    public function __toString()
    {
        return "Nombre: " . $this->nombre . ", Edad: " . $this->edad . ", Raza: " . $this->raza . ", Sexo: " . $this->sexo; // siempre debe devolver un string, no podemos usar un echo, tambien podemos usar etiquetas html.
    }
}


// Crear instancia de la clase Animales
$miAnimal = new Animales("Francisco", 3, "Labrador", "Macho");
$miAnimal2 = new Animales("Adolfo", 2, raza:"Pastor Alemán"); // Podemos usar named parameters para saltarnos parámetros opcionales

echo $miAnimal;
echo "<br>" . $miAnimal->nombre . " dice: " . $miAnimal->ladrar();
echo "<br>Edad en años humanos: " . $miAnimal->nombre . " tiene " . $miAnimal->calcularEdadHumana() . " años<br>";

// si ponemos directamente: $miAnimal->ladrar() y en la funtion ladrar ponemos un echo en vez de un return, podriamos sacrlo directamente sin necesidad de hacer un echo $miAnimal->ladrar()

echo $miAnimal2;
echo "<br>" . $miAnimal2->nombre . " dice: " . $miAnimal2->ladrar();
echo "<br>Edad en años humanos: " . $miAnimal2->nombre . " tiene " . $miAnimal2->calcularEdadHumana() . " años<br>";




