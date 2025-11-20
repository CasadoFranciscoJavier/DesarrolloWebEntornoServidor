<?php
session_start();

require_once __DIR__ . '/../../models/UserModel.php';

$DURACION_COOKIE = 10 * 60; // 10 MINUTOS

function hacerLogin($nombre, $contrasenia)
{
    global $DURACION_COOKIE;
    $usuarioModel = new UserModel();

    $usuarioObjeto = $usuarioModel->obtenerUsuarioPorNombre($nombre);

    if ($usuarioObjeto && $usuarioObjeto->getContrasenia() == $contrasenia) {
        $_SESSION["usuario"] = $usuarioObjeto->getNombre();
        $_SESSION["rol"] = $usuarioObjeto->getRol();
        $_SESSION["contrasenia"] = $usuarioObjeto->getContrasenia();
        $_SESSION["id"] = $usuarioObjeto->getId();

        setcookie("usuario", $nombre, time() + $DURACION_COOKIE, "/");
        setcookie("contrasenia", $contrasenia, time() + $DURACION_COOKIE, "/");

        header("Location: ../movies/list.php");
    }
}

if (isset($_SESSION["usuario"])) {
    header("Location: ../movies/list.php");

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
    </div>
</body>

</html>