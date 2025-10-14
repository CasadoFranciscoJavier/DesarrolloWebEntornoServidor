<?php
require_once "bbddVeterinaria.php";

function alert($text)
{
    echo "<script> alert('$text');window.location.href = 'veterinaria.html'; </script>";
}

// Función para validar string
function validarString($variablePOST, $minimo, $maximo)
{
    $vacio = empty($_POST[$variablePOST]);
    $valido = false;
    if (!$vacio) {
        $valido = (strlen($_POST[$variablePOST]) >= $minimo && strlen($_POST[$variablePOST]) <= $maximo);
    }
    if ($vacio) {
        alert("$variablePOST está vacío");
    } else if (!$valido) {
        alert("$variablePOST fuera de rango (longitud entre $minimo y $maximo)");
    }
    return $valido;
}

// Función para validar DNI
function validarDNI($dni)
{
    $vacio = empty($_POST["dni"]);
    $valido = false;

    if (!$vacio) {
        if (strlen($dni) == 9) {
            $numeros = substr($dni, 0, 8);
            $letra = substr($dni, 8, 1);

            $valido = is_numeric($numeros) && ctype_alpha($letra);
        }
    }

    if ($vacio) {
        alert("DNI está vacío");
    } else if (!$valido) {
        alert("DNI no válido (debe tener 8 dígitos + 1 letra)");
    }
    return $valido;
}

// Función para validar selección
function validarSeleccion($variablePOST)
{
    $vacio = empty($_POST[$variablePOST]);
    if ($vacio) {
        alert("Debes seleccionar $variablePOST");
    }
    return !$vacio;
}

//============================= main =============================

$todoValido = false;
$precioServicio = 0;
$precioExtras = 0;
$subtotal = 0;
$descuentoAplicado = 0;
$totalConDescuento = 0;
$IVA_PORCENTAJE = 0.10;
$totalIVA = 0;
$precioFinal = 0;
$mensajeDescuento = "";
$lista_extras = "";
$descuentoTasa = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $todoValido = validarString("nombre", 2, 30)
        && validarString("apellidos", 2, 40)
        && validarDNI($_POST["dni"])
        && validarSeleccion("servicio")
        && validarSeleccion("mascota")
        && validarSeleccion("urgencia");

    if ($todoValido) {
        $nombre = htmlspecialchars($_POST["nombre"]);
        $apellidos = htmlspecialchars($_POST["apellidos"]);
        $dni = htmlspecialchars($_POST["dni"]);
        $servicio = $_POST["servicio"];
        $mascota = $_POST["mascota"];
        $urgenciaSeleccionada = $_POST["urgencia"];

        $codigoPromoIngresado = isset($_POST["codigo"]) ? $_POST["codigo"] : "";
        $extrasSeleccionados = isset($_POST["extras"]) ? $_POST["extras"] : [];

        // Calcular precios
        $precioBaseServicio = $servicios[$servicio];
        $multiplicadorMascota = $mascotas[$mascota];
        $multiplicadorUrgencia = $urgencia[$urgenciaSeleccionada];
        $precioServicio = $precioBaseServicio * $multiplicadorMascota * $multiplicadorUrgencia;

        // Procesar extras
        $precioExtras = 0;
        if (!empty($extrasSeleccionados) && is_array($extrasSeleccionados)) {
            $lista_extras .= "<ul>";
            foreach ($extrasSeleccionados as $extra) {
                $precioExtra = $extras[$extra];
                $precioExtras += $precioExtra;
                $lista_extras .= "<li>" . htmlspecialchars($extra) . " - " . $precioExtra . " ¬</li>";
            }
            $lista_extras .= "</ul>";
        } else {
            $lista_extras = "<p>No seleccionaste ningún servicio adicional.</p>";
        }

        // Procesar código de promoción
        if (!empty($codigoPromoIngresado)) {
            if (array_key_exists($codigoPromoIngresado, $codigos)) {
                $descuentoPorcentaje = $codigos[$codigoPromoIngresado];
                $descuentoTasa = $descuentoPorcentaje / 100;
                $mensajeDescuento = "Código Promoción: <b>" . htmlspecialchars($codigoPromoIngresado) . "</b> (" . $descuentoPorcentaje . "% aplicado)";
            } else {
                $mensajeDescuento = "Código Promoción: No válido";
                $descuentoTasa = 0;
            }
        } else {
            $mensajeDescuento = "Código Promoción: No ingresado";
        }

        // Calcular totales
        $subtotal = $precioServicio + $precioExtras;
        $descuentoAplicado = $subtotal * $descuentoTasa;
        $totalConDescuento = $subtotal - $descuentoAplicado;
        $totalIVA = $totalConDescuento * $IVA_PORCENTAJE;
        $precioFinal = $totalConDescuento + $totalIVA;
    }
} else {
    alert("Método de solicitud no válido");
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen de Cita - Veterinaria</title>
</head>

<body>
    <div class="contenedor">
        <h1>CLÍNICA VETERINARIA - RESUMEN DE CITA</h1>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && $todoValido): ?>

            <h2>Datos del Propietario</h2>
            <p><strong>Nombre Completo:</strong> <?php echo $nombre . " " . $apellidos; ?></p>
            <p><strong>DNI:</strong> <?php echo $dni; ?></p>

            <h2>Detalles de la Cita</h2>
            <p><strong>Servicio:</strong> <?php echo htmlspecialchars($servicio); ?></p>
            <p><strong>Tipo de Mascota:</strong> <?php echo htmlspecialchars($mascota); ?></p>
            <p><strong>Tipo de Cita:</strong> <?php echo htmlspecialchars($urgenciaSeleccionada); ?></p>
            <p><strong>Coste servicio:</strong> <?php echo number_format($precioServicio, 2); ?> ¬ (<?php echo $precioBaseServicio; ?> ¬ × <?php echo $multiplicadorMascota; ?> × <?php echo $multiplicadorUrgencia; ?>)</p>

            <h2>Servicios Adicionales</h2>
            <?php echo $lista_extras; ?>
            <?php if ($precioExtras > 0): ?>
                <p><strong>Total servicios adicionales:</strong> <?php echo $precioExtras; ?> ¬</p>
            <?php endif; ?>

            <h2>Resumen de Costes</h2>
            <ul>
                <li><strong>Servicio:</strong> <?php echo number_format($precioServicio, 2); ?> ¬</li>
                <li><strong>Extras:</strong> <?php echo $precioExtras; ?> ¬</li>
                <li><strong>Subtotal:</strong> <?php echo number_format($subtotal, 2); ?> ¬</li>
            </ul>

            <div class="total-line">
                <p><?php echo $mensajeDescuento; ?></p>
                <?php if ($descuentoTasa > 0): ?>
                    <ul>
                        <li><strong>Descuento:</strong> - <?php echo number_format($descuentoAplicado, 2); ?> ¬</li>
                        <li><strong>Total con descuento:</strong> <?php echo number_format($totalConDescuento, 2); ?> ¬</li>
                    </ul>
                <?php endif; ?>
            </div>

            <div class="total-line">
                <p><strong>IVA (10%):</strong> + <?php echo number_format($totalIVA, 2); ?> ¬</p>
            </div>

            <div class="final-price">
                <strong>TOTAL FINAL:</strong> <?php echo number_format($precioFinal, 2); ?> ¬
            </div>

        <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>

            <p style="color:red; font-weight:bold;">Se encontraron errores en el formulario. Por favor, revisa las alertas y completa todos los campos obligatorios.</p>

        <?php else: ?>
            <p>Por favor, envía el formulario de cita para generar el resumen.</p>
        <?php endif; ?>
    </div>
</body>

<style>
    body {
        background: #f3f6f9;
        font-family: Arial, sans-serif;
        color: #333;
        padding: 20px;
    }

    .contenedor {
        background: #fff;
        max-width: 700px;
        margin: 40px auto;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border: 1px solid #ddd;
    }

    h1,
    h2 {
        color: #4a6fa5;
        border-bottom: 1px solid #eee;
        padding-bottom: 5px;
        margin-top: 20px;
    }

    p,
    ul {
        margin: 12px 0;
        font-size: 1.08em;
    }

    li {
        margin-bottom: 4px;
    }

    strong {
        font-weight: bold;
    }

    .total-line {
        padding: 5px 0;
        border-top: 1px dashed #ccc;
        margin-top: 15px;
    }

    .final-price {
        font-size: 1.3em;
        color: #ffffff;
        background-color: #4a6fa5;
        font-weight: bold;
        border-top: 2px solid #4a6fa5;
        text-align: center;
        padding: 15px;
        margin-top: 15px;
        border-radius: 6px;
    }
</style>

</html>
