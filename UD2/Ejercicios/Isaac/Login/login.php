<?php

session_start();

require_once "usuarios.php";

function hacerLogin($email, $password){

    global $usuarios;
    $DURACION_COOKIE = 10 * 60; // 10 MINUTOS

    if (isset($usuarios[$email]) && $usuarios[$email]['password'] == $password) {
        $_SESSION["nombre"] = $usuarios[$email]['nombre'];

        setcookie("email", $email, time() + $DURACION_COOKIE);
        setcookie("password", $password, time() + $DURACION_COOKIE);

        header("Location: hola.php");
    }
}

if (isset($_SESSION["nombre"])) {
    header("Location: hola.php");
} else if (isset($_COOKIE['email']) && isset($_COOKIE['password'])){

    $email = $_COOKIE['email'];
    $password = $_COOKIE['password'];

    hacerLogin($email, $password);

} else if(isset($_POST['email']) && isset($_POST['password'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    hacerLogin($email, $password);

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