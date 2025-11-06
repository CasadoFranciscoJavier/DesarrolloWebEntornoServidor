<?php
require_once __DIR__ . "/../model/ProductoModel.php";
require_once __DIR__ . "/../alert.php";

$productoModel = new ProductoModel($conexion);

$id = $GET["id"] ?? null;

if ($id == null) {
    alert("ID de producto no válido", "../index.php", "error");
}

$producto = $productoModel->obtenerPorId($id);

if ($producto == null) {
    alert("Producto no encontrado", "../index.php", "error");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"] ?? "";
    $precio = $_POST["precio"] ?? 0;

    $producto->setNombre($nombre);
    $producto->setPrecio($precio);

    if ($productoModel->actualizar($producto)) {
        alert("Producto actualizado correctamente", "../index.php", "success");
    } else {
        alert("Error al actualizar el producto", "./editar.php?id=" . $id, "error");
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
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($producto->getNombre()); ?>" required>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" step="0.01" min="0.01" value="<?php echo htmlspecialchars($producto->getPrecio()); ?>" required>

        <button type="submit">Actualizar Producto</button>

        <br><br>
        <a href="../index.php">Cancelar y volver</a>
    </form>
</body>
</html>
