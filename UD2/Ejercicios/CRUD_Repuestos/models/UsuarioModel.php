<?php

require_once "Conector.php";
require_once "Usuario.php";

class UsuarioModel
{
    private $miConector;

    public function __construct()
    {
        $this->miConector = new Conector();
    }

    private function filaUsuario($fila)
    {
        $usuario = null;
        if ($fila) {
            $id = $fila["ID_USUARIO"];
            $nombre = $fila["NOMBRE"];
            $contrasenia = $fila["CONTRASENIA"];
            $rol = $fila["ROL"];

            $usuario = new Usuario($id, $nombre, $contrasenia, $rol);
        }
        return $usuario;
    }

    public function insertarUsuario($usuario)
    {
        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("INSERT INTO USUARIOS (NOMBRE, CONTRASENIA, ROL) VALUES (:nombre, :contrasenia, :rol)");

        $nombre = $usuario->getNombre();
        $contrasenia = $usuario->getContrasenia();
        $rol = "usuario";

        $consulta->bindParam(':nombre', $nombre);
        $consulta->bindParam(':contrasenia', $contrasenia);
        $consulta->bindParam(':rol', $rol);

        return $consulta->execute();
    }

    public function obtenerUsuarioPorNombre($nombre)
    {
        try {
            $conexion = $this->miConector->conectar();

            $consulta = $conexion->prepare("SELECT * FROM USUARIOS WHERE NOMBRE = :nombre");
            $consulta->bindParam(':nombre', $nombre);
            $consulta->execute();

            $resultadoConsulta = $consulta->fetch();

            $usuario = $this->filaUsuario($resultadoConsulta);
        } catch (PDOException $excepcion) {
            $usuario = null;
        }

        return $usuario;
    }

    public function obtenerUsuarioPorId($id)
    {
        try {
            $conexion = $this->miConector->conectar();

            $consulta = $conexion->prepare("SELECT * FROM USUARIOS WHERE ID_USUARIO = :id");
            $consulta->bindParam(':id', $id);
            $consulta->execute();

            $resultadoConsulta = $consulta->fetch();

            $usuario = $this->filaUsuario($resultadoConsulta);
        } catch (PDOException $excepcion) {
            $usuario = null;
        }

        return $usuario;
    }

    public function banearUsuarioPorId($id)
    {
        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("UPDATE USUARIOS SET NOMBRE = :nombre, CONTRASENIA = :contrasenia WHERE ID_USUARIO = :id");

        $nombreBaneado = "usuario_baneado_" . $id;
        $contraseniaBaneada = "0000";

        $consulta->bindParam(':nombre', $nombreBaneado);
        $consulta->bindParam(':contrasenia', $contraseniaBaneada);
        $consulta->bindParam(':id', $id);

        return $consulta->execute();
    }

    public function obtenerUltimoId()
    {
        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("SELECT MAX(ID_USUARIO) FROM USUARIOS");

        $consulta->execute();

        $resultadoConsulta = $consulta->fetch();

        $id = $resultadoConsulta[0];

        return $id;
    }
}
