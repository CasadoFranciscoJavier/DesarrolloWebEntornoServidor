<?php


// Verificar si la solicitud es de tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Recuperar datos del formulario enviados por tests.php

    // Datos del usuario y del test (campos ocultos)
    $nombre = htmlspecialchars($_POST['nombre'] ?? 'Invitado');
    $apellido = htmlspecialchars($_POST['apellido'] ?? '');
    $asignatura = htmlspecialchars($_POST['asignatura'] ?? 'Desconocida');
    $cantidad_preguntas_test = intval($_POST['cantidad_preguntas_test'] ?? 0);

//     ¿Qué hace ???
// El operador ?? (fusión de null) se utiliza para verificar si una variable (o una expresión) existe y no es null. Si la variable existe y no es null, entonces se usa su valor. Si la variable no existe o es null, entonces se usa el valor que está a la derecha del ??.

// Es un atajo sintáctico para un isset() y un operador ternario, que era una construcción muy común antes de PHP 7.0.

// Equivalencia a código anterior a PHP 7.0
// Antes de PHP 7.0, para lograr el mismo efecto, tendrías que escribir algo como esto:

// PHP

// // Versión anterior a PHP 7.0 para lograr lo mismo
// $cantidad_preguntas_test_raw;
// if (isset($_POST['cantidad_preguntas_test'])) {
//     $cantidad_preguntas_test_raw = $_POST['cantidad_preguntas_test'];
// } else {
//     $cantidad_preguntas_test_raw = 0; // Valor por defecto
// }
// $cantidad_preguntas_test = intval($cantidad_preguntas_test_raw);
// O, usando un operador ternario:

// PHP

// // Versión con operador ternario (antes de PHP 7.0)
// $cantidad_preguntas_test = intval(isset($_POST['cantidad_preguntas_test']) ? $_POST['cantidad_preguntas_test'] : 0);
// Como puedes ver, ?? hace el código mucho más conciso y legible para esta tarea tan común.

    // Inicializar contadores
    $respuestas_correctas = 0;
    $respuestas_incorrectas = 0;
    $preguntas_con_respuesta_del_usuario = 0;

    // Array para almacenar el detalle de cada pregunta (texto, respuesta correcta, respuesta usuario, resultado)
    $detalle_resultados = [];

    // 2. Iterar a través de las preguntas para comparar las respuestas

    // Recorremos hasta la cantidad de preguntas que esperamos del test
    for ($i = 0; $i < $cantidad_preguntas_test; $i++) {
        $nombre_campo_respuesta = 'respuesta_pregunta_' . $i;
        $nombre_campo_pregunta_texto = 'pregunta_' . $i . '_texto';
        $nombre_campo_pregunta_correcta = 'pregunta_' . $i . '_correcta';

        // Obtener la respuesta del usuario para esta pregunta
        // Usamos ?? '' para evitar warnings si la respuesta no existe (ej. no fue seleccionada)
        $respuesta_usuario = $_POST[$nombre_campo_respuesta] ?? null; 
        
        // Obtener el texto de la pregunta y la respuesta correcta que enviamos oculta
        $texto_pregunta = htmlspecialchars($_POST[$nombre_campo_pregunta_texto] ?? 'Pregunta Desconocida');
        $respuesta_correcta = $_POST[$nombre_campo_pregunta_correcta] ?? null;

        $resultado_pregunta = 'No respondida'; // Estado por defecto

        if ($respuesta_usuario !== null) { // Si el usuario SÍ respondió a esta pregunta
            $preguntas_con_respuesta_del_usuario++;
            if ($respuesta_usuario == $respuesta_correcta) {
                $respuestas_correctas++;
                $resultado_pregunta = 'Correcta';
            } else {
                $respuestas_incorrectas++;
                $resultado_pregunta = 'Incorrecta';
            }
        }
        
        // Guardar el detalle para mostrarlo al final
        $detalle_resultados[] = [
            'pregunta' => $texto_pregunta,
            'respuesta_correcta' => $respuesta_correcta,
            'respuesta_usuario' => $respuesta_usuario,
            'resultado' => $resultado_pregunta
        ];
    }

    // 3. Calcular la nota final
    // Si no hubo preguntas o ninguna fue respondida, la nota es 0 para evitar división por cero
    if ($cantidad_preguntas_test > 0) {
        $nota_bruta = ($respuestas_correctas / $cantidad_preguntas_test) * 10;
        $nota_final = round($nota_bruta, 2); // Redondear a dos decimales
    } else {
        $nota_final = 0;
    }

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados del Test de <?php echo $asignatura; ?></title>
    
</head>
<body>
    <div class="contenedor-resultados">
        <h1>Resultados del Test</h1>

        <div class="resumen-test">
            <p><strong>Alumno/a:</strong> <?php echo $nombre . " " . $apellido; ?></p>
            <p><strong>Asignatura:</strong> <?php echo $asignatura; ?></p>
            <p><strong>Preguntas totales:</strong> <?php echo $cantidad_preguntas_test; ?></p>
            <p><strong>Preguntas acertadas:</strong> <span style="color:#28a745; font-weight:bold;"><?php echo $respuestas_correctas; ?></span></p>
            <p><strong>Preguntas falladas:</strong> <span style="color:#dc3545; font-weight:bold;"><?php echo $respuestas_incorrectas; ?></span></p>
            <p><strong>Preguntas no respondidas:</strong> <span style="color:#6c757d; font-weight:bold;"><?php echo $cantidad_preguntas_test - $preguntas_con_respuesta_del_usuario; ?></span></p>
            <div class="nota-final <?php echo ($nota_final < 5) ? 'baja' : ''; ?>">
                Nota final: <?php echo $nota_final; ?> / 10
            </div>
        </div>

        <h2>Detalle de las Preguntas</h2>
        <?php foreach ($detalle_resultados as $num => $detalle) : ?>
            <div class="pregunta-detalle">
                <p class="pregunta-texto">Pregunta <?php echo ($num + 1); ?>: <?php echo $detalle['pregunta']; ?></p>
                <p>Tu respuesta: 
                    <span class="respuesta-usuario">
                        <?php echo ($detalle['respuesta_usuario'] !== null) ? $detalle['respuesta_usuario'] : 'No respondida'; ?>
                    </span>
                </p>
                <p>Respuesta correcta: 
                    <span class="respuesta-correcta">
                        <?php echo $detalle['respuesta_correcta']; ?>
                    </span>
                </p>
                <p class="resultado-label">Resultado: 
                    <span class="
                        <?php 
                            if ($detalle['resultado'] == 'Correcta') echo 'resultado-correcta';
                            else if ($detalle['resultado'] == 'Incorrecta') echo 'resultado-incorrecta';
                            else echo 'resultado-no-respondida';
                        ?>
                    ">
                        <?php echo $detalle['resultado']; ?>
                    </span>
                </p>
            </div>
        <?php endforeach; ?>

        <a href="tests.html" class="volver-btn">Volver al inicio</a>
    </div>
</body>
<style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f0f2f5;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .contenedor-resultados {
            max-width: 800px;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #e0e6ed;
        }
        h1 {
            color: #4a6fa5;
            text-align: center;
            margin-bottom: 25px;
            font-size: 2.2em;
            font-weight: 700;
        }
        .resumen-test {
            text-align: center;
            margin-bottom: 35px;
            padding: 15px;
            border-radius: 8px;
            background-color: #e6f0ff;
            border: 1px solid #c9daed;
        }
        .resumen-test p {
            font-size: 1.1em;
            margin: 8px 0;
            color: #333;
        }
        .resumen-test strong {
            color: #2a4c7e;
        }
        .nota-final {
            font-size: 2.8em;
            font-weight: bold;
            color: #28a745; /* Color para notas aprobatorias */
            margin-top: 20px;
            text-align: center;
            animation: fadeInScale 0.8s ease-out;
        }
        .nota-final.baja {
            color: #dc3545; /* Color para notas bajas */
        }
        .pregunta-detalle {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #eee;
            border-radius: 8px;
            background-color: #fdfdfd;
        }
        .pregunta-detalle p {
            margin: 5px 0;
        }
        .pregunta-detalle .pregunta-texto {
            font-weight: bold;
            color: #4a6fa5;
            font-size: 1.1em;
            margin-bottom: 10px;
        }
        .pregunta-detalle .respuesta-usuario {
            color: #e67e22;
        }
        .pregunta-detalle .respuesta-correcta {
            color: #28a745;
        }
        .pregunta-detalle .resultado-label {
            font-weight: bold;
        }
        .pregunta-detalle .resultado-correcta {
            color: #28a745;
        }
        .pregunta-detalle .resultado-incorrecta {
            color: #dc3545;
        }
        .pregunta-detalle .resultado-no-respondida {
            color: #6c757d;
        }
        .volver-btn {
            display: block;
            width: fit-content;
            margin: 30px auto 10px;
            padding: 12px 25px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 1.1em;
            transition: background-color 0.3s ease;
        }
        .volver-btn:hover {
            background-color: #0056b3;
        }

        /* Animaciones */
        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
</html>

<?php
} else {
    // Si se accede directamente a procesarTest.php sin POST, redirigir al formulario inicial
    header("Location: tests.html");
    exit();
}
?>