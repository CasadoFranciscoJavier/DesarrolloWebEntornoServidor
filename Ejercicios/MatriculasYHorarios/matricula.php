<?php

// print_r($_POST); 

require_once "asignaturas_bd.php"; // Incluimos la matriz de horarios

function alert($text){
    echo "<script> alert('$text') </script>";
}

function validarString($variablePOST, $tamanioMinimo, $tamanioMaximo){
    
    $vacio = !isset($_POST[$variablePOST]) || empty($_POST[$variablePOST]);
    $valido = false;

    if (!$vacio){
        $valido = ( ( strlen($_POST[$variablePOST]) >= $tamanioMinimo )
                  && ( strlen($_POST[$variablePOST]) <= $tamanioMaximo ) );
    }
    
    if($vacio){
        alert("$variablePOST está vacío");
    } else if(!$valido){
        alert("$variablePOST fuera de rango (longitud entre $tamanioMinimo y $tamanioMaximo)");
    }

    return $valido;
}


// ================================= "main" =================================

$nombre = "";
$apellido = "";
$lista_asignaturas = "<p>Pendiente de datos o matrícula no válida.</p>";
$horario_detallado= ""; // <-- Variable que almacena el HTML del horario
$total_horas_clase = 0;      
$todoEsValido = false; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $todoEsValido = validarString("nombre", 1, 20) 
                  && validarString("apellidos", 1, 20);

    if ($todoEsValido) { 
        $nombre = htmlspecialchars($_POST["nombre"]);
        $apellido = htmlspecialchars($_POST["apellidos"]);
        
        $asignaturas_seleccionadas = isset($_POST["asignatura"]) ? $_POST["asignatura"] : []; 

        if (!empty($asignaturas_seleccionadas)) {
            $lista_asignaturas = "<ol>";
            foreach ($asignaturas_seleccionadas as $asignatura) {
                $lista_asignaturas .= "<li>" . htmlspecialchars($asignatura) . "</li>"; 
            }
            $lista_asignaturas .= "</ol>";

         
            
            // 1. Empezamos a construir el bloque de horario
            $horario_detallado.= "<h2>Horario de Clases</h2>";
            $horario_detallado.= "<ul>";

            foreach ($asignaturas_seleccionadas as $asignatura) {
                $datos_asignatura = $calendarioAsignaturas[$asignatura] ?? null;

                if ($datos_asignatura) {
                    $total_horas_clase += $datos_asignatura['total_horas']; // Acumular Horas Totales
                    
                    // 2. Detalle de la asignatura
                    $horario_detallado.= "<li><strong>" . htmlspecialchars($asignatura) . "</strong> (Total: " . $datos_asignatura['total_horas'] . " h/sem.):<br>";
                    $horario_detallado.= "<ul>";
                    
                    // 3. Recorrer los días y horarios
                    foreach ($datos_asignatura as $dia => $horarios) {
                        if ($dia !== 'total_horas') {
                            $horario_detallado.= "<li>" . $dia . ": " . implode(" y ", $horarios) . "</li>";
                        }
                    }
                    $horario_detallado.= "</ul></li>";
                }
            }
            $horario_detallado.= "</ul>";

            // 4. Mostrar Total de Horas
            $horario_detallado.= "<h3>Total de Horas Semanales de Clase:</h3>";
            $horario_detallado.= "<p><strong>" . $total_horas_clase . " horas</strong></p>";


        } else {
            $lista_asignaturas = "<p>No seleccionaste ninguna asignatura. Matriculación incompleta.</p>";
        }
    }

} else {
    alert("El método usado no es POST");
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Datos personales recibidos</title>
</head>

<body>
    <div class="contenedor">
        <h1><?php echo $nombre . " " . $apellido; ?></h1>
        <p><strong>Asignaturas matriculadas:</strong></p>
        <?php echo $lista_asignaturas; ?>
        
        <?php 
             if ($todoEsValido && !empty($asignaturas_seleccionadas)) {
            echo $horario_detallado;
        }
        ?>
    </div>

    <style>
        body {
            background: #f3f6f9;
            font-family: "Segoe UI", Arial, sans-serif;
            color: #333;
        }

        .contenedor {
            background: #fff;
            max-width: 420px;
            margin: 40px auto;
            padding: 32px 28px 24px 28px;
            border-radius: 14px;
            box-shadow: 0 4px 24px rgba(60, 80, 120, 0.08);
            border: 1px solid #e3e8ee;
        }

        h1 {
            text-align: center;
            color: #4a6fa5;
            margin-bottom: 24px;
            font-weight: 600;
        }
        
        h2 {
             color: #4a6fa5;
             border-bottom: 2px solid #e3e8ee;
             padding-bottom: 5px;
             margin-top: 30px;
        }

        h3 {
            color: #4a6fa5;
            margin-top: 20px;
            font-size: 1.2em;
        }

        label {
            color: #4a6fa5;
            font-weight: 500;
        }

        p {
            margin: 12px 0;
            font-size: 1.08em;
        }

        ul {
            margin-top: 10px;
            margin-bottom: 0;
            padding-left: 22px;
        }

        li {
            margin-bottom: 4px;
        }
    </style>

</html>