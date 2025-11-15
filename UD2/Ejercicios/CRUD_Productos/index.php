<?php

require_once "./model/ProductoModel.php";
require_once "./model/Producto.php";
require_once "./modalConfirm.php";

$productoModel = new ProductoModel();

$productos = $productoModel->obtenerTodosProductos();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de productos</title>
    <link rel="stylesheet" href="./css/style.css">
    <script>
        function confirmarEliminar(id) {
            mostrarModal('¿Estás seguro de que deseas eliminar este producto?', 'view/eliminar.php?id=' + id);
        }

         // sin el modal y de manera mas simple sería asi:
        //     function confirmarEliminar(id) {
        //         const respuesta = confirm('¿Estás seguro de que deseas eliminar este producto?');
        //         if (respuesta) {
        //             window.location.href = 'view/eliminar.php?id=' + id;
        //         }
        //     }
    </script>
</head>
<body>
    <div class="container">
        <h1>Productos disponibles</h1>

        <?php if (empty($productos)): ?>
            <p>No hay productos registrados.</p>
        <?php else: ?>
            <?php foreach ($productos as $producto): ?>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; padding: 12px; background: #f7fafd; border-radius: 8px; border: 1px solid #e3e8ee;">
                    <span style="color: #4a6fa5; font-weight: 500;">
                        <?php echo htmlspecialchars($producto->getNombre()); ?> -
                        <strong><?php echo number_format($producto->getPrecio(), 2); ?> €</strong>
                    </span>
                    <div>
                        <button onclick="window.location.href='view/editar.php?id=<?php echo $producto->getId(); ?>'">✏️ </button>
                        <button onclick="confirmarEliminar(<?php echo $producto->getId(); ?>)">🗑️ </button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <br>
        <button onclick="window.location.href='view/agregar.php'" style="display: inline-block; margin-top: 16px;">➕ Agregar producto</button>
        <button onclick="window.location.href='view/buscar.php'" style="display: inline-block; margin-top: 16px;">🔍 Buscar producto por ID</button>
    </div>

  
</body>
</html>
