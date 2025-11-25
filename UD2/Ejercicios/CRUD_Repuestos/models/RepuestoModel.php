<?php

require_once "Conector.php";
require_once "Repuesto.php";

class RepuestoModel
{
    private $miConector;

    public function __construct()
    {
        $this->miConector = new Conector();
    }

    private function filaRepuesto($fila)
    {
        $repuesto = null;
        if ($fila) {
            $id = $fila["ID_REPUESTO"];
            $nombre = $fila["NOMBRE"];
            $descripcion = $fila["DESCRIPCION"];
            $precio = $fila["PRECIO"];
            $stock = $fila["STOCK"];
            $categoria = $fila["CATEGORIA"];

            $repuesto = new Repuesto($id, $nombre, $descripcion, $precio, $stock, $categoria);
        }
        return $repuesto;
    }

    public function insertarRepuesto($repuesto)
    {
        try {
            $conexion = $this->miConector->conectar();
            $consulta = $conexion->prepare("INSERT INTO REPUESTOS(NOMBRE, DESCRIPCION, PRECIO, STOCK, CATEGORIA) VALUES (:nombre, :descripcion, :precio, :stock, :categoria)");

            $consulta->bindParam(':nombre', $repuesto->getNombre());
            $consulta->bindParam(':descripcion', $repuesto->getDescripcion());
            $consulta->bindParam(':precio', $repuesto->getPrecio());
            $consulta->bindParam(':stock', $repuesto->getStock());
            $consulta->bindParam(':categoria', $repuesto->getCategoria());

            $consulta->execute();
            $id = $this->obtenerUltimoId();
            $repuesto->setId($id);
        } catch (PDOException $excepcion) {
            $repuesto = null;
        }
        return $repuesto;
    }

    public function obtenerRepuestoPorId($id)
    {
        try {
            $conexion = $this->miConector->conectar();
            $consulta = $conexion->prepare("SELECT * FROM REPUESTOS WHERE ID_REPUESTO = :id");
            $consulta->bindParam(':id', $id);
            $consulta->execute();

            $resultadoConsulta = $consulta->fetch();

            $repuesto = $this->filaRepuesto($resultadoConsulta);
        } catch (PDOException $excepcion) {
            $repuesto = null;
        }
        return $repuesto;
    }

    public function obtenerTodosRepuestos()
    {
        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("SELECT * FROM REPUESTOS");
        $consulta->execute();

        $resultadoConsulta = $consulta->fetchAll();

        $repuestos = [];

        foreach ($resultadoConsulta as $fila) {
            $repuestos[] = $this->filaRepuesto($fila);
        }

        return $repuestos;
    }

    public function actualizarRepuesto($repuesto)
    {
        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("UPDATE REPUESTOS SET NOMBRE = :nombre, DESCRIPCION = :descripcion, PRECIO = :precio, STOCK = :stock, CATEGORIA = :categoria WHERE ID_REPUESTO = :id");

        $consulta->bindParam(':nombre', $repuesto->getNombre());
        $consulta->bindParam(':descripcion', $repuesto->getDescripcion());
        $consulta->bindParam(':precio', $repuesto->getPrecio());
        $consulta->bindParam(':stock', $repuesto->getStock());
        $consulta->bindParam(':categoria', $repuesto->getCategoria());
        $consulta->bindParam(':id', $repuesto->getId());

        return $consulta->execute();
    }

    public function borrarRepuestoPorId($id)
    {
        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("DELETE FROM REPUESTOS WHERE ID_REPUESTO = :id");
        $consulta->bindParam(':id', $id);

        return $consulta->execute();
    }

    public function obtenerUltimoId()
    {
        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("SELECT MAX(ID_REPUESTO) FROM REPUESTOS");

        $consulta->execute();

        $resultadoConsulta = $consulta->fetch();

        $id = $resultadoConsulta[0];

        return $id;
    }
}
