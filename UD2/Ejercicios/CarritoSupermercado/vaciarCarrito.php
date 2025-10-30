<?php
// Eliminar la cookie del carrito
setcookie('carrito', '', time() - 3600, "/");

// Redirigir al index
header('Location: index.php');
exit();
?>