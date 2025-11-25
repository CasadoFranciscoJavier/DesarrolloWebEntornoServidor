<?php

require_once "./navbar.php";
require_once "../../models/PedidoModel.php";
require_once "../../models/RepuestoModel.php";
require_once "../../models/UsuarioModel.php";

if (!isset($_SESSION["usuario"])) {
    header("Location: ../auth/login.php");
}

$rol = $usuario->getRol();

if ($rol != "administrador") {
    header("Location: list.php");
}

$pedidoModel = new PedidoModel();
$repuestoModel = new RepuestoModel();
$usuarioModel = new UsuarioModel();

$pedidos = $pedidoModel->obtenerTodosPedidos();

?>
<link rel="stylesheet" href="../../css/style.css">

<?php

echo "<h1>Todos los Pedidos (Administrador)</h1>";

if (count($pedidos) > 0) {
    echo "<table border='1' style='width: 90%; margin: 0 auto; border-collapse: collapse;'>";
    echo "<tr>";
    echo "<th>ID Pedido</th>";
    echo "<th>Usuario</th>";
    echo "<th>Repuesto</th>";
    echo "<th>Cantidad</th>";
    echo "<th>Fecha</th>";
    echo "<th>Estado</th>";
    echo "<th>Acciones</th>";
    echo "</tr>";

    foreach ($pedidos as $pedido) {
        $idPedido = $pedido->getId();
        $idUsuario = $pedido->getUsuarioId();
        $idRepuesto = $pedido->getRepuestoId();
        $cantidad = $pedido->getCantidad();
        $fecha = $pedido->getFecha();
        $estado = $pedido->getEstado();

        $repuesto = $repuestoModel->obtenerRepuestoPorId($idRepuesto);
        $nombreRepuesto = $repuesto->getNombre();

        $usuarioPedido = $usuarioModel->obtenerUsuarioPorId($idUsuario);
        $nombreUsuario = $usuarioPedido->getNombre();

        echo "<tr>";
        echo "<td>$idPedido</td>";
        echo "<td>$nombreUsuario</td>";
        echo "<td><a href='detail.php?id=$idRepuesto'>$nombreRepuesto</a></td>";
        echo "<td>$cantidad</td>";
        echo "<td>$fecha</td>";
        echo "<td>$estado</td>";
        echo "<td>";

        if ($estado == "pendiente") {
            echo "<a href='cambiarEstado.php?id=$idPedido&estado=procesando'><button>Procesar</button></a>";
        } else if ($estado == "procesando") {
            echo "<a href='cambiarEstado.php?id=$idPedido&estado=enviado'><button>Enviar</button></a>";
        } else if ($estado == "enviado") {
            echo "<a href='cambiarEstado.php?id=$idPedido&estado=entregado'><button>Entregar</button></a>";
        } else {
            echo "Completado";
        }

        echo "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>No hay pedidos en el sistema.</p>";
}

echo "<br>";
echo "<a href='list.php'><button>Volver al Catálogo</button></a>";
