<?php
require_once "bbddFarmacia.php";

function alert($text)
{
    echo "<script> alert('$text');window.location.href = 'farmacia.html'; </script>";
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
$precioProductos = 0;
$descuentoReceta = 0;
$precioProductosConReceta = 0;
$precioServicios = 0;
$precioEnvio = 0;
$subtotal = 0;
$descuentoAplicado = 0;
$totalConDescuento = 0;
$IVA_PORCENTAJE = 0.10;
$totalIVA = 0;
$precioFinal = 0;
$mensajeDescuento = "";
$lista_productos = "";
$lista_servicios = "";
$descuentoTasa = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $todoValido = validarString("nombre", 2, 30)
        && validarString("apellidos", 2, 40)
        && validarDNI($_POST["dni"])
        && validarInt("cantParacetamol", 0, 20)
        && validarInt("cantIbuprofeno", 0, 20)
        && validarInt("cantAmoxicilina", 0, 20)
        && validarInt("cantVitaminaC", 0, 20)
        && validarInt("cantCremaHidratante", 0, 20)
        && validarSeleccion("tipocliente")
        && validarSeleccion("envio");

    if ($todoValido) {
        $nombre = htmlspecialchars($_POST["nombre"]);
        $apellidos = htmlspecialchars($_POST["apellidos"]);
        $dni = htmlspecialchars($_POST["dni"]);
        $tipoCliente = $_POST["tipocliente"];
        $envioSeleccionado = $_POST["envio"];

        $cantParacetamol = (int)$_POST["cantParacetamol"];
        $cantIbuprofeno = (int)$_POST["cantIbuprofeno"];
        $cantAmoxicilina = (int)$_POST["cantAmoxicilina"];
        $cantVitaminaC = (int)$_POST["cantVitaminaC"];
        $cantCremaHidratante = (int)$_POST["cantCremaHidratante"];

        $codigoPromoIngresado = isset($_POST["codigo"]) ? $_POST["codigo"] : "";
        $serviciosSeleccionados = isset($_POST["servicios"]) ? $_POST["servicios"] : [];

        // Calcular precio productos
        $precioProductos = 0;
        $lista_productos .= "<ul>";

        if ($cantParacetamol > 0) {
            $precio = $productos["Paracetamol 1g"] * $cantParacetamol;
            $precioProductos += $precio;
            $lista_productos .= "<li>Paracetamol 1g × " . $cantParacetamol . " = " . number_format($precio, 2) . " €</li>";
        }

        if ($cantIbuprofeno > 0) {
            $precio = $productos["Ibuprofeno 600mg"] * $cantIbuprofeno;
            $precioProductos += $precio;
            $lista_productos .= "<li>Ibuprofeno 600mg × " . $cantIbuprofeno . " = " . number_format($precio, 2) . " €</li>";
        }

        if ($cantAmoxicilina > 0) {
            $precio = $productos["Amoxicilina"] * $cantAmoxicilina;
            $precioProductos += $precio;
            $lista_productos .= "<li>Amoxicilina × " . $cantAmoxicilina . " = " . number_format($precio, 2) . " €</li>";
        }

        if ($cantVitaminaC > 0) {
            $precio = $productos["Vitamina C"] * $cantVitaminaC;
            $precioProductos += $precio;
            $lista_productos .= "<li>Vitamina C × " . $cantVitaminaC . " = " . number_format($precio, 2) . " €</li>";
        }

        if ($cantCremaHidratante > 0) {
            $precio = $productos["Crema Hidratante"] * $cantCremaHidratante;
            $precioProductos += $precio;
            $lista_productos .= "<li>Crema Hidratante × " . $cantCremaHidratante . " = " . number_format($precio, 2) . " €</li>";
        }

        $lista_productos .= "</ul>";

        if ($precioProductos == 0) {
            $lista_productos = "<p>No seleccionaste ningún producto.</p>";
        }

        // Aplicar descuento por receta
        $multiplicadorReceta = $tiposCliente[$tipoCliente];
        $descuentoReceta = $precioProductos * (1 - $multiplicadorReceta);
        $precioProductosConReceta = $precioProductos * $multiplicadorReceta;

        // Calcular precio servicios
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

        // Calcular envío
        $precioEnvio = $envio[$envioSeleccionado];

        // Procesar código de promoción (se aplica después del descuento por receta)
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

        // Calcular totales (el envío NO se incluye en el descuento)
        $subtotal = $precioProductosConReceta + $precioServicios;
        $descuentoAplicado = $subtotal * $descuentoTasa;
        $totalConDescuento = $subtotal - $descuentoAplicado;
        $totalIVA = $totalConDescuento * $IVA_PORCENTAJE;
        $precioFinal = $totalConDescuento + $totalIVA + $precioEnvio;
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
    <title>Resumen de Pedido - Farmacia</title>
</head>

<body>
    <div class="contenedor">
        <h1>FARMACIA ONLINE - RESUMEN DE PEDIDO</h1>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && $todoValido): ?>

            <h2>Datos del Cliente</h2>
            <p><strong>Nombre Completo:</strong> <?php echo $nombre . " " . $apellidos; ?></p>
            <p><strong>DNI:</strong> <?php echo $dni; ?></p>
            <p><strong>Tipo de Cliente:</strong> <?php echo htmlspecialchars($tipoCliente); ?></p>

            <h2>Productos Solicitados</h2>
            <?php echo $lista_productos; ?>
            <p><strong>Total productos:</strong> <?php echo number_format($precioProductos, 2); ?> €</p>

            <?php if ($descuentoReceta > 0): ?>
                <div class="total-line">
                    <p><strong>Descuento por Receta Médica (40%):</strong> - <?php echo number_format($descuentoReceta, 2); ?> €</p>
                    <p><strong>Total productos con receta:</strong> <?php echo number_format($precioProductosConReceta, 2); ?> €</p>
                </div>
            <?php endif; ?>

            <h2>Servicios Adicionales</h2>
            <?php echo $lista_servicios; ?>
            <?php if ($precioServicios > 0): ?>
                <p><strong>Total servicios:</strong> <?php echo $precioServicios; ?> €</p>
            <?php endif; ?>

            <h2>Resumen de Costes</h2>
            <ul>
                <li><strong>Productos:</strong> <?php echo number_format($precioProductosConReceta, 2); ?> €</li>
                <li><strong>Servicios:</strong> <?php echo $precioServicios; ?> €</li>
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
                <p><strong>Envío (<?php echo htmlspecialchars($envioSeleccionado); ?>):</strong> + <?php echo number_format($precioEnvio, 2); ?> € (no incluido en descuento)</p>
            </div>

            <div class="final-price">
                <strong>TOTAL FINAL:</strong> <?php echo number_format($precioFinal, 2); ?> €
            </div>

        <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>

            <p style="color:red; font-weight:bold;">Se encontraron errores en el formulario. Por favor, revisa las alertas y completa todos los campos obligatorios.</p>

        <?php else: ?>
            <p>Por favor, envía el formulario de pedido para generar el resumen.</p>
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
