<?php

session_start();
require_once 'data.php';
require_once 'alert.php';



if (isset($_SESSION['usuario']) || isset($_COOKIE['usuario'])) {
    header('Location: bienvenida.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if ($email == '' || $password == '') {
        alert('Debes completar todos los campos.', 'login.php', 'info');
    }

    if (!isset($usuarios[$email])) {
        echo $email;
        echo $password;
        echo $usuarios[$email];
        alert('El Usuario no está registrado.', 'login.php', 'error');
    }

    if ($usuarios[$email]['password'] !== $password) {
        alert('Contraseña incorrecta.', 'login.php', 'error');
    }

    $_SESSION['usuario'] = $usuarios[$email]['nombre'];
    setcookie('usuario', $usuarios[$email]['nombre'], time() + 600, '/');
    alert('Acceso registrado correctamente. Redirigiendo...', 'bienvenida.php', 'success');
}
?>

<link rel="stylesheet" href="style.css">

<div class="container">
    <h1>Mi Primerito login</h1>
    <form method="POST">
        <label> Correo: <input type="email" name="email"></label><br>
        <label> Contraseña: <input type="password" name="password"></label>
        <input type="submit">
    </form>
</div>