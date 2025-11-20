<?php
session_start();
session_destroy();

setcookie("usuario", "", time() - 30, "/");
setcookie("contrasenia", "", time() - 30, "/");

header("Location: login.php");
