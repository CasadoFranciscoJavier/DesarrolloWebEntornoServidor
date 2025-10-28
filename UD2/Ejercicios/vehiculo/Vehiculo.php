<?php

require_once "Puerta.php";

class Vehiculo
{
    private $numeroDePuertas;
    private $puertas;
    private $tipoMotor;
    private $potencia;
    private $etiquetaMedioambiental;
    private $arrancado;

    public function __construct(
        $numeroDePuertas = 4,
        $tipoMotor = "Gasolina",
        $potencia = "100CV",
        $etiquetaMedioambiental = null
    ) {

        $this->numeroDePuertas = $numeroDePuertas;

        // $this->puertas = array_fill(0, $numeroDePuertas, new Puerta); modificas una puerta, pero como todas son el mismo objeto, todas parecen cambiar de estado.
        for ($i = 0; $i < $numeroDePuertas; $i++) {
            $this->puertas[] = new Puerta();
        }

        $this->tipoMotor = $tipoMotor;
        $this->potencia = $potencia;
        $this->etiquetaMedioambiental = $etiquetaMedioambiental;
        $this->arrancado = false;
    }

    public function encenderApagar()
    {
        $this->arrancado = !$this->arrancado;
    }

    public function cerrarVehiculo()
    {
        foreach ($this->puertas as $puerta) {
            if ($puerta->getAbierta())
                $puerta->abrirCerrar();
        }
    }
    public function abrirCerrarPuerta($indicePuerta) {

        $this->puertas[$indicePuerta]->abrirCerrar();
    }

    public function abrirCerrarVentana($indicePuerta){

        $this->puertas[$indicePuerta]->abrirCerrarVentana();
    }

    // public function puedeEntrarZBE(){
    //     return ($etiquetaMedioambiental == null ? false : true); // si no tiene etiqueta no puede entrar
    // }

    public function __toString()
    {
        $salida = "Nº puertas: $this->numeroDePuertas"
            . "<br>Tipo de motor: $this->tipoMotor"
            . "<br>Potencia: $this->potencia"
            . "<br>Etiqueta medioambiental: " . ($this->etiquetaMedioambiental ?? "Ninguna")
            . "<br>Estado del vehículo: " . ($this->arrancado ? "Arrancado" : "Apagado");

        foreach ($this->puertas as $puerta) {
            $salida = $salida . "<br>$puerta";
        }
        return $salida;
    }
}



$prueba = new Vehiculo;
$prueba->abrirCerrarPuerta(2);
$prueba->abrirCerrarVentana(3);

echo ($prueba);
