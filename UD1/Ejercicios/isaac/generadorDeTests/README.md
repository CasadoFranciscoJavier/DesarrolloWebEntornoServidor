Desarrolla un programa que genere tests de práctica con los siguientes requisitos:

1. **tests.html**:  
   Crea un formulario que incluya:
   - Un menú desplegable para seleccionar la asignatura del test.
   - Un campo de entrada numérico para indicar la cantidad de preguntas a incluir (máximo 5 preguntas).

2. **tests.php**:  
   Este archivo debe:
   - Generar un test aleatorio basándose en la asignatura seleccionada y la cantidad de preguntas especificada.
   - Las preguntas deben extraerse de un repositorio de preguntas predefinido en el código como un map o matriz (10 preguntas disponibles por cada asignatura).

3. **procesarTest.php**
   Este archivo debe:
   - Procesar las respuestas del usuario a los tests y asignarle una nota del 0 al 10 mostrando la cantidad de preguntas acertadas y falladas.