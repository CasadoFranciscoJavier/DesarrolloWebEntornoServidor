<?php

require_once "bbddGimnasio.php";

function alert($text){
    echo "<script> alert('$text');</script>" ;
}

// Verifica si la solicitud es de tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $edad = $_POST["edad"];
    $plan = $_POST["plan"];
    $horario = $_POST["horario"];
    $codigoPromo = isset($_POST["codigo"]) ? $_POST["codigo"] : "";
    $clasesSeleccionadas = isset($_POST["clases"]) ? $_POST["clases"] : [];
    $serviciosSeleccionados = isset($_POST["servicios"]) ? $_POST["servicios"] : [];

    $hayDescuento = array_key_exists($codigoPromo, $codigos);

    $precioPlan = $planes[$plan];
    $precioClases = 0;
    $precioServicios = 0;

    $lista_clases = "";
    if (!empty($clasesSeleccionadas)){
        $lista_clases .= "<ul>";
        foreach ($clasesSeleccionadas as $clase) {
            $precioClase = $clases[$clase];
            $precioClases += $precioClase;
            $lista_clases .= "<li>$clase - $precioClase ¬</li>";
        }
        $lista_clases .= "</ul>";
    } else {
        $lista_clases = "<p>No seleccionaste ninguna clase.</p>";
    }

    $lista_servicios = "";
    if (!empty($serviciosSeleccionados)){
        $lista_servicios .= "<ul>";
        foreach ($serviciosSeleccionados as $servicio) {
            $precioServicio = $servicios[$servicio];
            $precioServicios += $precioServicio;
            $lista_servicios .= "<li>$servicio - $precioServicio ¬</li>";
        }
        $lista_servicios .= "</ul>";
    } else {
        $lista_servicios = "<p>No seleccionaste ningún servicio.</p>";
    }

    $multiplicadorHorario = $horarios[$horario];
    $subtotalBase = $precioPlan + $precioClases + $precioServicios;
    $subtotalConHorario = $subtotalBase * $multiplicadorHorario;

    $descuentoAplicado = 0;
    $totalConDescuento = $subtotalConHorario;
    $mensajeDescuento = "No ingresado";

    if ($hayDescuento){
        $porcentajeDescuento = $codigos[$codigoPromo];
        $descuentoAplicado = $subtotalConHorario * ($porcentajeDescuento / 100);
        $totalConDescuento = $subtotalConHorario - $descuentoAplicado;
        $mensajeDescuento = "$codigoPromo ($porcentajeDescuento% aplicado)";
    } else {
        if (!empty($codigoPromo)){
            $mensajeDescuento = "No válido";
        }
    }

    $IVA = $totalConDescuento * 0.21;
    $precioFinal = $totalConDescuento + $IVA;

}else{
    alert("¿Qué haces usando GET?");
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación - Gimnasio</title>
</head>

<body>
    <div class="contenedor">
        <h1>GIMNASIO FIT CENTER - RESUMEN DE INSCRIPCIÓN</h1>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>

            <h2>Datos Personales</h2>
            <p><strong>Nombre Completo:</strong> <?php echo $nombre . " " . $apellidos; ?></p>
            <p><strong>Edad:</strong> <?php echo $edad; ?> años</p>

            <h2>Plan Contratado</h2>
            <p><strong><?php echo $plan; ?></strong> - <?php echo $precioPlan; ?>¬</p>

            <h2>Clases Grupales Seleccionadas</h2>
            <?php echo $lista_clases; ?>
            <?php if ($precioClases > 0): ?>
                <p><strong>Total clases:</strong> <?php echo $precioClases; ?>¬</p>
            <?php endif; ?>

            <h2>Servicios Adicionales</h2>
            <?php echo $lista_servicios; ?>
            <?php if ($precioServicios > 0): ?>
                <p><strong>Total servicios:</strong> <?php echo $precioServicios; ?>¬</p>
            <?php endif; ?>

            <h2>Horario</h2>
            <p><strong><?php echo $horario; ?></strong> (recargo <?php echo ($multiplicadorHorario - 1) * 100; ?>%)</p>

            <h2>Cálculo</h2>
            <ul>
                <li><strong>Subtotal base:</strong> <?php echo number_format($subtotalBase, 2); ?>¬ (<?php echo $precioPlan; ?> + <?php echo $precioClases; ?> + <?php echo $precioServicios; ?>)</li>
                <li><strong>Con horario:</strong> <?php echo number_format($subtotalConHorario, 2); ?>¬ (×<?php echo $multiplicadorHorario; ?>)</li>
            </ul>

            <div class="total-line">
                <p><strong>Código Promoción:</strong> <?php echo $mensajeDescuento; ?></p>
                <?php if ($hayDescuento): ?>
                    <ul>
                        <li><strong>Descuento:</strong> - <?php echo number_format($descuentoAplicado, 2); ?>¬</li>
                        <li><strong>Total con descuento:</strong> <?php echo number_format($totalConDescuento, 2); ?>¬</li>
                    </ul>
                <?php endif; ?>
            </div>

            <div class="total-line">
                <p><strong>IVA (21%):</strong> + <?php echo number_format($IVA, 2); ?>¬</p>
            </div>

            <div class="final-price">
                <strong>TOTAL FINAL:</strong> <?php echo number_format($precioFinal, 2); ?>¬
            </div>

        <?php else: ?>
            <p>Por favor, envía el formulario de inscripción.</p>
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
