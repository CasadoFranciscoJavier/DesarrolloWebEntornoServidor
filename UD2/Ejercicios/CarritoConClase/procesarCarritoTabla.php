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

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Tu carrito de compras</h1>

    <?php if (empty($carrito)): ?>
        <p>El carrito está vacío</p>
        <a href="index.php">Volver a la tienda</a>
    <?php else: ?>
        <table border="1">
            <tr>
                <th>Producto</th>
                <th>Precio unitario</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </tr>
            <?php
            foreach ($carrito as $codigo => $cantidad) {
                $producto = $productos[$codigo];
                $subtotal = $producto['precio'] * $cantidad;
                $totalCompra += $subtotal;

                echo '<tr>';
                echo '<td>' . htmlspecialchars($producto['nombre']) . '</td>';
                echo '<td>' . number_format($producto['precio'], 2) . '€</td>';
                echo '<td>' . $cantidad . '</td>';
                echo '<td>' . number_format($subtotal, 2) . '€</td>';
                echo '</tr>';
            }

            $gastosEnvio = $totalCompra * $gastosEnvio;
            if ($gastosEnvio < 5) {
                $gastosEnvio = 5;
            }

            $totalFinal = $totalCompra + $gastosEnvio;

            ?>
            <tr>
                <td colspan="3" style="text-align: right;"><strong>Total compra:</strong></td>
                <td><strong><?php echo number_format($totalCompra, 2); ?>€</strong></td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: right;"><strong>Gastos de envío: 2%, (mín. 5€):</strong></td>
                <td><strong><?php echo number_format($gastosEnvio, 2); ?>€</strong></td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: right;"><strong>TOTAL FINAL:</strong></td>
                <td><strong><?php echo number_format($totalFinal, 2); ?>€</strong></td>
            </tr>
        </table>

        <br>
        <a href="index.php">Modificar carrito</a> |
        <a href="vaciarCarrito.php">Vaciar carrito</a>
    <?php endif; ?>
</body>

</html>