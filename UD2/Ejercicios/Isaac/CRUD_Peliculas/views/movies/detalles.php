<?php

require_once "../../models/PeliculaModel.php";
require_once "../../models/Usuario.php";
require_once "./navbar.php";

$peliculaModel = new PeliculaModel();

$idPelicula = $_GET["id"];

$pelicula = $peliculaModel->obtenerPeliculaPorId($idPelicula);

$titulo = $pelicula->getTitulo();
$sinopsis = $pelicula->getSinopsis();
$nota = $pelicula->getNota();

echo "<h1>$titulo</h1>";
echo "<h1>Nota media: $nota</h1>";
echo "<p>$sinopsis</p>";

foreach ($pelicula->getComentarios() as $comentario) {
    $nombreUsuarioComenta = $comentario->getUsuario()->getNombre();
    $textoComentario = $comentario->getTexto();

    echo "<li>$nombreUsuarioComenta ha comentado: $textoComentario</li>";
}

?>

<form action="aniadirComentario.php" method="POST">
    <input type="hidden" name="id-pelicula" value="<?php echo $idPelicula ?>">
    <input type="text-area" name="texto-comentario">
    <input type="submit" value="Enviar comentario">
</form>