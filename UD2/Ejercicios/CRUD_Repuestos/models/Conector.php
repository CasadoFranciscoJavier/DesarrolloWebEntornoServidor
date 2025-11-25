<?php

class Conector
{
    public function conectar()
    {
        try {
            $conexion = new PDO("mysql:host=localhost;dbname=taller_repuestos", "root", "1234");
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $excepcion) {
            echo "Error en la conexión: " . $excepcion->getMessage();
        }
        return $conexion;
    }
}
