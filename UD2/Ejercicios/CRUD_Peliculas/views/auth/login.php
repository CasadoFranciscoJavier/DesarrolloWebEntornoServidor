<?php

session_start();

require_once "../../models/UserModel.php";
require_once "../../models/User.php";
require_once __DIR__ . '/../../alert.php';

$usuarioModel = new UserModel();

if (isset($_SESSION["usuario"])) {
    header("Location: ../movies/list.php");
    exit();
} else if (isset($_POST["nombre"]) && isset($_POST["contrasenia"])) {
    $nombre = $_POST["nombre"];
    $contrasenia = $_POST["contrasenia"];

    $usuario = $usuarioModel->hacerLogin($nombre, $contrasenia);

    if ($usuario) {
        $_SESSION["usuario"] = $usuario;
        alert("Inicio de sesión correcto", "../movies/list.php", "success");
    } else {
        alert("No se ha podido iniciar sesión, verifica tus credenciales", "login.php", "error");
    }
}

?>

<link rel="stylesheet" href="../../css/style.css">

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <h1>Login</h1>
        <form method="POST">
            <label>Usuario: <input type="text" name="nombre" required></label><br>
            <label>Contraseña: <input type="password" name="contrasenia" required></label><br>
            <input type="submit" value="Entrar">
        </form>
        <br>
        <a href="register.php">¿No tienes cuenta? Regístrate</a>
    </div>
</body>

</html>
