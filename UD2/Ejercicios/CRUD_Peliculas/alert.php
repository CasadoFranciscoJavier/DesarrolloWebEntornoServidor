<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>

<?php

function alert($mensaje, $redirigir, $tipo = 'info')
{
    echo "
        <div class='container'>
            <div class='alert $tipo'>
                <p>$mensaje</p>
            </div>
        </div>
        <meta http-equiv='refresh' content='3;url=$redirigir'>";

}

