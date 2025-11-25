<?php

require_once "./navbar.php";

$rol = $usuario->getRol();

if ($rol != "administrador") {
    header("Location: list.php");
}

if (isset($_POST["nombre"])) {
    require_once "../../models/RepuestoModel.php";
    require_once "../../models/Repuesto.php";

    $repuestoModel = new RepuestoModel();

    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $stock = $_POST["stock"];
    $categoria = $_POST["categoria"];

    $nuevoRepuesto = new Repuesto(null, $nombre, $descripcion, $precio, $stock, $categoria);
    $repuestoModel->insertarRepuesto($nuevoRepuesto);
    $id = $repuestoModel->obtenerUltimoId();

    header("Location: detail.php?id=$id");
}

?>
<link rel="stylesheet" href="../../css/style.css">

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Repuesto</title>
</head>
<body>
    <h1>Añadir Repuesto</h1>
    <form method="POST">
        <label>Nombre: <input name="nombre" type="text" required></label><br>
        <label>Descripción: <textarea name="descripcion" required></textarea></label><br>
        <label>Precio: <input name="precio" type="number" step="0.01" required></label><br>
        <label>Stock: <input name="stock" type="number" required></label><br>
        <label>Categoría: <input name="categoria" type="text" required></label><br>
        <input type="submit" value="Añadir Repuesto">
    </form>
    <br>
    <a href="list.php"><button>Volver</button></a>
</body>
</html>
