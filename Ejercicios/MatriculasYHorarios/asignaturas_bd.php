<?php


$asignaturas_siglas = [
    "Despliegue de Aplicaciones Web" => "DAW",
    "Diseno de Interfaces Web" => "DIW",
    "WordPress" => "WP", 
    "Desarrollo Web Entorno Servidor" => "DWES",
    "Ingles" => "ING",
    "Desarrollo Web Entorno Cliente" => "DWEC",
    "IPE II" => "IPE",
    "Proyecto" => "PROY",
    "RECREO" => "RECREO" 
];


$coloresAsignaturas = [
    "DWEC" => "#B3E0FF", // Azul claro
    "DWES" => "#FFB3B3", // Rojo claro
    "DAW" => "#B3FFC9",  // Verde claro
    "DIW" => "#FFD9B3",  // Naranja claro
    "WP" => "#E6B3FF",   // Púrpura claro
    "IPE" => "#FFFFB3",  // Amarillo claro
    "PROY" => "#D9D9D9", // Gris claro
    "ING" => "#B3FFFF",  // Cian claro
    "RECREO" => "#0fd60fff",  // Verde para recreo
    "" => "#FFFFFF"      // Blanco por defecto (hueco libre)
];


$calendarioAsignaturas = [
    "Despliegue de Aplicaciones Web" => [
        "LUNES" => ["12:30-13:30"], 
        "JUEVES" => ["12:00-13:00"], 
        "total_horas" => 2.0,
    ],
    "Diseno de Interfaces Web" => [
        "LUNES" => ["11:00-12:30"], 
        "MARTES" => ["10:00-11:00"], 
        "JUEVES" => ["13:00-14:30"], 
        "VIERNES" => ["12:30-13:30"], 
        "total_horas" => 5.0,
    ],
    "WordPress" => [
        "MIÉRCOLES" => ["08:00-11:00"], 
        "total_horas" => 3.0, 
    ],
    "Desarrollo Web Entorno Servidor" => [
        "MARTES" => ["08:00-10:00", "11:30-12:30"], 
        "MIÉRCOLES" => ["13:00-14:30"], 
        "JUEVES" => ["08:00-10:30"], 
        "total_horas" => 7.0,
    ],
    "Ingles" => [
        "LUNES" => ["13:30-15:30"], 
        "total_horas" => 2.0, 
    ],
    "Desarrollo Web Entorno Cliente" => [
        "LUNES" => ["08:00-10:30"], 
        "MARTES" => ["12:30-14:30"], 
        "MIÉRCOLES" => ["11:30-13:00"], 
        "total_horas" => 6.0,
    ],
    "IPE II" => [
        "JUEVES" => ["11:00-12:00"], 
        "VIERNES" => ["08:00-10:00"], 
        "total_horas" => 3.0,
    ],
    "Proyecto" => [
        "VIERNES" => ["10:00-12:00"], 
        "total_horas" => 2.0, 
    ],
];
