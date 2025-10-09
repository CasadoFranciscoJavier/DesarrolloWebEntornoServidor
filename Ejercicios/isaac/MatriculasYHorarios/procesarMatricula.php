<?php

require_once "horario.php";

function calcularDuracionHoras($horaInicio, $horaFin){
    return (strtotime($horaFin) - strtotime($horaInicio) ) / 3600;
}

function encontrarAsignatura($dia, $horaInicio){
    global $horario;
    $asignatura = "";
    $horaInicio = str_replace(":", "", $horaInicio);

    foreach ($horario as $asignaturaIterada => $horarioAsignatura) {
        if(isset($horarioAsignatura[$dia])){
            $horaInicioAsignatura = str_replace(":", "", $horarioAsignatura[$dia][0]);
            $horaFinAsignatura = str_replace(":", "", $horarioAsignatura[$dia][1]);

            if($horaInicio >= $horaInicioAsignatura && $horaInicio < $horaFinAsignatura){
                $asignatura = $asignaturaIterada;
            }

            if (isset($horarioAsignatura[$dia][2])) {
                $horaInicioAsignatura = str_replace(":", "", $horarioAsignatura[$dia][2]);
                $horaFinAsignatura = str_replace(":", "", $horarioAsignatura[$dia][3]);

                if($horaInicio >= $horaInicioAsignatura && $horaInicio < $horaFinAsignatura){
                    $asignatura = $asignaturaIterada;
                }
            }
        }
    }

    return $asignatura;
}

$asignaturasMatriculadas = $_POST["asignaturas"];
$horasSemanales = 0;

echo "<h1> Tu horario semanal </h1>";

foreach ($asignaturasMatriculadas as $asignatura) {
    echo "La asignatura $asignatura tiene este horario:";

    echo "<ul>";
    
    foreach ($horario[$asignatura] as $dia => $horas) {

        $horaInicio = $horas[0];
        $horaFin = $horas[1];

        $horasSemanales += calcularDuracionHoras($horaInicio, $horaFin);
        
        if(isset($horas[2]) && isset($horas[3])){
            $horaInicio2 = $horas[2]; 
            $horaFin2 = $horas[3]; 

            $horasSemanales += calcularDuracionHoras($horaInicio2, $horaFin2);

            echo "<li>$dia de $horaInicio a $horaFin y de $horaInicio2 a $horaFin2</li>";
        }else{
            echo "<li>$dia de $horaInicio a $horaFin</li>";
        }   
  
    }

    echo "</ul>";
}

echo "<h3> Te has matriculado de $horasSemanales horas a la semana </h3>";

?>

<table border=1>
    <thead>
        <tr>
            <th></th>
            <th>Lunes</th>
            <th>Martes</th>
            <th>Miércoles</th>
            <th>Jueves</th>
            <th>Viernes</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($horasHorario as $hora) {
            $horaInicio = $hora[0];
            $horaFin = $hora[1];

            echo "<tr><td>$horaInicio - $horaFin</td>";

            foreach ($diasSemana as $dia) {
                $asignaturaQueToca = encontrarAsignatura($dia, $horaInicio);
                if(in_array($asignaturaQueToca, $asignaturasMatriculadas)){
                    echo "<td class='$asignaturaQueToca'>$asignaturaQueToca</td>";
                }else{
                    echo "<td class='vacio'></td>";
                }
                
            }

            echo "</tr>";
        }
        ?>
    </tbody>
</table>