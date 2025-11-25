<?php

require_once "../../models/Usuario.php";
require_once "./navbar.php";

$usuario = $_SESSION["usuario"];
$rol = $usuario->getRol();

if ($rol == "ADMIN") {
    echo "SOY ADMIN";
} else {
    header("Location: ../../index.php");
}
