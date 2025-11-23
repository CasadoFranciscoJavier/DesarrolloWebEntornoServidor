<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: ../auth/login.php");
    exit();
}

require_once "../../models/CommentModel.php";
require_once "../../models/Comment.php";

if (isset($_GET["id"])) {
    $idPelicula = $_GET["id"];
}

if (isset($_POST["contenido"])) {
    $commentModel = new CommentModel();

    $contenido = $_POST["contenido"];
    $idUsuario = $_SESSION["id"];

    $nuevoComentario = new Comment(null, $contenido, $idUsuario, $idPelicula);
    $commentModel->insertarComentario($nuevoComentario);

    header("Location: detail.php?id=$idPelicula");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../css/style.css">
    <title>Añadir Comentario</title>
</head>

<body>
    <?php require_once "./navbar.php"; ?>

    <h1>Añadir Comentario</h1>
    <form method="POST">
        <label>Nuevo comentario:
            <textarea name="contenido" required rows="5" cols="50"></textarea>
        </label><br><br>

        <input type="submit" value="Añadir comentario">
        <a href="detail.php?id=<?php echo $idPelicula; ?>"><button type="button">Cancelar</button></a>
    </form>
</body>

</html>
