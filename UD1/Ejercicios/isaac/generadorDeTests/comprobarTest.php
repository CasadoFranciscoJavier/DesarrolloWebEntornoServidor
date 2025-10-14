<?php

    require_once "repositorioPreguntas.php";

    function comprobarRespuesta($asignatura, $pregunta, $respuesta){
        global $repositorioRespuestas;
        return $repositorioRespuestas[$asignatura][$pregunta] == $respuesta;
    }

    $asignatura = $_POST["asignatura"];
    unset($_POST["asignatura"]);

    $acertadas = 0;
    $cantidadPreguntas = count($_POST);

    foreach ($_POST as $pregunta => $respuesta) {
       $preguntaSin_ = str_replace("_", " ", $pregunta);
       $acertadas += comprobarRespuesta($asignatura, $preguntaSin_, $respuesta);
    }

    $falladas = $cantidadPreguntas - $acertadas;
    $nota = ($acertadas / $cantidadPreguntas) * 10;
    
    echo "Has acertado $acertadas preguntas, has fallado $falladas preguntas y has sacado un $nota";