<?php

require_once "../../models/Usuario.php";

session_start();

require_once "../../models/UsuarioModel.php";

$usuarioModel = new UsuarioModel();

if (isset($_SESSION["usuario"])) {
    header("Location: ../repuestos/list.php");
} else if (isset($_POST["nombre"]) && isset($_POST["contrasenia"])) {
    $nombre = $_POST["nombre"];
    $contrasenia = $_POST["contrasenia"];

    $nuevoUsuario = new Usuario(null, $nombre, $contrasenia, "usuario");
    $usuarioModel->insertarUsuario($nuevoUsuario);

    $usuarioRegistrado = $usuarioModel->obtenerUsuarioPorNombre($nombre);
    $_SESSION["usuario"] = $usuarioRegistrado;

    header("Location: ../repuestos/list.php");
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
            <label>Usuario: <input type="text" name="nombre"></label><br>
            <label>Contraseña: <input type="password" name="contrasenia"></label><br>
            <input type="submit" value="Registrarse">
        </form>
        <br>
        <a href="login.php">¿Ya tienes cuenta? Inicia sesión</a>
    </div>
</body>
</html>
