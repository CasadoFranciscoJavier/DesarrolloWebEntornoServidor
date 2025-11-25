<?php

require_once "./navbar.php";

$rol = $usuario->getRol();

if ($rol != "administrador") {
    header("Location: list.php");
}

$idRepuesto = $_GET["id"];

if (isset($_POST["tipo"])) {
    require_once "../../models/EmbalajeModel.php";
    require_once "../../models/Embalaje.php";

    $embalajeModel = new EmbalajeModel();

    $tipo = $_POST["tipo"];
    $dimensiones = $_POST["dimensiones"];
    $pesoMaximo = $_POST["pesoMaximo"];

    $nuevoEmbalaje = new Embalaje(null, $idRepuesto, $tipo, $dimensiones, $pesoMaximo);
    $embalajeModel->insertarEmbalaje($nuevoEmbalaje);

    header("Location: detail.php?id=$idRepuesto");
}

?>
<link rel="stylesheet" href="../../css/style.css">

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Embalaje</title>
</head>
<body>
    <h1>Añadir Embalaje</h1>
    <form method="POST">
        <label>Tipo: <input name="tipo" type="text" placeholder="Ej: Caja Grande" required></label><br>
        <label>Dimensiones: <input name="dimensiones" type="text" placeholder="Ej: 30x20x10 cm" required></label><br>
        <label>Peso Máximo (kg): <input name="pesoMaximo" type="number" step="0.01" required></label><br>
        <input type="submit" value="Añadir Embalaje">
    </form>
    <br>
    <a href="detail.php?id=<?php echo $idRepuesto?>"><button>Volver</button></a>
</body>
</html>
