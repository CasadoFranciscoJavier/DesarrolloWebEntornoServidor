<?php

require_once "inventario.php";

function alert($text)
{
    echo "<script> alert('$text');window.location.href = 'laboratorioHalloween.html'; </script>";
}

function validarInt($variablePOST, $minimo)
{
    $vacio = empty($_POST[$variablePOST]);
    $valido = false;
    $esEntero = false;

    if (!$vacio) {
        $esEntero = filter_var($_POST[$variablePOST], FILTER_VALIDATE_INT);

        if ($esEntero !== false) {
            $valido = ($_POST[$variablePOST] >= $minimo);
        }
    }

    if ($vacio) {
        alert("$variablePOST está vacío");
    } else if ($esEntero == false) {
        alert("$variablePOST debe ser un número entero");
    } else if (!$valido) {
        alert("$variablePOST fuera de rango (Debe ser mayor que $minimo)");
    }

    return $valido;
}

function validarSeleccion($variablePOST)
{
    $vacio = empty($_POST[$variablePOST]);
    if ($vacio) {
        alert("Debes seleccionar una opción para $variablePOST");
    }
    return !$vacio;
}

//============================= main =============================

$todoValido = false;
$precioPorCriatura = 0;
$precioRepuestos = 0;
$precioConservantes = 0;
$subtotal = 0;
$descuentoAplicado = 0;
$totalConDescuento = 0;
$mensajeDescuento = "0%";
$descuentoTasa = 0;
$costeTotalExperimento = 0;

$listaRepuestosNombres = [];
$listaConservantesNombres = [];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $todoValido = validarSeleccion("torsos")
        && validarSeleccion("cerebros")
        && validarSeleccion("reanimacion")
        && validarSeleccion("repuestos")
        && validarSeleccion("conservantes")
        && validarInt("cantidad", 1);

    if ($todoValido) {
        $torso = htmlspecialchars($_POST["torsos"]);
        $cerebro = htmlspecialchars($_POST["cerebros"]);
        $reanimacion = htmlspecialchars($_POST["reanimacion"]);
        $cantidad = (int)$_POST["cantidad"];

        $listaRepuestos = isset($_POST["repuestos"]) && is_array($_POST["repuestos"]) ? $_POST["repuestos"] : [];
        $listaConservantes = isset($_POST["conservantes"]) && is_array($_POST["conservantes"]) ? $_POST["conservantes"] : [];



        $precioPorCriatura += $inventario["torsos"][$torso]["precio"];
        $precioPorCriatura += $inventario["cerebros"][$cerebro]["precio"];
        $precioPorCriatura += $inventario["reanimacion"][$reanimacion]["precio"];

        foreach ($listaRepuestos as $repuesto) {
            if (isset($inventario["repuestos"][$repuesto])) {
                $precioRepuestos += $inventario["repuestos"][$repuesto]["precio"];
                $listaRepuestosNombres[] = $inventario["repuestos"][$repuesto]["nombre_completo"];
            }
        }
        $precioPorCriatura += $precioRepuestos;

        foreach ($listaConservantes as $conservante) {
            if (isset($inventario["conservantes"][$conservante])) {
                $precioConservantes += $inventario["conservantes"][$conservante]["precio"];
                $listaConservantesNombres[] = $inventario["conservantes"][$conservante]["nombre_completo"];
            }
        }
        $precioPorCriatura += $precioConservantes;



        $subtotal = $precioPorCriatura * $cantidad;


        if ($cantidad < 100) {
            $descuentoPorcentaje = 0;
        } elseif ($cantidad >= 100 && $cantidad < 200) {
            $descuentoPorcentaje = 5;
        } elseif ($cantidad >= 200) {
            $descuentoPorcentaje = 10;
        }

        $descuentoTasa = $descuentoPorcentaje / 100;
        $descuentoAplicado = $subtotal * $descuentoTasa;
        $totalConDescuento = $subtotal - $descuentoAplicado;

        $mensajeDescuento = "{$descuentoPorcentaje}% (Aplicado: " . number_format($descuentoAplicado, 2) . " €)";

        $costeTotalExperimento = $totalConDescuento;
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
    <title>Resumen del Pedido - Laboratorio Halloween</title>
</head>

<body>
    <div class="contenedor">
        <h1>RESUMEN DEL PEDIDO - EXPERIMENTO FRANKENSTEIN</h1>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && $todoValido): ?>

            <h2>Inventario Seleccionado:</h2>

            <p><strong>Repuestos:</strong><br>
                <?php
                if (!empty($listaRepuestosNombres)) {
                    foreach ($listaRepuestosNombres as $nombre) {
                        echo htmlspecialchars($nombre) . '<br>';
                    }
                } else {
                    echo "Ninguno";
                }
                ?>
            </p> (Total: <?php echo number_format($precioRepuestos, 2); ?> €/ud.)
            </p>

            <p><strong>Torso:</strong><br>
                <?php echo htmlspecialchars($inventario["torsos"][$torso]["nombre_completo"]); ?>
                (<?php echo number_format($inventario["torsos"][$torso]["precio"], 2); ?> €/ud.)
            </p>

            <p><strong>Cerebro:</strong><br>
                <?php echo htmlspecialchars($inventario["cerebros"][$cerebro]["nombre_completo"]); ?>
                (<?php echo number_format($inventario["cerebros"][$cerebro]["precio"], 2); ?> €/ud.)
            </p>

            <p><strong>Reanimación:</strong><br>
                <?php echo htmlspecialchars($inventario["reanimacion"][$reanimacion]["nombre_completo"]); ?>
                (<?php echo number_format($inventario["reanimacion"][$reanimacion]["precio"], 2); ?> €/ud.)
            </p>

            <p><strong>Conservantes:</strong><br>
                <?php
                if (!empty($listaConservantesNombres)) {
                    foreach ($listaConservantesNombres as $nombre) {
                        echo htmlspecialchars($nombre) . '<br>';
                    }
                } else {
                    echo "Ninguno";
                }
                ?>
            </p> (Total: <?php echo number_format($precioConservantes, 2); ?> €/ud.)

            <hr>

            <h2>Cálculo del Coste</h2>

            <p><strong>Precio por Criatura:</strong> <?php echo number_format($precioPorCriatura, 2); ?> €</p>

            <p><strong>Número de Criaturas:</strong> <?php echo $cantidad; ?></p>

            <p><strong>Subtotal (sin descuento):</strong> <?php echo number_format($subtotal, 2); ?> €</p>

            <div class="total-line total-discount-summary">
                <p><strong>Descuento Aplicado:</strong> <?php echo $mensajeDescuento; ?></p>
                <p><strong>Total con Descuento:</strong> <?php echo number_format($totalConDescuento, 2); ?> €</p>
            </div>

            <div class="final-price">
                <strong>COSTE TOTAL DEL EXPERIMENTO:</strong> <?php echo number_format($costeTotalExperimento, 2); ?> €
            </div>

        <?php else: ?>
            <p>Por favor, envía el formulario desde la página principal para generar el resumen.</p>
        <?php endif; ?>
    </div>
</body>

<style>
    body {
        background: #ffffffff;
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