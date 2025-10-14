
<?php
// Definimos los horarios y asignaturas
$horarios = [
    ["09:00 - 11:00", "Programación", "Desarrollo de Aplicaciones Web", "Bases de Datos", "Sistemas Informáticos", "Lenguaje de Marcas"],
    ["11:00 - 13:00", "Bases de Datos", "Desarrollo de Aplicaciones Web", "Programación", "Lenguaje de Marcas", "Sistemas Informáticos"],
    ["13:00 - 15:00", "Sistemas Informáticos", "Programación", "Desarrollo de Aplicaciones Web", "Lenguaje de Marcas", "Bases de Datos"],
    ["15:00 - 17:00", "Lenguaje de Marcas con miguel", "Sistemas Informáticos", "Bases de Datos", "Desarrollo de Aplicaciones Web", "Programación"],
    ["17:00 - 19:00", "Desarrollo de Aplicaciones Web", "Programación", "Lenguaje de Marcas", "Sistemas Informáticos", "Bases de Datos"]
];

$days = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horario DAW</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f7;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        table {
            border-collapse: collapse;
            width: 80%;
            margin-top: 20px;
            border: 2px solid #3e8e41;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
            font-size: 16px;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        td:nth-child(odd) {
            background-color: #e9f7e9;
        }
        td:nth-child(even) {
            background-color: #f1f1f1;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        h1 {
            color: #4CAF50;
        }
    </style>
</head>
<body>
    <h1>Horario de Asignaturas - Segundo Año DAW</h1>
    <table>
        <tr>
            <th>Hora/Día</th>
            <?php foreach ($days as $day): ?>
                <th><?php echo $day; ?></th>
            <?php endforeach; ?>
        </tr>
        <?php foreach ($horarios as $hora): ?>
            <tr>
                <td><?php echo $hora[0]; ?></td>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <td><?php echo $hora[$i]; ?></td>
                <?php endfor; ?>
            </tr>
        <?php endforeach; ?>
    </table>

    
</body>
</html>