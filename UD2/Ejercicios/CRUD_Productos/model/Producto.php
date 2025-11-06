<?php
class Producto
{
    private $id;
    private $nombre;
    private $precio;

    public function __construct($id, $nombre, $precio)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->precio = $precio;
    }

 
    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getPrecio()
    {
        return $this->precio;
    }


  
  

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }

   
    public function __toString()
    {
        return "ID: {$this->id}, Nombre: {$this->nombre}, Precio: {$this->precio}";
    }
}
?>
