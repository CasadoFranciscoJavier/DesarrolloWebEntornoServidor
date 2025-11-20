<?php

if (isset($_POST["nombre"])) {

    require_once "../model/ProductoModel.php";
    require_once "../model/Producto.php";

    $productoModel = new ProductoModel();

    $nombre = $_POST["nombre"];
    $precio = $_POST["precio"];

    $nuevoProducto = new Producto(null, $nombre, $precio);

    $nuevoProducto = $productoModel->insertarProducto($nuevoProducto);
    $id = $nuevoProducto->getId();

    header("Location: detalles.php?id=$id");
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
        <label>Nombre: <input name="nombre" type="text"></label><br>
        <label>Precio: <input name="precio" type="number" step="0.01"></label><br>
        <input type="submit">
    </form>
</body>

</html>