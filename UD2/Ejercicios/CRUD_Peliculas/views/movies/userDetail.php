<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: ../auth/login.php");
}

require_once __DIR__ . '/../../models/UserModel.php';
require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/navbar.php';



if (isset($_GET["id"])) {

    $userModel = new UserModel();

    $idUsuario = $_GET["id"];
    $nombreUsuario = $_GET["nombre"];
    $usuario = $userModel->obtenerUsuarioPorNombre($nombreUsuario);


    $usuarioRol = $_SESSION["rol"];
  

    
}
?>

<!DOCTYPE html>
<html lang=" es">

<head>
     <meta charset="UTF-8">
    <link rel="stylesheet" href="../../css/style.css">
    <title>Banear Usuario</title>
</head>

<body>
    <div class="container">
        <h1>Datos del usuario: <?php echo $nombreUsuario; ?></h1>
        <P>ID: <?php echo $idUsuario; ?></P>
        <P>Nombre: <?php echo $nombreUsuario; ?></P>
        <P>Rol: <?php echo $usuarioRol; ?></P>
   
    <?php
    if ($usuarioRol == "administrador") {
        echo "
            <form method='POST' action='banearUsuario.php'>
                <input type='hidden' name='id' value='$idUsuario'>
                <button style='background-color: red;' type='submit'>Banear Usuario</button>
            </form>
        ";
    }
    ?>
    <a href="list.php"><button>Volver</button></a>
     </div>
</body>
</html>