<?php

require_once "componentes.php";

$componentesObligatorios = ["Modelo", "Motor", "Color", "Llantas", "Equipamiento"];

function alert($text){
    // Imprime un script en JavaScript que muestra una alerta con el texto recibido
    echo "<script> alert('$text');</script>" ;
    // window.location.href = 'formularioConcesionario.html';</script>";
}

function validarComponentesObligatorios(){
    global $componentesObligatorios;
    foreach ($componentesObligatorios as $componente) {
        if ( !validarComponente($componente)){
            alert("El componente $componente es obligatorio");
        }
    }
}

function validarComponente($nombreComponente){

    global $componentes;
    $componenteTieneValor = isset($_POST[$nombreComponente]);

    if($componenteTieneValor){

        $valorRecibido = $_POST[$nombreComponente];
        $posiblesValores = $componentes[$nombreComponente];

        $nombreComponenteExiste = array_key_exists($valorRecibido, $posiblesValores); // Miramos si $valorRecibido es una clave del Array (Map) $posiblesValores

    }

    return $componenteTieneValor && $nombreComponenteExiste;
}

// Verifica si la solicitud es de tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $cantidadDeCoches = $_POST["cantidad"];
    $codigoDescuentoUsuario = $_POST["codigo_descuento"];
    $hayDescuento = array_key_exists($codigoDescuentoUsuario, $codigosDescuento);
    $precioUnitario = 0;

    validarComponentesObligatorios();

    echo "<ul>";
    foreach ($componentesObligatorios as $componente) {
        $valor = $_POST[$componente];
        $precioComponente = $componentes[$componente][$valor];
        $precioUnitario += $precioComponente;
        echo "<li>$componente: $valor - $precioComponente €</li>";
    }

        if (empty($_POST["Accesorios"])){
            echo "<li>Accesorios: SIN ACCESORIOS</li>";
        }else{
            echo "<li>Accesorios:<ul>";

            $accesorios = $_POST["Accesorios"];

            foreach ($accesorios as $accesorio) {
                $precioAccesorio = $componentes["Accesorios"][$accesorio];
                $precioUnitario += $precioAccesorio;
                echo "<li>$accesorio - $precioAccesorio €</li>";
            }

            echo "</ul></li>";
        }

    echo "</ul>";

    echo "<br>Cantidad de Coches: $cantidadDeCoches";
    echo "<br>Código de Descuento: " . ($hayDescuento ? $codigoDescuentoUsuario : "No válido");

    echo "<br><br>Precio por unidad: $precioUnitario €";

    $precioTotal = $precioUnitario * $cantidadDeCoches;

    echo "<br>Total sin Descuento: $precioTotal €";

    if($hayDescuento){
        $tasaDescuento = $codigosDescuento[$codigoDescuentoUsuario]/100;
        $descuentoAplicado = $precioTotal * $tasaDescuento;
        $precioTotal -= $descuentoAplicado;

        echo "<br>Descuento Aplicado: $descuentoAplicado €";
        echo "<br>Total con Descuento: $precioTotal €";
    }

    $IVA = round($precioTotal - ($precioTotal/1.21), 2);
    echo "<br><br>IVA (21%): $IVA €";


}else{
    alert("¿Qué haces usando GET?");
}