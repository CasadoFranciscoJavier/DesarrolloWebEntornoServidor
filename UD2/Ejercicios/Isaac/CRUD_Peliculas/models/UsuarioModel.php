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

    public function filaAUsuario($fila)
    {
        $usuario = null;

        if($fila){
            $id = $fila["ID_USUARIO"];
            $nombre = $fila["NOMBRE"];
            $email = $fila["EMAIL"];
            $password = $fila["PASS"];
            $rol = $fila["ROL"];

            $usuario = new Usuario($id, $nombre, $email, $password, $rol);
        }
        
        return $usuario;
    }

    public function hacerLogin($email, $password)
    {

        try {
            $conexion = $this->miConector->conectar();

            $consulta = $conexion->prepare("SELECT * FROM USUARIO WHERE EMAIL = :email AND PASS = :pass");
            $consulta->bindParam(':email', $email);
            $consulta->bindParam(':pass', $password);
            $consulta->execute();

            $resultadoConsulta = $consulta->fetch();

            $usuario = $this->filaAUsuario($resultadoConsulta);
        } catch (PDOException $excepcion) {
            $usuario = null;
        }

        return $usuario;
    }

    public function obtenerUsuarioPorId($id)
    {

        try {
            $conexion = $this->miConector->conectar();

            $consulta = $conexion->prepare("SELECT * FROM USUARIO WHERE ID_USUARIO = :id");
            $consulta->bindParam(':id', $id);
            $consulta->execute();

            $resultadoConsulta = $consulta->fetch();

            $usuario = $this->filaAUsuario($resultadoConsulta);
        } catch (PDOException $excepcion) {
            $usuario = null;
        }

        return $usuario;
    }

    public function obtenerTodosUsuarios()
    {

        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("SELECT * FROM USUARIO");
        $consulta->execute();

        $resultadoConsulta = $consulta->fetchAll();

        $usuarios = [];

        foreach ($resultadoConsulta as $fila) {
            $usuarios[] = $this->filaAUsuario($fila); //Push de usuario
        }

        return $usuarios;
    }

    public function insertarUsuario($usuario)
    {

        try {
            $conexion = $this->miConector->conectar();

            $consulta = $conexion->prepare("INSERT INTO USUARIO(NOMBRE, EMAIL, PASS) VALUES (:nombre, :email, :pass)");

            $consulta->bindParam(':nombre', $usuario->getNombre());
            $consulta->bindParam(':email', $usuario->getEmail());
            $consulta->bindParam(':pass', $usuario->getPassword());

            $consulta->execute();
            $id = $this->obenerUltimoId();

            $usuario->setId($id);
        } catch (PDOException $excepcion) {
            $usuario = null;
        }

        return $usuario;

    }

    public function obenerUltimoId()
    {

        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("SELECT MAX(ID_USUARIO) FROM USUARIO");

        $consulta->execute();

        $resultadoConsulta = $consulta->fetch();

        $id = $resultadoConsulta[0];

        return $id;

    }

    public function actualizarUsuario($usuario)
    {

        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("UPDATE USUARIO SET NOMBRE = :nombre, EMAIL = :email,  PASS = :pass WHERE ID_USUARIO=:id");

        $consulta->bindParam(':nombre', $usuario->getNombre());
        $consulta->bindParam(':email', $usuario->getEmail());
        $consulta->bindParam(':pass', $usuario->getPassword());
        $consulta->bindParam(':id', $usuario->getId());

        return $consulta->execute();

    }

    public function borrarUsuarioPorId($id)
    {

        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("DELETE FROM USUARIO WHERE ID_USUARIO=:id");

        $consulta->bindParam(':id', $id);

        return $consulta->execute();
    }

}