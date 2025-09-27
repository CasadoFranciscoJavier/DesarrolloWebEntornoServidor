<!-- Desarrolla un programa que genere tests de práctica con los siguientes requisitos:

tests.html:
Crea un formulario que incluya:

Un menú desplegable para seleccionar la asignatura del test.
Un campo de entrada numérico para indicar la cantidad de preguntas a incluir (máximo 5 preguntas).
tests.php:
Este archivo debe:

Generar un test aleatorio basándose en la asignatura seleccionada y la cantidad de preguntas especificada.
Las preguntas deben extraerse de un repositorio de preguntas predefinido en el código como un map o matriz (10 preguntas disponibles por cada asignatura).
procesarTest.php Este archivo debe:

Procesar las respuestas del usuario a los tests y asignarle una nota del 0 al 10 mostrando la cantidad de preguntas adecrtadas y falladas. -->

<?php
print_r($_POST);

// Función para mostrar alertas en JavaScript 
function alert($text)
{
    echo "<script> alert('$text') </script>";
}




// Función para validar string 
function validarString($variablePOST, $minimo, $maximo) {
 
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
function validarFloat($variablePOST, $minimo)
{
    $vacio = empty($_POST[$variablePOST]);
    $valido = false;
    if (!$vacio) {
        $esFloat = filter_var($_POST[$variablePOST], FILTER_VALIDATE_FLOAT);
        if ($esFloat !== false) {
            $valido = ($_POST[$variablePOST] >= $minimo);
        }
    }
    if ($vacio) {
        alert("$variablePOST está vacío");
    } else if (!$esFloat) {
        alert("$variablePOST debe ser un número decimal");
    } else if (!$valido) {
        echo "<script>
                alert('El $variablePOST está fuera de rango. Debe ser superior a $minimo kg.');
                window.location.href = 'radioCheckBox.html';
            </script>";
        exit;
    }
    return $valido;
}

// Función para validar selección (radio/checkBox) 
function validarSeleccion($variablePOST)
{
    $vacio = empty($_POST[$variablePOST]);
    if ($vacio) {
        alert("Debes seleccionar $variablePOST");
    }
    return !$vacio;
}

//============================= main =============================

// Validaciones principales 
$todoValido = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $todoValido = validarString("nombre", 1, 20)
        && validarString("apellido", 1, 20)
        && validarSeleccion("edad")
        && validarFloat("peso", 0)
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
            $lista_aficiones = "<ol>";
            foreach ($aficiones as $aficion) {
                $lista_aficiones .= "<li>" . ($aficion) . "</li>";
            }
            $lista_aficiones .= "</ol>";
        } else {
            $lista_aficiones = "<p>No seleccionaste ninguna afición.</p>";
        }
    }
} else {
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