<?php

require_once "../../models/MovieModel.php";
require_once "../../models/Movie.php";
require_once "./navbar.php";

$peliculaModel = new MovieModel();
$peliculas = $peliculaModel->obtenerTodosPeliculas();

?>
<link rel="stylesheet" href="../../css/style.css">

<h1>Listado de Películas</h1>

<ul>
<?php
foreach ($peliculas as $pelicula) {
    $titulo = $pelicula->getTitulo();
    $id = $pelicula->getId();
    echo "<li><a href='detail.php?id=$id'>$titulo</a></li>";
}
?>
</ul>
