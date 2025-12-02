<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Calculadora extends Controller
{
    public function sumar($n1, $n2)
    {
        return $n1 + $n2;
    }

    public function multiplicar($n1, $n2)
    {
        return $n1 * $n2;
    }

    public function elevar($n1, $n2)
    {
        return pow($n1, $n2);
    }

    public function obtenerListaNumeros($size)
    {
        $numeros = [];

        for ($i = 1; $i < $size; $i++) {
            $numeros[] = $i;
        }
        return $numeros;
    }
}
