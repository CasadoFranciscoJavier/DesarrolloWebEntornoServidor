<?php
require_once __DIR__ . '/../../models/RepuestoModel.php';
require_once __DIR__ . '/../../models/Repuesto.php';
require_once __DIR__ . '/navbar.php';

if (!isset($_SESSION["usuario"])) {
    header("Location: ../auth/login.php");
}

$usuarioRol = $usuario->getRol();

$repuestoModel = new RepuestoModel();
$repuestos = $repuestoModel->obtenerTodosRepuestos();
?>
<link rel="stylesheet" href="../../css/style.css">
<?php

echo "<h1>Catálogo de Repuestos</h1>";
foreach ($repuestos as $repuesto) {
    $id = $repuesto->getId();

    echo "
        <div class='container'
         style='
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            max-width: 600px;
            margin: 0 auto 10px auto;'>

            <span>$repuesto</span>
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

             <a href='add.php'>
                <button>➕ Añadir Repuesto</button>
            </a>
            </div>";
}
