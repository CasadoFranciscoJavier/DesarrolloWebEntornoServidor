<?php

require_once "./model/ProductoModel.php";
require_once "./model/Producto.php";

$productoModel = new ProductoModel();

$productos = $productoModel->obtenerTodosProductos();

foreach ($productos as $producto) {
    $id = $producto->getId();
    echo $producto . "<a href='view/eliminar.php?id=$id' onclick=\"return confirm('Estás seguro de lo que quieres hacer?')\";><button>🗑</button></a>" . "<a href='view/editar.php?id=$id'><button>✏</button></a>";
    echo "<br>";
}

?>
<a href="view/agregar.php">
    <button>Añadir Producto</button>
</a>

