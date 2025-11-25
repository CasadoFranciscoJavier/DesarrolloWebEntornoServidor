<?php

require_once "./navbar.php";

$rol = $usuario->getRol();

if ($rol != "administrador") {
    header("Location: list.php");
}

require_once "../../models/MovieModel.php";
require_once "../../models/Movie.php";

$movieModel = new MovieModel();

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $pelicula = $movieModel->obtenerPeliculaPorId($id);
}

if (isset($_POST["titulo"])) {
    $id = $_GET["id"];
    $titulo = $_POST["titulo"];
    $sinopsis = $_POST["sinopsis"];
    $anio = $_POST["anio"];
    $genero = $_POST["genero"];

    $peliculaActualizada = new Movie($id, $titulo, $sinopsis, $anio, $genero);
    $movieModel->actualizarPelicula($peliculaActualizada);

    header("Location: detail.php?id=$id");
}

?>
<link rel="stylesheet" href="../../css/style.css">

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Película</title>
</head>
<body>
    <h1>Editar Película</h1>
    <form method="POST">
        <label>ID: <input name="ID" type="text" value="<?php echo $pelicula->getId()?>" disabled></label><br>
        <label>Título: <input name="titulo" type="text" value="<?php echo $pelicula->getTitulo()?>"></label><br>
        <label>Sinopsis: <textarea name="sinopsis"><?php echo $pelicula->getSinopsis()?></textarea></label><br>
        <label>Año: <input name="anio" type="number" value="<?php echo $pelicula->getAnio()?>"></label><br>
        <label>Género: <input name="genero" type="text" value="<?php echo $pelicula->getGenero()?>"></label><br>
        <input type="submit" value="Actualizar Película">
    </form>
</body>
</html>
