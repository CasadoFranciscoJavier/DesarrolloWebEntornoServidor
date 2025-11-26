<?php

require_once "../../models/RatingModel.php";
require_once "../../models/Rating.php";
require_once "./navbar.php";

$ratingModel = new RatingModel();

if (isset($_GET["id"])) {
    $idPelicula = $_GET["id"];
}

if (isset($_POST["puntuacion"])) {
    $puntuacion = $_POST["puntuacion"];
    $idUsuario = $usuario->getId();

    $nuevaValoracion = new Rating(null, $puntuacion, $idUsuario, $idPelicula);
    $ratingModel->insertarPuntuacion($nuevaValoracion);

    header("Location: detail.php?id=$idPelicula");
}

?>
<link rel="stylesheet" href="../../css/style.css">

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Puntuación</title>
</head>
<body>
    <h1>Añadir Puntuación</h1>
    <form method="POST">
        <label>Puntuación (1-10):
            <select name="puntuacion" required>
                <option value="">Selecciona...</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
            </select>
        </label><br>
        <input type="submit" value="Añadir puntuación">
    </form>
    <br>
    <a href="detail.php?id=<?php echo $idPelicula; ?>"><button>Volver</button></a>
</body>
</html>
