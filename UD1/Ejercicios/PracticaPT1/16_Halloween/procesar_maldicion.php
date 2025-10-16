<?php
require_once "bbddAquelarre.php";

function alert($text)
{
    echo "<script> alert('$text');window.location.href = 'aquelarre.html'; </script>";
}

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
$costoServicioBase = 0;
$costoObjetos = 0;
$subtotal = 0;
$descuentoAplicado = 0;
$totalConDescuento = 0;
$IMPUESTO_PORCENTAJE = 0.13;
$totalImpuesto = 0;
$precioFinal = 0;
$mensajeDescuento = "";
$lista_objetos_html = "";
$descuentoTasa = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $todoValido = validarString("nombreAquelarre", 3, 30)
        && validarString("solicitante", 2, 40)
        && validarInt("intensidad", 1, 5)
        && validarSeleccion("tipoMaldicion")
        && validarSeleccion("duracionMaldicion");

    if ($todoValido) {
        $nombreAquelarre = htmlspecialchars($_POST["nombreAquelarre"]);
        $solicitante = htmlspecialchars($_POST["solicitante"]);
        $intensidad = (int)$_POST["intensidad"];
        $tipoMaldicion = $_POST["tipoMaldicion"];
        $duracionMaldicion = $_POST["duracionMaldicion"];

        $codigoHechizo = isset($_POST["codigoHechizo"]) ? strtoupper(htmlspecialchars(trim($_POST["codigoHechizo"]))) : "";
        $objetosSeleccionados = isset($_POST["objetos"]) ? $_POST["objetos"] : [];

        // Calcular costo base del servicio
        $costoTipo = $tiposMaldicion[$tipoMaldicion];
        $multiplicadorDuracion = $duraciones[$duracionMaldicion];
        $costoServicioBase = $intensidad * $costoTipo * $multiplicadorDuracion;

        // Procesar objetos de ritual
        $costoObjetos = 0;
        if (!empty($objetosSeleccionados) && is_array($objetosSeleccionados)) {
            $lista_objetos_html .= "<ul>";
            foreach ($objetosSeleccionados as $objeto) {
                $precioObjeto = $objetosRitual[$objeto];
                $costoObjetos += $precioObjeto;
                $lista_objetos_html .= "<li>" . htmlspecialchars($objeto) . " - " . $precioObjeto . " G.O.</li>";
            }
            $lista_objetos_html .= "</ul>";
        } else {
            $lista_objetos_html = "<p>Ningún objeto de ritual adicional seleccionado.</p>";
        }

        // Procesar código de promoción/hechizo
        if (!empty($codigoHechizo)) {
            if (array_key_exists($codigoHechizo, $hechizosDescuento)) {
                $descuentoPorcentaje = $hechizosDescuento[$codigoHechizo];
                $descuentoTasa = $descuentoPorcentaje / 100;
                $mensajeDescuento = "Código Hechizo: <b>" . $codigoHechizo . "</b> (" . $descuentoPorcentaje . "% aplicado)";
            } else {
                $mensajeDescuento = "Código Hechizo: No válido (¡Solo un truco!)";
                $descuentoTasa = 0;
            }
        } else {
            $mensajeDescuento = "Código Hechizo: No ingresado";
        }

        // Calcular totales
        $subtotal = $costoServicioBase + $costoObjetos;
        $descuentoAplicado = $subtotal * $descuentoTasa;
        $totalConDescuento = $subtotal - $descuentoAplicado;
        $totalImpuesto = $totalConDescuento * $IMPUESTO_PORCENTAJE;
        $precioFinal = $totalConDescuento + $totalImpuesto;
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
    <title>Recibo del Aquelarre - Halloween</title>
</head>

<body>
    <div class="contenedor">
        <h1>REPORTE DE MALDICIÓN 💀</h1>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && $todoValido): ?>

            <h2>Datos del Contrato</h2>
            <p><strong>Aquelarre:</strong> <?php echo $nombreAquelarre; ?></p>
            <p><strong>Solicitante:</strong> <?php echo $solicitante; ?></p>

            <h2>Servicio de Maldición</h2>
            <p><strong>Tipo:</strong> <?php echo htmlspecialchars($tipoMaldicion); ?></p>
            <p><strong>Intensidad:</strong> <?php echo $intensidad; ?> Calaveras</p>
            <p><strong>Duración:</strong> <?php echo htmlspecialchars($duracionMaldicion); ?></p>
            <p><strong>Costo Base:</strong> <?php echo $costoServicioBase; ?> G.O. (<?php echo $intensidad; ?> × <?php echo $costoTipo; ?> G.O. × <?php echo $multiplicadorDuracion; ?>)</p>

            <h2>Objetos de Ritual (Adicionales)</h2>
            <?php echo $lista_objetos_html; ?>
            <?php if ($costoObjetos > 0): ?>
                <p><strong>Total Objetos:</strong> <?php echo $costoObjetos; ?> G.O.</p>
            <?php endif; ?>

            <h2>Resumen del Presupuesto</h2>
            <ul>
                <li><strong>Costo Base:</strong> <?php echo $costoServicioBase; ?> G.O.</li>
                <li><strong>Objetos:</strong> <?php echo $costoObjetos; ?> G.O.</li>
                <li><strong>Subtotal:</strong> <?php echo $subtotal; ?> G.O.</li>
            </ul>

            <div class="total-line">
                <p><?php echo $mensajeDescuento; ?></p>
                <?php if ($descuentoTasa > 0): ?>
                    <ul>
                        <li><strong>Descuento Hechizo:</strong> - <?php echo number_format($descuentoAplicado, 2); ?> G.O.</li>
                        <li><strong>Total con Descuento:</strong> <?php echo number_format($totalConDescuento, 2); ?> G.O.</li>
                    </ul>
                <?php endif; ?>
            </div>

            <div class="total-line">
                <p><strong>Impuesto de las Tierras Malditas (13%):</strong> + <?php echo number_format($totalImpuesto, 2); ?> G.O.</p>
            </div>

            <div class="final-price">
                <strong>TOTAL A PAGAR:</strong> <?php echo number_format($precioFinal, 2); ?> G.O.
            </div>

        <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>

            <p style="color:red; font-weight:bold;">Se encontraron errores en el pergamino. ¡Asegúrate de haber completado todos los sellos!</p>

        <?php else: ?>
            <p>Por favor, envía el formulario de contratación del Aquelarre para obtener tu reporte.</p>
        <?php endif; ?>
    </div>
</body>
</html>