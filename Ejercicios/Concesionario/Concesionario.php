<?php
require_once "bbddConcesionario.php"; 

function alert($text)
{
    echo "<script> alert('$text') </script>";
}

// Función para validar string 
function validarString($variablePOST, $minimo, $maximo) {
    
    $vacio = empty($_POST[$variablePOST]);
    $valido = false;
    if (!$vacio){
        $valido = (strlen($_POST[$variablePOST]) >= $minimo && strlen($_POST[$variablePOST]) <= $maximo);
    }
    if($vacio){
        alert("$variablePOST está vacío");
    } else if(!$valido){
        alert("$variablePOST fuera de rango (longitud entre $minimo y $maximo)");
    }
    return $valido;
}

// Función para validar entero
function validarInt($variablePOST, $minimo, $maximo){
    
    $vacio = empty($_POST[$variablePOST]);
    $valido = false;
    $esEntero = false; 

    if (!$vacio){
        $esEntero = filter_var($_POST[$variablePOST], FILTER_VALIDATE_INT);

        if($esEntero !== false){
            $valido = ( ($_POST[$variablePOST] >= $minimo )
                     && ($_POST[$variablePOST] <= $maximo ) );
        }
    }
    
    if($vacio){
        alert("$variablePOST está vacío");
    } else if($esEntero === false){
        alert("$variablePOST debe ser un número entero");
    } else if(!$valido){
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
$precioPorUnidad = 0;
$totalSinDescuento = 0;
$descuentoAplicado = 0;
$totalConDescuento = 0;
$IVA_PORCENTAJE = 0.21;
$totalIVA = 0;
$precioFinal = 0;
$mensajeDescuento = "";
$lista_accesorios = "";
$descuentoTasa = 0; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $todoValido = validarInt("cantidad", 1, 5)
        && validarSeleccion("motor")
        && validarSeleccion("color")
        && validarSeleccion("llantas")
        && validarSeleccion("equipamiento")
        && validarSeleccion("modelo");

    if ($todoValido) {
        $cantidad = (int)$_POST["cantidad"];
        $modelo = $_POST["modelo"];
        $motor = $_POST["motor"];
        $color = $_POST["color"];
        $llantas = $_POST["llantas"];
        $equipamiento = $_POST["equipamiento"];
        
        $codigoDescuentoIngresado = isset($_POST["codigo"]) ? trim($_POST["codigo"]) : "";
        $accesorios = isset($_POST["accesorios"]) ? $_POST["accesorios"] : []; 

        $precioBaseModelo = $componentes["Modelo"][$modelo] ?? 0;
        $precioMotor = $componentes["Motor"][$motor] ?? 0;
        $precioColor = $componentes["Color"][$color] ?? 0;
        $precioLlantas = $componentes["Llantas"][$llantas] ?? 0;
        $precioEquipamiento = $componentes["Equipamiento"][$equipamiento] ?? 0;
        
        $precioAccesoriosTotal = 0;
        $lista_accesorios = "";

        if (!empty($accesorios) && is_array($accesorios)) {
            $lista_accesorios .= "<ul>";
            foreach ($accesorios as $servicio) {
                $precioAccesorio = $componentes["Accesorios"][$servicio] ?? 0;
                $precioAccesoriosTotal += $precioAccesorio;
                $lista_accesorios .= "<li>" . htmlspecialchars($servicio) . " - " . number_format($precioAccesorio, 0, ',', '.') . " €</li>";
            }
            $lista_accesorios .= "</ul>";
        } else {
            $lista_accesorios = "<p>No seleccionaste ningún accesorio extra.</p>";
        }

        $precioPorUnidad = $precioBaseModelo + $precioMotor + $precioColor + $precioLlantas + $precioEquipamiento + $precioAccesoriosTotal;

        if (!empty($codigoDescuentoIngresado)) {
            if (array_key_exists($codigoDescuentoIngresado, $codigosDescuento)) {
                $descuentoPorcentaje = $codigosDescuento[$codigoDescuentoIngresado];
                $descuentoTasa = $descuentoPorcentaje / 100;
                $mensajeDescuento = "Código de Descuento: <b>" . htmlspecialchars($codigoDescuentoIngresado) . "</b> (" . $descuentoPorcentaje . "% aplicado)";
            } else {
                $mensajeDescuento = "Código de Descuento: No válido";
                $descuentoTasa = 0;
            }
        } else {
            $mensajeDescuento = "Código de Descuento: No ingresado";
        }

        $totalSinDescuento = $precioPorUnidad * $cantidad;
        $descuentoAplicado = $totalSinDescuento * $descuentoTasa;
        $totalConDescuento = $totalSinDescuento - $descuentoAplicado;
        $totalIVA = $totalConDescuento * $IVA_PORCENTAJE;
        $precioFinal = $totalConDescuento + $totalIVA;

      
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen de Compra - Concesionario</title>
    <style>
      
        body { 
            background: #f3f6f9; 
            font-family: Arial, sans-serif; 
            color: #333; 
            padding: 20px; 
        }
        .contenedor { 
            background: #fff; 
            max-width: 600px; 
            margin: 40px auto; 
            padding: 30px; 
            border-radius: 8px; 
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); 
            border: 1px solid #ddd;
        }
        h1, h2 { 
            color: #4a6fa5; 
            border-bottom: 1px solid #eee; 
            padding-bottom: 5px; 
            margin-top: 20px;
        }
        p, ul {
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
            color: #28a745;
            font-weight: bold;
            border-top: 2px solid #28a745;
            padding-top: 10px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="contenedor">
        <h1>Factura de Pedido</h1>
        
        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && $todoValido): ?>
            
            <p><strong>Cantidad de Coches:</strong> <?php echo $cantidad; ?></p>

            <h2>Componentes Base</h2>
            <p><strong>Modelo:</strong> <?php echo htmlspecialchars($modelo); ?> - <?php echo $precioBaseModelo ?> €</p>
            <p><strong>Motor:</strong> <?php echo htmlspecialchars($motor); ?> - <?php echo $precioMotor ?> €</p>
            <p><strong>Color:</strong> <?php echo htmlspecialchars($color); ?> - <?php echo $precioColor ?> €</p>
            <p><strong>Llantas:</strong> <?php echo htmlspecialchars($llantas); ?> - <?php echo $precioLlantas ?> €</p>
            <p><strong>Equipamiento:</strong> <?php echo htmlspecialchars($equipamiento); ?> - <?php echo $precioEquipamiento ?> €</p>

            <h2>Accesorios Extra</h2>
            <?php echo $lista_accesorios; ?>

            <h2>Presupuesto por Unidad Detallado</h2>
            <ul>
                <li><strong>Precio por unidad (Total Componentes):</strong> <?php echo $precioPorUnidad; ?> €</li>
                <li><strong>Total sin Descuento:</strong> <?php echo $totalSinDescuento; ?> €</li>
            </ul>

            <div class="total-line">
                <p><strong>Descuento:</strong> <?php echo $mensajeDescuento; ?></p>
                <?php if ($descuentoTasa > 0): ?>
                    <ul>
                        <li><strong>Descuento Aplicado:</strong> - <?php echo $descuentoAplicado; ?> €</li>
                        <li><strong>Total con Descuento (Base Imponible):</strong> <?php echo $totalConDescuento; ?> €</li>
                    </ul>
                <?php endif; ?>
            </div>

            <div class="total-line">
                <p><strong>IVA (21%):</strong> + <?php echo $totalIVA; ?> €</p>
            </div>

            <div class="final-price">
                <strong>PRECIO FINAL:</strong> <?php echo $precioFinal; ?> €
            </div>

        <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
          
            <p style="color:red; font-weight:bold;">Se encontraron errores en el formulario. Por favor, revisa las alertas y completa todos los campos obligatorios.</p>
        <?php else: ?>
            <p>Por favor, envía el formulario de configuración del vehículo para generar la factura.</p>
        <?php endif; ?>
    </div>
</body>
</html>
