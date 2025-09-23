<?php

function esSaludableMensaje($imc) {
    $mensaje = "";
    if ($imc >= 18.5 && $imc <= 24.9) {
        $mensaje = "qué envidia, pero no te lo creas demasiado.";
    } elseif ($imc < 18.5) {
        $mensaje = "tienes menos carne que un lápiz.";
    } elseif ($imc >= 25 && $imc <= 29.9) {
        $mensaje = "tienes menos cuello que un muñeco de nieve.";
    } else {
        $mensaje = "tienes tu propio campo gravitacional, ¡Enhorabuena!";
    }

    return $mensaje;
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET["nombre"], $_GET["edad"], $_GET["altura"], $_GET["peso"])) {
        $nombre = $_GET["nombre"];
        $edad   = (int) $_GET["edad"];
        $altura = (int) $_GET["altura"];
        $peso   = (float) $_GET["peso"];

        if ($edad >= 0 && $edad <= 130 && $altura >= 50 && $altura <= 300 && $peso >= 20 && $peso <= 500) {
            $altura_m = $altura / 100;
            $imc = $peso / ($altura_m * $altura_m);
            $puls_max = 220 - $edad;

            echo "Hola $nombre!<br>";
            echo "Tienes $edad años, mides $altura cm y pesas $peso kg.<br>";
            echo "Tu IMC es " . number_format($imc, 2) . ", " . esSaludableMensaje($imc) . "<br>";
            echo "Tus pulsaciones máximas son $puls_max.";
        } else {
            echo "❌ Algún dato está fuera de los rangos permitidos.";
        }
    } else {
        echo "❌ Faltan datos en la petición.";
    }
} 
?>
