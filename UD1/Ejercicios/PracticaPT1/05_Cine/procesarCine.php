<?php
require_once "bbddCine.php";

function alert($text){
    echo "<script> alert('$text');</script>" ;
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $formato = $_POST["formato"];
    $dia = $_POST["dia"];
    $sesion = $_POST["sesion"];
    $entradas = (int)$_POST["entradas"];
    $codigo = isset($_POST["codigo"]) ? $_POST["codigo"] : "";
    $complementosSeleccionados = isset($_POST["complementos"]) ? $_POST["complementos"] : [];

    $hayCodigo = array_key_exists($codigo, $codigos);

    $precioFormato = $formatos[$formato];
    $multiplicadorDia = $dias[$dia];
    $multiplicadorSesion = $sesiones[$sesion];

    $precioEntrada = $precioFormato * $multiplicadorDia * $multiplicadorSesion;
    $precioEntradas = $precioEntrada * $entradas;

    $precioComplementos = 0;
    $lista_complementos = "";
    if (!empty($complementosSeleccionados)){
        $lista_complementos .= "<ul>";
        foreach ($complementosSeleccionados as $complemento) {
            $precioComplemento = $complementos[$complemento];
            $precioComplementos += $precioComplemento;
            $lista_complementos .= "<li>$complemento - $precioComplemento €</li>";
        }
        $lista_complementos .= "</ul>";
    } else {
        $lista_complementos = "<p>No seleccionaste complementos.</p>";
    }

    $subtotal = $precioEntradas + $precioComplementos;

    $descuentoAplicado = 0;
    $totalConDescuento = $subtotal;
    $mensajeCodigo = "No ingresado";

    if ($hayCodigo){
        $porcentajeCodigo = $codigos[$codigo];
        $descuentoAplicado = $subtotal * ($porcentajeCodigo / 100);
        $totalConDescuento = $subtotal - $descuentoAplicado;
        $mensajeCodigo = "$codigo ($porcentajeCodigo% descuento)";
    } else {
        if (!empty($codigo)){
            $mensajeCodigo = "No válido";
        }
    }

    $IVA = $totalConDescuento * 0.10;
    $precioFinal = $totalConDescuento + $IVA;

}else{
    alert("¿Qué haces usando GET?");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmación - Cine</title>
</head>
<body>
    <div class="contenedor">
        <h1>CINEPLEX - RESUMEN DE RESERVA</h1>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>

            <h2>Datos del Cliente</h2>
            <p><strong>Nombre:</strong> <?php echo $nombre; ?></p>
            <p><strong>Email:</strong> <?php echo $email; ?></p>

            <h2>Detalles de la Reserva</h2>
            <p><strong>Formato:</strong> <?php echo $formato; ?> (<?php echo $precioFormato; ?>€)</p>
            <p><strong>Día:</strong> <?php echo $dia; ?> (×<?php echo $multiplicadorDia; ?>)</p>
            <p><strong>Sesión:</strong> <?php echo $sesion; ?> (×<?php echo $multiplicadorSesion; ?>)</p>
            <p><strong>Número de Entradas:</strong> <?php echo $entradas; ?></p>

            <h2>Cálculo</h2>
            <ul>
                <li><strong>Precio por entrada:</strong> <?php echo number_format($precioEntrada, 2); ?>€</li>
                <li><strong>Total entradas:</strong> <?php echo number_format($precioEntradas, 2); ?>€</li>
            </ul>

            <h2>Complementos</h2>
            <?php echo $lista_complementos; ?>
            <?php if ($precioComplementos > 0): ?>
                <p><strong>Total complementos:</strong> <?php echo $precioComplementos; ?>€</p>
            <?php endif; ?>

            <div class="total-line">
                <p><strong>Subtotal:</strong> <?php echo number_format($subtotal, 2); ?>€</p>
            </div>

            <div class="total-line">
                <p><strong>Código:</strong> <?php echo $mensajeCodigo; ?></p>
                <?php if ($hayCodigo): ?>
                    <ul>
                        <li><strong>Descuento:</strong> - <?php echo number_format($descuentoAplicado, 2); ?>€</li>
                        <li><strong>Total con descuento:</strong> <?php echo number_format($totalConDescuento, 2); ?>€</li>
                    </ul>
                <?php endif; ?>
            </div>

            <div class="total-line">
                <p><strong>IVA (10%):</strong> + <?php echo number_format($IVA, 2); ?>€</p>
            </div>

            <div class="final-price">
                <strong>TOTAL FINAL:</strong> <?php echo number_format($precioFinal, 2); ?>€
            </div>

        <?php else: ?>
            <p>Por favor, envía el formulario de reserva.</p>
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
        color: #ffffff;
        background-color: #4a6fa5;
        font-weight: bold;
        text-align: center;
        padding: 15px;
        margin-top: 15px;
        border-radius: 6px;
    }
</style>
</html>
