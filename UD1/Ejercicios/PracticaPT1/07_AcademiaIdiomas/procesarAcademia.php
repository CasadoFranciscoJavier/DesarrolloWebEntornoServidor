<?php
require_once "bbddAcademia.php";

function alert($text)
{
    echo "<script> alert('$text');window.location.href = 'academia.html'; </script>";
}

// Funci�n para validar string
function validarString($variablePOST, $minimo, $maximo)
{
    $vacio = empty($_POST[$variablePOST]);
    $valido = false;
    if (!$vacio) {
        $valido = (strlen($_POST[$variablePOST]) >= $minimo && strlen($_POST[$variablePOST]) <= $maximo);
    }
    if ($vacio) {
        alert("$variablePOST est� vac�o");
    } else if (!$valido) {
        alert("$variablePOST fuera de rango (longitud entre $minimo y $maximo)");
    }
    return $valido;
}

// Funci�n para validar DNI
function validarDNI($dni)
{
    $vacio = empty($_POST["dni"]);
    $valido = false;

    if (!$vacio) {
        if (strlen($dni) == 9) {
            $numeros = substr($dni, 0, 8);
            $letra = substr($dni, 8, 1);

            $valido = is_numeric($numeros) && ctype_alpha($letra);
        }
    }

    if ($vacio) {
        alert("DNI est� vac�o");
    } else if (!$valido) {
        alert("DNI no v�lido (debe tener 8 d�gitos + 1 letra)");
    }
    return $valido;
}

// Funci�n para validar selecci�n
function validarSeleccion($variablePOST)
{
    $vacio = empty($_POST[$variablePOST]);
    if ($vacio) {
        alert("Debes seleccionar $variablePOST");
    }
    return !$vacio;
}

//============================= main =============================

$todoValido = false;
$precioCurso = 0;
$precioMateriales = 0;
$subtotal = 0;
$descuentoAplicado = 0;
$totalConDescuento = 0;
$IVA_PORCENTAJE = 0.10;
$totalIVA = 0;
$precioFinal = 0;
$mensajeDescuento = "";
$lista_materiales = "";
$descuentoTasa = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $todoValido = validarString("nombre", 2, 30)
        && validarString("apellidos", 2, 40)
        && validarDNI($_POST["dni"])
        && validarSeleccion("curso")
        && validarSeleccion("nivel")
        && validarSeleccion("modalidad");

    if ($todoValido) {
        $nombre = htmlspecialchars($_POST["nombre"]);
        $apellidos = htmlspecialchars($_POST["apellidos"]);
        $dni = htmlspecialchars($_POST["dni"]);
        $curso = $_POST["curso"];
        $nivel = $_POST["nivel"];
        $modalidad = $_POST["modalidad"];

        $codigoPromoIngresado = isset($_POST["codigo"]) ? $_POST["codigo"] : "";
        $materialesSeleccionados = isset($_POST["materiales"]) ? $_POST["materiales"] : [];

        // Calcular precios
        $precioBaseCurso = $cursos[$curso];
        $multiplicadorNivel = $niveles[$nivel];
        $multiplicadorModalidad = $modalidades[$modalidad];
        $precioCurso = $precioBaseCurso * $multiplicadorNivel * $multiplicadorModalidad;

        // Procesar materiales
        $precioMateriales = 0;
        if (!empty($materialesSeleccionados) && is_array($materialesSeleccionados)) {
            $lista_materiales .= "<ul>";
            foreach ($materialesSeleccionados as $material) {
                $precioMaterial = $materiales[$material];
                $precioMateriales += $precioMaterial;
                $lista_materiales .= "<li>" . htmlspecialchars($material) . " - " . $precioMaterial . " �</li>";
            }
            $lista_materiales .= "</ul>";
        } else {
            $lista_materiales = "<p>No seleccionaste ning�n material.</p>";
        }

        // Procesar c�digo de promoci�n
        if (!empty($codigoPromoIngresado)) {
            if (array_key_exists($codigoPromoIngresado, $codigos)) {
                $descuentoPorcentaje = $codigos[$codigoPromoIngresado];
                $descuentoTasa = $descuentoPorcentaje / 100;
                $mensajeDescuento = "C�digo Promoci�n: <b>" . htmlspecialchars($codigoPromoIngresado) . "</b> (" . $descuentoPorcentaje . "% aplicado)";
            } else {
                $mensajeDescuento = "C�digo Promoci�n: No v�lido";
                $descuentoTasa = 0;
            }
        } else {
            $mensajeDescuento = "C�digo Promoci�n: No ingresado";
        }

        // Calcular totales
        $subtotal = $precioCurso + $precioMateriales;
        $descuentoAplicado = $subtotal * $descuentoTasa;
        $totalConDescuento = $subtotal - $descuentoAplicado;
        $totalIVA = $totalConDescuento * $IVA_PORCENTAJE;
        $precioFinal = $totalConDescuento + $totalIVA;
    }
} else {
    alert("M�todo de solicitud no v�lido");
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen de Matr�cula - Academia</title>
</head>

<body>
    <div class="contenedor">
        <h1>ACADEMIA DE IDIOMAS - RESUMEN DE MATR�CULA</h1>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && $todoValido): ?>

            <h2>Datos del Estudiante</h2>
            <p><strong>Nombre Completo:</strong> <?php echo $nombre . " " . $apellidos; ?></p>
            <p><strong>DNI:</strong> <?php echo $dni; ?></p>

            <h2>Curso Seleccionado</h2>
            <p><strong>Idioma:</strong> <?php echo htmlspecialchars($curso); ?></p>
            <p><strong>Nivel:</strong> <?php echo htmlspecialchars($nivel); ?></p>
            <p><strong>Modalidad:</strong> <?php echo htmlspecialchars($modalidad); ?></p>
            <p><strong>Coste curso:</strong> <?php echo number_format($precioCurso, 2); ?> � (<?php echo $precioBaseCurso; ?> � � <?php echo $multiplicadorNivel; ?> � <?php echo $multiplicadorModalidad; ?>)</p>

            <h2>Materiales</h2>
            <?php echo $lista_materiales; ?>
            <?php if ($precioMateriales > 0): ?>
                <p><strong>Total materiales:</strong> <?php echo $precioMateriales; ?> �</p>
            <?php endif; ?>

            <h2>Resumen de Costes</h2>
            <ul>
                <li><strong>Curso:</strong> <?php echo number_format($precioCurso, 2); ?> �</li>
                <li><strong>Materiales:</strong> <?php echo $precioMateriales; ?> �</li>
                <li><strong>Subtotal:</strong> <?php echo number_format($subtotal, 2); ?> �</li>
            </ul>

            <div class="total-line">
                <p><?php echo $mensajeDescuento; ?></p>
                <?php if ($descuentoTasa > 0): ?>
                    <ul>
                        <li><strong>Descuento:</strong> - <?php echo number_format($descuentoAplicado, 2); ?> �</li>
                        <li><strong>Total con descuento:</strong> <?php echo number_format($totalConDescuento, 2); ?> �</li>
                    </ul>
                <?php endif; ?>
            </div>

            <div class="total-line">
                <p><strong>IVA (10%):</strong> + <?php echo number_format($totalIVA, 2); ?> �</p>
            </div>

            <div class="final-price">
                <strong>TOTAL FINAL:</strong> <?php echo number_format($precioFinal, 2); ?> �
            </div>

        <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>

            <p style="color:red; font-weight:bold;">Se encontraron errores en el formulario. Por favor, revisa las alertas y completa todos los campos obligatorios.</p>

        <?php else: ?>
            <p>Por favor, env�a el formulario de matr�cula para generar el resumen.</p>
        <?php endif; ?>
    </div>
</body>

<style>
    body {
        background: #f3f6f9;
        font-family: Arial, sans-serif;
        color: #333;
        padding: 20px;
    }

    .contenedor {
        background: #fff;
        max-width: 700px;
        margin: 40px auto;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border: 1px solid #ddd;
    }

    h1,
    h2 {
        color: #4a6fa5;
        border-bottom: 1px solid #eee;
        padding-bottom: 5px;
        margin-top: 20px;
    }

    p,
    ul {
        margin: 12px 0;
        font-size: 1.08em;
    }

    li {
        margin-bottom: 4px;
    }

    strong {
        font-weight: bold;
    }

    .total-line {
        padding: 5px 0;
        border-top: 1px dashed #ccc;
        margin-top: 15px;
    }

    .final-price {
        font-size: 1.3em;
        color: #ffffff;
        background-color: #4a6fa5;
        font-weight: bold;
        border-top: 2px solid #4a6fa5;
        text-align: center;
        padding: 15px;
        margin-top: 15px;
        border-radius: 6px;
    }
</style>

</html>
