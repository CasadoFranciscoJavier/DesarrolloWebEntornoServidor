<?php

require_once "../../models/PeliculaModel.php";
require_once "../../models/Pelicula.php";
require_once "../../models/Usuario.php";
require_once "./navbar.php";


$peliculaModel = new PeliculaModel();

$peliculas = $peliculaModel->obtenerTodosPeliculas();

echo "<ol>";

    foreach ($peliculas as $pelicula) {
        $titulo = $pelicula->getTitulo();
        $id = $pelicula->getId();
        echo "<li><a href='detalles.php?id=$id'>$titulo</a></li>";
    }

echo "</ol>";


?>