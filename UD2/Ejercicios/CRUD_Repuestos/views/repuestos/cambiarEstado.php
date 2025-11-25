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

if (isset($_GET["id"]) && isset($_GET["estado"])) {
    require_once "../../models/PedidoModel.php";

    $pedidoModel = new PedidoModel();
    $idPedido = $_GET["id"];
    $nuevoEstado = $_GET["estado"];

    $pedidoModel->cambiarEstadoPedido($idPedido, $nuevoEstado);

    header("Location: verTodosPedidos.php");
}
