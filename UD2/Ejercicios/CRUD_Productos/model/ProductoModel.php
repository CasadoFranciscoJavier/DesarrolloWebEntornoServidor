<?php
require_once "Producto.php";

try {
    // Crear una nueva conexión PDO
    $conexion = new PDO("mysql:host=localhost;dbname=tienda", "root", "1234");
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conexión exitosa <br>";
} catch (PDOException $e) {
    echo "Error en la conexión: " . $e->getMessage();
}

// Preparar la consulta
$stmt = $conexion->prepare("SELECT * FROM productos");
$stmt->execute();

// Recuperar los resultados
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);



class ProductoModel
{
    private $producto;
    private $lista_productos = [];


    public function __construct()
    {
        $this->producto = new Producto;
    }


    public function obtenerTodos() {}

    public function obtenerPorId($id) {}

    public function agregar($producto) {}


    public function actualizar($producto) {}

    public function eliminar($producto) {}
}
