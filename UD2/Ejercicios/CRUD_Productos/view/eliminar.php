<?php
require_once __DIR__ . "/../model/ProductoModel.php";
require_once __DIR__ . "/../alert.php";

$productoModel = new ProductoModel($conexion);

$id = $_GET["id"] ?? null;

if ($id == null) {
    alert("ID de producto no válido", "../index.php", "error");
}

if ($productoModel->eliminar($id)) {
    alert("Producto eliminado correctamente", "../index.php", "success");
} else {
    alert("Error al eliminar el producto", "../index.php", "error");
}
