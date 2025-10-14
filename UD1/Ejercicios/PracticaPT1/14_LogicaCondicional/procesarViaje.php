 <!-- Reglas de Negocio "Especiales" (Las Vueltecitas)
Una vez que los datos básicos sean válidos, implemente la siguiente lógica de negocio (validaciones cruzadas y costes condicionales):

Validación Cruzada de Servicio: Si el servicio "Seguro Premium" ha sido contratado Y la Duración del viaje es menor de 5 días, el sistema debe RECHAZAR el viaje (mostrar alert() y detenerse).

Descuento por Duración: Si la Duración del viaje es mayor de 10 días, aplique un 10% de descuento únicamente sobre el Costo Total de Estancia (coste diario x días).

Servicio Condicional: Si el Destino es París, el servicio "Alquiler de coche" debe ser GRATUITO (su coste es 0€ en el cálculo final).

C. Cálculo y Output
Calcule el presupuesto final y muestre el resultado en una tabla HTML amigable. Debe mostrar claramente:

Los datos del cliente y del viaje.

El Costo Total Diario (Base x Multiplicador).

El Costo de Estancia original y el Costo de Estancia final (tras aplicar el descuento).

El Costo Total de Servicios (tras aplicar las condiciones de gratuidad).

El Presupuesto Total final.

Una tabla de Desglose de Servicios por Día, coloreando las filas según el array $ColoresServicios. -->



<?php

require_once "bbddAgencia.php"; 
function alert($text)
{
    // Usamos window.history.back() para volver al formulario
    echo "<script> 
            alert('$text'); 
            window.history.back(); 
          </script>";
    exit(); // ¡Importante! Detiene la ejecución del script.
}

// Función para validar string (nombre/apellido)
function validarString($variablePOST, $minimo, $maximo) {
    $vacio = empty($_POST[$variablePOST]);
    $valido = false;
    
    if (!$vacio){
        $valido = (strlen($_POST[$variablePOST]) >= $minimo && strlen($_POST[$variablePOST]) <= $maximo);
    }
    
    if($vacio){
        alert("El campo '$variablePOST' está vacío");
    } else if(!$valido){
        alert("'$variablePOST' fuera de rango (longitud entre $minimo y $maximo)");
    }
    return $valido;
}

// Función para validar número entero (duracion)
function validarInt($variablePOST, $minimo, $maximo){
    $vacio = empty($_POST[$variablePOST]);
    $valido = false;
    $esEntero = false; // Inicializar aquí

    if (!$vacio){
        $esEntero = filter_var($_POST[$variablePOST], FILTER_VALIDATE_INT);

        if($esEntero){
            $valor = intval($_POST[$variablePOST]);
            $valido = ($valor >= $minimo && $valor <= $maximo);
        }
    }
    
    if($vacio){
        alert("El campo '$variablePOST' está vacío");
    } else if(!$esEntero){
        alert("'$variablePOST' debe ser un número entero");
    } else if(!$valido){
        alert("'$variablePOST' fuera de rango (entre $minimo y $maximo)");
    }

    return $valido;
}

// Función para validar selección (radio/select) 
function validarSeleccion($variablePOST)
{
   
    $vacio = empty($_POST[$variablePOST]) || (isset($_POST[$variablePOST]) && $_POST[$variablePOST] == "Nada");
    
    if ($vacio) {
        alert("Debes seleccionar una opción en el campo '$variablePOST'");
    }
    return !$vacio;
}

// ============================= INICIALIZACIÓN DE VARIABLES ==========================
$nombre = $apellido = $duracion = $destino = $alojamiento = "";
$servicios = [];
$lista_servicios = "";
$costeTotalDiario = $costeTotalEstancia = $costoServicios = $presupuestoTotal = 0;
$costoBase = $multiplicador = 0;
$descuentoPorcentaje = 0;
$mensajeDescuento = "";
$descuento_estancia = 0; 

// ============================= MAIN ==========================

$todoValido = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $todoValido = validarString("nombre", 1, 20)
        && validarString("apellido", 1, 20)
        && validarInt("duracion", 1, 30)
        && validarSeleccion("destino")
        && validarSeleccion("alojamiento");

    if ($todoValido) {
        // Asignar variables
        $nombre = htmlspecialchars($_POST["nombre"]);
        $apellido = htmlspecialchars($_POST["apellido"]);
        $duracion = intval($_POST["duracion"]); 
        $destino = $_POST["destino"];
        $alojamiento = $_POST["alojamiento"];
        $servicios = isset($_POST["servicios"]) ? $_POST["servicios"] : [];


        // ======================= 2. VALIDACIÓN CRUZADA (GIRO) ======================
        // Prohibir Seguro Premium si la duración es menor de 5 días.
        if (in_array("Seguro Premium", $servicios) && $duracion < 5) {
             alert("El Seguro Premium solo se puede contratar para estancias de 5 días o más."); 
        }

        // ======================= 3. CÁLCULO DE COSTES Y REGLAS DE NEGOCIO (GIRO) ======================

        // A. CÁLCULO BASE DE ESTANCIA (COSTO ORIGINAL)
        $costoBase = $DestinoCosteBase[$destino];
        $multiplicador = $AlojamientoMultiplicador[$alojamiento];
        $costeTotalDiario = $costoBase * $multiplicador;
        $costoEstanciaOriginal = $costeTotalDiario * $duracion; // Guardamos el costo sin descuento
        $costeTotalEstancia = $costoEstanciaOriginal; // Inicializamos con el original

        // B. APLICACIÓN DE DESCUENTO POR DURACIÓN (GIRO)
        if ($duracion > 10) {
            $descuentoPorcentaje = 10;
            $descuento_estancia = $costeTotalEstancia * ($descuentoPorcentaje / 100);
            $costeTotalEstancia -= $descuento_estancia;
            $mensajeDescuento = "¡Descuento del $descuentoPorcentaje% aplicado por estancia larga!";
        }
        
        // C. CÁLCULO DE SERVICIOS ADICIONALES (GIRO)
        $costoServicios = 0;
        if (!empty($servicios)) {
            $lista_servicios = "<ol>";
            foreach ($servicios as $servicio) {
                $costoActual = $ServiciosCoste[$servicio];
                $mensajeServicio = "";

                if ($servicio == "Alquiler de coche" && $destino == "Paris") {
                    $costoActual = 0;
                    $mensajeServicio = " (¡Gratis por promoción en París!)";
                }
                
                $costoServicios += $costoActual;
                $lista_servicios .= "<li>" . htmlspecialchars($servicio) . " - " . round($costoActual, 2) . " €" . $mensajeServicio . "</li>";
            }
            $lista_servicios .= "</ol>";
        } else {
            $lista_servicios = "<p>No seleccionaste ninguna servicio.</p>";
        }

        // D. PRESUPUESTO FINAL
        $presupuestoTotal = $costeTotalEstancia + $costoServicios;
        
    } else {
        // En teoría, este bloque no se alcanza si las validaciones básicas usan alert()/exit()
        alert("Ocurrió un error inesperado. Por favor, inténtalo de nuevo.");
    }

} else {
    // Si la solicitud no es de tipo POST
    alert("El método usado no es POST.");
}


// ================================= VISTA HTML (Si $todoValido es true) =================================
// El HTML solo se imprime si todas las validaciones fueron correctas y no hubo alert/exit().
if ($todoValido) { 
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Presupuesto de Viaje Detallado</title>
</head>

<body>
    <div class="contenedor">
        <h1>Datos del Cliente</h1>
        <p><strong>Nombre:</strong> <?php echo $nombre; ?> <?php echo $apellido; ?></p>

        <h2>Detalles del Viaje</h2>
        <p><strong>Destino:</strong> <?php echo $destino; ?></p>
        <p><strong>Duración:</strong> <?php echo $duracion; ?> días</p>
        <p><strong>Tipo de Alojamiento:</strong> <?php echo $alojamiento; ?></p>
        
        <?php if (!empty($mensajeDescuento)): ?>
             <p style="color: green; font-weight: bold; margin-top: 15px;">
                🎉 <?php echo $mensajeDescuento; ?> (Ahorro de <?php echo round($descuento_estancia, 2); ?> €)
             </p>
        <?php endif; ?>

        <h2>Servicios Contratados</h2>
        <?php echo $lista_servicios; ?>

        <h2>Presupuesto Detallado</h2>
        <ul>
            <li><strong>Costo Base Diario:</strong> <?php echo $costoBase; ?> €</li>
            <li><strong>Multiplicador Alojamiento:</strong> <?php echo $multiplicador; ?></li>
            <li><strong>Costo Total Diario:</strong> <?php echo round($costeTotalDiario, 2); ?> €</li>
            <li><strong>Costo Estancia Original:</strong> <?php echo round($costoEstanciaOriginal, 2); ?> €</li>
            <li><strong>Costo Estancia Final:</strong> <?php echo round($costeTotalEstancia, 2); ?> €</li>
            <li><strong>Costo Total Servicios:</strong> <?php echo round($costoServicios, 2); ?> €</li>
            <li style="font-size: 1.2em; color: #4a6fa5;"><strong>Presupuesto Total:</strong> <?php echo round($presupuestoTotal, 2); ?> €</li>
        </ul>

    </div>
    <h2>Desglose de Servicios por Día</h2>
<?php

if (!empty($servicios)) {
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    
    // Cabecera de la tabla
    echo "<tr>";
    echo "<th>Servicio</th>";
    echo "<th>Costo Total (€)</th>";
    for ($d = 1; $d <= $duracion; $d++) {
        echo "<th>Día $d</th>";
    }
    echo "</tr>";

    // Inicializamos array de totales por día
    $totalesPorDia = array_fill(1, $duracion, 0);
    
    // Recalcular los costos ajustados para la tabla, ya que se modificaron para el cálculo final
    foreach ($servicios as $servicio) {
         $costoTotal = $ServiciosCoste[$servicio];
         // Aplicar la regla de París=0
         if ($servicio == "Alquiler de coche" && $destino == "Paris") {
            $costoTotal = 0;
         }

        $costoDiario = $costoTotal / $duracion;
        $color = $ColoresServicios[$servicio];

        echo "<tr style='background-color: $color'>";
        echo "<td>$servicio</td>";
        echo "<td>" . round($costoTotal, 2) . " €</td>";

        for ($d = 1; $d <= $duracion; $d++) {
            echo "<td>" . round($costoDiario, 2) . " €</td>";
            $totalesPorDia[$d] += $costoDiario;
        }

        echo "</tr>";
    }

    // Fila de totales
    echo "<tr style='font-weight:bold; background-color:#DDD;'>";
    echo "<td colspan='2'>Total por Día (Servicios)</td>";
    for ($d = 1; $d <= $duracion; $d++) {
        echo "<td>" . round($totalesPorDia[$d], 2) . " €</td>";
    }
    echo "</tr>";

    echo "</table>";
} else {
    echo "<p>No hay servicios contratados para desglosar.</p>";
}
?>

</body>
<style>
/* Estilos CSS incluidos aquí */
    body {
        background: #f3f6f9;
        font-family: "Segoe UI", Arial, sans-serif;
        color: #333;
    }

    .contenedor {
        background: #fff;
        max-width: 520px;
        margin: 40px auto;
        padding: 32px 28px 24px 28px;
        border-radius: 14px;
        box-shadow: 0 4px 24px rgba(60, 80, 120, 0.08);
        border: 1px solid #e3e8ee;
    }

    h1, h2 {
        text-align: left;
        color: #4a6fa5;
        margin-bottom: 24px;
        font-weight: 600;
    }

    p {
        margin: 12px 0;
        font-size: 1.08em;
    }

    ul, ol {
        margin-top: 10px;
        margin-bottom: 0;
        padding-left: 22px;
    }

    li {
        margin-bottom: 4px;
    }
</style>
</html>
<?php
}
?>