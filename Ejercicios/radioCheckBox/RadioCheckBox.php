<?php
print_r ($_POST);

// Función para mostrar alertas en JavaScript 
function alert($text){
    echo "<script> alert('$text') </script>";
}

// Función para validar string 
function validarString($variablePOST, $minimo, $maximo){
    $vacio = empty($_POST[$variablePOST]);
    $valido = false;
    if (!$vacio){
        $valido = (strlen($_POST[$variablePOST]) >= $minimo && strlen($_POST[$variablePOST]) <= $maximo);
    }
    if($vacio){
        alert("$variablePOST está vacío");
    } else if(!$valido){
        alert("$variablePOST fuera de rango (longitud entre $minimo y $maximo)");
    }
    return $valido;
}

// Función para validar número decimal (peso)
function validarFloat($variablePOST, $minimo, $maximo){
    $vacio = empty($_POST[$variablePOST]);
    $valido = false;
    if (!$vacio){
        $esFloat = filter_var($_POST[$variablePOST], FILTER_VALIDATE_FLOAT);
        if($esFloat !== false){
            $valido = ($_POST[$variablePOST] >= $minimo && $_POST[$variablePOST] <= $maximo);
        }
    }
    if($vacio){
        alert("$variablePOST está vacío");
    } else if(!$esFloat){
        alert("$variablePOST debe ser un número decimal");
    } else if(!$valido){
        alert("$variablePOST está fuera de rango ($minimo - $maximo)");
    }
    return $valido;
}

// Función para validar selección (radio/checkBox) 
function validarSeleccion($variablePOST){
    $vacio = empty($_POST[$variablePOST]);
    if($vacio){
        alert("Debes seleccionar $variablePOST");
    }
    return !$vacio;
}

//============================= main //=============================

// Validaciones principales 
$todoValido = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $todoValido = validarString("nombre", 1, 20)
               && validarString("apellido", 1, 20)
               && validarSeleccion("edad")
               && validarFloat("peso", 20, 500)
               && validarSeleccion("sexo")
               && validarSeleccion("estado_civil");
   
    if ($todoValido) {
        $nombre = htmlspecialchars($_POST["nombre"]);
        $apellido = htmlspecialchars($_POST["apellido"]);
        $edad = ($_POST["edad"]);
        $peso = ($_POST["peso"]);
        $sexo = ($_POST["sexo"]);
        $estado_civil = ($_POST["estado_civil"]);
        $aficiones = isset($_POST["aficiones"]) ? $_POST["aficiones"] : "";
        
        if (!empty($aficiones)) {
            $lista_aficiones = "<ul>";
            foreach ($aficiones as $aficion) {
                $lista_aficiones .= "<li>" .($aficion) . "</li>";
            }
            $lista_aficiones .= "</ul>";
        } else {
            $lista_aficiones = "<p>No seleccionaste ninguna afición.</p>";
        }
    }
}else {
    // Si la solicitud no es de tipo POST, muestra una alerta
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
        <p><strong>Edad:</strong> <?php echo $edad; ?></p>
        <p><strong>Peso:</strong> <?php echo $peso; ?> kg</p>
        <p><strong>Sexo:</strong> <?php echo $sexo; ?></p>
        <p><strong>Estado civil:</strong> <?php echo $estado_civil; ?></p>
        <p><strong>Aficiones:</strong></p>
        <?php echo $lista_aficiones; ?>
    </div>
</body>