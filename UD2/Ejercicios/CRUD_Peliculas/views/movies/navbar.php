<?php

?>



<nav class="navbar">
    <div class="navbar-left">
        <a href="../../views/movies/list.php" class="nav-button">Inicio</a>
    </div>

    <div class="navbar-right">
        <?php if (isset($_SESSION['usuario']) || isset($_COOKIE['usuario'])): ?>
            <?php $usuario = $_SESSION['usuario'] ?? $_COOKIE['usuario']; ?>
            <span class="nav-username">Hola, <?php echo htmlspecialchars($usuario); ?></span>
            <a href="../../views/auth/logout.php" class="nav-button">Cerrar sesión</a>
        <?php elseif (!isset($_SESSION['usuario']) && !isset($_COOKIE['usuario'])): ?>
            <a href="../../views/auth/register.php" class="nav-button">Registrar usuario</a>
             <?php else: ?>
            <a href="../../views/auth/login.php" class="nav-button">Iniciar sesión</a>
        <?php endif; ?>
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
