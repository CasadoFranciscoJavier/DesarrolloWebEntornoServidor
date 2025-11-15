<?php

require_once "../model/ProductoModel.php";
require_once "../model/Producto.php";
require_once "../alert.php";

$productoModel = new ProductoModel();

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $producto = $productoModel->obtenerProductoPorId($id);
}
if (isset($_POST["nombre"])) {

    $id = $_GET["id"];
    $nombre = $_POST["nombre"];
    $precio = $_POST["precio"];

    $productoValido = $productoModel->buscarProductoExistente($nombre);

    // Verificar si el nombre ya existe, PERO permitir que mantenga su propio nombre
    if ($productoValido == null || $productoValido->getId() == $id) {
        $producto = new Producto($id, $nombre, $precio);

        $productoModel->actualizarProducto($producto);

        alert("Producto actualizado correctamente", "../index.php", "success");

    } else {
        alert("El producto $nombre ya existe", "../index.php", "error");
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <form method="POST" action="">
        <h1>Editar Producto</h1>

        <label for="nombre">Nombre del producto:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($producto->getNombre()); ?>"
            required>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" step="0.01" min="0.01"
            value="<?php echo htmlspecialchars($producto->getPrecio()); ?>" required>

        <button type="submit">Actualizar Producto</button>

        <br><br>
        <a href="../index.php">Cancelar y volver</a>
    </form>
</body>

</html>