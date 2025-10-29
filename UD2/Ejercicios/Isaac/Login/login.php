<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="container">

<?php
session_start();

require_once "usuarios.php";


function alert_msg($mensaje, $redirigir, $tipo = 'info') {
    
    echo " <div class='alert $tipo'>
            <p>$mensaje</p>
        </div>
        <meta http-equiv='refresh' content='3;url=$redirigir'>";
    exit;
}

// ===========================================
// LÓGICA DE VERIFICACIÓN 
// ===========================================
if (isset($_POST['email']) && isset($_POST['password'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

   
    if (empty($email) || empty($password)) {
        alert_msg("Debes completar todos los campos.", "login.html", "info");
    }

    if (!isset($usuarios[$email])) {
        alert_msg("El usuario no está registrado.", "login.html", "error");

        }  else if ($usuarios[$email]['password'] == $password) {
            $_SESSION["nombre"] = $usuarios[$email]['nombre'];  
            alert_msg("Acceso registrado correctamente. Redirigiendo...", "hola.php", "success");

        } else {
            
            alert_msg("Contraseña incorrecta.", "login.html", "error");
        }

} else {
    // Si se accede directamente sin datos POST
        alert_msg("¿Dónde te crees que vas, avioneto?", "login.html", "error");

}

?>
 </div>
</body>
</html>

