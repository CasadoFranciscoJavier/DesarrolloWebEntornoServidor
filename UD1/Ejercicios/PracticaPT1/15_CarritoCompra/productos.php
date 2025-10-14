<?php

// =================================== REPOSITORIO DE DATOS ===================================

$catalogoProductos = [
    "electronica" => [
        "Portatil XYZ" => ["precio" => 1200.00, "stock" => 5],
        "Monitor 4K" => ["precio" => 450.50, "stock" => 12],
        "Ratón Gaming" => ["precio" => 55.90, "stock" => 30],
    ],
    "hogar" => [
        "Aspiradora Robot" => ["precio" => 300.00, "stock" => 8],
        "Cafetera Express" => ["precio" => 150.00, "stock" => 20],
        "Set de Sartenes" => ["precio" => 75.25, "stock" => 15],
    ],
    "deportes" => [
        "Bicicleta Montaña" => ["precio" => 550.00, "stock" => 3],
        "Esterilla Yoga" => ["precio" => 25.00, "stock" => 50],
        "Balón de Fútbol" => ["precio" => 35.00, "stock" => 100],
    ],
];

// Constantes de cálculo
define('IVA_PORCENTAJE', 0.21); // 21% de IVA
define('DESCUENTO_MAYOR_A_10', 0.05); // 5% de descuento por más de 10 unidades

// =================================== FUNCIONES BASE ===================================

/**
 * Función para mostrar alertas en JavaScript y volver a la página anterior
 * @param string $text Mensaje a mostrar.
 */
function alert($text)
{
    echo "<script> 
            alert('$text'); 
            window.history.back(); // Volver al formulario
          </script>";
    exit(); // Detiene la ejecución
}

/**
 * Función simple para validar un string no vacío.
 * @param string $variablePOST Nombre de la variable POST.
 * @return bool True si es válido, False si está vacío.
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
?>