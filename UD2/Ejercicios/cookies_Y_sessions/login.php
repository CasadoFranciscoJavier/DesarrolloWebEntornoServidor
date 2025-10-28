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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombre'])) {
    $nombre = trim($_POST['nombre']);

    if ($nombre == '') {
        alert('Debes introducir un nombre.', 'login.html', 'info');
    }

    $_SESSION['usuario'] = $nombre;

    setcookie('usuario', $nombre, time() + 60, '/');

    alert('Sesión y cookie creadas correctamente.', 'bienvenida.php', 'success');
} else {
    alert('Acceso no válido.', 'login.html', 'error');
}
?>
