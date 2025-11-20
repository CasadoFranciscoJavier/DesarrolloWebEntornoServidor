<?php

require_once "./navbar.php";

if (!isset($_SESSION["usuario"])) {
    header("Location: ../auth/login.php");
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
    $nuevaPelicula = $movieModel->insertarPelicula($nuevaPelicula);


    $nuevaMovieId = $movieModel->obtenerUltimoId();
    

    header("Location: detail.php?id=$nuevaMovieId");
}

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../css/style.css">

    <title>Agregar producto</title>
</head>

<body>
    <h1>Añadir Película</h1>
    <form method="POST">
        <label>Título: <input name="titulo" type="text" value=""></label><br>
        <label>Sinopsis: <textarea name="sinopsis"></textarea></label><br>
        <label>Año: <input name="anio" type="number" value=""></label><br>
        <label>Género: <input name="genero" type="text" value=""></label><br>

        <input type="submit">
    </form>
</body>

</html>