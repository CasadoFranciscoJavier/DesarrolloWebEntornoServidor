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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cerrar'])) {
    //session_unset(); //elimina todas las variables que hay dentro de la sesión actual, pero no destruye la sesión en sí.
    session_destroy();
    header('Location: login.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hola</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form method="post">
        <h1>Hola, <?php echo htmlspecialchars($_SESSION['usuario'], ENT_QUOTES, 'UTF-8'); ?>!</h1>
        <p>Has iniciado sesión correctamente.</p>
        <button type="submit" name="cerrar">Cerrar sesión</button>
    </form>
</body>
</html>


<!-- 
session_start();

if (!isset($_SESSION['usuario'])) {
    echo "<script>
            alert('No hay sesión activa');
            window.location.href = 'login.html';
          </script>";
    exit;
}

echo "Hola, " . htmlspecialchars($_SESSION['usuario'], ENT_QUOTES, 'UTF-8') . "!";  -->
