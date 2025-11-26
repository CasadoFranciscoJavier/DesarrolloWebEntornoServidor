<?php

session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: ../auth/login.php");
    exit();
} else {
    $usuario = $_SESSION["usuario"];
}

?>

<nav class="navbar">
    <div class="navbar-left">
        <a href="list.php" class="nav-button">Películas</a>
        <?php
        $rol = $usuario->getRol();
        if ($rol == "administrador") {
            echo '<a href="add.php" class="nav-button">Añadir Película</a>';
        }
        ?>
    </div>

    <div class="navbar-right">
        <span class="nav-username">Hola, <?php echo htmlspecialchars($usuario->getNombre()); ?></span>
        <a href="../auth/logout.php" class="nav-button">Cerrar sesión</a>
    </div>
</nav>
















<style>
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #222;
    padding: 10px 20px;
    color: white;
    margin-bottom: 20px;
}

.nav-button {
    color: white;
    text-decoration: none;
    padding: 5px 10px;
    margin-left: 10px;
    border: 1px solid transparent;
    border-radius: 5px;
    transition: background-color 0.2s, border 0.2s;
}

.nav-button:hover {
    background-color: #555;
    border: 1px solid white;
}

.nav-username {
    margin-right: 10px;
    font-weight: bold;
}
</style>
