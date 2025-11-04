<?php
class Producto {
 
    public $nombre;
    public $precio;
    

   
    public function __construct($nombre="", $precio=0) {
        $this->nombre = $nombre;
        $this->precio = $precio;
    
    }

      public function getNombre(){
        return $this->nombre;
    }

    public function getPrecio(){
        return $this->precio;
    }

  

}




