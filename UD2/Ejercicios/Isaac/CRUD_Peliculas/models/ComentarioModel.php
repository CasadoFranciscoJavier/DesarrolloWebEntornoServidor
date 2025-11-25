<?php

require_once "Conector.php";
require_once "Comentario.php";
require_once "UsuarioModel.php";

class ComentarioModel
{
    private $miConector;
    private $usuarioModel;

    public function __construct()
    {
        $this->miConector = new Conector();
        $this->usuarioModel = new UsuarioModel();
    }

    private function filaAComentario($fila)
    {
        $comentario = null;

        if($fila){
            $id = $fila["ID_COMENTARIO"];
            $idPelicula = $fila["ID_PELICULA"];
            $texto = $fila["TEXTO_COMENTARIO"];

            $usuario = $this->usuarioModel->filaAUsuario($fila);
            $comentario = new Comentario($id, $idPelicula, $usuario, $texto);
        }
        
        return $comentario;
    }

    public function obtenerComentarioPorId($id)
    {

        try {
            $conexion = $this->miConector->conectar();

            $consulta = $conexion->prepare("SELECT * FROM COMENTARIO 
                                                    JOIN USUARIO ON USUARIO.ID_USUARIO = COMENTARIO.ID_USUARIO
                                                    WHERE ID_COMENTARIO = :id");
            $consulta->bindParam(':id', $id);
            $consulta->execute();

            $resultadoConsulta = $consulta->fetch();

            $comentario = $this->filaAComentario($resultadoConsulta);
        } catch (PDOException $excepcion) {
            $comentario = null;
        }

        return $comentario;
    }

    public function obtenerTodosComentarios()
    {

        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("SELECT * FROM COMENTARIO 
                                                JOIN USUARIO ON USUARIO.ID_USUARIO = COMENTARIO.ID_USUARIO");
        $consulta->execute();

        $resultadoConsulta = $consulta->fetchAll();

        $comentarios = [];

        foreach ($resultadoConsulta as $fila) {
            $comentarios[] = $this->filaAComentario($fila); //Push de comentario
        }

        return $comentarios;
    }

    public function obtenerComentariosPorIdPelicula($idPelicula)
    {

        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("SELECT * FROM COMENTARIO 
                                                JOIN USUARIO ON USUARIO.ID_USUARIO = COMENTARIO.ID_USUARIO
                                                WHERE ID_PELICULA = :idPelicula");
        $consulta->bindParam(':idPelicula', $idPelicula);
        $consulta->execute();

        $resultadoConsulta = $consulta->fetchAll();

        $comentarios = [];

        foreach ($resultadoConsulta as $fila) {
            $comentarios[] = $this->filaAComentario($fila); //Push de comentario
        }

        return $comentarios;
    }

    public function insertarComentario($comentario)
    {

        try {
            $conexion = $this->miConector->conectar();

            $consulta = $conexion->prepare("INSERT INTO COMENTARIO(ID_PELICULA, ID_USUARIO, TEXTO_COMENTARIO) VALUES (:idPelicula, :idUsuario, :texto)");

            $consulta->bindParam(':idPelicula', $comentario->getIdPelicula());
            $consulta->bindParam(':idUsuario', $comentario->getUsuario()->getId());
            $consulta->bindParam(':texto', $comentario->getTexto());

            $consulta->execute();
            $id = $this->obenerUltimoId();

            $comentario->setId($id);
        } catch (PDOException $excepcion) {
            $comentario = null;
        }

        return $comentario;

    }

    public function obenerUltimoId()
    {

        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("SELECT MAX(ID_COMENTARIO) FROM COMENTARIO");

        $consulta->execute();

        $resultadoConsulta = $consulta->fetch();

        $id = $resultadoConsulta[0];

        return $id;

    }

    public function borrarComentarioPorId($id)
    {

        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("DELETE FROM COMENTARIO WHERE ID_COMENTARIO=:id");

        $consulta->bindParam(':id', $id);

        return $consulta->execute();
    }

}