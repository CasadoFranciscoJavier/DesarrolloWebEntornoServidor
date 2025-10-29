<link rel="stylesheet" href="style.css">
<div class="container">

    <?php

    session_start();

    if (isset($_SESSION["nombre"])) {
        echo "<h1>Hola " . $_SESSION["nombre"] . "!!!!</h1>";
    } else {
        header("Location: login.html");
        exit;
    }

    ?>
</div>