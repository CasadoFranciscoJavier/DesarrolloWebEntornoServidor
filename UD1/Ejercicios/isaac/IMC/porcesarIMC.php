<?php
// Crea un programa PHP que reciba los siguientes datos del usuario:
//  - Nombre (máximo 20 carácteres de longitud)
//  - Edad (entero entre 0 y 130)
//  - Altura en cm (entero entre 50 y 300)
//  - Peso en kg (float entre 20 y 500)

// A partir de esos datos, calcula el IMC del usuario.
// El script debe validar el tipo de petición http, que los datos enviados existan y que sean válidos


// Función para mostrar alertas en JavaScript
function alert($text){
    // Imprime un script en JavaScript que muestra una alerta con el texto recibido
    echo "<script> alert('$text') </script>";
}

// Función para validar que un string esté dentro de un rango de longitud
function validarString($variablePOST, $tamanioMinimo, $tamanioMaximo){
    // Verifica si la variable enviada por POST está vacía
    $vacio = empty($_POST[$variablePOST]);
    // Inicializa la variable $valido como false
    $valido = false;

    // Si la variable no está vacía
    if (!$vacio){
        // Verifica si la longitud del string está dentro del rango especificado
        $valido = ( ( strlen($_POST[$variablePOST]) >= $tamanioMinimo )
                 && ( strlen($_POST[$variablePOST]) <= $tamanioMaximo ) );
    }
    
    // Si está vacía, muestra un mensaje de alerta
    if($vacio){
        alert("$variablePOST está vacío");
    } else if(!$valido){
        // Si no está dentro del rango, muestra una alerta con el rango válido
        alert("$variablePOST fuera de rango (longitud entre $tamanioMinimo y $tamanioMaximo)");
    }

    // Devuelvo si es válido o no
    return $valido;
}

// Función para validar que un número entero esté dentro de un rango
function validarInt($variablePOST, $minimo, $maximo){
    // Verifica si la variable enviada por POST está vacía
    $vacio = empty($_POST[$variablePOST]);
    // Inicializa la variable $valido como false
    $valido = false;

    // Si la variable no está vacía
    if (!$vacio){
        // Valida que el valor recibido sea un entero
        $esEntero = filter_var($_POST[$variablePOST], FILTER_VALIDATE_INT);

        // Si es entero, verifica que esté dentro del rango especificado
        if($esEntero){
            $valido = ( ($_POST[$variablePOST] >= $minimo )
                 && ($_POST[$variablePOST] <= $maximo ) );
        }
    }
    
    // Si está vacía, muestra un mensaje de alerta
    if($vacio){
        alert("$variablePOST está vacío");
    } else if(!$esEntero){
        // Si no es entero, muestra una alerta
        alert("$variablePOST debe ser un número entero");
    } else if(!$valido){
        // Si no está dentro del rango, muestra una alerta con el rango válido
        alert("$variablePOST fuera de rango (entre $minimo y $maximo)");
    }

    // Devuelvo si es válido o no
    return $valido;
}

// Función para validar que un número decimal (float) esté dentro de un rango
function validarFloat($variablePOST, $minimo, $maximo){
    // Verifica si la variable enviada por POST está vacía
    $vacio = empty($_POST[$variablePOST]);
    // Inicializa la variable $valido como false
    $valido = false;

    // Si la variable no está vacía
    if (!$vacio){
        // Valida que el valor recibido sea un número decimal (float)
        $esFloat = filter_var($_POST[$variablePOST], FILTER_VALIDATE_FLOAT);

        // Si es float, verifica que esté dentro del rango especificado
        if($esFloat){
            $valido = ( ($_POST[$variablePOST] >= $minimo )
                 && ($_POST[$variablePOST] <= $maximo ) );
        }
    }
    
    // Si está vacía, muestra un mensaje de alerta
    if($vacio){
        alert("$variablePOST está vacío");
    } else if(!$esFloat){
        // Si no es un número decimal, muestra una alerta
        alert("$variablePOST debe ser un número decimal");
    } else if(!$valido){
        // Si no está dentro del rango, muestra una alerta con el rango válido
        alert("$variablePOST fuera de rango (entre $minimo y $maximo)");
    }

    // Devuelvo si es válido o no
    return $valido;
}

// ================================= "main" =================================

// Verifica si la solicitud es de tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Valida todos los campos requeridos: nombre, edad, altura y peso
    $todoEsValido = validarString("nombre", 1, 20) 
                 && validarInt("edad", 0, 130)
                 && validarInt("altura", 50, 300)
                 && validarFloat("peso", 20, 500);

    // Si todas las validaciones son correctas
    if($todoEsValido){
        // Escapa caracteres especiales en el nombre para evitar vulnerabilidades XSS
        $nombre = htmlspecialchars($_POST["nombre"]);
        // Asigna la edad recibida del formulario
        $edad = $_POST["edad"];
        // Convierte la altura de centímetros a metros
        $altura = $_POST["altura"] / 100;
        // Asigna el peso recibido del formulario
        $peso = $_POST["peso"];

        // Calcula el Índice de Masa Corporal (IMC)
        $IMC = round( $peso / ($altura * $altura) , 2);

        // Muestra el resultado del IMC
        echo "Tu IMC es $IMC";
    }

} else {
    // Si la solicitud no es de tipo POST, muestra una alerta
    alert("El método usado no es POST");
}