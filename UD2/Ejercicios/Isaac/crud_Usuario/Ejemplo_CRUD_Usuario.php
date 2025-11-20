<?php

try {
    // Crear una nueva conexión PDO
    $conexion = new PDO("mysql:host=localhost;dbname=DB_USUARIOS", "root", "1234");
    
    // Establecer el modo de error a excepciones
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conexión exitosa";
} catch (PDOException $e) {
    // Capturar y manejar los errores de conexión
    echo "Error en la conexión: " . $e->getMessage();
}

// =================== SELECCIONAR TODOS LOS USUARIOS =================== //

// Preparar la consulta
$stmt = $conexion->prepare("SELECT * FROM USUARIO");

// Ejecutar la consulta
$stmt->execute();

// Recuperar los resultados
$resultado = $stmt->fetchAll();

echo "<br><br>";

print_r($resultado);

echo "<br><br>";

foreach ($resultado as $numeroFila => $fila) {
    echo "<br> Fila $numeroFila : ";
    print_r($fila);
}

// ======================= SELECCIONAR UN USUARIO ======================= //

$id = 1;

// Preparar la consulta
$stmt = $conexion->prepare("SELECT * FROM USUARIO WHERE id = :id");

// Enlazar el valor del marcador de posición
$stmt->bindParam(':id', $id);

// Ejecutar la consulta
$stmt->execute();

// Recuperar los resultados
$resultado = $stmt->fetch();

// print_r($resultado);

// ======================= INSERTAR UN USUARIO ======================= //

echo "<br><br> INSERTAR <br><br>";

// Preparar la consulta
$stmt = $conexion->prepare("INSERT INTO USUARIO(NOMBRE, EDAD) VALUES(:nombre, :edad)");

$nombre = "Evaristo";
$edad = 22;

// Enlazar el valor del marcador de posición
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':edad', $edad);

// Ejecutar la consulta
$ejecucion = $stmt->execute(); // execute devuelve un booleano indicando el éxito o no de la consulta

print_r($ejecucion);

// ======================= BORRAR UN USUARIO ======================= //

echo "<br><br> BORRAR <br><br>";

// Preparar la consulta
$stmt = $conexion->prepare("DELETE FROM USUARIO WHERE ID=:id");

$id = 5;
// Enlazar el valor del marcador de posición
$stmt->bindParam(':id', $id);

// Ejecutar la consulta
$ejecucion = $stmt->execute(); // execute devuelve un booleano indicando el éxito o no de la consulta

print_r($ejecucion);

// ======================= ACTUALIZAR UN USUARIO ======================= //

echo "<br><br> ACTUALIZAR <br><br>";

// Preparar la consulta
$stmt = $conexion->prepare("UPDATE USUARIO SET NOMBRE=:nombre WHERE ID=:id");

$id = 8;
$nombre = "Evaristo lider clon";
// Enlazar el valor del marcador de posición
$stmt->bindParam(':id', $id);
$stmt->bindParam(':nombre', $nombre);

// Ejecutar la consulta
$ejecucion = $stmt->execute(); // execute devuelve un booleano indicando el éxito o no de la consulta

print_r($ejecucion);

// ======================= INYECCION SQL ======================= //

echo "<br><br> INYECCION SQL <br><br>";

$id = "8; DROP TABLE USUARIO;";

$consulta = "SELECT * FROM USUARIO WHERE id = ".$id;

$stmt = $conexion->prepare($consulta);

$stmt->execute();

$resultado = $stmt->fetch();

print_r($resultado);