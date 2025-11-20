<?php

session_start();

if(isset($_SESSION["nombre"])){
    echo "Hola " . $_SESSION["nombre"] . "!!!!";

    echo "<br><a href='cerrarSesion.php'>CERRAR SESIÓN</a>";

}else{
    header("Location: login.php");
}