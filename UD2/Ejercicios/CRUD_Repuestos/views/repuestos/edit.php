<?php

require_once "./navbar.php";

$rol = $usuario->getRol();

if ($rol != "administrador") {
    header("Location: list.php");
}

require_once "../../models/RepuestoModel.php";
require_once "../../models/Repuesto.php";

$repuestoModel = new RepuestoModel();

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $repuesto = $repuestoModel->obtenerRepuestoPorId($id);
}

if (isset($_POST["nombre"])) {
    $id = $_GET["id"];
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $stock = $_POST["stock"];
    $categoria = $_POST["categoria"];

    $repuestoActualizado = new Repuesto($id, $nombre, $descripcion, $precio, $stock, $categoria);
    $repuestoModel->actualizarRepuesto($repuestoActualizado);

    header("Location: detail.php?id=$id");
}

?>
<link rel="stylesheet" href="../../css/style.css">

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Repuesto</title>
</head>
<body>
    <h1>Editar Repuesto</h1>
    <form method="POST">
        <label>ID: <input name="ID" type="text" value="<?php echo $repuesto->getId()?>" disabled></label><br>
        <label>Nombre: <input name="nombre" type="text" value="<?php echo $repuesto->getNombre()?>" required></label><br>
        <label>Descripción: <textarea name="descripcion" required><?php echo $repuesto->getDescripcion()?></textarea></label><br>
        <label>Precio: <input name="precio" type="number" step="0.01" value="<?php echo $repuesto->getPrecio()?>" required></label><br>
        <label>Stock: <input name="stock" type="number" value="<?php echo $repuesto->getStock()?>" required></label><br>
        <label>Categoría: <input name="categoria" type="text" value="<?php echo $repuesto->getCategoria()?>" required></label><br>
        <input type="submit" value="Actualizar Repuesto">
    </form>
    <br>
    <a href="detail.php?id=<?php echo $repuesto->getId()?>"><button>Volver</button></a>
</body>
</html>
