<?php
session_start();

require_once __DIR__ . '/../../models/UserModel.php';
require_once __DIR__ . '/../../alert.php';

$usuarioModel = new UserModel();
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["email"] ?? "");
    $password = trim($_POST["password"] ?? "");

    if (!$nombre || !$password) {
        $mensaje = "Debes completar todos los campos.";
    } else {
        $usuario = $usuarioModel->obtenerUsuarioPorNombre($nombre); 

        if (!$usuario) {
            $mensaje = "Usuario no encontrado.";
        } elseif ($usuario->getContrasenia() != $password) {
            $mensaje = "Contraseña incorrecta.";
        } else {
            $_SESSION['usuario'] = $usuario->getNombre();
            setcookie('usuario', $usuario->getNombre(), time() + 3600, '/');
            header("Location: ../../views/movies/list.php");
            exit;
        }
    }
}
?>

<link rel="stylesheet" href="../../css/style.css">

<div class="container">
    <h1>Login</h1>
    <?php if ($mensaje) echo "<p style='color:red;'>$mensaje</p>"; ?>
    <form method="POST">
        <label>Usuario: <input type="text" name="email"></label><br>
        <label>Contraseña: <input type="password" name="password"></label><br>
        <input type="submit" value="Entrar">
    </form>
</div>
