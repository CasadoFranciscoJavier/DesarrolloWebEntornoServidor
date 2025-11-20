<?php

require_once "../model/ProductoModel.php";
require_once "../model/Producto.php";

$productoModel = new ProductoModel();

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $producto = $productoModel->obtenerProductoPorId($id);

    echo $producto . "<a href='eliminar.php?id=$id' onclick=\"return confirm('Estás seguro de lo que quieres hacer?')\";><button>🗑</button></a>" . "<a href='editar.php?id=$id'><button>✏</button></a>";
    echo "<br>";
}