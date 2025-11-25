<?php

require_once __DIR__ . '/../repuestos/navbar.php';
require_once __DIR__ . '/../../models/UsuarioModel.php';

$DURACION_COOKIE = 10 * 60;

function hacerLogin($nombre, $contrasenia)
{
    global $DURACION_COOKIE;
    $usuarioModel = new UsuarioModel();

    $usuarioObjeto = $usuarioModel->obtenerUsuarioPorNombre($nombre);

    if ($usuarioObjeto && $usuarioObjeto->getContrasenia() == $contrasenia) {
        $_SESSION["usuario"] = $usuarioObjeto;

        setcookie("usuario", $nombre, time() + $DURACION_COOKIE, "/");
        setcookie("contrasenia", $contrasenia, time() + $DURACION_COOKIE, "/");

        header("Location: ../repuestos/list.php");
    } else {
        echo "<p style='color: red;'>Usuario o contraseña incorrectos</p>";
    }
}

if (isset($_SESSION["usuario"])) {
    header("Location: ../repuestos/list.php");
} else if (isset($_COOKIE["usuario"]) && isset($_COOKIE["contrasenia"])) {
    $nombre = $_COOKIE["usuario"];
    $contrasenia = $_COOKIE["contrasenia"];
    hacerLogin($nombre, $contrasenia);
} else if (isset($_POST["nombre"]) && isset($_POST["contrasenia"])) {
    $nombre = $_POST["nombre"];
    $contrasenia = $_POST["contrasenia"];
    hacerLogin($nombre, $contrasenia);
}
?>

<link rel="stylesheet" href="../../css/style.css">

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form method="POST">
            <label>Usuario: <input type="text" name="nombre"></label><br>
            <label>Contraseña: <input type="password" name="contrasenia"></label><br>
            <input type="submit" value="Entrar">
        </form>
        <br>
        <a href="register.php">¿No tienes cuenta? Regístrate</a>
    </div>
</body>
</html>
