<?php

require_once "Conector.php";
require_once "Comment.php";

class CommentModel
{
    private $miConector;

    public function __construct()
    {
        $this->miConector = new Conector();
    }

    private function filaComentario($fila)
    {
        if (!$fila) return null;

        $id = $fila["id"];
        $contenido = $fila["contenido"];
        $usuarioId = $fila["usuario_id"];
        $peliculaId = $fila["pelicula_id"];

        $comentario = new Comment($id, $contenido, $usuarioId, $peliculaId);

        if (isset($fila["usuario_nombre"])) {
            $comentario->setUsuarioNombre($fila["usuario_nombre"]);
        }
        if (isset($fila["pelicula_titulo"])) {
            $comentario->setPeliculaTitulo($fila["pelicula_titulo"]);
        }

        return $comentario;
    }

    public function insertarComentario($comentario)
    {
        $conexion = $this->miConector->conectar();

        $sql = "INSERT INTO comentarios (contenido, usuario_id, pelicula_id)
                VALUES (:contenido, :usuario_id, :pelicula_id)";
        $stmt = $conexion->prepare($sql);

        $contenido = $comentario->getContenido();
        $usuarioId = $comentario->getUsuarioId();
        $peliculaId = $comentario->getPeliculaId();

        $stmt->bindParam(':contenido', $contenido);
        $stmt->bindParam(':usuario_id', $usuarioId);
        $stmt->bindParam(':pelicula_id', $peliculaId);

        return $stmt->execute();
    }

    public function obtenerComentarioPorId($id)
    {
        $conexion = $this->miConector->conectar();

        $sql = "SELECT c.*, u.nombre as usuario_nombre, p.titulo as pelicula_titulo
                FROM comentarios c
                JOIN usuarios u ON c.usuario_id = u.id
                JOIN peliculas p ON c.pelicula_id = p.id
                WHERE c.id = :id";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $fila = $stmt->fetch();
        return $this->filaComentario($fila);
    }

    public function obtenerComentariosPorPelicula($peliculaId)
    {
        $conexion = $this->miConector->conectar();

        $sql = "SELECT c.*, u.nombre as usuario_nombre, p.titulo as pelicula_titulo
                FROM comentarios c
                JOIN usuarios u ON c.usuario_id = u.id
                JOIN peliculas p ON c.pelicula_id = p.id
                WHERE c.pelicula_id = :pelicula_id
                ORDER BY c.id DESC";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':pelicula_id', $peliculaId);
        $stmt->execute();

        $resultadoConsulta = $stmt->fetchAll();

        $comentarios = [];
        foreach ($resultadoConsulta as $fila) {
            $comentarios[] = $this->filaComentario($fila);
        }

        return $comentarios;
    }

    public function borrarComentarioPorId($id)
    {
        $conexion = $this->miConector->conectar();

        $sql = "DELETE FROM comentarios WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function actualizarComentario($comentario)
    {
        $conexion = $this->miConector->conectar();

        $sql = "UPDATE comentarios
                SET contenido = :contenido
                WHERE id = :id";

        $stmt = $conexion->prepare($sql);

        $contenido = $comentario->getContenido();
        $id = $comentario->getId();

        $stmt->bindParam(':contenido', $contenido);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }
}
