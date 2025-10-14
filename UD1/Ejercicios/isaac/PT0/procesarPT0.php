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

// ============================================== MAIN ============================================== //

// Recogida de datos del formulario enviado por el usuario
// Estos datos provienen de los campos seleccionados en el formulario HTML mediante el método POST.
$procesador = $_POST['procesador']; // Procesador seleccionado
$ram = $_POST['ram']; // Memoria RAM seleccionada
$disco = $_POST['disco']; // Tipo de disco duro seleccionado
$grafica = $_POST['grafica']; // Tarjeta gráfica seleccionada
$alimentacion = $_POST['alimentacion']; // Fuente de alimentación seleccionada
$cantidad = $_POST['cantidad']; // Cantidad de ordenadores solicitada
$codigo = $_POST['codigo']; // Código de descuento ingresado (si lo hay)

// Asignación de precios a variables
// Cada precio se extrae del array `$componentes` en función de las opciones seleccionadas por el usuario.
$precioProcesador = $componentes["Procesador"][$procesador]; // Precio del procesador
$precioRam = $componentes["RAM"][$ram]; // Precio de la memoria RAM
$precioDisco = $componentes["Memoria"][$disco]; // Precio del disco duro
$precioGrafica = $componentes["Grafica"][$grafica]; // Precio de la tarjeta gráfica
$precioAlimentacion = $componentes["Alimentacion"][$alimentacion]; // Precio de la fuente de alimentación

// Cálculo del precio base del PC sumando los precios de los componentes obligatorios seleccionados
// Se obtiene el total de la configuración base del equipo.
$precioBase = $precioProcesador + $precioRam + $precioDisco + $precioGrafica + $precioAlimentacion;

// Cálculo del precio de los accesorios seleccionados
// Se inicializa `$accesorios` como un array vacío y `$precioAccesorios` como 0.
$accesorios = []; // Inicialización del array de accesorios
$precioAccesorios = 0; // Precio total de los accesorios (inicialmente 0)

// Verificar si el usuario seleccionó algún accesorio
// Si `$_POST['accesorios']` está configurado, es decir, se seleccionaron accesorios,
// se asignan a la variable `$accesorios` y se calcula su precio.
if (isset($_POST['accesorios'])) {
    $accesorios = $_POST['accesorios']; // Asignación de los accesorios seleccionados
    // Recorrer cada accesorio y sumar su precio correspondiente al total de accesorios
    foreach ($accesorios as $accesorio) {
        $precioAccesorios += $componentes["Accesorios"][$accesorio]; // Suma el precio de cada accesorio
    }
}

$precioBase = ($precioBase + $precioAccesorios);

// Cálculo del precio total del PC sin aplicar ningún descuento
// Se suma el precio base del PC con el precio de los accesorios, y se multiplica por la cantidad de equipos solicitada.
$precioTotal = $precioBase * $cantidad;

// Aplicación del descuento si el código ingresado es válido
// Se inicializa `$descuento` a 0 y se verifica si el código ingresado existe en el array de `$codigosDescuento`.
$descuento = 0; // Descuento inicial es 0%
if (isset($codigosDescuento[$codigo])) {
    // Si el código es válido, se calcula el porcentaje de descuento
    $descuento = $codigosDescuento[$codigo] / 100; // Calcula el descuento
}

// Cálculo del IVA (21%)
// El IVA se calcula sobre el precio total con el descuento aplicado (si lo hay).
$iva = ($precioTotal - ($precioTotal / 1.21)) * (1-$descuento);

// ============================================= SALIDA ============================================= //

// Mostrar resultados detallados al usuario
// Se construye un desglose de la configuración y precios seleccionados.
echo "<h1>Resumen de tu PC Personalizado</h1>";
echo "<ul>"; // Lista para organizar los resultados
echo "<li><b>Procesador:</b> $procesador - $precioProcesador €</li>"; // Mostrar procesador seleccionado y su precio
echo "<li><b>Memoria RAM:</b> $ram - $precioRam €</li>"; // Mostrar RAM seleccionada y su precio
echo "<li><b>Disco Duro:</b> $disco - $precioDisco €</li>"; // Mostrar disco duro seleccionado y su precio
echo "<li><b>Tarjeta Gráfica:</b> $grafica - $precioGrafica €</li>"; // Mostrar tarjeta gráfica seleccionada y su precio
echo "<li><b>Fuente de Alimentación:</b> $alimentacion - $precioAlimentacion €</li>"; // Mostrar fuente de alimentación seleccionada y su precio

// Si se seleccionaron accesorios, mostrarlos con su respectivo precio
if (!empty($accesorios)) {
    echo "<li><b>Accesorios:</b><ul>";
    // Recorrer cada accesorio seleccionado y mostrarlo en una lista interna
    foreach ($accesorios as $accesorio) {
        echo "<li>$accesorio - " . $componentes["Accesorios"][$accesorio] . " €</li>"; // Mostrar cada accesorio y su precio
    }
    echo "</ul></li>";
} else {
    // Si no se seleccionaron accesorios, mostrar "Ninguno"
    echo "<li><b>Accesorios:</b> Ninguno</li>";
}

echo "</ul>"; // Cierre de la lista de resultados

// Mostrar la cantidad de equipos solicitada
echo "<b>Cantidad de Equipos:</b> $cantidad<br>";

// Mostrar información sobre el código de descuento (si se aplicó o no)
if ($descuento > 0) {
    echo "<b>Código de Descuento:</b> $codigo<br><br>"; // Código de descuento aplicado
} else {
    echo "<b>Código de Descuento:</b> No válido<br><br>"; // Indicar que el código ingresado no es válido
}

echo "<b>Precio por unidad:</b> $precioBase €<br>";
// Mostrar el precio total sin incluir el IVA
echo "<b>Total sin Descuento:</b> $precioTotal €<br>"; // Precio sin IVA
if ($descuento > 0) {
    echo "<b>Descuento Aplicado:</b> ". $precioTotal * $descuento."<br>"; // Código de descuento aplicado
    echo "<b>Total con Descuento:</b> ".$precioTotal * (1-$descuento)."<br>"; // Código de descuento aplicado
}

echo "<br>";

// Mostrar el IVA calculado
echo "<b>IVA (21%):</b> $iva €"; // Monto del IVA
?>