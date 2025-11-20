<?php

require_once "Conector.php";
require_once "Movie.php";

class MovieModel
{
    private $miConector;

    public function __construct()
    {
        $this->miConector = new Conector();
    }

    private function filaPelicula($fila)
    {
        $id = $fila["id"];
        $titulo = $fila["titulo"];
        $sinopsis = $fila["sinopsis"];
        $anio = $fila["anio"];
        $genero = $fila["genero"];

        $pelicula = new Movie($id, $titulo, $sinopsis, $anio, $genero);

        return $pelicula;
    }

    public function insertarPelicula($pelicula)
    {
        try {
            $conexion = $this->miConector->conectar();

            $consulta = $conexion->prepare("INSERT INTO peliculas(titulo, sinopsis, anio, genero) VALUES (:titulo, :sinopsis, :anio, :genero)");

            $consulta->bindParam(':titulo', $pelicula->getTitulo());
            $consulta->bindParam(':sinopsis', $pelicula->getSinopsis());
            $consulta->bindParam(':anio', $pelicula->getAnio());
            $consulta->bindParam(':genero', $pelicula->getGenero());

            $consulta->execute();
            $id = $this->obtenerUltimoId();

            $pelicula->setId($id);
        } catch (PDOException $excepcion) {
            $pelicula = null;
        }

        return $pelicula;
    }

    public function obtenerUltimoId()
    {
        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("SELECT MAX(id) FROM peliculas");

        $consulta->execute();

        $resultadoConsulta = $consulta->fetch();

        $id = $resultadoConsulta[0];

        return $id;
    }


    public function obtenerPeliculaPorId($id)
    {
        try {
            $conexion = $this->miConector->conectar();

            $consulta = $conexion->prepare("SELECT * FROM peliculas WHERE id = :id");
            $consulta->bindParam(':id', $id);
            $consulta->execute();

            $resultadoConsulta = $consulta->fetch();

            $pelicula = $this->filaPelicula($resultadoConsulta);
        } catch (PDOException $excepcion) {
            $pelicula = null;
        }

        return $pelicula;
    }

    public function obtenerTodosPeliculas()
    {
        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("SELECT * FROM peliculas");
        $consulta->execute();

        $resultadoConsulta = $consulta->fetchAll();

        $peliculas = [];

        foreach ($resultadoConsulta as $fila) {
            $peliculas[] = $this->filaPelicula($fila);
        }

        return $peliculas;
    }

    public function borrarPeliculaPorId($id)
    {
        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("DELETE FROM peliculas WHERE id=:id");

        $consulta->bindParam(':id', $id);

        return $consulta->execute();
    }

    public function actualizarPelicula($pelicula)
    {
        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("UPDATE peliculas SET titulo = :titulo, sinopsis = :sinopsis, anio = :anio, genero = :genero WHERE id=:id");

        $consulta->bindParam(':titulo', $pelicula->getTitulo());
        $consulta->bindParam(':sinopsis', $pelicula->getSinopsis());
        $consulta->bindParam(':anio', $pelicula->getAnio());
        $consulta->bindParam(':genero', $pelicula->getGenero());
        $consulta->bindParam(':id', $pelicula->getId());

        return $consulta->execute();
    }
}
