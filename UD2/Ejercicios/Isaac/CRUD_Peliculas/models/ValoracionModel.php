<?php

require_once "Conector.php";

class ValoracionModel
{
    private $miConector;

    public function __construct()
    {
        $this->miConector = new Conector();
    }

    public function obtenerNotaPorIdPelicula($idPelicula)
    {

        try {
            $conexion = $this->miConector->conectar();

            $consulta = $conexion->prepare("SELECT ROUND(AVG(NOTA_VALORACION), 2) AS NOTA FROM VALORACION WHERE ID_PELICULA = :idPelicula");
            $consulta->bindParam(':idPelicula', $idPelicula);
            $consulta->execute();

            $resultadoConsulta = $consulta->fetch();

            $nota = $resultadoConsulta ? $resultadoConsulta["NOTA"] : null;
        } catch (PDOException $excepcion) {
            $nota = null;
        }

        return $nota;
    }


}