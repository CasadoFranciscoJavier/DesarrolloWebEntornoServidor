<?php

session_start();

require_once "../../models/User.php";
require_once "../../models/UserModel.php";
require_once __DIR__ . '/../../alert.php';

$usuarioModel = new UserModel();

if (isset($_SESSION["usuario"])) {
    header("Location: ../movies/list.php");
    exit();
} else if (isset($_POST["nombre"]) && isset($_POST["contrasenia"])) {
    $nombre = $_POST["nombre"];
    $contrasenia = $_POST["contrasenia"];

    $nuevoUsuario = new User(null, $nombre, $contrasenia, "usuario");
    $resultado = $usuarioModel->insertarUsuario($nuevoUsuario);

    if ($resultado) {
        $usuarioRegistrado = $usuarioModel->obtenerUsuarioPorNombre($nombre);
        $_SESSION["usuario"] = $usuarioRegistrado;
        alert("Registro exitoso", "../movies/list.php", "success");
    } else {
        alert("Error al registrar usuario", "register.php", "error");
    }
}

?>
<link rel="stylesheet" href="../../css/style.css">

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
</head>
<body>
    <div class="container">
        <h1>Registro</h1>
        <form method="POST">
            <label>Usuario: <input type="text" name="nombre" required></label><br>
            <label>Contraseña: <input type="password" name="contrasenia" required></label><br>
            <input type="submit" value="Registrarse">
        </form>
        <br>
        <a href="login.php">¿Ya tienes cuenta? Inicia sesión</a>
    </div>
</body>
</html>
