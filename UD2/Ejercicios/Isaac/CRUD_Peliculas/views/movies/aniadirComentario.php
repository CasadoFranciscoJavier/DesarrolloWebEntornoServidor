<?php

require_once "../../models/ComentarioModel.php";
require_once "../../models/Usuario.php";
require_once "./navbar.php";

$comentarioModel = new ComentarioModel();

$idPelicula = $_POST["id-pelicula"];
$texto = $_POST["texto-comentario"];

$comentario = new Comentario(null, $idPelicula, $usuario, $texto);

$comentarioModel->insertarComentario($comentario);

header("Location: detalles.php?id=$idPelicula");