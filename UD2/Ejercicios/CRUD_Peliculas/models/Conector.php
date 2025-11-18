<?php

class Conector
{

    public function conectar(){

        try {
            $conexion = new PDO("mysql:host=localhost;dbname=tienda", "root", "1234");
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            echo "Error en la conexión: " . $e->getMessage();
        }

        return $conexion;

    }


}
