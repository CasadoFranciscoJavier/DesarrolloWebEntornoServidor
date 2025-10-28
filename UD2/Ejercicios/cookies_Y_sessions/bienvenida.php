<?php
session_start();

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

if (!isset($_SESSION['usuario'])) {
    alert('No hay sesión activa.', 'login.html', 'info');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cerrar'])) {
    session_destroy();
    setcookie('usuario', '', time() - 3600, '/');
    alert('Sesión y cookie eliminadas.', 'login.html', 'error');
}

$usuario = htmlspecialchars($_SESSION['usuario']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Bienvenida</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <form method="post">
    <h1>Hola, <?php echo $usuario; ?></h1>
    <p>Tu sesión y cookie están activas.</p>
    <button type="submit" name="cerrar">Cerrar sesión</button>
  </form>

</body>
</html>
