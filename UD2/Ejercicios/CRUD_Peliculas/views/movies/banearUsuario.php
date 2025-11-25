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

if (isset($_POST["id"])) {
    require_once "../../models/UserModel.php";

    $userModel = new UserModel();
    $idUsuario = $_POST["id"];

    $userModel->banearUsuarioPorId($idUsuario);

    header("Location: list.php");
}
