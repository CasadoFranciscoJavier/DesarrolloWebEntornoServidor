<?php
session_start();
require_once 'loginData.php';

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

// ==================== main ====================
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.html');
    exit;
}

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

if ($email == '' || $password == '') {
    alert('Debes completar todos los campos.', 'login.html', 'info');
}

if (!isset($usuarios[$email])) {
    alert('El Usuario no está registrado.', 'login.html', 'error');
}

if ($usuarios[$email]['password'] !== $password) {
    alert('Contraseña incorrecta.', 'login.html', 'error');
}


$_SESSION['usuario'] = $usuarios[$email]['nombre'];
alert('Acceso registrado correctamente.', 'hola.php', 'success'); 


