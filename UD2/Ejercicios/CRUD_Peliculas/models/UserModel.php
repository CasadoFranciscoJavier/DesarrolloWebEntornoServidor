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

    private function filaUser($fila)
    {
        if (!$fila)
            return null;

        $user = new User(
            $fila["id"],
            $fila["nombre"],
            $fila["contrasenia"],
            $fila["rol"]
        );



        return $user;
    }

    // solo para registrar usuarios normales
    public function insertarUsuario($usuario)
    {
        $conexion = $this->miConector->conectar();

        $sql = "INSERT INTO usuarios (nombre, contrasenia, rol)
                VALUES (:nombre, :contrasenia, :rol)";
        $stmt = $conexion->prepare($sql);

        $stmt->bindParam(':nombre', $usuario->getNombre());
        $stmt->bindParam(':contrasenia', $usuario->getContrasenia());
        $stmt->bindParam(':rol', "usuario");

        return $stmt->execute();
    }


   public function obtenerUsuarioPorNombre($nombre)
{
    try {
        $conexion = $this->miConector->conectar();
        $consulta = $conexion->prepare("SELECT * FROM usuarios WHERE nombre = :nombre");
        $consulta->bindParam(':nombre', $nombre);
        $consulta->execute();

        $fila = $consulta->fetch();

        return $this->filaUser($fila);
    } catch (PDOException $ex) {
        return null;
    }
}


    public function obtenerTodosUsuarios()
    {
        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("SELECT * FROM usuarios");
        $consulta->execute();

        $resultadoConsulta = $consulta->fetchAll();

        $usuarios = [];

        foreach ($resultadoConsulta as $fila) {
            $usuarios[] = $this->filaUser($fila);
        }

        return $usuarios;
    }

    public function banearUsuarioPorId($id)
    {
        $conexion = $this->miConector->conectar();

        $sql = "UPDATE usuarios
                SET nombre = :nombre,
                    contrasenia = :contrasenia,
                WHERE id = :id";
        $stmt = $conexion->prepare($sql);

        $stmt->bindParam(':nombre', "usuario_baneado");
        $stmt->bindParam(':contrasenia', 0000);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }


    public function actualizarUsuario(User $usuario)
    {
        $conexion = $this->miConector->conectar();

        $sql = "UPDATE usuarios
                SET nombre = :nombre,
                    contrasenia = :contrasenia,
                    rol = :rol
                WHERE id = :id";


        $stmt = $conexion->prepare($sql);

        $stmt->bindParam(':nombre', $usuario->getNombre());
        $stmt->bindParam(':contrasenia', $usuario->getContrasenia());
        $stmt->bindParam(':rol', $usuario->getRol());
        $stmt->bindParam(':id', $usuario->getId());

        return $stmt->execute();
    }
}
