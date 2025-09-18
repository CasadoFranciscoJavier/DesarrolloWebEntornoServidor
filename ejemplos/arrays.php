<?php
    $numeros = array(1, 2, 3, 4, 5);
    $letras = array('a', 'b');
    echo $numeros[0];  // Imprime 1
    echo $numeros."<br>";
    print_r($numeros);
    echo count($numeros);
    $concatenar = array_merge($numeros, $letras);
    print_r($concatenar);

    $persona = array("nombre" => "Juan");
    echo isset($persona["nombre"]);

?>