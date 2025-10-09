<?php

require_once "bbddTienda.php";

function alert($text){
    echo "<script> alert('$text');</script>" ;
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $direccion = $_POST["direccion"];
    $envio = $_POST["envio"];
    $cupon = isset($_POST["cupon"]) ? $_POST["cupon"] : "";
    $productosSeleccionados = isset($_POST["productos"]) ? $_POST["productos"] : [];
    $serviciosSeleccionados = isset($_POST["servicios"]) ? $_POST["servicios"] : [];

    $hayCupon = array_key_exists($cupon, $cupones);
    $precioEnvio = $envios[$envio];
    $precioProductos = 0;
    $precioServicios = 0;

    $lista_productos = "";
    if (!empty($productosSeleccionados)){
        $lista_productos .= "<ul>";
        foreach ($productosSeleccionados as $producto) {
            $precioUnitario = $productos[$producto];
            $nombreCampo = "cant_" . $producto;
            $cantidad = isset($_POST[$nombreCampo]) ? (int)$_POST[$nombreCampo] : 1;
            $precioTotal = $precioUnitario * $cantidad;
            $precioProductos += $precioTotal;
            $lista_productos .= "<li>$producto × $cantidad = $precioTotal ¬</li>";
        }
        $lista_productos .= "</ul>";
    } else {
        $lista_productos = "<p>No seleccionaste ningún producto.</p>";
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

    $subtotal = $precioProductos + $precioEnvio + $precioServicios;

    $descuentoAplicado = 0;
    $totalConDescuento = $subtotal;
    $mensajeCupon = "No ingresado";

    if ($hayCupon){
        $porcentajeCupon = $cupones[$cupon];
        $descuentoAplicado = $subtotal * ($porcentajeCupon / 100);
        $totalConDescuento = $subtotal - $descuentoAplicado;
        $mensajeCupon = "$cupon ($porcentajeCupon% descuento)";
    } else {
        if (!empty($cupon)){
            $mensajeCupon = "No válido";
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
    <title>Confirmación - Tech Store</title>
</head>

<body>
    <div class="contenedor">
        <h1>TECH STORE - RESUMEN DE COMPRA</h1>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>

            <h2>Datos del Cliente</h2>
            <p><strong>Nombre:</strong> <?php echo $nombre; ?></p>
            <p><strong>Email:</strong> <?php echo $email; ?></p>
            <p><strong>Dirección:</strong> <?php echo $direccion; ?></p>

            <h2>Productos en el Carrito</h2>
            <?php echo $lista_productos; ?>
            <p><strong>Total productos:</strong> <?php echo number_format($precioProductos, 2); ?>¬</p>

            <h2>Método de Envío</h2>
            <p><strong><?php echo $envio; ?></strong> - <?php echo $precioEnvio; ?>¬</p>

            <h2>Servicios Adicionales</h2>
            <?php echo $lista_servicios; ?>
            <?php if ($precioServicios > 0): ?>
                <p><strong>Total servicios:</strong> <?php echo $precioServicios; ?>¬</p>
            <?php endif; ?>

            <div class="total-line">
                <p><strong>Subtotal:</strong> <?php echo number_format($subtotal, 2); ?>¬</p>
            </div>

            <div class="total-line">
                <p><strong>Cupón:</strong> <?php echo $mensajeCupon; ?></p>
                <?php if ($hayCupon): ?>
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
            <p>Por favor, envía el formulario de compra.</p>
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
