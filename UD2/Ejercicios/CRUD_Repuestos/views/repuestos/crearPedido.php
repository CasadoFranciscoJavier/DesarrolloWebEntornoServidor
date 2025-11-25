<?php

require_once "./navbar.php";
require_once "../../models/RepuestoModel.php";

if (!isset($_SESSION["usuario"])) {
    header("Location: ../auth/login.php");
}

$idRepuesto = $_GET["id"];
$repuestoModel = new RepuestoModel();
$repuesto = $repuestoModel->obtenerRepuestoPorId($idRepuesto);

if (isset($_POST["cantidad"])) {
    require_once "../../models/PedidoModel.php";
    require_once "../../models/Pedido.php";

    $pedidoModel = new PedidoModel();

    $cantidad = $_POST["cantidad"];
    $idUsuario = $usuario->getId();
    $fecha = date("Y-m-d");
    $estado = "pendiente";

    $nuevoPedido = new Pedido(null, $idUsuario, $idRepuesto, $cantidad, $fecha, $estado);
    $pedidoModel->insertarPedido($nuevoPedido);

    header("Location: misPedidos.php");
}

?>
<link rel="stylesheet" href="../../css/style.css">

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Pedido</title>
</head>
<body>
    <h1>Crear Pedido</h1>
    <p><strong>Repuesto:</strong> <?php echo $repuesto->getNombre()?></p>
    <p><strong>Precio unitario:</strong> <?php echo $repuesto->getPrecio()?> €</p>
    <p><strong>Stock disponible:</strong> <?php echo $repuesto->getStock()?> unidades</p>

    <form method="POST">
        <label>Cantidad: <input name="cantidad" type="number" min="1" max="<?php echo $repuesto->getStock()?>" required></label><br>
        <input type="submit" value="Realizar Pedido">
    </form>
    <br>
    <a href="detail.php?id=<?php echo $idRepuesto?>"><button>Volver</button></a>
</body>
</html>
