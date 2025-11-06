<?php
function alert($mensaje, $redirigir, $tipo = 'info')
{
    echo "
        <link rel='stylesheet' href='style.css'>
        <div class='container'>
            <div class='alert $tipo'>
                <p>$mensaje</p>
            </div>
        </div>
        <meta http-equiv='refresh' content='3;url=$redirigir'>
    ";
    exit;
}

try {
    // Crear una nueva conexión PDO
    $conexion = new PDO("mysql:host=localhost;dbname=tienda", "root", "1234");
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     echo "Conexión exitosa <br>";

} catch (PDOException $e) {
     echo "Error en la conexión: " . $e->getMessage();
}

// Preparar la consulta
$stmt = $conexion->prepare("SELECT * FROM productos");
$stmt->execute();

// Recuperar los resultados
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de productos</title>
    <link rel="stylesheet" href="./css/style.css">
    <script>
        function confirmarEliminacion(url) {
            if (confirm("¿Estás seguro de eliminar este producto?")) {
                window.location.href = url;
            } else {
                alert("El producto no fue eliminado.");
            }
        }
    </script>
</head>
<body>

    <h1>Productos disponibles</h1>

   
       <?php
foreach ($resultado as $fila) {
    echo "<div style='display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;'>";
    echo "<span>" . htmlspecialchars($fila['nombre']) . " - " . number_format($fila['precio'], 2) . " €</span>";
    echo "<div>";
    echo "<button onclick=\"window.location.href='editar.php?id=" . $fila['id'] . "'\">✏️ Editar</button> ";
    echo "<button onclick=\"confirmarEliminacion('eliminar.php?id=" . $fila['id'] . "')\">🗑️ Eliminar</button>";
    echo "</div>";
    echo "</div>";
}
?>

   

    <br>
    <a href="agregar.php">➕ Agregar producto</a>

</body>
</html>
