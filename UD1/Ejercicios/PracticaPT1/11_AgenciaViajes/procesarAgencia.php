<?php
require_once "bbddAgencia.php";

function alert($text)
{
    echo "<script> alert('$text');window.location.href = 'viajes.html'; </script>";
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

// Función para validar entero
function validarInt($variablePOST, $minimo, $maximo)
{
    $vacio = empty($_POST[$variablePOST]);
    $valido = false;
    $esEntero = false;

    if (!$vacio) {
        $esEntero = filter_var($_POST[$variablePOST], FILTER_VALIDATE_INT);

        if ($esEntero !== false) {
            $valido = (($_POST[$variablePOST] >= $minimo)
                && ($_POST[$variablePOST] <= $maximo));
        }
    }

    if ($vacio) {
        alert("$variablePOST está vacío");
    } else if ($esEntero == false) {
        alert("$variablePOST debe ser un número entero");
    } else if (!$valido) {
        alert("$variablePOST fuera de rango (entre $minimo y $maximo)");
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
$precioVehiculo = 0;
$precioSeguros = 0;
$costeGasolina = 0;
$subtotal = 0;
$descuentoAplicado = 0;
$totalConDescuento = 0;
$IVA_PORCENTAJE = 0.10;
$totalIVA = 0;
$precioFinal = 0;
$mensajeDescuento = "";
$lista_seguros = "";
$descuentoTasa = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $todoValido = validarString("nombre", 2, 30)
        && validarString("apellidos", 2, 40)
        && validarDNI($_POST["dni"])
        && validarInt("dias", 1, 30)
        && validarInt("kmestimados", 1, 3000)
        && validarSeleccion("vehiculo")
        && validarSeleccion("kilometraje");

    if ($todoValido) {
        $nombre = htmlspecialchars($_POST["nombre"]);
        $apellidos = htmlspecialchars($_POST["apellidos"]);
        $dni = htmlspecialchars($_POST["dni"]);
        $dias = (int)$_POST["dias"];
        $kmEstimados = (int)$_POST["kmestimados"];
        $vehiculo = $_POST["vehiculo"];
        $kilometrajeSeleccionado = $_POST["kilometraje"];

        $codigoPromoIngresado = isset($_POST["codigo"]) ? $_POST["codigo"] : "";
        $segurosSeleccionados = isset($_POST["seguros"]) ? $_POST["seguros"] : [];

        // Calcular precios
        $precioBaseVehiculo = $vehiculos[$vehiculo];
        $multiplicadorKilometraje = $kilometraje[$kilometrajeSeleccionado];
        $precioVehiculo = $precioBaseVehiculo * $multiplicadorKilometraje * $dias;

        // Calcular coste de gasolina
        $consumoVehiculo = $consumo[$vehiculo];
        $litrosNecesarios = ($kmEstimados / 100) * $consumoVehiculo;
        $costeGasolina = $litrosNecesarios * $PRECIO_GASOLINA;

        // Procesar seguros
        $precioSeguros = 0;
        if (!empty($segurosSeleccionados) && is_array($segurosSeleccionados)) {
            $lista_seguros .= "<ul>";
            foreach ($segurosSeleccionados as $seguro) {
                $precioSeguro = $seguros[$seguro];
                $precioTotal = $precioSeguro * $dias;
                $precioSeguros += $precioTotal;
                $lista_seguros .= "<li>" . htmlspecialchars($seguro) . " - " . $precioSeguro . " €/día × " . $dias . " = " . $precioTotal . " €</li>";
            }
            $lista_seguros .= "</ul>";
        } else {
            $lista_seguros = "<p>No seleccionaste ningún seguro o extra.</p>";
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

        // Calcular totales (la gasolina NO se incluye en el descuento)
        $subtotal = $precioVehiculo + $precioSeguros;
        $descuentoAplicado = $subtotal * $descuentoTasa;
        $totalConDescuento = $subtotal - $descuentoAplicado;
        $totalIVA = $totalConDescuento * $IVA_PORCENTAJE;
        $precioFinal = $totalConDescuento + $totalIVA + $costeGasolina;
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
    <title>Resumen de Alquiler - Agencia de Viajes</title>
</head>

<body>
    <div class="contenedor">
        <h1>AGENCIA DE VIAJES - RESUMEN DE ALQUILER</h1>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && $todoValido): ?>

            <h2>Datos del Cliente</h2>
            <p><strong>Nombre Completo:</strong> <?php echo $nombre . " " . $apellidos; ?></p>
            <p><strong>DNI:</strong> <?php echo $dni; ?></p>

            <h2>Vehículo Seleccionado</h2>
            <p><strong>Tipo:</strong> <?php echo htmlspecialchars($vehiculo); ?></p>
            <p><strong>Días de alquiler:</strong> <?php echo $dias; ?></p>
            <p><strong>Kilometraje incluido:</strong> <?php echo htmlspecialchars($kilometrajeSeleccionado); ?></p>
            <p><strong>Coste vehículo:</strong> <?php echo number_format($precioVehiculo, 2); ?> € (<?php echo $precioBaseVehiculo; ?> € × <?php echo $multiplicadorKilometraje; ?> × <?php echo $dias; ?> días)</p>

            <h2>Seguros y Extras</h2>
            <?php echo $lista_seguros; ?>
            <?php if ($precioSeguros > 0): ?>
                <p><strong>Total seguros y extras:</strong> <?php echo number_format($precioSeguros, 2); ?> €</p>
            <?php endif; ?>

            <h2>Coste de Gasolina Estimado</h2>
            <p><strong>Kilómetros estimados:</strong> <?php echo $kmEstimados; ?> km</p>
            <p><strong>Consumo del vehículo:</strong> <?php echo $consumoVehiculo; ?> L/100km</p>
            <p><strong>Litros necesarios:</strong> <?php echo number_format($litrosNecesarios, 2); ?> L</p>
            <p><strong>Precio gasolina:</strong> <?php echo $PRECIO_GASOLINA; ?> €/L</p>
            <p><strong>Coste gasolina:</strong> <?php echo number_format($costeGasolina, 2); ?> €</p>

            <h2>Resumen de Costes</h2>
            <ul>
                <li><strong>Vehículo:</strong> <?php echo number_format($precioVehiculo, 2); ?> €</li>
                <li><strong>Seguros y extras:</strong> <?php echo number_format($precioSeguros, 2); ?> €</li>
                <li><strong>Subtotal:</strong> <?php echo number_format($subtotal, 2); ?> €</li>
            </ul>

            <div class="total-line">
                <p><?php echo $mensajeDescuento; ?></p>
                <?php if ($descuentoTasa > 0): ?>
                    <ul>
                        <li><strong>Descuento:</strong> - <?php echo number_format($descuentoAplicado, 2); ?> €</li>
                        <li><strong>Total con descuento:</strong> <?php echo number_format($totalConDescuento, 2); ?> €</li>
                    </ul>
                <?php endif; ?>
            </div>

            <div class="total-line">
                <p><strong>IVA (10%):</strong> + <?php echo number_format($totalIVA, 2); ?> €</p>
            </div>

            <div class="total-line">
                <p><strong>Gasolina estimada:</strong> + <?php echo number_format($costeGasolina, 2); ?> € (no incluida en descuento)</p>
            </div>

            <div class="final-price">
                <strong>TOTAL FINAL:</strong> <?php echo number_format($precioFinal, 2); ?> €
            </div>

        <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>

            <p style="color:red; font-weight:bold;">Se encontraron errores en el formulario. Por favor, revisa las alertas y completa todos los campos obligatorios.</p>

        <?php else: ?>
            <p>Por favor, envía el formulario de alquiler para generar el resumen.</p>
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
