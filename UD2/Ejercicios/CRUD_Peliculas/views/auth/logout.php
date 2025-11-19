<?php
session_start();
require_once __DIR__ . '/../../alert.php';

// Destruir sesión
$_SESSION = [];
if (isset($_COOKIE['usuario'])) {
    setcookie('usuario', '', time() - 3600, '/');
}
session_destroy();

alert('Cerrando sesión...', '../../index.php', 'error');


// Redirigir al login. esto se pondria si no tuviera mi alert
// header("Location: ../index.php");
// exit;
