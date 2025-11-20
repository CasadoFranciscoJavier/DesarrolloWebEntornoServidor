<?php

setcookie("carrito","", time() - 1);

header("Location: index.php");