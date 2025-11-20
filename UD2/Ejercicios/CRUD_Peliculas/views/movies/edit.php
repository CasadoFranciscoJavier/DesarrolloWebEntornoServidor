<?php

session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: ../auth/login.php");
}

require_once __DIR__ . '/../../models/MovieModel.php';
require_once __DIR__ . '/../../models/Movie.php';

$movieModel = new MovieModel();

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $peliculaActual = $movieModel->obtenerPeliculaPorId($id);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_GET["id"];
    $titulo = $_POST["titulo"];
    $sinopsis = $_POST["sinopsis"];
    $anio = $_POST["anio"];
    $genero = $_POST["genero"];

    $nuevaPelicula = new Movie($id, $titulo, $sinopsis, $anio, $genero);

    $movieModel->actualizarPelicula($nuevaPelicula);
    header("Location: detail.php?id=$id");
    exit();
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../css/style.css">
    <title>Editar Película</title>
</head>
<body>
    <h1>Editar Película</h1>
    <form method="POST">
        <label>ID: <input name="ID" type="text" value="<?php echo $peliculaActual->getId()?>" disabled></label><br>
        <label>Título: <input name="titulo" type="text" value="<?php echo $peliculaActual->getTitulo()?>"></label><br>
        <label>Sinopsis: <textarea name="sinopsis"><?php echo $peliculaActual->getSinopsis()?></textarea></label><br>
        <label>Año: <input name="anio" type="number" value="<?php echo $peliculaActual->getAnio()?>"></label><br>
        <label>Género: <input name="genero" type="text" value="<?php echo $peliculaActual->getGenero()?>"></label><br>

        <input type="submit">
    </form>
</body>
</html>