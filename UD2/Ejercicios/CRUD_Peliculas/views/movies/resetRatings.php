<?php

require_once "../../models/User.php";

session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: ../auth/login.php");
}

$usuario = $_SESSION["usuario"];
$rol = $usuario->getRol();

if ($rol != "administrador") {
    header("Location: list.php");
}

if (isset($_GET["id"])) {
    require_once "../../models/RatingModel.php";

    $ratingModel = new RatingModel();
    $idPelicula = $_GET["id"];

    $ratingModel->borrarPuntuacionPorIdPelicula($idPelicula);

    header("Location: detail.php?id=$idPelicula");
}
