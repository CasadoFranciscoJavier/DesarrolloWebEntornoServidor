<?php

require_once "../../models/RepuestoModel.php";
require_once "../../models/Repuesto.php";
require_once "../../models/EmbalajeModel.php";
require_once "./navbar.php";

$repuestoModel = new RepuestoModel();
$embalajeModel = new EmbalajeModel();

$idRepuesto = $_GET["id"];

$repuesto = $repuestoModel->obtenerRepuestoPorId($idRepuesto);
$embalajes = $embalajeModel->obtenerEmbalajesPorRepuesto($idRepuesto);

$nombre = $repuesto->getNombre();
$descripcion = $repuesto->getDescripcion();
$precio = $repuesto->getPrecio();
$stock = $repuesto->getStock();
$categoria = $repuesto->getCategoria();

?>
<link rel="stylesheet" href="../../css/style.css">

<?php

echo "<h1>$nombre</h1>";
echo "<p><strong>Descripción:</strong> $descripcion</p>";
echo "<p><strong>Precio:</strong> $precio €</p>";
echo "<p><strong>Stock:</strong> $stock unidades</p>";
echo "<p><strong>Categoría:</strong> $categoria</p>";

echo "<h3>Embalajes Disponibles</h3>";

if (count($embalajes) > 0) {
    echo "<ul>";
    foreach ($embalajes as $embalaje) {
        $tipoEmbalaje = $embalaje->getTipo();
        $dimensiones = $embalaje->getDimensiones();
        $pesoMaximo = $embalaje->getPesoMaximo();
        $idEmbalaje = $embalaje->getId();

        echo "<li>";
        echo "<strong>Tipo:</strong> $tipoEmbalaje | <strong>Dimensiones:</strong> $dimensiones | <strong>Peso máx:</strong> $pesoMaximo kg";

        if ($usuario->getRol() == "administrador") {
            echo " <a href='deleteEmbalaje.php?id=$idEmbalaje&idRepuesto=$idRepuesto' onclick=\"return confirm('¿Eliminar este embalaje?')\"><button>🗑</button></a>";
        }

        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No hay embalajes disponibles para este repuesto.</p>";
}

if ($usuario->getRol() == "administrador") {
    echo "<br>";
    echo "<a href='addEmbalaje.php?id=$idRepuesto'><button>📦 Añadir Embalaje</button></a>";
    echo " ";
    echo "<a href='edit.php?id=$idRepuesto'><button>✏️ Editar Repuesto</button></a>";
    echo " ";
    echo "<a href='delete.php?id=$idRepuesto' onclick=\"return confirm('¿Eliminar este repuesto?')\"><button style='background-color: red; color: white;'>🗑️ Eliminar</button></a>";
}

echo "<br><br>";
echo "<a href='crearPedido.php?id=$idRepuesto'><button>🛒 Hacer Pedido</button></a>";
echo "<br><br>";
echo "<a href='list.php'><button>Volver al Catálogo</button></a>";
