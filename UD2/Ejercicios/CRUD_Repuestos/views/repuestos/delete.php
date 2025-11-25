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

if (isset($_GET["id"])) {
    require_once "../../models/RepuestoModel.php";
    require_once "../../models/Repuesto.php";

    $repuestoModel = new RepuestoModel();
    $id = $_GET["id"];
    $repuestoModel->borrarRepuestoPorId($id);
}

header("Location: list.php");
