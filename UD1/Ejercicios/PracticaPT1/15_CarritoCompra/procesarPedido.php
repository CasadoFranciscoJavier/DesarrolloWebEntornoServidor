<?php
require_once "productos.php"; // Necesario para IVA_PORCENTAJE y DESCUENTO_MAYOR_A_10

// =================================== INICIALIZACIÓN DE VARIABLES ===================================
$nombreCliente = $_POST['nombre_cliente'] ?? 'ERROR';
$categoria = $_POST['categoria'] ?? 'ERROR';

$productosSeleccionados = $_POST['seleccionados'] ?? [];
$cantidades = $_POST['cantidad'] ?? [];
$precios = $_POST['precio'] ?? []; // Obtenido del campo oculto
$stocks = $_POST['stock'] ?? [];   // Obtenido del campo oculto

$subtotalBase = 0.0;
$totalDescuento = 0.0;
$resumenProductos = [];

// =================================== CÁLCULO DE PEDIDO Y LÓGICA CONDICIONAL ===================================

// Aseguramos que haya al menos un producto seleccionado
if (empty($productosSeleccionados)) {
    alert("Debes seleccionar al menos un producto para realizar el pedido.");
}

// Iterar solo sobre los productos que el usuario seleccionó
foreach ($productosSeleccionados as $nombreProducto) {
    // Asegurarse de que tenemos cantidad y precio para el producto seleccionado
    $cantidad = intval($cantidades[$nombreProducto] ?? 0);
    $precioUnitario = floatval($precios[$nombreProducto] ?? 0.0);
    $stockDisponible = intval($stocks[$nombreProducto] ?? 0);

    // Validación extra: Si la cantidad es cero (aunque el input type="number" lo evita)
    // o si la cantidad excede el stock (aunque el input max lo evita, es buena práctica)
    if ($cantidad > 0 && $cantidad <= $stockDisponible) {
        
        $costoLineaBase = $precioUnitario * $cantidad;
        $descuentoLinea = 0.0;
        $mensajeDescuento = "No aplica";

        // VUELTECITA: Descuento si la cantidad es mayor a 10 unidades
        if ($cantidad > 10) {
            $descuentoLinea = $costoLineaBase * DESCUENTO_MAYOR_A_10;
            $totalDescuento += $descuentoLinea;
            $mensajeDescuento = "Aplicado " . (DESCUENTO_MAYOR_A_10 * 100) . "%";
        }

        $costoLineaFinal = $costoLineaBase - $descuentoLinea;
        $subtotalBase += $costoLineaFinal;

        // Guardar el resumen para el output HTML
        $resumenProductos[] = [
            "nombre" => $nombreProducto,
            "cantidad" => $cantidad,
            "precio_unitario" => $precioUnitario,
            "costo_base" => round($costoLineaBase, 2),
            "descuento" => round($descuentoLinea, 2),
            "costo_final" => round($costoLineaFinal, 2),
            "mensaje_descuento" => $mensajeDescuento,
        ];
        
    } else {
alert("Cantidad no disponible");    }
}

// Cálculos finales
$costoIVA = $subtotalBase * IVA_PORCENTAJE;
$presupuestoTotal = $subtotalBase + $costoIVA;

// =================================== OUTPUT HTML FINAL ===================================
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resumen de Pedido</title>
</head>
<body>
    <h1>Resumen del Pedido</h1>
    <h2>Cliente: <?php echo htmlspecialchars($nombreCliente); ?> | Categoría: <?php echo htmlspecialchars($categoria); ?></h2>

    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cant.</th>
                <th>Precio Unit.</th>
                <th>Costo Base</th>
                <th>Descuento</th>
                <th>Costo Final</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resumenProductos as $item): ?>
            <tr>
                <td><?php echo htmlspecialchars($item['nombre']); ?></td>
                <td><?php echo $item['cantidad']; ?></td>
                <td><?php echo $item['precio_unitario']; ?> €</td>
                <td><?php echo $item['costo_base']; ?> €</td>
                <td style="color: green;"><?php echo $item['descuento']; ?> € (<?php echo $item['mensaje_descuento']; ?>)</td>
                <td style="font-weight: bold;"><?php echo $item['costo_final']; ?> €</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <br>
    
    <h2>Total Presupuesto</h2>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <td>Subtotal (antes de IVA)</td>
            <td style="text-align: right;"><?php echo round($subtotalBase, 2); ?> €</td>
        </tr>
        <tr>
            <td>Total Descuentos Aplicados</td>
            <td style="text-align: right; color: green;">- <?php echo round($totalDescuento, 2); ?> €</td>
        </tr>
        <tr>
            <td>IVA (<?php echo IVA_PORCENTAJE * 100; ?>%)</td>
            <td style="text-align: right;"><?php echo round($costoIVA, 2); ?> €</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">PRESUPUESTO TOTAL</td>
            <td style="text-align: right; font-weight: bold; font-size: 1.2em; color: blue;"><?php echo round($presupuestoTotal, 2); ?> €</td>
        </tr>
    </table>

    <br>
    <button onclick="window.location.href='pedido.html'">Hacer Nuevo Pedido</button>
</body>
</html>