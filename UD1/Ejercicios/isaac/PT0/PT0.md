# Prueba Técnica 0: Formulario de Configuración de un PC Personalizado con Descuentos y Validación

## [Enlace GitHub](https://classroom.github.com/a/e0RJT1cn)

El objetivo de este ejercicio es crear un formulario HTML para personalizar un PC de escritorio. El formulario permitirá a los usuarios seleccionar componentes obligatorios como procesador, memoria RAM, disco duro, tarjeta gráfica y fuente de alimentación usando botones `radio`. Los accesorios opcionales podrán seleccionarse mediante `checkboxes`. Además, el formulario contará con un campo de texto para ingresar un código de descuento y un campo de tipo `number` para especificar la cantidad de ordenadores que se desea comprar (mínimo 1 y máximo 10).

Una vez que el usuario complete el formulario, un archivo PHP procesará las selecciones. El script calculará el precio total del PC (o PCs) basándose en los componentes seleccionados y los accesorios adicionales. Si el usuario ingresa un código de descuento válido (predefinido en un `map` en PHP), se aplicará el descuento al precio final. Si el código ingresado no es válido, el script calculará el precio total sin descuento e indicará que el código es incorrecto.

Los resultados se mostrarán en una página de resumen que incluya un desglose de costes y el total final con o sin descuento. También debe calcular el IVA (21% del total) y mostrar el precio total con impuestos.

## Instrucciones para el Formulario en HTML:

1. **Estructura del Formulario:**
   Crea un formulario con las siguientes secciones:
   
   1. **Procesador (Obligatorio)** - Usa `radio buttons`:
      - Intel i5
      - Intel i7
      - AMD Ryzen 5

   2. **Memoria RAM (Obligatorio)** - Usa `radio buttons`:
      - 8 GB
      - 16 GB
      - 32 GB

   3. **Disco Duro (Obligatorio)** - Usa `radio buttons`:
      - 256 GB SSD
      - 512 GB SSD
      - 1 TB SSD
      - 2 TB HDD

   4. **Tarjeta Gráfica (Obligatorio)** - Usa `radio buttons`:
      - NVIDIA GTX 1650
      - NVIDIA RTX 3060
      - AMD RX 6600 XT

   5. **Fuente de Alimentación (Obligatorio)** - Usa `radio buttons`:
      - 500W
      - 650W
      - 750W

   6. **Accesorios Opcionales** - Usa `checkboxes` para seleccionar uno o más:
      - Teclado Mecánico
      - Ratón Gaming
      - Monitor 24"
      - Audífonos
      - Impresora
      - Webcam
      - Alfombrilla RGB
      - Altavoces

   7. **Cantidad de Ordenadores** - Utiliza un campo `number` que permita especificar cuántas unidades (equipos montados) se desean comprar (mínimo 1 y máximo 10).

   8. **Código de Descuento (Opcional)** - Usa un campo de texto para ingresar un código de descuento. El campo debe aceptar un código que será validado en el backend.

2. **Script PHP:**
   Crea un archivo PHP que realice las siguientes operaciones:

   - Define un `map` predefinido con los componentes, accesorios y sus precios (lo tienes más abajo).
   - Crea un `map` adicional con los códigos de descuento válidos y sus respectivos porcentajes (lo tienes más abajo).
   - Calcula el coste total del PC basándose en los componentes obligatorios seleccionados y los accesorios opcionales.
   - Si el usuario ha ingresado un código de descuento válido, aplica el descuento correspondiente al precio total.
   - Si el código ingresado es incorrecto, muestra un mensaje indicando que el código no es válido y calcula el precio total sin descuento.
   - Calcula el precio final de la compra multiplicando por la cantidad de ordenadores especificada (si está entre 1 y 10).
   - Genera un desglose con los componentes seleccionados, la cantidad de equipos a comprar, y el precio total con y sin descuento. Además, muestra el total de impuestos (IVA).
   
3. **Salida Esperada:**
   - Si el formulario se ha llenado correctamente, el script PHP debe mostrar un resumen detallado con los componentes seleccionados, la cantidad de equipos a comprar y el precio total con un desglose del descuento (si se ingresó uno válido) y los impuestos (21% de IVA).
   - Si no se completan las secciones obligatorias, debe mostrar un mensaje de advertencia con las secciones faltantes.

## `map` Predefinidos

```php
<?php
// Precios de los componentes y accesorios del PC
$componentes = [
    "Procesador" => [
        "Intel i5" => 200,
        "Intel i7" => 300,
        "AMD Ryzen 5" => 250
    ],
    "RAM" => [
        "8 GB" => 40,
        "16 GB" => 80,
        "32 GB" => 150
    ],
    "Memoria" => [
        "256 GB SSD" => 50,
        "512 GB SSD" => 90,
        "1 TB SSD" => 150,
        "2 TB HDD" => 100
    ],
    "Grafica" => [
        "NVIDIA GTX 1650" => 150,
        "NVIDIA RTX 3060" => 400,
        "AMD RX 6600 XT" => 300
    ],
    "Alimentacion" => [
        "500W" => 50,
        "650W" => 70,
        "750W" => 100
    ],
    "Accesorios" => [
        "Teclado Mecanico" => 70,
        "Raton Gaming" => 50,
        "Monitor 24" => 150,
        "Audifonos" => 30,
        "Impresora" => 120,
        "Webcam" => 60,
        "Alfombrilla RGB" => 30,
        "Altavoces" => 80
    ]
];

// Códigos de descuento válidos
$codigosDescuento = [
    "DESCUENTO10" => 10,  // 10% de descuento
    "PCGAMER20" => 20,    // 20% de descuento
    "SUPEROFERTA30" => 30 // 30% de descuento
];
?>
```

## Ejemplos de Salida

1. **Sin Descuento Aplicado:**
   ```
   Resumen de tu PC Personalizado:

   - Procesador: Intel i7 - 300 €
   - Memoria RAM: 16 GB - 80 €
   - Disco Duro: 512 GB SSD - 90 €
   - Tarjeta Gráfica: NVIDIA RTX 3060 - 400 €
   - Fuente de Alimentación: 650W - 70 €
   - Accesorios:
      * Raton Gaming - 50 €
      * Monitor 24 - 150 €

   Cantidad de Equipos: 2
   Código de Descuento: No válido

   Precio por unidad: 1140 €
   Total sin Descuento: 2280 €

   IVA (21%): 395,70 €
   ```

2. **Con Descuento Aplicado:**
   ```
   Resumen de tu PC Personalizado:

   - Procesador: AMD Ryzen 5 - 250 €
   - Memoria RAM: 32 GB - 150 €
   - Disco Duro: 1 TB SSD - 150 €
   - Tarjeta Gráfica: AMD RX 6600 XT - 300 €
   - Fuente de Alimentación: 750W - 100 €
   - Accesorios:
      * Teclado Mecanico - 70 €
      * Audifonos - 30 €
      * Impresora - 120 €

   Cantidad de Equipos: 1
   Código de Descuento: SUPEROFERTA30

   Precio por unidad: 1170 €
   Total sin Descuento: 1170 €
   Descuento Aplicado: 351 €
   Total con Descuento: 819 €

   IVA (21%): 142,14 €
   ```