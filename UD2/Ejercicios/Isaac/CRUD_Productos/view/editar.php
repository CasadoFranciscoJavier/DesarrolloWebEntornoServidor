<?php

require_once "../model/ProductoModel.php";
require_once "../model/Producto.php";

$productoModel = new ProductoModel();

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $producto = $productoModel->obtenerProductoPorId($id);
}
if (isset($_POST["nombre"])) {

    $id = $_GET["id"];
    $nombre = $_POST["nombre"];
    $precio = $_POST["precio"];

    $producto = new Producto($id, $nombre, $precio);
    
    $productoModel->actualizarProducto($producto);

    header("Location: ../index.php");
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar producto</title>
</head>
<body>
    <form method="POST">
        <label>ID: <input name="ID" type="text" value="<?php echo $producto->getId()?>" disabled></label><br>
        <label>Nombre: <input name="nombre" type="text" value="<?php echo $producto->getNombre()?>"></label><br>
        <label>Precio: <input name="precio" type="number" step="0.01" value="<?php echo $producto->getPrecio()?>"></label><br>
        <input type="submit">
    </form>
</body>
</html>