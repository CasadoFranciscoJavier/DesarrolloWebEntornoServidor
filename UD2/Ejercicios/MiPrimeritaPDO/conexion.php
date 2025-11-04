<?php




try {
    // Crear una nueva conexión PDO
    $conexion = new PDO("mysql:host=localhost;dbname=mi_primerita_dto", "root", "1234");
    
    // Establecer el modo de error a excepciones
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conexión exitosa <br>";


} catch (PDOException $e) {
    // Capturar y manejar los errores de conexión
    echo "Error en la conexión: " . $e->getMessage();
}

    // Preparar la consulta
$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id = :id");

// Enlazar el valor del marcador de posición
$stmt->bindParam(':id', $id);

// Asignar el valor y ejecutar la consulta
$id = 1;
$stmt->execute();

// Recuperar los resultados
$resultado = $stmt->fetchAll();
foreach ($resultado as $fila) {
    echo $fila['nombre'];
}



