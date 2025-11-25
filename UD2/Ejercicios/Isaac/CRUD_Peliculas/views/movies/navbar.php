<?php

session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: views/auth/login.php");
} else {
    $usuario = $_SESSION["usuario"];
}
?>

<nav>
    <ul>
        <li><a href="/CRUD_Peliculas/views/movies/list.php">Peliculas</a></li>
        <li><a href="/CRUD_Peliculas/views/auth/logout.php">Cerrar sesión</a></li>

        <?php

        $rol = $usuario->getRol();
        if ($rol == "ADMIN") {
            echo "<li><a href='/CRUD_Peliculas/views/movies/add.php'>Añadir Pelicula</a></li>";
        }

        ?>
    </ul>
</nav>