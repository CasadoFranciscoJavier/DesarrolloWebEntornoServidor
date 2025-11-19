<?php

session_start();


require_once 'alert.php';



if (isset($_SESSION['usuario']) || isset($_COOKIE['usuario'])) {
    header('Location: views/movies/list.php');
    exit;
} else {
    header('Location: views/auth/login.php');
    exit;
}
