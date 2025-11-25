<?php

require_once "../../models/User.php";

session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: ../auth/login.php");
}

require_once "../../models/UserModel.php";
require_once "./navbar.php";

$userModel = new UserModel();

if (isset($_GET["id"])) {
    $idUsuario = $_GET["id"];
    $usuarioBuscado = $userModel->obtenerUsuarioPorId($idUsuario);
}

$nombreUsuario = $usuarioBuscado->getNombre();
$rolUsuario = $usuarioBuscado->getRol();

?>
<link rel="stylesheet" href="../../css/style.css">

<?php

echo "<h1>Detalles del Usuario</h1>";
echo "<p><strong>ID:</strong> $idUsuario</p>";
echo "<p><strong>Nombre:</strong> $nombreUsuario</p>";
echo "<p><strong>Rol:</strong> $rolUsuario</p>";

if ($usuario->getRol() == "administrador") {
    echo "<br>";
    echo "<form action='banearUsuario.php' method='POST'>";
    echo "<input type='hidden' name='id' value='$idUsuario'>";
    echo "<button type='submit' onclick=\"return confirm('¿Banear a este usuario?')\" style='background-color: red; color: white;'>Banear Usuario</button>";
    echo "</form>";
}

echo "<br>";
echo "<a href='list.php'><button>Volver</button></a>";
