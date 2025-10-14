# Ejercicio: Formulario de Configuración de un Coche Personalizado con Descuentos y Validación

## Descripción

El objetivo de este ejercicio es crear un formulario HTML para personalizar un coche en un concesionario. El formulario permitirá a los usuarios seleccionar componentes obligatorios como modelo, motor, color, llantas y equipamiento adicional usando botones `radio`. Los accesorios opcionales se podrán seleccionar mediante `checkboxes`. Además, el formulario contará con un campo de texto para ingresar un código de descuento y un campo de tipo `number` para especificar la cantidad de coches que se desea comprar (mínimo 1 y máximo 5).

Una vez que el usuario complete el formulario, un archivo PHP procesará las selecciones. El script calculará el precio total del coche (o coches) basándose en las configuraciones seleccionadas y los accesorios adicionales. Si el usuario ingresa un código de descuento válido (predefinido en un `map` en PHP), se aplicará el descuento al precio final. Si el código ingresado no es válido, el script calculará el precio total sin descuento e indicará que el código es incorrecto.

Los resultados se mostrarán en una página de resumen que incluya un desglose de costes y el total final con o sin descuento. Además, debe calcular el IVA (21% del total) y mostrar el precio total con impuestos.

## Instrucciones para el Formulario en HTML:

1. **Estructura del Formulario:**
   Crea un formulario con las siguientes secciones:
   
   1. **Modelo (Obligatorio)** - Usa `radio buttons`:
      - Compacto
      - Sedán
      - SUV

   2. **Motor (Obligatorio)** - Usa `radio buttons`:
      - Gasolina 1.6L
      - Diesel 2.0L
      - Eléctrico 75 kWh

   3. **Color (Obligatorio)** - Usa `radio buttons`:
      - Blanco
      - Negro
      - Azul Metálico
      - Rojo

   4. **Llantas (Obligatorio)** - Usa `radio buttons`:
      - 16" Aleación
      - 18" Aleación
      - 20" Deportivo

   5. **Equipamiento (Obligatorio)** - Usa `radio buttons`:
      - Básico
      - Confort
      - Premium

   6. **Accesorios Opcionales** - Usa `checkboxes` para seleccionar uno o más:
      - Techo Panorámico
      - Asientos de Cuero
      - Sistema de Sonido Premium
      - Cámara de 360°
      - Paquete Deportivo
      - Control de Crucero Adaptativo
      - Sensores de Aparcamiento
      - Maletero Eléctrico

   7. **Cantidad de Coches** - Utiliza un campo `number` que permita especificar cuántas unidades se desean comprar (mínimo 1 y máximo 5).

   8. **Código de Descuento (Opcional)** - Usa un campo de texto para ingresar un código de descuento. El campo debe aceptar un código que será validado en el backend.

2. **Script PHP:**
   Crea un archivo PHP que realice las siguientes operaciones:

   - Define un `map` predefinido con los modelos, motores, colores, llantas, equipamiento y accesorios, junto con sus precios.
   - Crea un `map` adicional con los códigos de descuento válidos y sus respectivos porcentajes.
   - Calcula el coste total del coche basándose en los componentes obligatorios seleccionados y los accesorios opcionales.
   - Si el usuario ha ingresado un código de descuento válido, aplica el descuento correspondiente al precio total.
   - Si el código ingresado es incorrecto, muestra un mensaje indicando que el código no es válido y calcula el precio total sin descuento.
   - Calcula el precio final de la compra multiplicando por la cantidad de coches especificada (si está entre 1 y 5).
   - Genera un desglose con los componentes seleccionados, la cantidad de coches a comprar, y el precio total con y sin descuento. Además, muestra el total de impuestos (IVA).
   
3. **Salida Esperada:**
   - Si el formulario se ha llenado correctamente, el script PHP debe mostrar un resumen detallado con los componentes seleccionados, la cantidad de coches a comprar y el precio total con un desglose del descuento (si se ingresó uno válido) y los impuestos (21% de IVA).
   - Si no se completan las secciones obligatorias, debe mostrar un mensaje de advertencia con las secciones faltantes.

## `map` Predefinidos

```php
<?php
// Precios de los componentes y accesorios del coche
$componentes = [
    "Modelo" => [
        "Compacto" => 15000,
        "Sedán" => 20000,
        "SUV" => 30000
    ],
    "Motor" => [
        "Gasolina 1.6L" => 2000,
        "Diesel 2.0L" => 3000,
        "Eléctrico 75 kWh" => 10000
    ],
    "Color" => [
        "Blanco" => 0,
        "Negro" => 500,
        "Azul Metálico" => 1000,
        "Rojo" => 1500
    ],
    "Llantas" => [
        "16\" Aleación" => 500,
        "18\" Aleación" => 1000,
        "20\" Deportivo" => 1500
    ],
    "Equipamiento" => [
        "Básico" => 0,
        "Confort" => 2000,
        "Premium" => 5000
    ],
    "Accesorios" => [
        "Techo Panorámico" => 1200,
        "Asientos de Cuero" => 1500,
        "Sistema de Sonido Premium" => 1000,
        "Cámara de 360°" => 800,
        "Paquete Deportivo" => 2000,
        "Control de Crucero Adaptativo" => 1500,
        "Sensores de Aparcamiento" => 600,
        "Maletero Eléctrico" => 900
    ]
];

// Códigos de descuento válidos
$codigosDescuento = [
    "AUTODESCUENTO5" => 5,   // 5% de descuento
    "CARSALE10" => 10,       // 10% de descuento
    "PROMO15" => 15          // 15% de descuento
];
?>
```

## Ejemplos de Salida

1. **Sin Descuento Aplicado:**
   ```
   Resumen de tu Coche Personalizado:

   - Modelo: SUV - 30000 €
   - Motor: Eléctrico 75 kWh - 10000 €
   - Color: Rojo - 1500 €
   - Llantas: 20" Deportivo - 1500 €
   - Equipamiento: Premium - 5000 €
   - Accesorios:
      * Techo Panorámico - 1200 €
      * Sistema de Sonido Premium - 1000 €

   Cantidad de Coches: 2
   Código de Descuento: No válido

   Precio por unidad: 48700 €
   Total sin Descuento: 97400 €

   IVA (21%): 20454 €
   ```

2. **Con Descuento Aplicado:**
   ```
   Resumen de tu Coche Personalizado:

   - Modelo: Sedán - 20000 €
   - Motor: Diesel 2.0L - 3000 €
   - Color: Negro - 500 €
   - Llantas: 18" Aleación - 1000 €
   - Equipamiento: Confort - 2000 €
   - Accesorios:
      * Asientos de Cuero - 1500 €
      * Paquete Deportivo - 2000 €
      * Maletero Eléctrico - 900 €

   Cantidad de Coches: 1
   Código de Descuento: CARSALE10

   Precio por unidad: 30900 €
   Total sin Descuento: 30900 €
   Descuento Aplicado: 3090 €
   Total con Descuento: 27810 €

   IVA (21%): 5840,10 €
   ```