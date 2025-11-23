<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: ../auth/login.php");
    exit();
}

require_once "../../models/RatingModel.php";
require_once "../../models/Rating.php";

if (isset($_GET["id"])) {
    $idPelicula = $_GET["id"];
}

if (isset($_POST["puntuacion"])) {
    $ratingModel = new RatingModel();

    $puntuacion = $_POST["puntuacion"];
    $idUsuario = $_SESSION["id"];

    $nuevaPuntuacion = new Rating(null, $puntuacion, $idUsuario, $idPelicula);
    $ratingModel->insertarPuntuacion($nuevaPuntuacion);

    header("Location: detail.php?id=$idPelicula");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../css/style.css">
    <title>Añadir Puntuación</title>
</head>

<body>
    <?php require_once "./navbar.php"; ?>

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
        </label><br><br>

        <input type="submit" value="Añadir puntuación">
        <a href="detail.php?id=<?php echo $idPelicula; ?>"><button type="button">Cancelar</button></a>
    </form>
</body>

</html>
