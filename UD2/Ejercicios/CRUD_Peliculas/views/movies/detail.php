<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: ../auth/login.php");
}

require_once __DIR__ . '/../../models/MovieModel.php';
require_once __DIR__ . '/../../models/Movie.php';
require_once __DIR__ . '/../../models/RatingModel.php';
require_once __DIR__ . '/../../models/CommentModel.php';
require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../models/Comment.php';

$usuarioRol = $_SESSION["rol"];



$peliculaModel = new MovieModel();
$ratingModel = new RatingModel();
$comentarioModel = new CommentModel();

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $pelicula = $peliculaModel->obtenerPeliculaPorId($id);
    $mediaPuntuacion = $ratingModel->obtenerMediaPuntuacionPorPelicula($id);
    $comentarios = $comentarioModel->obtenerComentariosPorPelicula($id);
}
?>
<link rel="stylesheet" href="../../css/style.css">
<?php
require_once __DIR__ . '/navbar.php';


echo "<h1 style = 'text-align: left';>" . $pelicula->getTitulo() . "</h1>";
echo "<p><strong>Sinopsis:</strong> " . $pelicula->getSinopsis() . "</p>";
echo "<p><strong>Año:</strong> " . $pelicula->getAnio() . "</p>";
echo "<p><strong>Género:</strong> " . $pelicula->getGenero() . "</p>";
echo "<p><strong>Puntuación media:</strong> " . $mediaPuntuacion . "/10</p>";

echo "<h3 style= 'text-align: left';>" . "Comentarios:</h3>";
foreach ($comentarios as $comentario) {
    $idUsuario = $comentario->getUsuarioId();
    $nombreUsuario = $comentario->getUsuarioNombre();

    // No mostrar comentarios de usuarios baneados
    if (strpos($nombreUsuario, 'usuario_baneado') === 0) {
        continue;
    }

    echo "<p><strong>" . $nombreUsuario . ":</strong> " . $comentario->getContenido() . "<a href='userDetail.php?id=$idUsuario&nombre=$nombreUsuario'><button>🔎</button></a>"."</p>";
}

if ($usuarioRol == "administrador") {
    echo "<br>";
    echo "<a href='edit.php?id=$id'><button>✏</button></a>";
    echo "<a href='delete.php?id=$id' onclick=\"return confirm('Estás seguro de lo que quieres hacer?')\"><button>🗑</button></a>";
}

echo "<br><br>";
echo "<a href='list.php'><button>Volver</button></a>";
