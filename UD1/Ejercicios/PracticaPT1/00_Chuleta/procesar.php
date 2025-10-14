<?php
// ================================= FUNCIONES BÁSICAS =================================

function alert($text){
    // Imprime un script en JavaScript que muestra una alerta con el texto recibido
 echo "<script> 
            alert('$text'); 
            window.location.href = 'formulario.html'; 
          </script>";
    }

function validarCampoVacio($variablePOST){
    $vacio = empty($_POST[$variablePOST]);

    if($vacio){
        alert("El campo '$variablePOST' está vacío o no se seleccionó");
    }

    return !$vacio;
}

function validarString($variablePOST, $tamanioMinimo, $tamanioMaximo){
    if (!validarCampoVacio($variablePOST)) {
        return false;
    }

    $valor = $_POST[$variablePOST];
    $valido = false;

    $valido = ( ( strlen($valor) >= $tamanioMinimo )
             && ( strlen($valor) <= $tamanioMaximo ) );
    
    if(!$valido){
        alert("'$variablePOST' fuera de rango (longitud entre $tamanioMinimo y $tamanioMaximo)");
    }

    // Devuelvo si es válido o no
    return $valido;
}

function validarDNI($dni)
{
    $vacio = empty($_POST["dni"]);
    $valido = false;

    if (!$vacio) {
        // Verificar que tiene exactamente 9 caracteres
        if (strlen($dni) == 9) {
            // Los primeros 8 deben ser números y el último una letra
            $numeros = substr($dni, 0, 8);
            $letra = substr($dni, 8, 1);

            $valido = is_numeric($numeros) && ctype_alpha($letra);
        }
    }

    if ($vacio) {
        alert("DNI está vacío");
    } else if (!$valido) {
        alert("DNI no válido (debe tener 8 dígitos + 1 letra)");
    }
    return $valido;
}

function validarFecha($variablePOST) {
    // 1. Verificar si el campo está vacío
    if (!isset($_POST[$variablePOST]) || empty($_POST[$variablePOST])) {
        alert("El campo '$variablePOST' está vacío.");
        return false;
    }

    $fecha = $_POST[$variablePOST];
    $valido = false;

    if (strtotime($fecha) !== false) {
        $valido = true;
    }

    if (!$valido) {
        alert("El valor de '$variablePOST' ('$fecha') no es una fecha válida o el formato es incorrecto.");
    }
    
    return $valido;
}

function validarInt($variablePOST, $minimo, $maximo){
    if (!validarCampoVacio($variablePOST)) {
        return false;
    }

    $valor = $_POST[$variablePOST];
    $valido = false;
    $esEntero = filter_var($valor, FILTER_VALIDATE_INT);

    if($esEntero){
        $valido = ( ($valor >= $minimo ) && ($valor <= $maximo ) );
    }
    
    if(!$esEntero){
        alert("'$variablePOST' debe ser un número entero");
    } else if(!$valido){
        alert("'$variablePOST' fuera de rango (entre $minimo y $maximo)");
    }

    return $valido;
}

// Función para validar que un número decimal (float) esté dentro de un rango y sea válido
function validarFloat($variablePOST, $minimo, $maximo){
    if (!validarCampoVacio($variablePOST)) {
        return false;
    }

    $valor = $_POST[$variablePOST];
    $valido = false;
    
    // FILTER_VALIDATE_FLOAT acepta números con punto (.) o coma (,) si se usa FILTER_FLAG_ALLOW_THOUSAND, pero lo dejaremos simple.
    $esFloat = filter_var($valor, FILTER_VALIDATE_FLOAT); 

    if($esFloat){
        $valido = ( ($valor >= $minimo ) && ($valor <= $maximo ) );
    }
    
    if(!$esFloat){
        alert("'$variablePOST' debe ser un número decimal (float)");
    } else if(!$valido){
        alert("'$variablePOST' fuera de rango (entre $minimo y $maximo)");
    }

    return $valido;
}

// ================================= FUNCIONES DE VALIDACIÓN ESPECÍFICAS =================================

// Función para validar campos de correo electrónico
function validarEmail($variablePOST){
    if (!validarCampoVacio($variablePOST)) {
        return false;
    }

    $valor = $_POST[$variablePOST];
    
    // Usa filter_var para validar el formato estándar de correo
    $valido = filter_var($valor, FILTER_VALIDATE_EMAIL);

    if(!$valido){
        alert("'$variablePOST' no tiene un formato de correo electrónico válido.");
    }

    return $valido;
}

// Función para validar contraseña (usamos longitud mínima)
function validarPassword($variablePOST, $tamanioMinimo){
    if (!validarCampoVacio($variablePOST)) {
        return false;
    }
    
    $valor = $_POST[$variablePOST];
    $longitud = strlen($valor);
    $valido = ($longitud >= $tamanioMinimo);

    if(!$valido){
        alert("'$variablePOST' debe tener al menos $tamanioMinimo caracteres. Actual: $longitud");
    }

    // Opcionalmente se puede añadir:
    // $contieneNumero = preg_match('/\d/', $valor);
    // $contieneMayuscula = preg_match('/[A-Z]/', $valor);
    // if (!$contieneNumero || !$contieneMayuscula) { alert("La clave debe tener mayúsculas y números"); return false; }

    return $valido;
}

// Función para validar que al menos un checkbox de un grupo fue marcado
function validarCheckbox($variablePOST){
    // Los checkbox se envían como un array. Si el array está vacío, no se seleccionó nada.
    $vacio = empty($_POST[$variablePOST]) || !is_array($_POST[$variablePOST]);

    if($vacio){
        alert("Debe seleccionar al menos un elemento de '$variablePOST'.");
    }

    // Devuelve true si no está vacío, false si está vacío
    return !$vacio;
}

// ================================= "main" - LÓGICA DE PROCESAMIENTO =================================

// Verifica si la solicitud es de tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Validar los campos de TIPO DE SELECCIÓN (radio, checkbox, select)
    $radioValido = validarCampoVacio("procesador"); // Verifica que se haya seleccionado un radio
    $checkboxValido = validarCheckbox("accesorios"); // Verifica que se haya seleccionado al menos 1 checkbox
    $selectValido = validarCampoVacio("sistema_operativo"); // Verifica que se haya seleccionado un option (o el primero por defecto)

    // 2. Validar los campos de TEXTO y NÚMEROS
    $nombreValido = validarString("nombre_cliente", 3, 50);
    $enteroValido = validarInt("cantidad_entera", 1, 100);
    // Validamos el decimal con un rango, por ejemplo, entre 0.1 y 10.0
    $decimalValido = validarFloat("version_decimal", 0.1, 10.0);
    $emailValido = validarEmail("email_contacto");
    $passwordValido = validarPassword("clave_secreta", 8); // Mínimo 8 caracteres

    // 3. Validar otros campos (textarea, date, etc. solo verificamos que no estén vacíos)
    $textareaValido = validarCampoVacio("notas_largas");
    $fechaValida = validarCampoVacio("fecha_solicitud"); // Podríamos añadir validación de formato, pero lo dejamos simple.

    // Comprueba que TODAS las validaciones sean correctas
    $todoEsValido = $radioValido && $checkboxValido && $selectValido 
                 && $nombreValido && $enteroValido && $decimalValido 
                 && $emailValido && $passwordValido 
                 && $textareaValido && $fechaValida;

    // Si todas las validaciones son correctas
    if($todoEsValido){
        echo "<h2>¡Validación Exitosa!</h2>";
        echo "<p>Todos los datos son válidos y listos para procesar:</p>";
        
        // Ejemplo de cómo acceder y mostrar los datos:
        echo "<ul>";
        echo "<li>Procesador Seleccionado: <b>" . htmlspecialchars($_POST["procesador"]) . "</b></li>";
        echo "<li>Nombre del Cliente: <b>" . htmlspecialchars($_POST["nombre_cliente"]) . "</b></li>";
        echo "<li>Email: <b>" . htmlspecialchars($_POST["email_contacto"]) . "</b></li>";
        echo "<li>Accesorios Seleccionados: <b>" . implode(", ", array_map('htmlspecialchars', $_POST["accesorios"])) . "</b></li>";
        echo "<li>Versión Decimal: <b>" . htmlspecialchars($_POST["version_decimal"]) . "</b></li>";
        echo "</ul>";

        // Aquí iría el código para guardar en base de datos, calcular el precio final, enviar un email, etc.

    } else {
        echo "<h2>Error de Validación</h2>";
        echo "<p>Por favor, revisa los mensajes de alerta para corregir los datos enviados.</p>";
    }

} else {
    // Si la solicitud no es de tipo POST, muestra una alerta
    alert("El método usado no es POST. Por favor, envía el formulario.");
}
?>