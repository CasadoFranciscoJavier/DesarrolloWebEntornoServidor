<?php

require_once "repositorioPreguntas.php";

// Función para mostrar alertas y redirigir al formulario
function mostrarMensaje($texto) {
    echo "<script>alert('$texto');</script>";
    echo "<script>window.location.href = 'generadorDeTests.html';</script>";
}

// Obtener valores del formulario
$nombreAsignatura = $_POST['asignatura'];
$cantidadPreguntas = $_POST['numeroDePreguntas'];

// Validar datos del formulario
if (empty($nombreAsignatura) || empty($cantidadPreguntas)) {
    mostrarMensaje('Faltan datos del formulario. Por favor, completa todos los campos.');
} elseif ($nombreAsignatura !== 'matematicas' && $nombreAsignatura !== 'historia' && $nombreAsignatura !== 'ciencias') {
    mostrarMensaje('Asignatura no válida. Por favor, selecciona una asignatura válida.');
} elseif ($cantidadPreguntas < 1 || $cantidadPreguntas > 5) {
    mostrarMensaje('Número de preguntas inválido. Por favor, ingresa un valor entre 1 y 5.');
} else {
    // Generar el test si las validaciones son correctas
    $arrayPreguntas = $repositorioPreguntas[$nombreAsignatura];
    $preguntasSeleccionadas = array_rand($arrayPreguntas, $cantidadPreguntas); // array_rand solo selecciona claves. Devuelve un array de claves.

    // Generar el test en formato HTML
    ?>

    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Document</title>
    </head>
    <body>

        <?php echo "<h1>Preguntas de la asugnatura: $nombreAsignatura</h1>" ?>

        <form action="comprobarTest.php" method="POST">

            <?php

                echo "<input type='hidden' name='asignatura' value='$nombreAsignatura'>";

                foreach ($preguntasSeleccionadas as $pregunta) {
                    echo "<h2>$pregunta</h2>";

                    $respuestas = $repositorioPreguntas[$nombreAsignatura][$pregunta];
                    foreach ($respuestas as $respuesta) {
                        echo "<label>
                                <input type='radio' name='$pregunta' value='$respuesta'>
                                $respuesta
                             </label> <br>";
                    }
                }

            ?>

        <input type="submit">
            
        </form>
        
    </body>
    </html>

    <?php

}