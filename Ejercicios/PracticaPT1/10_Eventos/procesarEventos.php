<?php
require_once "bbddEventos.php";

function alert($text)
{
    echo "<script> alert('$text');window.location.href = 'eventos.html'; </script>";
}

// Funci�n para validar string
function validarString($variablePOST, $minimo, $maximo)
{
    $vacio = empty($_POST[$variablePOST]);
    $valido = false;
    if (!$vacio) {
        $valido = (strlen($_POST[$variablePOST]) >= $minimo && strlen($_POST[$variablePOST]) <= $maximo);
    }
    if ($vacio) {
        alert("$variablePOST est� vac�o");
    } else if (!$valido) {
        alert("$variablePOST fuera de rango (longitud entre $minimo y $maximo)");
    }
    return $valido;
}

// Funci�n para validar DNI
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
        alert("DNI est� vac�o");
    } else if (!$valido) {
        alert("DNI no v�lido (debe tener 8 d�gitos + 1 letra)");
    }
    return $valido;
}

// Funci�n para validar entero
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
        alert("$variablePOST est� vac�o");
    } else if ($esEntero == false) {
        alert("$variablePOST debe ser un n�mero entero");
    } else if (!$valido) {
        alert("$variablePOST fuera de rango (entre $minimo y $maximo)");
    }

    return $valido;
}

// Funci�n para validar selecci�n
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
$precioEvento = 0;
$precioMenu = 0;
$precioServicios = 0;
$subtotal = 0;
$descuentoAplicado = 0;
$totalConDescuento = 0;
$IVA_PORCENTAJE = 0.10;
$totalIVA = 0;
$precioFinal = 0;
$mensajeDescuento = "";
$lista_servicios = "";
$descuentoTasa = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $todoValido = validarString("nombre", 2, 30)
        && validarString("apellidos", 2, 40)
        && validarDNI($_POST["dni"])
        && validarInt("invitados", 1, 500)
        && validarSeleccion("evento")
        && validarSeleccion("menu")
        && validarSeleccion("temporada");

    if ($todoValido) {
        $nombre = htmlspecialchars($_POST["nombre"]);
        $apellidos = htmlspecialchars($_POST["apellidos"]);
        $dni = htmlspecialchars($_POST["dni"]);
        $invitados = (int)$_POST["invitados"];
        $evento = $_POST["evento"];
        $menu = $_POST["menu"];
        $temporadaSeleccionada = $_POST["temporada"];

        $codigoPromoIngresado = isset($_POST["codigo"]) ? $_POST["codigo"] : "";
        $serviciosSeleccionados = isset($_POST["servicios"]) ? $_POST["servicios"] : [];

        // Calcular precios
        $precioBaseEvento = $eventos[$evento];
        $precioBaseMenu = $menus[$menu];
        $multiplicadorTemporada = $temporada[$temporadaSeleccionada];

        $precioEvento = $precioBaseEvento * $invitados * $multiplicadorTemporada;
        $precioMenu = $precioBaseMenu * $invitados * $multiplicadorTemporada;

        // Procesar servicios
        $precioServicios = 0;
        if (!empty($serviciosSeleccionados) && is_array($serviciosSeleccionados)) {
            $lista_servicios .= "<ul>";
            foreach ($serviciosSeleccionados as $servicio) {
                $precioServicio = $servicios[$servicio];
                if ($servicio == "Barra Libre") {
                    $precioTotal = $precioServicio * $invitados;
                    $precioServicios += $precioTotal;
                    $lista_servicios .= "<li>" . htmlspecialchars($servicio) . " - " . $precioServicio . " �/persona � " . $invitados . " = " . $precioTotal . " �</li>";
                } else {
                    $precioServicios += $precioServicio;
                    $lista_servicios .= "<li>" . htmlspecialchars($servicio) . " - " . $precioServicio . " �</li>";
                }
            }
            $lista_servicios .= "</ul>";
        } else {
            $lista_servicios = "<p>No seleccionaste ning�n servicio adicional.</p>";
        }

        // Procesar c�digo de promoci�n
        if (!empty($codigoPromoIngresado)) {
            if (array_key_exists($codigoPromoIngresado, $codigos)) {
                $descuentoPorcentaje = $codigos[$codigoPromoIngresado];
                $descuentoTasa = $descuentoPorcentaje / 100;
                $mensajeDescuento = "C�digo Promoci�n: <b>" . htmlspecialchars($codigoPromoIngresado) . "</b> (" . $descuentoPorcentaje . "% aplicado)";
            } else {
                $mensajeDescuento = "C�digo Promoci�n: No v�lido";
                $descuentoTasa = 0;
            }
        } else {
            $mensajeDescuento = "C�digo Promoci�n: No ingresado";
        }

        // Calcular totales
        $subtotal = $precioEvento + $precioMenu + $precioServicios;
        $descuentoAplicado = $subtotal * $descuentoTasa;
        $totalConDescuento = $subtotal - $descuentoAplicado;
        $totalIVA = $totalConDescuento * $IVA_PORCENTAJE;
        $precioFinal = $totalConDescuento + $totalIVA;
    }
} else {
    alert("M�todo de solicitud no v�lido");
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen de Evento - Catering</title>
</head>

<body>
    <div class="contenedor">
        <h1>ORGANIZACI�N DE EVENTOS - RESUMEN</h1>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && $todoValido): ?>

            <h2>Datos del Cliente</h2>
            <p><strong>Nombre Completo:</strong> <?php echo $nombre . " " . $apellidos; ?></p>
            <p><strong>DNI:</strong> <?php echo $dni; ?></p>

            <h2>Detalles del Evento</h2>
            <p><strong>Tipo de Evento:</strong> <?php echo htmlspecialchars($evento); ?></p>
            <p><strong>Men�:</strong> <?php echo htmlspecialchars($menu); ?></p>
            <p><strong>N�mero de Invitados:</strong> <?php echo $invitados; ?></p>
            <p><strong>Temporada:</strong> <?php echo htmlspecialchars($temporadaSeleccionada); ?></p>

            <h2>Costes por Persona</h2>
            <ul>
                <li><strong>Coste evento:</strong> <?php echo number_format($precioEvento, 2); ?> � (<?php echo $precioBaseEvento; ?> � � <?php echo $invitados; ?> � <?php echo $multiplicadorTemporada; ?>)</li>
                <li><strong>Coste men�:</strong> <?php echo number_format($precioMenu, 2); ?> � (<?php echo $precioBaseMenu; ?> � � <?php echo $invitados; ?> � <?php echo $multiplicadorTemporada; ?>)</li>
            </ul>

            <h2>Servicios Adicionales</h2>
            <?php echo $lista_servicios; ?>
            <?php if ($precioServicios > 0): ?>
                <p><strong>Total servicios:</strong> <?php echo number_format($precioServicios, 2); ?> �</p>
            <?php endif; ?>

            <h2>Resumen de Costes</h2>
            <ul>
                <li><strong>Evento:</strong> <?php echo number_format($precioEvento, 2); ?> �</li>
                <li><strong>Men�:</strong> <?php echo number_format($precioMenu, 2); ?> �</li>
                <li><strong>Servicios:</strong> <?php echo number_format($precioServicios, 2); ?> �</li>
                <li><strong>Subtotal:</strong> <?php echo number_format($subtotal, 2); ?> �</li>
            </ul>

            <div class="total-line">
                <p><?php echo $mensajeDescuento; ?></p>
                <?php if ($descuentoTasa > 0): ?>
                    <ul>
                        <li><strong>Descuento:</strong> - <?php echo number_format($descuentoAplicado, 2); ?> �</li>
                        <li><strong>Total con descuento:</strong> <?php echo number_format($totalConDescuento, 2); ?> �</li>
                    </ul>
                <?php endif; ?>
            </div>

            <div class="total-line">
                <p><strong>IVA (10%):</strong> + <?php echo number_format($totalIVA, 2); ?> �</p>
            </div>

            <div class="final-price">
                <strong>TOTAL FINAL:</strong> <?php echo number_format($precioFinal, 2); ?> �
            </div>

        <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>

            <p style="color:red; font-weight:bold;">Se encontraron errores en el formulario. Por favor, revisa las alertas y completa todos los campos obligatorios.</p>

        <?php else: ?>
            <p>Por favor, env�a el formulario de evento para generar el resumen.</p>
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
