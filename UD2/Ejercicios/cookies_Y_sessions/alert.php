<link rel="stylesheet" href="style.css">


<?php

function alert($mensaje, $redirigir, $tipo = 'info')
{
    echo " 
        <div class='container'>
            <div class='alert $tipo'>
                <p>$mensaje</p>
            </div>
        </div>
        <meta http-equiv='refresh' content='3;url=$redirigir'>";
    exit;
}

?>