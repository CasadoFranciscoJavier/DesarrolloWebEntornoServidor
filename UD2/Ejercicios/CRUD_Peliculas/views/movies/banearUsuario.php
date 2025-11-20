<?php
session_start();

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "administrador") {
    header("Location: ../auth/login.php");
    exit;
}

require_once __DIR__ . '/../../models/UserModel.php';
require_once __DIR__ . '/../../alert.php';

if (isset($_POST["id"])) {
    $userModel = new UserModel();
    $userModel->banearUsuarioPorId($_POST["id"]);
    alert ("Usuario baneado correctamente de la base de datos","list.php","success");
} else {
    header("Location: list.php");
    exit;
}
