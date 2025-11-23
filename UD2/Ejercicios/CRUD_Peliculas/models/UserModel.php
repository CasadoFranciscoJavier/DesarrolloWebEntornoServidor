<?php

require_once "Conector.php";
require_once "User.php";

class UserModel
{
    private $miConector;

    public function __construct()
    {
        $this->miConector = new Conector();
    }

    private function filaUsuario($fila)
    {
        if (!$fila) return null;

        $id = $fila["id"];
        $nombre = $fila["nombre"];
        $contrasenia = $fila["contrasenia"];
        $rol = $fila["rol"];

        $usuario = new User($id, $nombre, $contrasenia, $rol);
        return $usuario;
    }

    public function insertarUsuario($usuario)
    {
        $conexion = $this->miConector->conectar();

        $sql = "INSERT INTO usuarios (nombre, contrasenia, rol)
                VALUES (:nombre, :contrasenia, :rol)";
        $stmt = $conexion->prepare($sql);

        $nombre = $usuario->getNombre();
        $contrasenia = $usuario->getContrasenia();
        $rol = "usuario";

        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':contrasenia', $contrasenia);
        $stmt->bindParam(':rol', $rol);

        return $stmt->execute();
    }


    public function obtenerUsuarioPorNombre($nombre)
    {
        try {
            $conexion = $this->miConector->conectar();

            $consulta = $conexion->prepare("SELECT * FROM usuarios WHERE nombre = :nombre");
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

            $consulta = $conexion->prepare("SELECT * FROM usuarios WHERE id = :id");
            $consulta->bindParam(':id', $id);
            $consulta->execute();

            $resultadoConsulta = $consulta->fetch();

            $usuario = $this->filaUsuario($resultadoConsulta);
        } catch (PDOException $excepcion) {
            $usuario = null;
        }

        return $usuario;
    }


    public function obtenerTodosUsuarios()
    {
        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("SELECT * FROM usuarios");
        $consulta->execute();

        $resultadoConsulta = $consulta->fetchAll();

        $usuarios = [];

        foreach ($resultadoConsulta as $fila) {
            $usuarios[] = $this->filaUsuario($fila);
        }

        return $usuarios;
    }

    public function banearUsuarioPorId($id)
    {
        $conexion = $this->miConector->conectar();

        $sql = "UPDATE usuarios
                SET nombre = :nombre,
                    contrasenia = :contrasenia
                WHERE id = :id";
        $stmt = $conexion->prepare($sql);

        $nombreBaneado = "usuario_baneado_" . $id;
        $contraseniaBaneada = "0000";

        $stmt->bindParam(':nombre', $nombreBaneado);
        $stmt->bindParam(':contrasenia', $contraseniaBaneada);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function actualizarUsuario($usuario)
    {
        $conexion = $this->miConector->conectar();

        $sql = "UPDATE usuarios
                SET nombre = :nombre,
                    contrasenia = :contrasenia,
                    rol = :rol
                WHERE id = :id";

        $stmt = $conexion->prepare($sql);

        $nombre = $usuario->getNombre();
        $contrasenia = $usuario->getContrasenia();
        $rol = $usuario->getRol();
        $id = $usuario->getId();

        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':contrasenia', $contrasenia);
        $stmt->bindParam(':rol', $rol);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function obtenerUltimoId()
    {
       $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("SELECT MAX(id) FROM usuarios");

        $consulta->execute();

        $resultadoConsulta = $consulta->fetch();

        $id = $resultadoConsulta[0];

        return $id;
    }   
}
