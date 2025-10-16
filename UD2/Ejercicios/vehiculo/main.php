<?php
require_once 'Vehiculo.php';
require_once 'Puerta.php';
require_once 'Ventana.php';

// Crear las instancias de Puerta
$puerta1 = new Puerta(false); // Puerta cerrada, Ventana cerrada
$puerta2 = new Puerta(true); // Puerta abierta, Ventana cerrada

// Crear la instancia de Vehiculo, pasándole el array de puertas
$miCoche = new Vehiculo(2, [$puerta1, $puerta2], "Gasolina", 100, "C");

echo "Estado inicial:<br>";
echo "P1: " . $puerta1;
echo "P2: " . $puerta2;

echo "--- Ejecutando abrirCerrarVehiculo() ---";


echo "Estado final (después de la llamada):";
// La puerta 1 se abrió, su ventana se abrió.
// La puerta 2 se cerró, su ventana se abrió.
echo "P1: " . $puerta1 ;
echo "P2: " . $puerta2 ;