<?php

require_once 'productos.php';
?>

<link rel="stylesheet" href="style.css">
<h1>Listado de productos</h1>

<form action="procesarCarrito.php" method="POST">
    <?php
    foreach ($productos as $producto) {
        echo '<div class="producto" style="display: flex; justify-content: space-between;">';
        echo htmlspecialchars($producto['nombre']);
        echo '<input type="number" name="cantidad" min="0" value="0" style="width: 60px;">';
        echo '</div>';
    }
    echo '<input type="submit" value="Guardar 🛒">';
    ?>
</form>

