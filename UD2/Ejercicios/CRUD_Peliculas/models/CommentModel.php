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

        $comentario = new Comment(
            $fila["id"],
            $fila["contenido"],
            $fila["usuario_id"],
            $fila["pelicula_id"]
        );

    

        return $comentario;
    }

    public function insertarComentario(Comment $comentario)
    {
        $conexion = $this->miConector->conectar();

        $sql = "INSERT INTO comentarios (contenido, usuario_id, pelicula_id)
                VALUES (:contenido, :usuario_id, :pelicula_id)";
        $stmt = $conexion->prepare($sql);

        $stmt->bindParam(':contenido', $comentario->getContenido());
        $stmt->bindParam(':usuario_id', $comentario->getUsuarioId());
        $stmt->bindParam(':pelicula_id', $comentario->getPeliculaId());

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

    public function obtenerComentariosPorPelicula($pelicula_id)
    {
        $conexion = $this->miConector->conectar();

        $sql = "SELECT c.*, u.nombre as usuario_nombre, p.titulo as pelicula_titulo
                FROM comentarios c
                JOIN usuarios u ON c.usuario_id = u.id
                JOIN peliculas p ON c.pelicula_id = p.id
                WHERE c.pelicula_id = :pelicula_id
                ORDER BY c.id DESC";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':pelicula_id', $pelicula_id);
        $stmt->execute();

        $comentarios = [];
        foreach($stmt->fetchAll() as $fila){
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

    public function actualizarComentario(Comment $comentario)
    {
        $conexion = $this->miConector->conectar();

        $sql = "UPDATE comentarios
                SET contenido = :contenido
                WHERE id = :id";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':contenido', $comentario->getContenido());
        $stmt->bindParam(':id', $comentario->getId());

        return $stmt->execute();
    }
}
