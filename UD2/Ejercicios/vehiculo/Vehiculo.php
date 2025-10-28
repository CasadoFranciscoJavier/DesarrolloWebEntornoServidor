<?php

require_once "Puerta.php";

class Vehiculo{
    private $numeroDePuertas;
    private $puertas;
    private $tipoMotor; 
    private $potencia;
    private $etiquetaMedioambiental;
    private $arrancado;

    public function __construct($numeroDePuertas = 4, 
                                $tipoMotor = "Gasolina", 
                                $potencia = "100CV", 
                                $etiquetaMedioambiental = null) {

        $this->numeroDePuertas = $numeroDePuertas;

        // $this->puertas = array_fill(0, $numeroDePuertas, new Puerta); OJO! Esto me rellena el array con referencias de una misma puerta, no puertas distintas

        for ($i=0; $i < $numeroDePuertas; $i++) { 
            $nuevaPuerta = new Puerta();
            $this->puertas[] = $nuevaPuerta;
        }

        $this->tipoMotor = $tipoMotor;
        $this->potencia = $potencia;
        $this->etiquetaMedioambiental = $etiquetaMedioambiental;
        $this->arrancado = false;
    }

    public function encenderApagar(){
        $this->arrancado = !$this->arrancado;
    }

    public function cerrarVehiculo(){
        foreach ($this->puertas as $puerta) {
            if ($puerta->getAbierta()){
                $puerta->abrirCerrar();
            }

            if ($puerta->getVentana()->getAbierta()) {
                $puerta->abrirCerrarVentana();
            }
        }
    }

    public function puedeEntrarZBE(){
        return (isset($etiquetaMedioambiental) ? false : true); // si no tiene etiqueta no puede entrar
    }

    public function abrirCerrarPuerta($indicePuerta){
        $this->puertas[$indicePuerta]->abrirCerrar();
    }

    public function abrirCerrarVentana($indicePuerta){
        $this->puertas[$indicePuerta]->abrirCerrarVentana();
    }

    public function __toString(){
        $salida = "Nº puertas: $this->numeroDePuertas"
                ."<br>Tipo de motor: $this->tipoMotor"
                ."<br>Potencia: $this->potencia"
                ."<br>El vehículo está " . ($this->arrancado ? "arrancado" : "NO arrancado")
                ."<br>El vehículo " . ($this->etiquetaMedioambiental ? "tiene etiqueta" : "NO tiene etiqueta")
                ."<br>Puertas del vehículo:";

        foreach ($this->puertas as $puerta) {
            $salida = $salida . "<br>$puerta";
        }

        return $salida;

    }
}

// ============================================== //

$prueba = new Vehiculo;
$prueba->abrirCerrarPuerta(2);
$prueba->abrirCerrarVentana(0);
$prueba->abrirCerrarVentana(3);

$prueba->cerrarVehiculo();

echo $prueba;