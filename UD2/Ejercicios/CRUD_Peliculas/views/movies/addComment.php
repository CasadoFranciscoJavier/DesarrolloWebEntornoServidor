<?php

require_once "../../models/CommentModel.php";
require_once "../../models/Comment.php";
require_once "./navbar.php";

$comentarioModel = new CommentModel();

$idPelicula = $_POST["id-pelicula"];
$contenido = $_POST["contenido-comentario"];
$idUsuario = $usuario->getId();

$comentario = new Comment(null, $contenido, $idUsuario, $idPelicula);

$comentarioModel->insertarComentario($comentario);

header("Location: detail.php?id=$idPelicula");
