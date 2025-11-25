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

if (isset($_GET["id"]) && isset($_GET["idPelicula"])) {
    require_once "../../models/CommentModel.php";

    $comentarioModel = new CommentModel();
    $idComentario = $_GET["id"];
    $idPelicula = $_GET["idPelicula"];

    $comentarioModel->borrarComentarioPorId($idComentario);

    header("Location: detail.php?id=$idPelicula");
}
