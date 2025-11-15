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
        $producto = null;

        if ($fila) {
            $id = $fila["id"];
            $nombre = $fila["nombre"];
            $precio = $fila["precio"];

            $producto = new Producto($id, $nombre, $precio);
        }

        return $producto;
    }

    public function obtenerProductoPorId($id)
    {

        try {
            $conexion = $this->miConector->conectar();

            $consulta = $conexion->prepare("SELECT * FROM productos WHERE id = :id");
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

        $consulta = $conexion->prepare("SELECT * FROM productos");
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

        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("INSERT INTO productos(nombre, precio) VALUES (:nombre, :precio)");
        $nombre = $producto->getNombre();
        $precio = $producto->getPrecio();

        $consulta->bindParam(':nombre', $nombre);
        $consulta->bindParam(':precio', $precio);

        return $consulta->execute();


    }

    public function actualizarProducto($producto)
    {

        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("UPDATE productos SET nombre = :nombre, precio = :precio WHERE id=:id");

        $nombre = $producto->getNombre();
        $precio = $producto->getPrecio();
        $id = $producto->getId();

        $consulta->bindParam(':nombre',$nombre);
        $consulta->bindParam(':precio', $precio);
        $consulta->bindParam(':id', $id);

        return $consulta->execute();

    }

    public function borrarProductoPorId($id)
    {

        $conexion = $this->miConector->conectar();

        $consulta = $conexion->prepare("DELETE FROM productos WHERE id=:id");

        $consulta->bindParam(':id', $id);

        return $consulta->execute();
    }

    public function buscarProductoExistente($nuevoNombre)
    {
        try {
            $conexion = $this->miConector->conectar();

            $consulta = $conexion->prepare("SELECT * FROM productos WHERE nombre = :nombre");
            $consulta->bindParam(':nombre', $nuevoNombre);
            $consulta->execute();

            $resultadoConsulta = $consulta->fetch();

            $producto = $this->filaAProducto($resultadoConsulta);
        } catch (PDOException $excepcion) {
            $producto = null;
        }

        return $producto;


    }




}
