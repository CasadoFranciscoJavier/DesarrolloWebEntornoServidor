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

        $id = $fila["id"];
        $puntuacion = $fila["puntuacion"];
        $usuarioId = $fila["usuario_id"];
        $peliculaId = $fila["pelicula_id"];

        $rating = new Rating($id, $puntuacion, $usuarioId, $peliculaId);

        if (isset($fila["usuario_nombre"])) {
            $rating->setUsuarioNombre($fila["usuario_nombre"]);
        }
        if (isset($fila["pelicula_titulo"])) {
            $rating->setPeliculaTitulo($fila["pelicula_titulo"]);
        }

        return $rating;
    }

    public function insertarPuntuacion($puntuacion)
    {
        $conexion = $this->miConector->conectar();

        $sql = "INSERT INTO rating (puntuacion, usuario_id, pelicula_id)
                VALUES (:puntuacion, :usuario_id, :pelicula_id)";
        $stmt = $conexion->prepare($sql);

        $valorPuntuacion = $puntuacion->getPuntuacion();
        $usuarioId = $puntuacion->getUsuarioId();
        $peliculaId = $puntuacion->getPeliculaId();

        $stmt->bindParam(':puntuacion', $valorPuntuacion);
        $stmt->bindParam(':usuario_id', $usuarioId);
        $stmt->bindParam(':pelicula_id', $peliculaId);

        return $stmt->execute();
    }

    public function obtenerPuntuacionPorId($id)
    {
        $conexion = $this->miConector->conectar();

        $sql = "SELECT r.*, u.nombre as usuario_nombre, p.titulo as pelicula_titulo
                FROM rating r
                JOIN usuarios u ON r.usuario_id = u.id
                JOIN peliculas p ON r.pelicula_id = p.id
                WHERE r.id = :id";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $resultadoConsulta = $stmt->fetch();
        $puntuacion = $this->filaPuntuacion($resultadoConsulta);

        return $puntuacion;
    }

    public function obtenerMediaPuntuacionPorPelicula($peliculaId)
    {
        $conexion = $this->miConector->conectar();

        $sql = "SELECT AVG(r.puntuacion) AS media
                FROM rating r
                WHERE r.pelicula_id = :pelicula_id";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':pelicula_id', $peliculaId);
        $stmt->execute();

        $resultado = $stmt->fetch();

        $media = $resultado['media'] !== null ? round($resultado['media'], 2) : 0;

        return $media;
    }


    public function borrarPuntuacionPorIdPelicula($peliculaId)
    {
        $conexion = $this->miConector->conectar();

        $sql = "DELETE FROM rating WHERE pelicula_id = :pelicula_id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':pelicula_id', $peliculaId);

        return $stmt->execute();
    }

    public function actualizarPuntuacion($puntuacion)
    {
        $conexion = $this->miConector->conectar();

        $sql = "UPDATE rating
                SET puntuacion = :puntuacion
                WHERE id = :id";
        $stmt = $conexion->prepare($sql);

        $valorPuntuacion = $puntuacion->getPuntuacion();
        $id = $puntuacion->getId();

        $stmt->bindParam(':puntuacion', $valorPuntuacion);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }
}
