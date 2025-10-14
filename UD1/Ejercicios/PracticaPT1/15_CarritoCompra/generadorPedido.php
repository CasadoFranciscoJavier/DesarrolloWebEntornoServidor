<?php
require_once "productos.php";

// =================================== VALIDACIÓN INICIAL ===================================

$nombreCliente = $_POST['nombre_cliente'] ?? '';
$categoriaSeleccionada = $_POST['categoria'] ?? '';

$valido = false;
$productosDeCategoria = [];

// 1. Validar campos
if (validarCampoVacio('nombre_cliente') && validarCampoVacio('categoria')) {
    
    // 2. Validar que la categoría exista en el repositorio
    if (isset($catalogoProductos[$categoriaSeleccionada])) {
        $productosDeCategoria = $catalogoProductos[$categoriaSeleccionada];
        $valido = true;
    } else {
        alert("La categoría '$categoriaSeleccionada' no es válida.");
    }
}

// =================================== GENERACIÓN DEL FORMULARIO ===================================

if ($valido) {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Paso 2: Catálogo de Productos</title>
    </head>
    <body>
        <h1>Catálogo de Productos de <?php echo htmlspecialchars($categoriaSeleccionada); ?></h1>
        <h2>Cliente: <?php echo htmlspecialchars($nombreCliente); ?></h2>

        <form action="procesarPedido.php" method="POST">
            <input type="hidden" name="nombre_cliente" value="<?php echo htmlspecialchars($nombreCliente); ?>">
            <input type="hidden" name="categoria" value="<?php echo htmlspecialchars($categoriaSeleccionada); ?>">
            
            <table border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <th>Seleccionar</th>
                    <th>Producto</th>
                    <th>Precio Unitario (€)</th>
                    <th>Stock</th>
                    <th>Cantidad Deseada</th>
                </tr>
                
                <?php
                $i = 0; // Contador para indexar los campos ocultos
                
                foreach ($productosDeCategoria as $nombreProducto => $datosProducto) {
                    $precio = $datosProducto['precio'];
                    $stock = $datosProducto['stock'];
                    $nombreLimpio = htmlspecialchars($nombreProducto);
                    
                    echo "<tr>";
                    // Checkbox para seleccionar el producto
                    echo "<td><input type='checkbox' name='seleccionados[]' value='$nombreLimpio' id='prod_$i'></td>";
                    
                    // Nombre del Producto
                    echo "<td><label for='prod_$i'>$nombreLimpio</label></td>";
                    
                    // Precio y Stock
                    echo "<td>$precio €</td>";
                    echo "<td>$stock</td>";
                    
                    // Input de Cantidad Deseada (Mínimo 1, Máximo igual al stock)
                    echo "<td><input type='number' name='cantidad[$nombreLimpio]' min='1' max='$stock' value='1'></td>";
                    echo "</tr>";
                    
                    // CAMPOS OCULTOS PARA PASAR DATOS A PROCESARPEDIDO.PHP
                    // Pasamos el precio y el stock en campos ocultos, indexados por nombre del producto
                    echo "<input type='hidden' name='precio[$nombreLimpio]' value='$precio'>";
                    echo "<input type='hidden' name='stock[$nombreLimpio]' value='$stock'>";
                    
                    $i++;
                }
                ?>
                
            </table>
            <br>
            <button type="submit">Finalizar Pedido y Calcular</button>
        </form>
    </body>
    </html>
<?php
}
?>