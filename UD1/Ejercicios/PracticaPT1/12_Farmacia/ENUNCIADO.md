# Ejercicio 12: Farmacia - Sistema de Pedidos

## Descripción
Crear un formulario HTML para realizar pedidos en una farmacia online. El sistema permitirá seleccionar tipo de cliente (con o sin receta), productos, cantidad de cada producto, envío, y aplicar códigos promocionales. **IMPORTANTE: Los productos con receta tienen un descuento adicional del 40% aplicado ANTES del código promocional.**

## Arrays Predefinidos
```php
$productos = [
    "Paracetamol 1g" => 8.50,
    "Ibuprofeno 600mg" => 6.20,
    "Amoxicilina" => 12.00,
    "Vitamina C" => 5.50,
    "Crema Hidratante" => 15.00
];

$tiposCliente = [
    "Sin Receta" => 1.0,
    "Con Receta Médica" => 0.6    // 40% descuento
];

$envio = [
    "Recogida en Tienda" => 0,
    "Envío Estándar" => 4.50,
    "Envío Express 24h" => 9.00,
    "Envío Urgente" => 15.00
];

$servicios = [
    "Medición de Tensión" => 3,
    "Test de Glucosa" => 5,
    "Consulta Farmacéutica" => 8
];

$codigos = [
    "SALUD10" => 10,
    "FARMACIA15" => 15,
    "BIENESTAR20" => 20
];
```

## Notas Especiales
- El descuento por receta (40%) se aplica SOLO al coste de productos
- El código promocional se aplica después del descuento por receta
- El envío NO se incluye en ningún descuento
- El usuario debe ingresar la cantidad de cada producto (usar 5 inputs numéricos diferentes)
