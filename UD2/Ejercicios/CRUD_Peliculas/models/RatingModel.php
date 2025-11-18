<?php

require_once "Conector.php";
require_once "Rating.php";

class RatingModel
{
    private $miConector;

    public function __construct()
    {
        $this->miConector = new Conector();
    }

    private function filaPuntuacion($fila)
    {
        if (!$fila) return null;

        $puntuacion = new Rating(
            $fila["id"],
            $fila["puntuacion"],
            $fila["usuario_id"],
            $fila["pelicula_id"]
        );

        // Asignamos nombre de usuario y título de película si vienen en la consulta
        if(isset($fila["usuario_nombre"])) {
            $puntuacion->setUsuarioNombre($fila["usuario_nombre"]);
        }
        if(isset($fila["pelicula_titulo"])) {
            $puntuacion->setPeliculaTitulo($fila["pelicula_titulo"]);
        }

        return $puntuacion;
    }

    public function insertarPuntuacion(Rating $puntuacion)
    {
        $conexion = $this->miConector->conectar();

        $sql = "INSERT INTO rating (puntuacion, usuario_id, pelicula_id)
                VALUES (:puntuacion, :usuario_id, :pelicula_id)";
        $stmt = $conexion->prepare($sql);

        $stmt->bindParam(':puntuacion', $puntuacion->getPuntuacion());
        $stmt->bindParam(':usuario_id', $puntuacion->getUsuarioId());
        $stmt->bindParam(':pelicula_id', $puntuacion->getPeliculaId());

        return $stmt->execute();
    }

    public function obtenerPuntuacionPorId($id)
    {
        $conexion = $this->miConector->conectar();

        $sql = "SELECT c.*, u.nombre as usuario_nombre, p.titulo as pelicula_titulo
                FROM rating c
                JOIN usuarios u ON c.usuario_id = u.id
                JOIN peliculas p ON c.pelicula_id = p.id
                WHERE c.id = :id";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $fila = $stmt->fetch();
        return $this->filapuntuacion($fila);
    }

    public function obtenerMediaPuntuacionPorPelicula($pelicula_id)
{
    $conexion = $this->miConector->conectar();

    $sql = "SELECT AVG(p.puntuacion) AS media
            FROM rating p
            WHERE p.pelicula_id = :pelicula_id";

    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':pelicula_id', $pelicula_id);
    $stmt->execute();

    $resultado = $stmt->fetch();

    return $resultado['media'] !== null ? round($resultado['media'], 2) : 0;
}


    public function borrarPuntuacionPorIdPelicula($pelicula_id)
    {
        $conexion = $this->miConector->conectar();

        $sql = "DELETE FROM rating WHERE pelicula_id = :pelicula_id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':pelicula_id', $pelicula_id);

        return $stmt->execute();
    }

    public function actualizarPuntuacion (Rating $puntuacion)
    {
        $conexion = $this->miConector->conectar();

        $sql = "UPDATE rating
                SET puntuacion = :puntuacion,
                    
                WHERE id = :id";
        $stmt = $conexion->prepare($sql);

        $stmt->bindParam(':puntuacion', $puntuacion->getPuntuacion());
        
        $stmt->bindParam(':id', $puntuacion->getId());

        return $stmt->execute();
    }
}
