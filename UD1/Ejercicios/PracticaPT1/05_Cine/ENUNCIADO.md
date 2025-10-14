# Ejercicio 5: Sistema de Reserva de Entradas de Cine

## Descripción

Crear un formulario HTML para reservar entradas de cine. El sistema permitirá seleccionar película, formato (2D, 3D, IMAX), día de la semana, sesión, número de entradas, complementos (palomitas, bebidas) y aplicar códigos promocionales.

El script PHP calculará el precio total basándose en el formato elegido, día de la semana (fines de semana más caros), sesión, número de entradas, complementos y aplicará descuentos con códigos válidos. Se calculará el IVA (10%).

## Arrays Predefinidos

```php
// Películas y formatos
$formatos = [
    "2D" => 8,
    "3D" => 11,
    "IMAX" => 15
];

// Recargo por día
$dias = [
    "Lunes a Jueves" => 1.0,
    "Viernes" => 1.15,
    "Sábado y Domingo" => 1.3
];

// Sesiones
$sesiones = [
    "Matinal (antes 14:00)" => 0.85,
    "Tarde (14:00-18:00)" => 1.0,
    "Noche (después 18:00)" => 1.1
];

// Complementos
$complementos = [
    "Palomitas Pequeñas" => 4,
    "Palomitas Grandes" => 6,
    "Refresco Pequeño" => 3,
    "Refresco Grande" => 5,
    "Combo Pareja" => 12,
    "Nachos con Queso" => 5
];

// Códigos promocionales
$codigos = [
    "CINE50" => 50,
    "ESTUDIANTE" => 20,
    "FAMILIA15" => 15
];
```
