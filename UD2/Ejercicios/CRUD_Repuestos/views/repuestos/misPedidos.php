<?php

require_once "./navbar.php";
require_once "../../models/PedidoModel.php";
require_once "../../models/RepuestoModel.php";

if (!isset($_SESSION["usuario"])) {
    header("Location: ../auth/login.php");
}

$pedidoModel = new PedidoModel();
$repuestoModel = new RepuestoModel();

$idUsuario = $usuario->getId();
$pedidos = $pedidoModel->obtenerPedidosPorUsuario($idUsuario);

?>
<link rel="stylesheet" href="../../css/style.css">

<?php

echo "<h1>Mis Pedidos</h1>";

if (count($pedidos) > 0) {
    echo "<table border='1' style='width: 80%; margin: 0 auto; border-collapse: collapse;'>";
    echo "<tr>";
    echo "<th>ID Pedido</th>";
    echo "<th>Repuesto</th>";
    echo "<th>Cantidad</th>";
    echo "<th>Fecha</th>";
    echo "<th>Estado</th>";
    echo "</tr>";

    foreach ($pedidos as $pedido) {
        $idPedido = $pedido->getId();
        $idRepuesto = $pedido->getRepuestoId();
        $cantidad = $pedido->getCantidad();
        $fecha = $pedido->getFecha();
        $estado = $pedido->getEstado();

        $repuesto = $repuestoModel->obtenerRepuestoPorId($idRepuesto);
        $nombreRepuesto = $repuesto->getNombre();

        echo "<tr>";
        echo "<td>$idPedido</td>";
        echo "<td><a href='detail.php?id=$idRepuesto'>$nombreRepuesto</a></td>";
        echo "<td>$cantidad</td>";
        echo "<td>$fecha</td>";
        echo "<td>$estado</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>No tienes pedidos realizados.</p>";
}

echo "<br>";
echo "<a href='list.php'><button>Volver al Catálogo</button></a>";

if ($usuario->getRol() == "administrador") {
    echo " ";
    echo "<a href='verTodosPedidos.php'><button>Ver Todos los Pedidos (Admin)</button></a>";
}
