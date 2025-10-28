<?php

require_once "loginData.php";
// ================================= FUNCIONES BÁSICAS =================================

function alert($text)
{
    // Imprime un script en JavaScript que muestra una alerta con el texto recibido
    echo "<script> 
            alert('$text'); 
            window.location.href = 'login.html'; 
          </script>";
}


function ValidarEmail($variablePOST)
{
    $vacio = !isset($_POST[$variablePOST]) || empty($_POST[$variablePOST]);
    $valido = false;

    if (!$vacio) {
        // Usa filter_var para validar el formato estándar de correo
        $valido = filter_var($_POST[$variablePOST], FILTER_VALIDATE_EMAIL);
    }

    if ($vacio) {
        alert("$variablePOST está vacío");
    } else if (!$valido) {
        alert("'$variablePOST' no tiene un formato de correo electrónico válido.");
    }

    return $valido;
}

function validarPassword($variablePOST, $tamanioMinimo = 6)
{
    $vacio = !isset($_POST[$variablePOST]) || empty($_POST[$variablePOST]);
    $valido = false;

    if (!$vacio) {
        $longitud = strlen($_POST[$variablePOST]);
        $valido = ($longitud >= $tamanioMinimo);
    }

    if ($vacio) {
        alert("$variablePOST está vacío");
    } else if (!$valido) {
        alert("'$variablePOST' debe tener al menos $tamanioMinimo caracteres. Actual: $longitud");
    }

    return $valido;
}




//============================= main =============================

// Validaciones principales 
$todoValido = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $todoValido = ValidarEmail("email")
        && validarPassword("password");



    if ($todoValido) {
        if (array_key_exists($email, $usuarios) && $usuarios[$email]['password'] == $password) {
            $nombreUsuario = $usuarios[$email]['nombre'];
            setcookie("usuario", $nombreUsuario, time() + 3600);
            echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <title>Bienvenido</title>
</head>
<body>
    <div class='contenedor'>
        <h1>Bienvenido, $nombreUsuario!</h1>
        <p>Has iniciado sesión correctamente.</p>
    </div>  
</body>
</html>";
        } else {
            alert("Credenciales inválidas. Por favor, inténtalo de nuevo.");
        }
    }
}
?>





<style>
    body {
        background: #f3f6f9;
        font-family: "Segoe UI", Arial, sans-serif;
        color: #333;
    }

    .contenedor {
        background: #fff;
        max-width: 420px;
        margin: 40px auto;
        padding: 32px 28px 24px 28px;
        border-radius: 14px;
        box-shadow: 0 4px 24px rgba(60, 80, 120, 0.08);
        border: 1px solid #e3e8ee;
    }

    h1 {
        text-align: center;
        color: #4a6fa5;
        margin-bottom: 24px;
        font-weight: 600;
    }

    label {
        color: #4a6fa5;
        font-weight: 500;
    }

    p {
        margin: 12px 0;
        font-size: 1.08em;
    }

    ul {
        margin-top: 10px;
        margin-bottom: 0;
        padding-left: 22px;
    }

    li {
        margin-bottom: 4px;
    }
</style>

</html>