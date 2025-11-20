<?php
session_start();
require_once __DIR__ . '/navbar.php';

require_once __DIR__ . '/../../models/MovieModel.php';
require_once __DIR__ . '/../../models/RatingModel.php';
require_once __DIR__ . '/../../models/CommentModel.php';
require_once __DIR__ . '/../../models/UserModel.php';

// Comprobamos sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: ../auth/login.php');
    exit;
}

$usuarioRegistrado = $_SESSION['usuario'];

$usuarioModel = new UserModel();
$usuarioObj = $usuarioModel->obtenerUsuarioPorNombre($usuarioRegistrado);
$rolUsuario = $usuarioObj ? $usuarioObj->getRol() : null;

$id = $_GET['id'] ?? null;
$movieModel = new MovieModel();
$pelicula = $movieModel->obtenerPeliculaPorId($id);

$movieRatingModel = new RatingModel();
$peliculaRating = $movieRatingModel->obtenerMediaPuntuacionPorPelicula($id);

$movieCommentModel = new CommentModel();
$peliculaComments = $movieCommentModel->obtenerComentariosPorPelicula($id);
?>

<link rel="stylesheet" href="../../css/style.css">

<div class="container">
  

    <?php if (empty($pelicula)): ?>
        <p>No hay película registrada.</p>
    <?php else: ?>
        <div class="movie-list">
           
           
                <div class="movie-card">
                    <h2><?php echo htmlspecialchars($pelicula->getTitulo()); ?></h2>
                    <p><strong>Sinopsis:</strong> <?php echo htmlspecialchars($pelicula->getSinopsis()); ?></p>
                    <p><strong>Año:</strong> <?php echo htmlspecialchars($pelicula->getAnio()); ?></p>
                    <p><strong>Género:</strong> <?php echo htmlspecialchars($pelicula->getGenero()); ?></p>
                    <p><strong>Media de Puntuación:</strong> <?php echo htmlspecialchars($peliculaRating); ?></p>
                    <p><strong>Comentarios:</strong>
                        <ul>
                            <?php foreach ($peliculaComments as $comentario): ?>
                                <li><?php echo htmlspecialchars($comentario->getContenido()); echo htmlspecialchars($comentario->getUsuarioNombre()); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </p>
              <?php if ($rolUsuario == 'administrador'): ?>
                   <button onclick ="window.location.href='edit.php?id=<?php echo $pelicula->getId();?>'">✏️ Editar</button>
                   <button onclick ="if(confirm('¿Estás seguro de que deseas eliminar esta película?')) { window.location.href='delete.php?id=<?php echo $pelicula->getId();?>'; }">🗑️ Eliminar</button> 
                <?php endif; ?>
               
                </div>
           
        </div>
    <?php endif; ?>
</div>
