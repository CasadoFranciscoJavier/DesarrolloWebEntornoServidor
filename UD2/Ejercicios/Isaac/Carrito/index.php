<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Carrito</title>
</head>

<body>

    <form method="POST" action="procesarCarrito.php">

        <?php
        require_once "productos.php";

        $total = 0;

        if (isset($_COOKIE["carrito"])) {
            $carritoGuardado = json_decode($_COOKIE["carrito"], true);
        }

        foreach ($productos as $codigoBarras => $producto) {
            $nombreProducto = $producto->getNombre();
            $precioProducto = $producto->getPrecio();

            $cantidad = isset($carritoGuardado[$codigoBarras]) ? $carritoGuardado[$codigoBarras] : 0;

            $total += $cantidad * $precioProducto;

            echo "<label>$nombreProducto <input name=$codigoBarras type='number' value=$cantidad></label><br>";
        }
        ?>

        <input type="submit" value="Guardar carrito">
        <button><a href="borrarCarrito.php">Borrar carrito</a></button>

    </form>

    <?php

    
    $gastosEnvio = $total * 0.02;
    $gastosEnvio = round($gastosEnvio < 5 ? 5 : $gastosEnvio, 2);
    $total = round($total, 2);

    echo "<br><br>TOTAL: $total €<br>";
    echo "GASTOS DE ENVIO: $gastosEnvio €<br>";

    ?>

</body>

</html>