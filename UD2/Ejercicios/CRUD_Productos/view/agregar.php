<?php

if (isset($_POST["nombre"])) {

    require_once "../model/ProductoModel.php";
    require_once "../model/Producto.php";
    require_once "../alert.php";

    $productoModel = new ProductoModel();

    $nombre = $_POST["nombre"];
    $precio = $_POST["precio"];



    $productoValido = $productoModel->buscarProductoExistente($nombre);
   


    if ($productoValido == null) {

        $nuevoProducto = new Producto(null, $nombre, $precio);

        $productoModel->insertarProducto($nuevoProducto);

        alert("Producto agregado correctamente", "../index.php", "success");

    } else {
        alert("El producto $nombre ya existe", "../index.php", "error");
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <form method="POST" action="">
        <h1>Agregar Nuevo Producto</h1>

        <label for="nombre">Nombre del producto:</label>
        <input type="text" id="nombre" name="nombre">

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" step="0.01" min="0.01">

        <button type="submit">Agregar Producto</button>

        <br><br>
        <a href="../index.php">Volver a la lista</a>
    </form>
</body>

</html>