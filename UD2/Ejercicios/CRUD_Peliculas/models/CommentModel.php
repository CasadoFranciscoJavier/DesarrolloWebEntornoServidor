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
        if (!$fila) {
            return null;
        }

        return new Comment(
            $fila["id"],
            $fila["contenido"],
            $fila["usuario_id"],
            $fila["pelicula_id"]
        );
    }

    public function obtenerComentarioPorId($id)
    {
        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("SELECT * FROM comentarios WHERE id = :id");
        $consulta->bindParam(':id', $id);
        $consulta->execute();

        return $this->filaComentario($consulta->fetch());
    }

    public function obtenerTodosComentarios()
    {
        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("SELECT * FROM comentarios");
        $consulta->execute();

        $comentarios = [];

        foreach ($consulta->fetchAll() as $fila) {
            $comentarios[] = $this->filaComentario($fila);
        }

        return $comentarios;
    }

    public function insertarComentario(Comment $comentario)
    {
        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("
            INSERT INTO comentarios (contenido, usuario_id, pelicula_id)
            VALUES (:contenido, :usuario_id, :pelicula_id)
        ");

        $consulta->bindParam(':contenido', $comentario->getContenido());
        $consulta->bindParam(':usuario_id', $comentario->getUsuarioId());
        $consulta->bindParam(':pelicula_id', $comentario->getPeliculaId());

        return $consulta->execute();
    }

    public function actualizarComentario(Comment $comentario)
    {
        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("
            UPDATE comentarios
            SET contenido = :contenido,
                usuario_id = :usuario_id,
                pelicula_id = :pelicula_id
            WHERE id = :id
        ");

        $consulta->bindParam(':contenido', $comentario->getContenido());
        $consulta->bindParam(':usuario_id', $comentario->getUsuarioId());
        $consulta->bindParam(':pelicula_id', $comentario->getPeliculaId());
        $consulta->bindParam(':id', $comentario->getId());

        return $consulta->execute();
    }

    public function borrarComentarioPorId($id)
    {
        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("DELETE FROM comentarios WHERE id = :id");
        $consulta->bindParam(':id', $id);

        return $consulta->execute();
    }
}
