<?php

require_once "./navbar.php";
require_once "../../models/MovieModel.php";
require_once "../../models/Movie.php";

require_once "../../models/CommentModel.php";
require_once "../../models/Comment.php";
   
   

if (!isset($_SESSION["usuario"])) {
    header("Location: ../auth/login.php");
}

if (isset($_GET["id"])) {
    $idPelicula = $_GET["id"];
    // $peliculaActual = $movieModel->obtenerPeliculaPorId($id);
}


if (isset($_POST["contenido"])) {

    $commentModel = new CommentModel();

    $contenido = $_POST["contenido"];
    $idUsuario = $_SESSION["usuario"]->getId();

    $nuevoComentario = new Comment(null, $contenido, $idPelicula, $idUsuario);
    $nuevoComentario = $commentModel->insertarComentario($nuevoComentario);


    header("Location: detail.php?id=$idPelicula");
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
        <label>Nuevo comentario: <textarea name="contenido"></textarea></label><br>

        <input type="submit">
    </form>
</body>

</html>