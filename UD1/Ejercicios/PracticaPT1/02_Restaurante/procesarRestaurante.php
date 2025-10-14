<?php
require_once "bbddRestaurante.php";

function alert($text)
{
    echo "<script> alert('$text');window.location.href = 'restaurante.html'; </script>";
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

// Función para validar teléfono
function validarTelefono($telefono)
{
    $vacio = empty($_POST["telefono"]);
    $valido = false;

    if (!$vacio) {
        $valido = (strlen($telefono) == 9 && is_numeric($telefono));
    }

    if ($vacio) {
        alert("Teléfono está vacío");
    } else if (!$valido) {
        alert("Teléfono no válido (debe tener 9 dígitos)");
    }
    return $valido;
}

// Función para validar email
function validarEmail($email)
{
    $vacio = empty($_POST["email"]);
    $valido = false;

    if (!$vacio) {
        $valido = filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    if ($vacio) {
        alert("Email está vacío");
    } else if (!$valido) {
        alert("Email no válido");
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
$precioMenu = 0;
$precioMenuConMultiplicadores = 0;
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
        && validarTelefono($_POST["telefono"])
        && validarEmail($_POST["email"])
        && validarInt("comensales", 1, 20)
        && validarSeleccion("menu")
        && validarSeleccion("dia")
        && validarSeleccion("turno");

    if ($todoValido) {
        $nombre = htmlspecialchars($_POST["nombre"]);
        $telefono = htmlspecialchars($_POST["telefono"]);
        $email = htmlspecialchars($_POST["email"]);
        $comensales = (int)$_POST["comensales"];
        $menu = $_POST["menu"];
        $dia = $_POST["dia"];
        $turno = $_POST["turno"];

        $codigoPromoIngresado = isset($_POST["codigo"]) ? $_POST["codigo"] : "";
        $serviciosSeleccionados = isset($_POST["servicios"]) ? $_POST["servicios"] : [];

        // Calcular precios
        $precioMenuPorPersona = $menus[$menu];
        $multiplicadorDia = $dias[$dia];
        $multiplicadorTurno = $turnos[$turno];

        $precioMenu = $comensales * $precioMenuPorPersona;
        $precioMenuConDia = $precioMenu * $multiplicadorDia;
        $precioMenuConMultiplicadores = $precioMenuConDia * $multiplicadorTurno;

        // Procesar servicios adicionales
        $precioServicios = 0;
        if (!empty($serviciosSeleccionados) && is_array($serviciosSeleccionados)) {
            $lista_servicios .= "<ul>";
            foreach ($serviciosSeleccionados as $servicio) {
                $precioServicio = $servicios[$servicio];
                $precioServicios += $precioServicio;
                $lista_servicios .= "<li>" . htmlspecialchars($servicio) . " - " . $precioServicio . " ¬</li>";
            }
            $lista_servicios .= "</ul>";
        } else {
            $lista_servicios = "<p>No seleccionaste ningún servicio adicional.</p>";
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
        $subtotal = $precioMenuConMultiplicadores + $precioServicios;
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
    <title>Confirmación de Reserva - Restaurante</title>
</head>

<body>
    <div class="contenedor">
        <h1>RESTAURANTE LA BUENA MESA - RESUMEN DE RESERVA</h1>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && $todoValido): ?>

            <h2>Datos de Contacto</h2>
            <p><strong>Nombre:</strong> <?php echo $nombre; ?></p>
            <p><strong>Teléfono:</strong> <?php echo $telefono; ?></p>
            <p><strong>Email:</strong> <?php echo $email; ?></p>

            <h2>Detalles de la Reserva</h2>
            <p><strong>Menú:</strong> <?php echo htmlspecialchars($menu); ?> (<?php echo $precioMenuPorPersona; ?>¬ por persona)</p>
            <p><strong>Comensales:</strong> <?php echo $comensales; ?> personas</p>
            <p><strong>Día:</strong> <?php echo htmlspecialchars($dia); ?> (recargo <?php echo ($multiplicadorDia - 1) * 100; ?>%)</p>
            <p><strong>Turno:</strong> <?php echo htmlspecialchars($turno); ?> (recargo <?php echo ($multiplicadorTurno - 1) * 100; ?>%)</p>

            <h2>Cálculo de Menús</h2>
            <ul>
                <li><strong>Base:</strong> <?php echo number_format($precioMenu, 2); ?>¬ (<?php echo $comensales; ?> × <?php echo $precioMenuPorPersona; ?>¬)</li>
                <li><strong>Con día <?php echo htmlspecialchars($dia); ?>:</strong> <?php echo number_format($precioMenuConDia, 2); ?>¬ (×<?php echo $multiplicadorDia; ?>)</li>
                <li><strong>Con turno:</strong> <?php echo number_format($precioMenuConMultiplicadores, 2); ?>¬ (×<?php echo $multiplicadorTurno; ?>)</li>
            </ul>

            <h2>Servicios Adicionales</h2>
            <?php echo $lista_servicios; ?>
            <?php if ($precioServicios > 0): ?>
                <p><strong>Total servicios:</strong> <?php echo number_format($precioServicios, 2); ?> ¬</p>
            <?php endif; ?>

            <h2>Resumen</h2>
            <ul>
                <li><strong>Subtotal menús:</strong> <?php echo number_format($precioMenuConMultiplicadores, 2); ?> ¬</li>
                <li><strong>Subtotal servicios:</strong> <?php echo number_format($precioServicios, 2); ?> ¬</li>
                <li><strong>Total:</strong> <?php echo number_format($subtotal, 2); ?> ¬</li>
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
            <p>Por favor, envía el formulario de reserva para generar el resumen.</p>
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
