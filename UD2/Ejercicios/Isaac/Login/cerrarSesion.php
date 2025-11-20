<?php

session_start();
session_destroy();

setcookie("email", "", time() - 30);
setcookie("password", "", time() - 30);

header("Location: login.php");