<?php

require_once "./models/Usuario.php";
require_once "./views/movies/navbar.php";

session_start();

if (isset($_SESSION["usuario"])) {
    header("Location: views/movies/list.php");
}