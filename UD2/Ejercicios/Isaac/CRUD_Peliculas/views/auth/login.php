<?php

session_start();

require_once "../../models/UsuarioModel.php";
require_once "../../models/Usuario.php";

$usuarioModel = new UsuarioModel();

if (isset($_SESSION["usuario"])) {
    header("Location: ../../index.php");
} else if(isset($_POST['email']) && isset($_POST['password'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $usuario = $usuarioModel->hacerLogin($email, $password);

    $_SESSION["usuario"] = $usuario;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Formulario Login</title>
</head>

<body>

    <form method="POST">
        <label> Correo: <input type="email" name="email"></label><br>
        <label> Contraseña: <input type="password" name="password"></label>
        <input type="submit">
    </form>

</body>

</html>