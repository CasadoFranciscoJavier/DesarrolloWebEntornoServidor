# Ejercicio 5: Sistema de Reserva de Entradas de Cine

## Descripci�n

Crear un formulario HTML para reservar entradas de cine. El sistema permitir� seleccionar pel�cula, formato (2D, 3D, IMAX), d�a de la semana, sesi�n, n�mero de entradas, complementos (palomitas, bebidas) y aplicar c�digos promocionales.

El script PHP calcular� el precio total bas�ndose en el formato elegido, d�a de la semana (fines de semana m�s caros), sesi�n, n�mero de entradas, complementos y aplicar� descuentos con c�digos v�lidos. Se calcular� el IVA (10%).

## Arrays Predefinidos

```php
// Pel�culas y formatos
$formatos = [
    "2D" => 8,
    "3D" => 11,
    "IMAX" => 15
];

// Recargo por d�a
$dias = [
    "Lunes a Jueves" => 1.0,
    "Viernes" => 1.15,
    "S�bado y Domingo" => 1.3
];

// Sesiones
$sesiones = [
    "Matinal (antes 14:00)" => 0.85,
    "Tarde (14:00-18:00)" => 1.0,
    "Noche (despu�s 18:00)" => 1.1
];

// Complementos
$complementos = [
    "Palomitas Peque�as" => 4,
    "Palomitas Grandes" => 6,
    "Refresco Peque�o" => 3,
    "Refresco Grande" => 5,
    "Combo Pareja" => 12,
    "Nachos con Queso" => 5
];

// C�digos promocionales
$codigos = [
    "CINE50" => 50,
    "ESTUDIANTE" => 20,
    "FAMILIA15" => 15
];
```
