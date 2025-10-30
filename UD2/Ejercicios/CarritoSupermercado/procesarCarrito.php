<?php
require_once 'productos.php';

$carrito = [];

if (isset($_POST['productos'])) {
    foreach ($_POST['productos'] as $codigo => $cantidad) {
        if ($cantidad > 0) {
            $carrito[$codigo] = (int) $cantidad;
        }
    }
}

setcookie('carrito', json_encode($carrito), time() + 86400, "/");

$totalCompra = 0;
$gastosEnvio = 0.02;
?>

<div class="container">
    <link rel="stylesheet" href="style.css">

    <h1>Carrito actual</h1>

    <?php if (empty($carrito)): ?>
        <p>Carrito vacío</p>
        <a href="index.php">Volver a la tienda</a>
    <?php else: ?>

        <?php
        foreach ($carrito as $codigo => $cantidad) {
            $producto = $productos[$codigo];
            $subtotal = $producto['precio'] * $cantidad;
            $totalCompra += $subtotal;

            echo "<p style='text-align: left'>";
            echo "<strong>{$producto['nombre']}</strong> x {$cantidad}<br>";
            echo "Precio unidad: " . number_format($producto['precio'], 2) . "€<br>";
            echo "Subtotal: " . number_format($subtotal, 2) . "€";
            echo "</p>";
            echo "<hr>";

        }

        $gastosEnvio = $totalCompra * $gastosEnvio;
        if ($gastosEnvio < 5)
            $gastosEnvio = 5;
        $totalFinal = $totalCompra + $gastosEnvio;
        ?>
        <p><strong>Total compra:</strong> <?php echo number_format($totalCompra, 2); ?>€</p>
        <p><strong>Gastos de envío 2% (mín. 5€):</strong> <?php echo number_format($gastosEnvio, 2); ?>€</p>
        <br>
        <hr>
        <p><strong>TOTAL FINAL:</strong> <?php echo number_format($totalFinal, 2); ?>€</p>
        <hr>
        <p>Gracias por su visita</p>
        <hr>
        <p>
            <a href="index.php">Modificar</a> |
            <a href="vaciarCarrito.php">Vaciar</a>
        </p>

    <?php endif; ?>
</div>