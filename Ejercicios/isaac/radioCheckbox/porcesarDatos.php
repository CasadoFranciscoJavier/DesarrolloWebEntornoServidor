   <!-- - Recoger los datos enviados por el formulario.  
   - Mostrar el nombre y apellidos en un título <h1>.  
   - Mostrar la edad, peso, sexo y estado civil en párrafos.  
   - Listar las aficiones seleccionadas en una lista <ul>.   -->

<?php
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $edad = $_POST["edad"];
    $peso = $_POST["peso"];
    $sexo = $_POST["sexo"];
    $estadoCivil = $_POST["estado-civil"];
    $aficiones = $_POST["aficiones"];

    echo "<h1>$nombre $apellidos</h1>";
    echo "<p>Edad: $edad</p>";
    echo "<p>Peso: $peso</p>";
    echo "<p>Sexo: $sexo</p>";
    echo "<p>Estado Civil: $estadoCivil</p>";

    echo "<h2>Aficiones:</h2> <ol>";
    
        foreach ($aficiones as $aficion) {
            echo "<li>$aficion</li>";
        }
    
    echo "</ol>";