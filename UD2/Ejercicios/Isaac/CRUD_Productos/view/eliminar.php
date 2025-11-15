<?php

if (isset($_GET["id"])) {

    require_once "../model/ProductoModel.php";
    require_once "../model/Producto.php";

    $productoModel = new ProductoModel();

    $id = $_GET["id"];

    $productoModel->borrarProductoPorId($id);

}

header("Location: ../index.php");