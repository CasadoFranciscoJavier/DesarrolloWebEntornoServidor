<?php

require_once "Conector.php";
require_once "Producto.php";

class ProductoModel
{
    private $miConector;

    public function __construct()
    {
        $this->miConector = new Conector();
    }

    private function filaAProducto($fila)
    {

        // TO-DO: si la fila está vacía, la función debe devolver null
        $id = $fila["ID"];
        $nombre = $fila["NOMBRE"];
        $precio = $fila["PRECIO"];

        $producto = new Producto($id, $nombre, $precio);

        return $producto;
    }

    public function obtenerProductoPorId($id)
    {

        try {
            $conexion = $this->miConector->conectar();

            $consulta = $conexion->prepare("SELECT * FROM PRODUCTO WHERE id = :id");
            $consulta->bindParam(':id', $id);
            $consulta->execute();

            $resultadoConsulta = $consulta->fetch();

            $producto = $this->filaAProducto($resultadoConsulta);
        } catch (PDOException $excepcion) {
            $producto = null;
        }

        return $producto;
    }

    public function obtenerTodosProductos()
    {

        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("SELECT * FROM PRODUCTO");
        $consulta->execute();

        $resultadoConsulta = $consulta->fetchAll();

        $productos = [];

        foreach ($resultadoConsulta as $fila) {
            $productos[] = $this->filaAProducto($fila); //Push de producto
        }

        return $productos;
    }

    public function insertarProducto($producto)
    {

        try {
            $conexion = $this->miConector->conectar();

            $consulta = $conexion->prepare("INSERT INTO PRODUCTO(NOMBRE, PRECIO) VALUES (:nombre, :precio)");

            $consulta->bindParam(':nombre', $producto->getNombre());
            $consulta->bindParam(':precio', $producto->getPrecio());

            $consulta->execute();
            $id = $this->obenerUltimoId();

            $producto->setId($id);
        } catch (PDOException $excepcion) {
            $producto = null;
        }

        return $producto;

    }

    public function obenerUltimoId()
    {

        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("SELECT MAX(ID) FROM PRODUCTO");

        $consulta->execute();

        $resultadoConsulta = $consulta->fetch();

        $id = $resultadoConsulta[0];

        return $id;

    }

    public function actualizarProducto($producto)
    {

        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("UPDATE PRODUCTO SET NOMBRE = :nombre, PRECIO = :precio WHERE ID=:id");

        $consulta->bindParam(':nombre', $producto->getNombre());
        $consulta->bindParam(':precio', $producto->getPrecio());
        $consulta->bindParam(':id', $producto->getId());

        return $consulta->execute();
        // TO-DO: que la función devuelva el producto insertado con su nuevo ID

    }

    public function borrarProductoPorId($id)
    {

        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("DELETE FROM PRODUCTO WHERE ID=:id");

        $consulta->bindParam(':id', $id);

        return $consulta->execute();
    }

}