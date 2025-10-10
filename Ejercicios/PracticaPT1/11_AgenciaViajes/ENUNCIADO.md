# Ejercicio 11: Agencia de Viajes - Alquiler de Vehículos

## Descripción
Crear un formulario HTML para alquilar vehículos en una agencia de viajes. El sistema permitirá seleccionar tipo de vehículo, días de alquiler, kilometraje incluido, seguros adicionales, calcular el coste de gasolina estimado y aplicar códigos promocionales.

## Arrays Predefinidos
```php
$vehiculos = [
    "Coche Compacto" => 35,
    "Coche Familiar" => 50,
    "SUV" => 70,
    "Furgoneta 9 plazas" => 85,
    "Moto" => 25
];

$kilometraje = [
    "100 km/día" => 1.0,
    "200 km/día" => 1.3,
    "Ilimitado" => 1.6
];

$seguros = [
    "Seguro Básico" => 5,
    "Seguro a Todo Riesgo" => 15,
    "Seguro Premium" => 25,
    "GPS Navegador" => 8,
    "Silla Infantil" => 6
];

$consumo = [
    "Coche Compacto" => 5.5,      // litros/100km
    "Coche Familiar" => 7.0,
    "SUV" => 9.5,
    "Furgoneta 9 plazas" => 11.0,
    "Moto" => 4.0
];

$codigos = [
    "VIAJE10" => 10,
    "VERANO15" => 15,
    "FAMILIA20" => 20
];
```

## Notas Especiales
- El precio de la gasolina es de 1.45€/litro
- El usuario debe ingresar los kilómetros estimados que va a recorrer (1-3000 km)
- El coste de gasolina se calcula: (km_estimados / 100) * consumo_vehiculo * precio_gasolina
- El coste de gasolina NO se incluye en el descuento promocional
