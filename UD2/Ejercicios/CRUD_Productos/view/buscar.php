<?php
require_once __DIR__ . "/../conexion.php";
require_once __DIR__ . "/../model/ProductoModel.php";

$productoModel = new ProductoModel($conexion);
$producto = null;
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

    if ($id && $id > 0) {
        $producto = $productoModel->obtenerPorId($id);

        if (!$producto) {
            $mensaje = "No se encontró ningún producto con el ID: $id";
        }
    } else {
        $mensaje = "Por favor, ingresa un ID válido.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Buscar producto</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container">
        <h1>Buscar producto</h1>

        <form method="POST" action="">
            <label for="id">ID del producto:</label>
            <input type="number" id="id" name="id" min="1" required>

            <button type="submit">Buscar</button>
        </form>

        <?php if (!empty($mensaje)): ?>
            <div style="margin-top: 20px; padding: 12px; background: #ffe6e6; border-radius: 8px; color: #cc0000;">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>

        <?php if ($producto): ?>
            <div
                style="margin-top: 20px; padding: 20px; background: #e8f5e9; border-radius: 8px; border: 2px solid #4caf50;">
                <h2>Producto encontrado</h2>
                <p><strong>ID:</strong> <?php echo htmlspecialchars($producto->getId()); ?></p>
                <p><strong>Nombre:</strong> <?php echo htmlspecialchars($producto->getNombre()); ?></p>
                <p><strong>Precio:</strong> <?php echo number_format($producto->getPrecio(), 2); ?> €</p>
            </div>
        <?php endif; ?>

        <br>
        <button onclick="window.location.href='../index.php'" style="display: inline-block; margin-top: 16px;">Volver
            al listado</button>
    </div>
</body>

</html>