<?php
require_once "tarifas.php";

// =================================== INICIALIZACIÓN DE VARIABLES ===================================
$dni = $_POST['dni'] ?? 'N/A';
$nombre = $_POST['nombre'] ?? 'N/A';
$curso = $_POST['curso'] ?? 'N/A';
$tipoMatricula = $_POST['tipo_matricula'] ?? 'primera'; 
$asignaturasObligatorias = $_POST['obligatorias'] ?? []; 
// Las opcionales devuelven un array [NombreAsignatura => Créditos]
$asignaturasOpcionales = $_POST['opcionales'] ?? []; 

$totalCreditos = 0;
$costeBasePorCredito = PRECIO_CREDITO_BASE;
$recargoMatricula = 0.0;
$recargoOpcionales = 0.0;

$listaMatriculada = [];
$numOpcionalesSeleccionadas = count($asignaturasOpcionales);

// =================================== CÁLCULO DE CRÉDITOS Y COSTE BASE ===================================

// 1. Determinar el coste base por crédito según el tipo de matrícula
if ($tipoMatricula == 'segunda') {
    // Aplicar recargo del 20%
    $costeBasePorCredito *= RECARGO_SEGUNDA_MATRICULA_FACTOR;
    $recargoMatricula = $costeBasePorCredito - PRECIO_CREDITO_BASE;
}

// 2. Procesar Obligatorias y Opcionales
$todasAsignaturas = array_merge($asignaturasObligatorias, $asignaturasOpcionales);

foreach ($todasAsignaturas as $nombreAsig => $creditos) {
    $creditos = intval($creditos);
    $totalCreditos += $creditos;
    $costoLinea = $creditos * $costeBasePorCredito;
    $tipo = (isset($asignaturasObligatorias[$nombreAsig])) ? "Obligatoria" : "Opcional";

    $listaMatriculada[] = [
        "nombre" => $nombreAsig,
        "creditos" => $creditos,
        "tipo" => $tipo,
        "costo_linea" => round($costoLinea, 2),
    ];
}

// 3. CÁLCULO FINAL Y RECARGOS CONDICIONALES
$costoTotalSinRecargoOpcional = $totalCreditos * $costeBasePorCredito;
$costoFinal = $costoTotalSinRecargoOpcional;
$mensajeRecargoOpcionales = "No aplica.";

// VUELTECITA: Aplicar recargo si hay demasiadas opcionales seleccionadas
if ($numOpcionalesSeleccionadas > LIMITE_OPCIONALES_RECARGO) {
    $recargoOpcionales = $costoTotalSinRecargoOpcional * RECARGO_EXCESO_OPCIONALES;
    $costoFinal += $recargoOpcionales;
    $mensajeRecargoOpcionales = "¡ATENCIÓN! Recargo del " . (RECARGO_EXCESO_OPCIONALES * 100) . "% aplicado por exceder el límite de " . LIMITE_OPCIONALES_RECARGO . " opcionales.";
}

// =================================== OUTPUT HTML FINAL (Sin Tablas) ===================================
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resumen de Matrícula</title>
</head>
<body>
    <h1>Resumen de Matrícula</h1>
    
    <p><strong>Alumno:</strong> <?php echo htmlspecialchars($nombre); ?> (DNI: <?php echo htmlspecialchars($dni); ?>)</p>
    <p><strong>Curso:</strong> <?php echo htmlspecialchars($curso); ?></p>
    <p><strong>Tipo Matrícula:</strong> <?php echo ($tipoMatricula == 'primera' ? 'Primera Matrícula' : 'Segunda o Posterior'); ?></p>

    <hr>

    <h2>Asignaturas Matriculadas</h2>
    
    <dl>
        <?php foreach ($listaMatriculada as $item): ?>
            <dt style="font-weight: bold; margin-top: 10px;"><?php echo htmlspecialchars($item['nombre']); ?></dt>
            <dd style="margin-left: 20px;">
                <span style="font-weight: 500;">Créditos:</span> <?php echo $item['creditos']; ?> (<?php echo $item['tipo']; ?>)
                <span style="float: right; font-weight: bold;"><?php echo $item['costo_linea']; ?> €</span>
            </dd>
        <?php endforeach; ?>
    </dl>
    
    <hr>

    <h2>Desglose de Costes</h2>
    <div style="max-width: 400px;">
        <p>
            <span>Créditos Totales Matriculados:</span>
            <span style="float: right;"><?php echo $totalCreditos; ?></span>
        </p>
        <p>
            <span>Coste Base por Crédito:</span>
            <span style="float: right;"><?php echo round(PRECIO_CREDITO_BASE, 2); ?> €</span>
        </p>
        <p>
            <span>Recargo por Segunda Matrícula:</span>
            <span style="float: right; color: <?php echo ($recargoMatricula > 0) ? 'red' : 'green'; ?>;"><?php echo round($recargoMatricula, 2); ?> €/Crédito</span>
        </p>
        <p style="padding-top: 10px; border-top: 1px dashed #ccc;">
            <strong>Subtotal de Matrícula:</strong>
            <strong style="float: right;"><?php echo round($costoTotalSinRecargoOpcional, 2); ?> €</strong>
        </p>
        
        <?php if ($recargoOpcionales > 0): ?>
            <p style="color: red; padding-top: 5px;">
                <span>Recargo por Exceso de Opcionales:</span>
                <span style="float: right;">+ <?php echo round($recargoOpcionales, 2); ?> €</span>
            </p>
        <?php endif; ?>
        
        <p style="padding: 15px 0; border-top: 2px solid #333; margin-top: 10px;">
            <strong style="font-size: 1.1em;">TOTAL FINAL A PAGAR:</strong>
            <strong style="float: right; font-size: 1.3em; color: blue;"><?php echo round($costoFinal, 2); ?> €</strong>
        </p>
    </div>

    <?php if ($numOpcionalesSeleccionadas > LIMITE_OPCIONALES_RECARGO): ?>
        <p style="color: red; font-weight: bold; margin-top: 20px;"><?php echo $mensajeRecargoOpcionales; ?></p>
    <?php endif; ?>

</body>
</html>