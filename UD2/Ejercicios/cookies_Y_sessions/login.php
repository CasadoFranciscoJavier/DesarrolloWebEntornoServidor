<?php
session_start();
require_once 'data.php';

print_r($usuarios);

if (isset($_SESSION['usuario']) || isset($_COOKIE['usuario'])) {
    header('Location: bienvenida.php');
    exit;
}

function alert($mensaje, $redirigir, $tipo = 'info') {
    echo "
    <link rel='stylesheet' href='style.css'>
    <div class='container'>
        <div class='alert $tipo'>
            <p>$mensaje</p>
        </div>
    </div>
    <meta http-equiv='refresh' content='2;url=$redirigir'>
    ";
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
    alert('Acceso registrado correctamente.', 'bienvenida.php', 'success'); 
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Primerito login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Mi Primerito login</h1>
    <form method="POST">
        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email">
        <br><br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password">
        <br><br>
        <input type="submit" value="Iniciar Sesión">     
    </form>
</body>
</html>
