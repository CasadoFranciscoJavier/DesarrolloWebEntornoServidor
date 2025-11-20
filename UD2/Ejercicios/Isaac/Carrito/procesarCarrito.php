<?php

$DURACION_COOKIE = 30 * 24 * 60 * 60; //30 días

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)){

    setcookie("carrito",json_encode($_POST), time() + $DURACION_COOKIE);

}

header("Location: index.php");