<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: ../auth/login.php");
}

require_once __DIR__ . '/../../models/MovieModel.php';
require_once __DIR__ . '/../../models/Movie.php';

$usuarioRol = $_SESSION["rol"];

$peliculaModel = new MovieModel();
$peliculas = $peliculaModel->obtenerTodosPeliculas();
?>
<link rel="stylesheet" href="../../css/style.css">
<?php
require_once __DIR__ . '/navbar.php';

echo "<h1>Listado de Películas</h1>";
foreach ($peliculas as $pelicula) {
    $id = $pelicula->getId();

    echo "
        <div class='container'
         style='
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            max-width: 600px;
            margin: 0 auto 10px auto;'>

            <span>$pelicula</span>
            <a href='detail.php?id=$id'>
                <button>👁</button>
            </a>
        </div>";
}


if ($usuarioRol == "administrador") {

    echo "<div class='container'
         style='
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            max-width: 600px;
            margin: 0 auto 10px auto;'>

            <a href='add.php'><button>➕</button></a>";
}
