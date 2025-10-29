Desarrolla una aplicación PHP que permita gestionar el inicio de sesión de los usuarios utilizando un array asociativo (mapa) de correos electrónicos y contraseñas.

login.html: Crea un formulario de inicio de sesión con los campos de correo electrónico y contraseña. Este formulario enviará los datos a un archivo login.php para su validación.

login.php: Implementa la lógica para validar el inicio de sesión utilizando un mapa predefinido de correos electrónicos y contraseñas. Si las credenciales son correctas, establece una sesión con el nombre de usuario correspondiente y redirige a hola.php.

hola.php: Esta página debe saludar al usuario con un mensaje personalizado: "Hola, {Usuario}!" utilizando la información almacenada en la sesión. Además, incluye un botón para cerrar sesión, que destruirá la sesión y redirigirá de vuelta a login.html.

Si el usuario intenta acceder a hola.php sin haber iniciado sesión, la página debe mostrar una alerta notificando que no hay sesión activa y redirigir automáticamente a login.html.

Modifica el programa anterior de forma que al hacer login correcto, se almacene en una cooke el correo y la contraseña durante 10 minutos, de forma que si el usuario vuelve a la página en esos 10 minutos y se ha cerrado la sesión, se vuelva a abrir.

Opción 1: login.html -> pase a ser .php

Opción 2: **fusionar login.html y login.php

En la página hola.php añade un botón cerrar sesión que borre la cookie y cierre la sesión actual

Aquí tienes un ejemplo de un array asociativo (maa) en PHP con 10 usuarios, cada uno con su email, nombre y contraseña. Este map podría ser utilizado en tu archivo login.php para validar las credenciales de los usuarios: (archivo data.php)