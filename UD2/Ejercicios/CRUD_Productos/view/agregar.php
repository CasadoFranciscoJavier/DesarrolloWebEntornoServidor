<?php
require_once __DIR__ . "/../model/ProductoModel.php";
require_once __DIR__ . "/../alert.php";

$productoModel = new ProductoModel($conexion);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"] ?? "";
    $precio = $_POST["precio"] ?? 0;

    $nuevoProducto = new Producto(null, $nombre, $precio);

    if ($productoModel->agregar($nuevoProducto)) {
        alert("Producto agregado correctamente", "../index.php", "success");
    } else {
        alert("Error: El nombre no puede estar vacío y el precio debe ser mayor a 0", "./agregar.php", "error");
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
