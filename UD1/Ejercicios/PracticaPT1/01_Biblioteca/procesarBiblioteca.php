<?php
require_once "bbddBiblioteca.php";

function alert($text)
{
    echo "<script> alert('$text');window.location.href = 'biblioteca.html'; </script>";
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
        // Verificar que tiene exactamente 9 caracteres
        if (strlen($dni) == 9) {
            // Los primeros 8 deben ser números y el último una letra
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
$precioMembresia = 0;
$precioLibros = 0;
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
        && validarInt("cantidad", 1, 10)
        && validarSeleccion("membresia")
        && validarSeleccion("categoria")
        && validarSeleccion("duracion");

    if ($todoValido) {
        $nombre = htmlspecialchars($_POST["nombre"]);
        $apellidos = htmlspecialchars($_POST["apellidos"]);
        $dni = htmlspecialchars($_POST["dni"]);
        $cantidad = (int)$_POST["cantidad"];
        $membresia = $_POST["membresia"];
        $categoria = $_POST["categoria"];
        $duracion = $_POST["duracion"];

        $codigoPromoIngresado = isset($_POST["codigo"]) ? $_POST["codigo"] : "";
        $serviciosSeleccionados = isset($_POST["servicios"]) ? $_POST["servicios"] : [];

        // Calcular precios
        $precioMembresia = $membresias[$membresia];
        $precioCategoria = $categorias[$categoria];
        $multiplicadorDuracion = $duraciones[$duracion];
        $precioLibros = $cantidad * $precioCategoria * $multiplicadorDuracion;

        // Procesar servicios adicionales
        $precioServicios = 0;
        if (!empty($serviciosSeleccionados) && is_array($serviciosSeleccionados)) {
            $lista_servicios .= "<ul>";
            foreach ($serviciosSeleccionados as $servicio) {
                $precioServicio = $servicios[$servicio];
                $precioServicios += $precioServicio;
                $lista_servicios .= "<li>" . htmlspecialchars($servicio) . " - " . $precioServicio . " €</li>";
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
        $subtotal = $precioMembresia + $precioLibros + $precioServicios;
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
    <title>Resumen de Préstamo - Biblioteca</title>
</head>

<body>
    <div class="contenedor">
        <h1>BIBLIOTECA MUNICIPAL - RESUMEN DE PRÉSTAMO</h1>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && $todoValido): ?>

            <h2>Datos del Usuario</h2>
            <p><strong>Nombre Completo:</strong> <?php echo $nombre . " " . $apellidos; ?></p>
            <p><strong>DNI:</strong> <?php echo $dni; ?></p>

            <h2>Membresía Seleccionada</h2>
            <p><strong><?php echo htmlspecialchars($membresia); ?></strong> - <?php echo $precioMembresia; ?> €/mes</p>

            <h2>Préstamo de Libros</h2>
            <p><strong>Categoría:</strong> <?php echo htmlspecialchars($categoria); ?></p>
            <p><strong>Cantidad:</strong> <?php echo $cantidad; ?> libros</p>
            <p><strong>Duración:</strong> <?php echo htmlspecialchars($duracion); ?></p>
            <p><strong>Coste libros:</strong> <?php echo $precioLibros; ?> € (<?php echo $cantidad; ?> libros × <?php echo $precioCategoria; ?> € × <?php echo $multiplicadorDuracion; ?>)</p>

            <h2>Servicios Adicionales</h2>
            <?php echo $lista_servicios; ?>
            <?php if ($precioServicios > 0): ?>
                <p><strong>Total servicios:</strong> <?php echo $precioServicios; ?> €</p>
            <?php endif; ?>

            <h2>Resumen de Costes</h2>
            <ul>
                <li><strong>Membresía:</strong> <?php echo $precioMembresia; ?> €</li>
                <li><strong>Libros:</strong> <?php echo $precioLibros; ?> €</li>
                <li><strong>Servicios:</strong> <?php echo $precioServicios; ?> €</li>
                <li><strong>Subtotal:</strong> <?php echo $subtotal; ?> €</li>
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

            <div class="final-price">
                <strong>TOTAL FINAL:</strong> <?php echo number_format($precioFinal, 2); ?> €
            </div>

        <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>

            <p style="color:red; font-weight:bold;">Se encontraron errores en el formulario. Por favor, revisa las alertas y completa todos los campos obligatorios.</p>

        <?php else: ?>
            <p>Por favor, envía el formulario de préstamo para generar el resumen.</p>
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
