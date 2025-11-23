<?php
session_start();

if (isset($_POST["nombre"])) {

    require_once "../../models/UserModel.php";
    require_once "../../models/User.php";


    $UserModel = new UserModel();

    $nombre = $_POST["nombre"];
    $contrasenia = $_POST["contrasenia"];

    $nuevoUsuario = new User(null, $nombre, $contrasenia);
    $nuevoUsuario = $UserModel->insertarUsuario($nuevoUsuario);


    $nuevoUsuarioId = $UserModel->obtenerUltimoId();

    // Iniciar sesión automáticamente después del registro
    $_SESSION["usuario"] = $nombre;
    $_SESSION["rol"] = "usuario"; // Asumiendo que los nuevos usuarios tienen rol "usuario"

    header("Location: ../movies/userDetail.php?id=$nuevoUsuarioId");
    exit;
}

require_once "../movies/navbar.php";

?>


<link rel="stylesheet" href="../../css/style.css">

<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
</head>

<body>
    <div class="container">
        <h1>Register</h1>
        <form method="POST">
            <label>Usuario: <input type="text" name="nombre"></label><br>
            <label>Contraseña: <input type="password" name="contrasenia"></label><br>
            <input type="submit" value="Registrarme">
        </form>
    </div>
</body>

</html>