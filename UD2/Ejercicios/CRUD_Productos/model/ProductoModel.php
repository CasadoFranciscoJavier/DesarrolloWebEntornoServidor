<?php
require_once "Producto.php";
require_once __DIR__ . "/../conexion.php";



class ProductoModel
{
    private $conexion;
    private $lista_productos = [];


    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }


  
    public function obtenerTodos() {
        $this->lista_productos = [];

        $stmt = $this->conexion->prepare("SELECT * FROM productos ORDER BY id ASC");
        $stmt->execute();
        $resultado = $stmt->fetchAll();

        foreach ($resultado as $producto) {
            $this->lista_productos[] = new Producto(
                $producto["id"],
                $producto["nombre"],
                $producto["precio"]
            );
        }

        return $this->lista_productos;
    }

  
    public function obtenerPorId($id) {
        $producto = null;

        $stmt = $this->conexion->prepare("SELECT * FROM productos WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $resultado = $stmt->fetch();

        if ($resultado) {
            $producto = new Producto(
                $resultado["id"],
                $resultado["nombre"],
                $resultado["precio"]
            );
        }

        return $producto;
    }


    public function agregar($producto) {
        $resultado = false;

        $nombre = $producto->getNombre();
        $precio = $producto->getPrecio();

        if (!empty($nombre) && $precio > 0) {
            $stmt = $this->conexion->prepare("INSERT INTO productos (nombre, precio) VALUES (:nombre, :precio)");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':precio', $precio);

            if ($stmt->execute()) {
                $resultado = true;
            }
        }

        return $resultado;
    }

  
    public function actualizar($producto) {
        $resultado = false;

        $id = $producto->getId();
        $nombre = $producto->getNombre();
        $precio = $producto->getPrecio();

        if (!empty($nombre) && $precio > 0 && $id != null) {
            $stmt = $this->conexion->prepare("UPDATE productos SET nombre = :nombre, precio = :precio WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':precio', $precio);

            if ($stmt->execute()) {
                $resultado = true;
            }
        }

        return $resultado;
    }

   
    public function eliminar($id) {
        $resultado = false;

        if ($id != null && $id > 0) {
            $stmt = $this->conexion->prepare("DELETE FROM productos WHERE id = :id");
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                $resultado = true;
            }
        }

        return $resultado;
    }
}
