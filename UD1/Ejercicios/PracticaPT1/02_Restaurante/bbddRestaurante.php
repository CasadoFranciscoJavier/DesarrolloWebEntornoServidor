<?php

// Precios base por menú (por persona)
$menus = [
    "Menú del Día" => 12,
    "Menú Ejecutivo" => 18,
    "Menú Degustación" => 35,
    "Menú Gourmet" => 55,
    "A la Carta" => 30
];

// Multiplicador según día
$dias = [
    "Lunes a Jueves" => 1.0,
    "Viernes" => 1.15,
    "Sábado" => 1.3,
    "Domingo" => 1.2
];

// Multiplicador según turno
$turnos = [
    "Comida (13:00-16:00)" => 1.0,
    "Cena (20:00-23:00)" => 1.1
];

// Servicios adicionales (precio total, no por persona)
$servicios = [
    "Bodega Premium (vino seleccionado)" => 45,
    "Postre Especial del Chef" => 25,
    "Menú Infantil (por cada niño)" => 8,
    "Decoración de Mesa" => 20,
    "Música en Vivo" => 80
];

// Códigos promocionales
$codigos = [
    "GOURMET20" => 20,
    "FAMILIA10" => 10,
    "PRIMERAVEZ" => 15
];

?>
