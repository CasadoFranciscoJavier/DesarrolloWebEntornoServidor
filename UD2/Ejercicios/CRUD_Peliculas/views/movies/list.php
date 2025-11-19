<?php
session_start();
require_once __DIR__ . '/navbar.php';


require_once __DIR__ . '/../../models/MovieModel.php';

// Comprobamos sesión
if (!isset($_SESSION['usuario']) && !isset($_COOKIE['usuario'])) {
    header('Location: ../auth/login.php');
    exit;
}

$movieModel = new MovieModel();
$peliculas = $movieModel->obtenerTodosPeliculas();
?>

<link rel="stylesheet" href="../../css/style.css">

<div class="container">
    <h1>Lista de Películas</h1>

    <?php if (empty($peliculas)): ?>
        <p>No hay películas registradas.</p>
    <?php else: ?>
        <div class="movie-list">
            <?php foreach ($peliculas as $pelicula): ?>
                <div class="movie-card">
                    <h2><?php echo htmlspecialchars($pelicula->getTitulo()); ?></h2>
                    <p><strong>Sinopsis:</strong> <?php echo htmlspecialchars($pelicula->getSinopsis()); ?></p>
                    <p><strong>Año:</strong> <?php echo htmlspecialchars($pelicula->getAnio()); ?></p>
                    <p><strong>Género:</strong> <?php echo htmlspecialchars($pelicula->getGenero()); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
