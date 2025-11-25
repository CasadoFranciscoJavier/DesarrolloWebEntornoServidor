<?php

require_once "../../models/Usuario.php";

session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: ../auth/login.php");
}

$usuario = $_SESSION["usuario"];
$rol = $usuario->getRol();

if ($rol != "administrador") {
    header("Location: list.php");
}

if (isset($_GET["id"]) && isset($_GET["idRepuesto"])) {
    require_once "../../models/EmbalajeModel.php";

    $embalajeModel = new EmbalajeModel();
    $idEmbalaje = $_GET["id"];
    $idRepuesto = $_GET["idRepuesto"];

    $embalajeModel->borrarEmbalajePorId($idEmbalaje);

    header("Location: detail.php?id=$idRepuesto");
}
