<?php
print_r($_POST);
require_once "bbddAgencia.php";

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

// Función para validar número entero (días)
function validarInt($variablePOST, $minimo, $maximo){
    // Verifica si la variable enviada por POST está vacía
    $vacio = empty($_POST[$variablePOST]);
    // Inicializa la variable $valido como false
    $valido = false;

    // Si la variable no está vacía
    if (!$vacio){
        // Valida que el valor recibido sea un entero
        $esEntero = filter_var($_POST[$variablePOST], FILTER_VALIDATE_INT);

        // Si es entero, verifica que esté dentro del rango especificado
        if($esEntero){
            $valido = ( ($_POST[$variablePOST] >= $minimo )
                 && ($_POST[$variablePOST] <= $maximo ) );
        }
    }
    
    // Si está vacía, muestra un mensaje de alerta
    if($vacio){
        alert("$variablePOST está vacío");
    } else if(!$esEntero){
        // Si no es entero, muestra una alerta
        alert("$variablePOST debe ser un número entero");
    } else if(!$valido){
        // Si no está dentro del rango, muestra una alerta con el rango válido
        alert("$variablePOST fuera de rango (entre $minimo y $maximo)");
    }

    // Devuelvo si es válido o no
    return $valido;
}

// Función para validar selección (radio/checkBox) 
function validarSeleccion($variablePOST)
{
    $vacio = empty($_POST[$variablePOST]);
    if ($vacio) {
        alert("Debes seleccionar $variablePOST");
    }
    return !$vacio;
}

//============================= main =============================

// Validaciones principales 
$todoValido = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $todoValido = validarString("nombre", 1, 20)
        && validarString("apellido", 1, 20)
        && validarInt("duracion", 1, 30)
        && validarSeleccion("destino")
        && validarSeleccion("alojamiento");

    if ($todoValido) {
        $nombre = htmlspecialchars($_POST["nombre"]);
        $apellido = htmlspecialchars($_POST["apellido"]);
        $duracion = ($_POST["duracion"]);
        $destino = ($_POST["destino"]);
        $alojamiento = ($_POST["alojamiento"]);
        $servicios = isset($_POST["servicios"]) ? $_POST["servicios"] : "";

        if (!empty($servicios)) {
            $lista_servicios = "<ol>";
            foreach ($servicios as $servicio) {
                $lista_servicios .= "<li>" . ($servicio) . "</li>";
            }
            $lista_servicios .= "</ol>";
        } else {
            $lista_servicios = "<p>No seleccionaste ninguna servicio.</p>";
        }
    }

    $costeTotalDiario = 0;
    $costeTotalEstancia = 0;
    $costoServicios = 0;
    $presupuestoTotal = 0;



        $costoBase = $DestinoCosteBase[$destino];
        $multiplicador = $AlojamientoMultiplicador[$alojamiento];
        $costeTotalDiario = $costoBase * $multiplicador;
        $costeTotalEstancia = $costeTotalDiario * $duracion;

       foreach ($servicios as $servicio) {
         $costoServicios += $ServiciosCoste[$servicio];
       }
       

        $presupuestoTotal = $costeTotalEstancia + $costoServicios;

    } else {
    // Si la solicitud no es de tipo POST, muestra una alerta
    alert("El método usado no es POST");
}




        
     
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Datos personales recibidos</title>
</head>

<body>
    <div class="contenedor">
        <h1>Datos del Cliente</h1>
        <p><strong>Nombre:</strong> <?php echo $nombre; ?></p>
        <p><strong>Apellido:</strong> <?php echo $apellido; ?></p>

        <h2>Detalles del Viaje</h2>
        <p><strong>Destino:</strong> <?php echo $destino; ?></p>
        <p><strong>Duración:</strong> <?php echo $duracion; ?> días</p>
        <p><strong>Tipo de Alojamiento:</strong> <?php echo $alojamiento; ?></p>

        <h2>Servicios Contratados</h2>
        <?php
        if (!empty($servicios)) {
            echo "<ul>";
            foreach ($servicios as $servicio) {
                $precioServicio = $ServiciosCoste[$servicio];
                echo "<li>$servicio - $precioServicio €</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No seleccionaste ningún servicio.</p>";
        }
        ?>

        <h2>Presupuesto Detallado</h2>
        <ul>
            <li><strong>Costo Base Diario:</strong> <?php echo $costoBase; ?> €</li>
            <li><strong>Multiplicador por Tipo de Alojamiento:</strong> <?php echo $multiplicador; ?></li>
            <li><strong>Costo Total Diario:</strong> <?php echo $costeTotalDiario; ?> €</li>
            <li><strong>Costo Total de Estancia (Duración * Diario):</strong> <?php echo $costeTotalEstancia; ?> €</li>
            <li><strong>Costo Total Servicios:</strong> <?php echo $costoServicios; ?> €</li>
            <li><strong>Presupuesto Total:</strong> <?php echo $presupuestoTotal; ?> €</li>
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

    // Filas de servicios
    foreach ($servicios as $servicio) {
        $costoTotal = $ServiciosCoste[$servicio];
        $costoDiario = $costoTotal / $duracion;
        $color = $ColoresServicios[$servicio];

        echo "<tr style='background-color: $color'>";
        echo "<td>$servicio</td>";
        echo "<td>$costoTotal €</td>";

        for ($d = 1; $d <= $duracion; $d++) {
            echo "<td>" . round($costoDiario, 2) . " €</td>";
            $totalesPorDia[$d] += $costoDiario;
        }

        echo "</tr>";
    }

    // Fila de totales
    echo "<tr style='font-weight:bold; background-color:#DDD;'>";
    echo "<td colspan='2'>Total por Día</td>";
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

    h1 {
        text-align: center;
        color: #4a6fa5;
        margin-bottom: 24px;
        font-weight: 600;
    }
    h2 {
        text-align: left;
        color: #4a6fa5;
        margin-bottom: 24px;
        font-weight: 600;
    }

    label {
        color: #4a6fa5;
        font-weight: 500;
    }

    p {
        margin: 12px 0;
        font-size: 1.08em;
    }

    ul {
        margin-top: 10px;
        margin-bottom: 0;
        padding-left: 22px;
    }

    li {
        margin-bottom: 4px;
    }
</style>

</html>
