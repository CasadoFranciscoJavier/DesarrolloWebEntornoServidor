<?php
class Valoracion{

    private $id;
    private $idPelicula;
    private $idUsuario;
    private $nota;

    public function __construct($id, $idPelicula, $idUsuario, $nota) {
        $this->id = $id;
        $this->idPelicula = $idPelicula;
        $this->idUsuario = $idUsuario;
        $this->nota = $nota;
    }

}