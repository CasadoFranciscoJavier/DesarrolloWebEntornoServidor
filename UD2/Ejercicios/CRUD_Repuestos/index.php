<?php

require_once 'models/Usuario.php';

session_start();

if (isset($_SESSION['usuario'])) {
    header('Location: views/repuestos/list.php');
    exit;
} else {
    header('Location: views/auth/login.php');
    exit;
}
