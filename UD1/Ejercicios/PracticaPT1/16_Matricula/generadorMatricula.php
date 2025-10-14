<?php
require_once "tarifas.php";

// =================================== FUNCIONES DE VALIDACIÓN ===================================

/**
 * Función para mostrar alertas en JavaScript y volver a la página anterior
 */
function alert($text)
{
    echo "<script> 
            alert('$text'); 
            window.history.back();
          </script>";
    exit();
}

/**
 * Valida que un campo POST no esté vacío.
 * @return bool True si es válido.
 */
function validarCampoVacio($variablePOST) {
    $vacio = empty($_POST[$variablePOST]);
    $valido = false;

    if (!$vacio) {
        $valido = true;
    }
    
    if ($vacio) {
        alert("El campo '$variablePOST' está vacío.");
    }
    
    return $valido;
}

/**
 * Valida el formato básico del DNI/NIE.
 * @param string $dni El valor del DNI/NIE.
 * @return bool True si es válido.
 */
function validarDNI($dni) {
    $longitudValida = strlen($dni) == 9;
    $formatoValido = $longitudValida && preg_match('/^[0-9]{8}[A-Z]$/i', $dni);
    $valido = false;

    if ($formatoValido) {
        $valido = true;
    }
    
    if (!$formatoValido) {
        alert("El DNI/NIE '$dni' no tiene el formato correcto (8 números seguidos de una letra mayúscula).");
    }
    
    return $valido;
}

// =================================== LÓGICA PRINCIPAL ===================================

$dni = $_POST['dni'] ?? '';
$nombre = $_POST['nombre'] ?? '';
$curso = $_POST['curso'] ?? '';
$tipoMatricula = $_POST['tipo_matricula'] ?? '';

$todoValido = false;
$nombreCurso = "";
$asignaturasObligatorias = [];
$asignaturasOpcionales = [];

// 1. Validaciones
if (validarCampoVacio('dni') && validarCampoVacio('nombre') && validarCampoVacio('curso') && validarCampoVacio('tipo_matricula')) {
    
    // 2. Validación de formato de DNI
    if (validarDNI($dni)) {
        
        // 3. Validación de que el curso exista en el plan de estudios
        if (isset($planEstudios[$curso])) {
            
            $nombreCurso = $planEstudios[$curso]['nombre_curso'];
            $asignaturasDisponibles = $planEstudios[$curso]['asignaturas'];
            
            // Separar Obligatorias y Opcionales
            foreach ($asignaturasDisponibles as $nombreAsignatura => $datos) {
                if ($datos['tipo'] == 'obligatoria') {
                    // Guardamos el nombre y los créditos
                    $asignaturasObligatorias[$nombreAsignatura] = $datos['creditos'];
                } else {
                    $asignaturasOpcionales[$nombreAsignatura] = $datos['creditos'];
                }
            }
            
            $todoValido = true;
            
        } else {
            alert("El curso seleccionado no está disponible en nuestro plan de estudios.");
        }
    }
}

// =================================== GENERACIÓN DEL FORMULARIO DE SELECCIÓN ===================================

if ($todoValido) {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Paso 2: Selección de Asignaturas</title>
    </head>
    <body>
        <h1>Matrícula en <?php echo htmlspecialchars($nombreCurso); ?></h1>
        <h2>Cliente: <?php echo htmlspecialchars($nombre); ?> (<?php echo htmlspecialchars($dni); ?>)</h2>
        
        <form action="procesarMatricula.php" method="POST">
            <input type="hidden" name="dni" value="<?php echo htmlspecialchars($dni); ?>">
            <input type="hidden" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>">
            <input type="hidden" name="curso" value="<?php echo htmlspecialchars($nombreCurso); ?>">
            <input type="hidden" name="tipo_matricula" value="<?php echo htmlspecialchars($tipoMatricula); ?>">

            <?php foreach ($asignaturasObligatorias as $nombreAsig => $creditos): ?>
                <input type="hidden" name="obligatorias[<?php echo htmlspecialchars($nombreAsig); ?>]" value="<?php echo $creditos; ?>">
            <?php endforeach; ?>

            <h3>Asignaturas Obligatorias (Fijas):</h3>
            <ul>
                <?php foreach ($asignaturasObligatorias as $nombreAsig => $creditos): ?>
                    <li><?php echo htmlspecialchars($nombreAsig); ?> (<?php echo $creditos; ?> Créditos)</li>
                <?php endforeach; ?>
            </ul>
            
            <?php if (!empty($asignaturasOpcionales)): ?>
            <h3>Asignaturas Opcionales (Selecciona las que desees):</h3>
            
            <?php 
                $numOpcionales = count($asignaturasOpcionales);
                echo "<p>Puedes seleccionar hasta $numOpcionales opcionales. **Atención:** Seleccionar más de " . LIMITE_OPCIONALES_RECARGO . " aplica un recargo del " . (RECARGO_EXCESO_OPCIONALES * 100) . "%.</p>";
            ?>
            
            <ul>
                <?php foreach ($asignaturasOpcionales as $nombreAsig => $creditos): ?>
                    <li>
                        <input type="checkbox" name="opcionales[<?php echo htmlspecialchars($nombreAsig); ?>]" value="<?php echo $creditos; ?>">
                        <?php echo htmlspecialchars($nombreAsig); ?> (<?php echo $creditos; ?> Créditos)
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>

            <br>
            <button type="submit">Calcular Presupuesto de Matrícula</button>
        </form>
    </body>
    </html>
<?php
}
?>