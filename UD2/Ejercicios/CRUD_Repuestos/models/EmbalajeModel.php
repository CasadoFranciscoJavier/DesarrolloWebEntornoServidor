<?php

require_once "Conector.php";
require_once "Embalaje.php";

class EmbalajeModel
{
    private $miConector;

    public function __construct()
    {
        $this->miConector = new Conector();
    }

    private function filaEmbalaje($fila)
    {
        $embalaje = null;
        if ($fila) {
            $id = $fila["ID_EMBALAJE"];
            $repuestoId = $fila["ID_REPUESTO"];
            $tipo = $fila["TIPO"];
            $dimensiones = $fila["DIMENSIONES"];
            $pesoMaximo = $fila["PESO_MAXIMO"];

            $embalaje = new Embalaje($id, $repuestoId, $tipo, $dimensiones, $pesoMaximo);
        }
        return $embalaje;
    }

    public function insertarEmbalaje($embalaje)
    {
        try {
            $conexion = $this->miConector->conectar();
            $consulta = $conexion->prepare("INSERT INTO EMBALAJES(ID_REPUESTO, TIPO, DIMENSIONES, PESO_MAXIMO) VALUES (:repuestoId, :tipo, :dimensiones, :pesoMaximo)");

            $consulta->bindParam(':repuestoId', $embalaje->getRepuestoId());
            $consulta->bindParam(':tipo', $embalaje->getTipo());
            $consulta->bindParam(':dimensiones', $embalaje->getDimensiones());
            $consulta->bindParam(':pesoMaximo', $embalaje->getPesoMaximo());

            $consulta->execute();
            $id = $this->obtenerUltimoId();
            $embalaje->setId($id);
        } catch (PDOException $excepcion) {
            $embalaje = null;
        }
        return $embalaje;
    }

    public function obtenerEmbalajesPorRepuesto($repuestoId)
    {
        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("SELECT * FROM EMBALAJES WHERE ID_REPUESTO = :repuestoId");
        $consulta->bindParam(':repuestoId', $repuestoId);
        $consulta->execute();

        $resultadoConsulta = $consulta->fetchAll();

        $embalajes = [];

        foreach ($resultadoConsulta as $fila) {
            $embalajes[] = $this->filaEmbalaje($fila);
        }

        return $embalajes;
    }

    public function borrarEmbalajePorId($id)
    {
        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("DELETE FROM EMBALAJES WHERE ID_EMBALAJE = :id");
        $consulta->bindParam(':id', $id);

        return $consulta->execute();
    }

    public function obtenerUltimoId()
    {
        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("SELECT MAX(ID_EMBALAJE) FROM EMBALAJES");

        $consulta->execute();

        $resultadoConsulta = $consulta->fetch();

        $id = $resultadoConsulta[0];

        return $id;
    }
}
