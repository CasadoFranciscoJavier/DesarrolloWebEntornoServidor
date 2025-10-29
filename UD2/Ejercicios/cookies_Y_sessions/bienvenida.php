<?php
session_start();
require_once 'alert.php';

if (!isset($_SESSION['usuario'])) {
  alert('No hay sesión activa.', 'login.html', 'info');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cerrar'])) {
  session_destroy();
  setcookie('usuario', '', time() - 3600, '/');
  alert('Sesión y cookie eliminadas.', 'login.php', 'error');
}

$usuario = htmlspecialchars($_SESSION['usuario']);
?>

<link rel="stylesheet" href="style.css">
<div class="container">
  <h1>BIENVENIDO</h1>
  <form method="post">
    <h2>Hola, <?php echo $usuario; ?></h2>
    <p>Tu sesión y cookie están activas.</p>
    <button type="submit" name="cerrar">Cerrar sesión</button>
  </form>
</div>