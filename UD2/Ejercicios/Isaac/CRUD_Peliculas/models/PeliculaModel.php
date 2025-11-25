<?php

require_once "Conector.php";
require_once "Pelicula.php";
require_once "ValoracionModel.php";
require_once "ComentarioModel.php";

class PeliculaModel
{
    private $miConector;
    private $valoracionModel;
    private $comentarioModel;

    public function __construct()
    {
        $this->miConector = new Conector();
        $this->valoracionModel = new ValoracionModel();
        $this->comentarioModel = new ComentarioModel();
    }

    private function filaAPelicula($fila)
    {

        // TO-DO: si la fila está vacía, la función debe devolver null
        $id = $fila["ID_PELICULA"];
        $titulo = $fila["TITULO"];
        $sinopsis = $fila["SINOPSIS"];
        $nota = $this->valoracionModel->obtenerNotaPorIdPelicula($id);
        $comentarios = $this->comentarioModel->obtenerComentariosPorIdPelicula($id);

        $pelicula = new Pelicula($id, $titulo, $sinopsis, $nota, $comentarios);

        return $pelicula;
    }

    public function obtenerPeliculaPorId($id)
    {

        try {
            $conexion = $this->miConector->conectar();

            $consulta = $conexion->prepare("SELECT * FROM PELICULA WHERE ID_PELICULA = :id");
            $consulta->bindParam(':id', $id);
            $consulta->execute();

            $resultadoConsulta = $consulta->fetch();

            $pelicula = $this->filaAPelicula($resultadoConsulta);
        } catch (PDOException $excepcion) {
            $pelicula = null;
        }

        return $pelicula;
    }

    public function obtenerTodosPeliculas()
    {

        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("SELECT * FROM PELICULA");
        $consulta->execute();

        $resultadoConsulta = $consulta->fetchAll();

        $peliculas = [];

        foreach ($resultadoConsulta as $fila) {
            $peliculas[] = $this->filaAPelicula($fila); //Push de pelicula
        }

        return $peliculas;
    }

    public function insertarPelicula($pelicula)
    {

        try {
            $conexion = $this->miConector->conectar();

            $consulta = $conexion->prepare("INSERT INTO PELICULA(TITULO, SINOPSIS) VALUES (:titulo, :sinopsis)");

            $consulta->bindParam(':titulo', $pelicula->getTitulo());
            $consulta->bindParam(':sinopsis', $pelicula->getSinopsis());

            $consulta->execute();
            $id = $this->obenerUltimoId();

            $pelicula->setId($id);
        } catch (PDOException $excepcion) {
            $pelicula = null;
        }

        return $pelicula;

    }

    public function obenerUltimoId()
    {

        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("SELECT MAX(ID_PELICULA) FROM PELICULA");

        $consulta->execute();

        $resultadoConsulta = $consulta->fetch();

        $id = $resultadoConsulta[0];

        return $id;

    }

    public function actualizarPelicula($pelicula)
    {

        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("UPDATE PELICULA SET TITULO = :titulo, SINOPSIS = :sinopsis WHERE ID_PELICULA=:id");

        $consulta->bindParam(':titulo', $pelicula->getTitulo());
        $consulta->bindParam(':sinopsis', $pelicula->getSinopsis());
        $consulta->bindParam(':id', $pelicula->getId());

        return $consulta->execute();

    }

    public function borrarPeliculaPorId($id)
    {

        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("DELETE FROM PELICULA WHERE ID_PELICULA=:id");

        $consulta->bindParam(':id', $id);

        return $consulta->execute();
    }

}