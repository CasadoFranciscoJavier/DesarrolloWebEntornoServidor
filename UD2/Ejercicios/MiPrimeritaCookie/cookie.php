<?php
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
    $nombre = ($_POST['nombre']);

    if ($nombre == '') {
        alert('Debes introducir un nombre.', 'cookie.html'); // si no pongo el tipo, coge de base el de info(el azulito)
    }

    setcookie('usuario', $nombre, time() + 60, '/'); 
    alert('Cookie creada correctamente.', 'hola_cookie.php', 'success');

} else {
    alert('Acceso no válido.', 'cookie.html', 'error');
}
?>

la funcion alert debe funcionar asi, como te pongo aqui, en este ejemplo