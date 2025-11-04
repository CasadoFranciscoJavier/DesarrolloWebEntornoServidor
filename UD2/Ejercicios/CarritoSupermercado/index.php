<?php
require_once 'productos.php';

// Leer el carrito de la cookie si existe
$carrito = [];
if (isset($_COOKIE['carrito'])) {
    $carrito = json_decode($_COOKIE['carrito'], true);
}
?>

<link rel="stylesheet" href="style.css">

<h1>Listado de productos</h1>

<form action="procesarCarrito.php" method="POST">
    <?php
    foreach ($productos as $codigo => $producto) {
        $cantidadActual = isset($carrito[$codigo]) ? $carrito[$codigo] : 0;


        echo '<div style="display: flex; justify-content: space-between; ">';
        echo $producto['nombre'] . ' - ' . $producto['precio'] . '€';
        echo '<input type="number" name="productos[' . $codigo . ']" min="0" value="' . $cantidadActual . '" style="width: 60px;">';
        echo '</div>';
    }

    ?>

    <input type="submit" value="Guardar 🛒">
</form>