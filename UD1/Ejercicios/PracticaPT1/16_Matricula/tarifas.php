<?php

// =================================== DATOS DE LA UNIVERSIDAD ===================================

define('PRECIO_CREDITO_BASE', 30.00); // Precio base por crédito en Primera Matrícula
define('RECARGO_SEGUNDA_MATRICULA_FACTOR', 1.20); // Recargo del 20% (multiplicador)
define('RECARGO_EXCESO_OPCIONALES', 0.10); // Recargo del 10% por más de 5 opcionales
define('LIMITE_OPCIONALES_RECARGO', 5); // Límite de opcionales antes del recargo

/**
 * Array con la estructura de las asignaturas por curso.
 */
$planEstudios = [
    "1_dam" => [
        "nombre_curso" => "1º DAM",
        "asignaturas" => [
            "Programación" => ["creditos" => 8, "tipo" => "obligatoria"],
            "Bases de Datos" => ["creditos" => 6, "tipo" => "obligatoria"],
            "Sistemas Operativos" => ["creditos" => 6, "tipo" => "obligatoria"],
            "Interfaces Web" => ["creditos" => 4, "tipo" => "opcional"],
            "Redes y Seguridad" => ["creditos" => 4, "tipo" => "opcional"],
            "Emprendimiento" => ["creditos" => 2, "tipo" => "opcional"],
        ]
    ],
    "2_daw" => [
        "nombre_curso" => "2º DAW",
        "asignaturas" => [
            "Desarrollo Web Entorno Cliente" => ["creditos" => 8, "tipo" => "obligatoria"],
            "Desarrollo Web Entorno Servidor" => ["creditos" => 8, "tipo" => "obligatoria"],
            "Frameworks JavaScript" => ["creditos" => 5, "tipo" => "opcional"],
            "Diseño UX/UI" => ["creditos" => 5, "tipo" => "opcional"],
        ]
    ],
    "master_ciber" => [
        "nombre_curso" => "Máster en Ciberseguridad",
        "asignaturas" => [
            "Fundamentos de Hacking Ético" => ["creditos" => 10, "tipo" => "obligatoria"],
            "Auditoría de Sistemas" => ["creditos" => 10, "tipo" => "obligatoria"],
            "Forensics Digital" => ["creditos" => 8, "tipo" => "obligatoria"],
            "Legislación TIC" => ["creditos" => 5, "tipo" => "opcional"],
            "Criptografía Avanzada" => ["creditos" => 5, "tipo" => "opcional"],
        ]
    ],
];

?>