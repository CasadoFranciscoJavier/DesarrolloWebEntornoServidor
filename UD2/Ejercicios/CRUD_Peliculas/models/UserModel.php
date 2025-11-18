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
        if (!$fila) return null;

        $user = new User(
            $fila["id"],
            $fila["puntuacion"],
            $fila["usuario_id"],
            $fila["pelicula_id"]
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


    public function obtenerUsuarioPorId($id)
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
