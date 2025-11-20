<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
</head>
<body>
<style>
/* Estilos base para el contenedor */
.container {
    background: #fff;
    max-width: 800px;
    width: fit-content;
    min-width: 420px;
    margin: 40px auto;
    padding: 32px 28px 24px 28px;
    border-radius: 14px;
    box-shadow: 0 4px 24px rgba(60, 80, 120, 0.08);
    border: 1px solid #e3e8ee;
    text-align: center;
}

/* Alerta base */
.alert {
    background: #ffe8e8;
    color: #a94442;
    border: 1px solid #f5c6cb;
    border-radius: 6px;
    padding: 10px;
    margin: 16px 0;
    text-align: center;
    box-sizing: border-box;
}

/* Variante success: tono verde */
.alert.success {
    background: #e8f8ed;
    color: #2f8f4a;
    border: 1px solid #cdeed1;
}

/* Variante info: tono azul */
.alert.info {
    background: #eaf3fb;
    color: #2f6fa0;
    border: 1px solid #d6eaf8;
}

/* Variante error */
.alert.error {
    background: #ffe8e8;
    color: #a94442;
    border: 1px solid #f5c6cb;
}
</style>

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

