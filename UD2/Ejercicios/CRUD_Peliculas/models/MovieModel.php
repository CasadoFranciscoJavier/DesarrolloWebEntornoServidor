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

    private function filaUser($fila)
    {
        if (!$fila) return null;

        $movie = new Movie(
            $fila["id"],
            $fila["titulo"],
            $fila["sinopsis"],
            $fila["anio"],
            $fila["genero"]
        );



        return $movie;
    }

    // solo para registrar usuarios normales
    public function insertarPelicula($movie)
    {
        $conexion = $this->miConector->conectar();

        $sql = "INSERT INTO peliculas (titulo, sinopsis, anio, genero)
                VALUES (:titulo, :sinopsis, :anio, :genero)";
        $stmt = $conexion->prepare($sql);

        $stmt->bindParam(':titulo', $movie->getTitulo());
        $stmt->bindParam(':sinopsis', $movie->getSinopsis());
        $stmt->bindParam(':anio', $movie->getAnio());
        $stmt->bindParam(':genero', $movie->getGenero());

        return $stmt->execute();
    }


    public function obtenerPeliculaPorId($id)
    { {

            try {
                $conexion = $this->miConector->conectar();

                $consulta = $conexion->prepare("SELECT * FROM usuarios WHERE id = :id");
                $consulta->bindParam(':id', $id);
                $consulta->execute();

                $resultadoConsulta = $consulta->fetch();

                $usuario = $this->filaUser($resultadoConsulta);
            } catch (PDOException $excepcion) {
                $usuario = null;
            }

            return $usuario;
        }
    }

    public function obtenerTodosPeliculas()
    {

        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("SELECT * FROM peliculas");
        $consulta->execute();

        $resultadoConsulta = $consulta->fetchAll();

        $peliculas = [];

        foreach ($resultadoConsulta as $fila) {
            $peliculas[] = $this->filaUser($fila); //Push de pelicula
        }

        return $peliculas;
    }

    public function eliminarPeliculaPorId($id)
    {
        $conexion = $this->miConector->conectar();

        $sql = "DELETE FROM peliculas WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }


    public function actualizarPelicula (Movie $movie)
    {
        $conexion = $this->miConector->conectar();

        $sql = "UPDATE peliculas
                SET titulo = :titulo,
                    sinopsis = :sinopsis,
                    anio = :anio,
                    genero = :genero
                WHERE id = :id";
        $stmt = $conexion->prepare($sql);

        $stmt->bindParam(':titulo', $movie->getTitulo());
        $stmt->bindParam(':sinopsis', $movie->getSinopsis());
        $stmt->bindParam(':anio', $movie->getAnio());
        $stmt->bindParam(':genero', $movie->getGenero());
        $stmt->bindParam(':id', $movie->getId());

        return $stmt->execute();
    }
}
