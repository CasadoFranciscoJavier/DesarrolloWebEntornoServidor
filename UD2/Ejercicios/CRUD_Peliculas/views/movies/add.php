<?php

require_once "./navbar.php";

$rol = $usuario->getRol();

if ($rol != "administrador") {
    header("Location: list.php");
}

if (isset($_POST["titulo"])) {
    require_once "../../models/MovieModel.php";
    require_once "../../models/Movie.php";

    $movieModel = new MovieModel();

    $titulo = $_POST["titulo"];
    $sinopsis = $_POST["sinopsis"];
    $anio = $_POST["anio"];
    $genero = $_POST["genero"];

    $nuevaPelicula = new Movie(null, $titulo, $sinopsis, $anio, $genero);
    $movieModel->insertarPelicula($nuevaPelicula);
    $id = $movieModel->obtenerUltimoId();

    header("Location: detail.php?id=$id");
}

?>
<link rel="stylesheet" href="../../css/style.css">

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Película</title>
</head>
<body>
    <h1>Añadir Película</h1>
    <form method="POST">
        <label>Título: <input name="titulo" type="text"></label><br>
        <label>Sinopsis: <textarea name="sinopsis"></textarea></label><br>
        <label>Año: <input name="anio" type="number"></label><br>
        <label>Género: <input name="genero" type="text"></label><br>
        <input type="submit" value="Añadir Película">
    </form>
</body>
</html>
