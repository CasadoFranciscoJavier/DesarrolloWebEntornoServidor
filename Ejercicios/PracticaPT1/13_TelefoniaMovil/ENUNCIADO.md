# Ejercicio 13: Compañía de Telefonía Móvil - Planes y Tarifas

## Descripción
Crear un formulario HTML para contratar un plan de telefonía móvil. El sistema permitirá seleccionar plan base, cantidad de GB adicionales, minutos internacionales, servicios adicionales, y aplicar códigos promocionales. **IMPORTANTE: Si el cliente tiene permanencia de 24 meses, obtiene un 25% de descuento adicional sobre el plan y GB (aplicado ANTES del código promocional).**

## Arrays Predefinidos
```php
$planes = [
    "Plan Básico" => 15,
    "Plan Estándar" => 25,
    "Plan Premium" => 40,
    "Plan Ilimitado" => 60
];

$gbAdicionales = [
    "0 GB" => 0,
    "5 GB" => 5,
    "10 GB" => 9,
    "20 GB" => 15,
    "50 GB" => 30
];

$minutosInternacionales = [
    "Sin minutos" => 1.0,
    "100 minutos" => 1.15,
    "300 minutos" => 1.30,
    "Ilimitado" => 1.50
];

$servicios = [
    "Netflix Básico" => 8,
    "Spotify Premium" => 10,
    "Amazon Prime" => 5,
    "Roaming Internacional" => 12,
    "Seguro de Móvil" => 7
];

$permanencia = [
    "Sin Permanencia" => 1.0,
    "Permanencia 24 meses" => 0.75    // 25% descuento
];

$codigos = [
    "TELF10" => 10,
    "DATOS20" => 20,
    "NAVEGA15" => 15
];
```

## Notas Especiales
- El descuento por permanencia (25%) se aplica SOLO al plan base + GB adicionales
- Los minutos internacionales son un multiplicador sobre (plan + GB)
- El código promocional se aplica después del descuento por permanencia
- Los servicios adicionales NO se incluyen en ningún descuento
