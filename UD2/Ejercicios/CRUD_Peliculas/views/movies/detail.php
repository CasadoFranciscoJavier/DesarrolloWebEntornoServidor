<?php

require_once "../../models/MovieModel.php";
require_once "../../models/Movie.php";
require_once "../../models/RatingModel.php";
require_once "../../models/CommentModel.php";
require_once "./navbar.php";

$peliculaModel = new MovieModel();
$ratingModel = new RatingModel();
$comentarioModel = new CommentModel();

$idPelicula = $_GET["id"];

$pelicula = $peliculaModel->obtenerPeliculaPorId($idPelicula);
$mediaPuntuacion = $ratingModel->obtenerMediaPuntuacionPorPelicula($idPelicula);
$comentarios = $comentarioModel->obtenerComentariosPorPelicula($idPelicula);

$titulo = $pelicula->getTitulo();
$sinopsis = $pelicula->getSinopsis();
$anio = $pelicula->getAnio();
$genero = $pelicula->getGenero();

?>
<link rel="stylesheet" href="../../css/style.css">

<?php

echo "<h1>$titulo</h1>";
echo "<p><strong>Sinopsis:</strong> $sinopsis</p>";
echo "<p><strong>Año:</strong> $anio</p>";
echo "<p><strong>Género:</strong> $genero</p>";
echo "<p><strong>Puntuación media:</strong> $mediaPuntuacion/10</p>";

echo "<br>";
echo "<a href='addRating.php?id=$idPelicula'><button>⭐ Añadir Puntuación</button></a>";

echo "<h3>Comentarios</h3>";

foreach ($comentarios as $comentario) {
    $nombreUsuario = $comentario->getUsuarioNombre();
    $contenidoComentario = $comentario->getContenido();
    $idComentario = $comentario->getId();
    $idUsuario = $comentario->getUsuarioId();

    if (strpos($nombreUsuario, 'usuario_baneado') === 0) {
        continue;
    }

    echo "<li>";
    echo "<a href='userDetail.php?id=$idUsuario&nombre=$nombreUsuario'>$nombreUsuario</a> ha comentado: $contenidoComentario";

    if ($usuario->getRol() == "administrador") {
        echo " <a href='deleteComment.php?id=$idComentario&idPelicula=$idPelicula' onclick=\"return confirm('¿Eliminar este comentario?')\"><button>🗑</button></a>";
    }

    echo "</li>";
}

if ($usuario->getRol() == "administrador") {
    echo "<br>";
    echo "<a href='edit.php?id=$idPelicula'><button>✏ Editar</button></a> ";
    echo "<a href='delete.php?id=$idPelicula' onclick=\"return confirm('Estás seguro de lo que quieres hacer?')\"><button>🗑 Eliminar</button></a> ";
    echo "<a href='resetRatings.php?id=$idPelicula' onclick=\"return confirm('¿Resetear todas las valoraciones?')\"><button>🔄 Resetear Valoraciones</button></a>";
}

?>

<form action="addComment.php" method="POST">
    <input type="hidden" name="id-pelicula" value="<?php echo $idPelicula ?>">
    <textarea name="contenido-comentario" rows="4" cols="50"></textarea><br>
    <input type="submit" value="Enviar comentario">
</form>

<br>
<a href="list.php"><button>Volver</button></a>
