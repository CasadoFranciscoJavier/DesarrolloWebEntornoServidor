<?php
setcookie('carrito', '', time() - 3600, "/");

header('Location: index.php');

