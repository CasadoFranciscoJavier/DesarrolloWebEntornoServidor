<!-- Ejercicio 1 PHP, práctica de sintáxis básica -->
<!-- Crea un Map de productos y precios, la clave será el nombre del producto y el valor el precio del producto. -->
<!-- Crea un array con el mismo tamaño que la cantidad de productos existente, este array contendrá la cantidad de cada producto comprada.
Crea un programa que calcule e imprima el ticket de compra mostrando cada producto, la cantidad comprada, el total de la compra y el precio con el IVA desglosado. -->

<?php

$productos = array("Pera" => 2, "Pan" => 1, "Agua" => 3);
$cantidad = array(6, 0, 2);
$iva = 1.21;

$totalSinIva = 0;

echo "<h1>Ticket de Compra</h1>";


echo "<table border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse; background-color: #a9c4c0ff;'>";

echo "<tr>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Precio c/u (€)</th>
        <th>Subtotal (€)</th>
        <th>IVA (€)</th>
        <th>Total (€)</th>
      </tr>";

$index = 0;
foreach ($productos as $producto => $precioConIva) {
    $cant = $cantidad[$index];

    $precioSinIva = $precioConIva / ($iva);
    $subtotalSinIva = $precioSinIva * $cant;
    $subtotalIva = $subtotalSinIva * $iva;
    $total = $subtotalSinIva + $subtotalIva;

    $totalSinIva += $subtotalSinIva;
    if ($cant !=0) {
      echo "<tr>
            <td>$producto</td>
            <td>$cant</td>
            <td>" . number_format($precioConIva, 2) . "</td>
            <td>" . number_format($subtotalSinIva, 2) . "</td>
            <td>" . number_format($subtotalIva, 2) . "</td>
            <td>" . number_format($total, 2) . "</td>
          </tr>";
      
    }

    

    $index++;
}

$totalConIva = $totalSinIva * ($iva);

// Totales finales
echo "<tr>
        <td colspan='3'><strong>Total</strong></td>
        <td><strong>" . number_format($totalSinIva, 2) . "</strong></td>
        <td><strong>" . number_format($totalConIva - $totalSinIva, 2) . "</strong></td>
        <td><strong>" . number_format($totalConIva, 2) . "</strong></td>
      </tr>";

echo "</table>";

?>




