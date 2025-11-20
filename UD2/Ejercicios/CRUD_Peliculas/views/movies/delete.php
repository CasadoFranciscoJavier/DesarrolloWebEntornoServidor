<?php

if (isset($_GET["id"])) {

    require_once "../../models/MovieModel.php";
    require_once "../../models/Movie.php";

    $movieModel = new MovieModel();

    $id = $_GET["id"];

    $movieModel->borrarPeliculaPorId($id);
}

header("Location: ../../index.php");