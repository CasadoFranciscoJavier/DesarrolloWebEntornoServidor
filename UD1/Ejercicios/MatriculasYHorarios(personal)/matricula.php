<?php
require_once "asignaturas_bd.php"; // seguimos usando asignaturas, siglas, colores y calendario

function alert($text)
{
    echo "<script> alert('$text') </script>";
}

function validarString($variablePOST, $tamanioMinimo, $tamanioMaximo)
{
    $vacio = !isset($_POST[$variablePOST]) || empty($_POST[$variablePOST]);
    $valido = false;

    if (!$vacio) {
        $valido = ((strlen($_POST[$variablePOST]) >= $tamanioMinimo)
            && (strlen($_POST[$variablePOST]) <= $tamanioMaximo));
    }

    if ($vacio) {
        alert("$variablePOST está vacío");
    } else if (!$valido) {
        alert("$variablePOST fuera de rango (longitud entre $tamanioMinimo y $tamanioMaximo)");
    }

    return $valido;
}

// ================================= "main" =================================
$nombre = "";
$apellido = "";
$lista_asignaturas = "<p>Pendiente de datos o matrícula no válida.</p>";
$horario_detallado = "";
$horario_tabla = "";
$total_horas_clase = 0;
$todoEsValido = false;
$asignaturas_seleccionadas = [];

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

            // ================= LISTADO DETALLADO =================
            $horario_detallado .= "<h2>Detalle de Asignaturas</h2>";
            $horario_detallado .= "<ul>";
            foreach ($asignaturas_seleccionadas as $asignatura) {
                $datos_asignatura = $calendarioAsignaturas[$asignatura] ?? null;
                if ($datos_asignatura) {
                    $totalHorasAsignatura = $datos_asignatura['total_horas'];
                    $total_horas_clase += $totalHorasAsignatura;
                    $horario_detallado .= "<li><strong>" . htmlspecialchars($asignatura) . "</strong> (" . $totalHorasAsignatura . " h/sem.)<br>";
                    $horario_detallado .= "<ul>";
                    foreach ($datos_asignatura as $dia => $horarios) {
                        if ($dia !== 'total_horas') {
                            $horario_detallado .= "<li>" . $dia . ": " . implode(" y ", $horarios) . "</li>";
                        }
                    }
                    $horario_detallado .= "</ul></li>";
                }
            }
            $horario_detallado .= "</ul>";
            $horario_detallado .= "<h3>Total de horas semanales: $total_horas_clase h</h3>";

            // ================= TABLA DE HORARIO =================
            $dias_semana = ["LUNES", "MARTES", "MIÉRCOLES", "JUEVES", "VIERNES"];
            $bloques_tiempo = [
                "08:00-08:30",
                "08:30-09:00",
                "09:00-09:30",
                "09:30-10:00",
                "10:00-10:30",
                "10:30-11:00",
                "11:00-11:30",
                "11:30-12:00",
                "12:00-12:30",
                "12:30-13:00",
                "13:00-13:30",
                "13:30-14:00",
                "14:00-14:30",
                "14:30-15:00",
                "15:00-15:30"
            ];

            $recreo_por_dia = [
                "LUNES"      => "10:30-11:00",
                "MARTES"     => "11:00-11:30",
                "MIÉRCOLES"  => "11:00-11:30",
                "JUEVES"     => "10:30-11:00",
                "VIERNES"    => "12:00-12:30",
            ];

            $horario_tabla = "<h2>Horario Semanal</h2>";
            $horario_tabla .= "<table class='horario'>";
            // Encabezado
            $horario_tabla .= "<tr><th>Hora</th>";
            foreach ($dias_semana as $dia) {
                $horario_tabla .= "<th>$dia</th>";
            }
            $horario_tabla .= "</tr>";

            // Filas
            foreach ($bloques_tiempo as $bloque) {
                $horario_tabla .= "<tr>";
                $horario_tabla .= "<td class='hora'>$bloque</td>";

                foreach ($dias_semana as $dia) {
                    $asignaturaCelda = "";
                    $colorCelda = "#fff";

                    // 1) Si este bloque es el recreo de ESTE día, lo marcamos siempre
                    if ($bloque == $recreo_por_dia[$dia]) {
                        $asignaturaCelda = "RECREO";
                        $colorCelda = $coloresAsignaturas["RECREO"];
                    } else {
                        foreach ($asignaturas_seleccionadas as $asignatura) {
                            if (isset($calendarioAsignaturas[$asignatura][$dia])) {
                                foreach ($calendarioAsignaturas[$asignatura][$dia] as $tramo) {

                                    list($ini, $fin) = explode("-", $tramo); // el de la tabla
                                    list($iniBloq, $finBloq) = explode("-", $bloque); // el de la asignatura
                                
                                    // comprobamos si el bloque está dentro del tramo
                                    if ($iniBloq >= $ini && $finBloq <= $fin) {
                                        $sigla = isset($asignaturas_siglas[$asignatura]) ? $asignaturas_siglas[$asignatura] : $asignatura;
                                        $asignaturaCelda = $sigla;
                                        $colorCelda = isset($coloresAsignaturas[$sigla]) ? $coloresAsignaturas[$sigla] : "#FFFFFF";
                                    }
                                }
                            }
                        }
                    }


                    $horario_tabla .= "<td style='background:$colorCelda;font-weight:bold;text-align:center;'>$asignaturaCelda</td>";
                }
                $horario_tabla .= "</tr>";
            }
            $horario_tabla .= "</table>";
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
    <title>Matricula 2º DAW STEM Granada</title>
</head>

<body>
    <div class="contenedor">
        <h1><?php echo $nombre . " " . $apellido; ?></h1>
        <p><strong>Asignaturas matriculadas:</strong></p>
        <?php echo $lista_asignaturas; ?>
        <?php
        if ($todoEsValido && !empty($asignaturas_seleccionadas)) {
            echo $horario_detallado;
            echo $horario_tabla;
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
            max-width: 900px;
            margin: 40px auto;
            padding: 32px;
            border-radius: 14px;
            box-shadow: 0 4px 24px rgba(60, 80, 120, 0.08);
            border: 1px solid #e3e8ee;
        }

        h1,
        h2,
        h3 {
            color: #4a6fa5;
        }

        table.horario {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 0.9em;
            text-align: center;
        }

        table.horario th,
        table.horario td {
            border: 1px solid #ccc;
            padding: 6px;
        }

        table.horario th {
            background: #4a6fa5;
            color: white;
        }

        td.hora {
            font-weight: bold;
            background: #f0f0f0;
        }
    </style>

</html>