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


if (isset($_POST['borrar'])) {
    setcookie("usuario", "", time() - 3600, "/");
    alert("Cookie eliminada correctamente.", "cookie.html", "success");
}

if (!isset($_COOKIE['usuario'])) {
    alert("No hay cookie activa.", "cookie.html", "info");
}

$usuario = htmlspecialchars($_COOKIE['usuario']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Bienvenido</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container text-center">
    <h1>Hola <?php echo $usuario; ?></h1>
    <p>Tu cookie sigue activa.</p>
    <form method="post">
      <button type="submit" name="borrar">Borrar cookie</button>
    </form>
  </div>
</body>
</html>
