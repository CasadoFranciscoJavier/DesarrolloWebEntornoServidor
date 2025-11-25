<?php

require_once "Conector.php";
require_once "Pedido.php";

class PedidoModel
{
    private $miConector;

    public function __construct()
    {
        $this->miConector = new Conector();
    }

    private function filaPedido($fila)
    {
        $pedido = null;
        if ($fila) {
            $id = $fila["ID_PEDIDO"];
            $usuarioId = $fila["ID_USUARIO"];
            $repuestoId = $fila["ID_REPUESTO"];
            $cantidad = $fila["CANTIDAD"];
            $fecha = $fila["FECHA"];
            $estado = $fila["ESTADO"];

            $pedido = new Pedido($id, $usuarioId, $repuestoId, $cantidad, $fecha, $estado);
        }
        return $pedido;
    }

    public function insertarPedido($pedido)
    {
        try {
            $conexion = $this->miConector->conectar();
            $consulta = $conexion->prepare("INSERT INTO PEDIDOS(ID_USUARIO, ID_REPUESTO, CANTIDAD, FECHA, ESTADO) VALUES (:usuarioId, :repuestoId, :cantidad, :fecha, :estado)");

            $consulta->bindParam(':usuarioId', $pedido->getUsuarioId());
            $consulta->bindParam(':repuestoId', $pedido->getRepuestoId());
            $consulta->bindParam(':cantidad', $pedido->getCantidad());
            $consulta->bindParam(':fecha', $pedido->getFecha());
            $consulta->bindParam(':estado', $pedido->getEstado());

            $consulta->execute();
            $id = $this->obtenerUltimoId();
            $pedido->setId($id);
        } catch (PDOException $excepcion) {
            $pedido = null;
        }
        return $pedido;
    }

    public function obtenerPedidosPorUsuario($usuarioId)
    {
        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("SELECT * FROM PEDIDOS WHERE ID_USUARIO = :usuarioId ORDER BY FECHA DESC");
        $consulta->bindParam(':usuarioId', $usuarioId);
        $consulta->execute();

        $resultadoConsulta = $consulta->fetchAll();

        $pedidos = [];

        foreach ($resultadoConsulta as $fila) {
            $pedidos[] = $this->filaPedido($fila);
        }

        return $pedidos;
    }

    public function obtenerTodosPedidos()
    {
        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("SELECT * FROM PEDIDOS ORDER BY FECHA DESC");
        $consulta->execute();

        $resultadoConsulta = $consulta->fetchAll();

        $pedidos = [];

        foreach ($resultadoConsulta as $fila) {
            $pedidos[] = $this->filaPedido($fila);
        }

        return $pedidos;
    }

    public function cambiarEstadoPedido($id, $estado)
    {
        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("UPDATE PEDIDOS SET ESTADO = :estado WHERE ID_PEDIDO = :id");

        $consulta->bindParam(':estado', $estado);
        $consulta->bindParam(':id', $id);

        return $consulta->execute();
    }

    public function obtenerUltimoId()
    {
        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("SELECT MAX(ID_PEDIDO) FROM PEDIDOS");

        $consulta->execute();

        $resultadoConsulta = $consulta->fetch();

        $id = $resultadoConsulta[0];

        return $id;
    }
}
