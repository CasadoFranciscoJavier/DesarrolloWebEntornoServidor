# Ejercicio 1: Sistema de Préstamos de Biblioteca - EXPLICACIÓN

## Estructura del Ejercicio

Este ejercicio consta de 4 archivos principales:

1. **ENUNCIADO.md** - El enunciado del ejercicio
2. **biblioteca.html** - Formulario HTML para capturar datos
3. **bbddBiblioteca.php** - Arrays asociativos con precios y códigos
4. **procesarBiblioteca.php** - Lógica de validación y cálculo
5. **README.md** - Este archivo con explicaciones

---

## Explicación Detallada del Código

### 1. Archivo: biblioteca.html

Este archivo contiene el formulario HTML que el usuario completa. Características importantes:

#### Campos de texto básicos:
```html
<input type="text" id="nombre" name="nombre" maxlength="30" required>
```
- **name**: Nombre con el que se enviará el dato al servidor (en $_POST)
- **maxlength**: Límite máximo de caracteres (validación del lado del cliente)
- **required**: Campo obligatorio (validación HTML5)

#### Radio buttons (una sola opción):
```html
<input type="radio" name="membresia" value="Básica" required>
```
- Todos los radio del mismo grupo comparten el **name**
- Solo se puede seleccionar uno
- El **value** es lo que se envía al servidor

#### Select (menú desplegable):
```html
<select name="categoria" required>
    <option value="">Selecciona una categoría</option>
    <option value="Novela">Novela</option>
</select>
```
- Primera opción vacía para forzar selección
- El **value** debe coincidir exactamente con las claves del array PHP

#### Checkboxes (múltiples opciones):
```html
<input type="checkbox" name="servicios[]" value="Reserva de Sala de Estudio">
```
- Los **corchetes []** en el name indican que es un array
- Se pueden seleccionar múltiples opciones
- En PHP se recibe como array

#### Estilos CSS integrados:
El formulario usa los mismos estilos que tus ejercicios anteriores:
- Fondo suave (#f3f6f9)
- Formulario centrado con sombra
- Colores azules para consistencia (#4a6fa5, #7ea1c4)

---

### 2. Archivo: bbddBiblioteca.php

Contiene todos los datos del sistema en **arrays asociativos** (equivalente a Map en otros lenguajes).

#### Arrays asociativos simples:
```php
$membresias = [
    "Básica" => 5,
    "Premium" => 12,
    "VIP" => 25
];
```
- **Clave** => **Valor**
- Se accede con: `$membresias["Básica"]` retorna `5`

#### ¿Por qué usar arrays asociativos?
1. Facilita mantenimiento: cambiar precios sin tocar la lógica
2. Validación: podemos verificar si una clave existe
3. Escalabilidad: fácil agregar nuevas opciones

---

### 3. Archivo: procesarBiblioteca.php

Este es el archivo más complejo. Contiene toda la lógica de validación y procesamiento.

#### Función alert():
```php
function alert($text)
{
    echo "<script> alert('$text');window.location.href = 'biblioteca.html'; </script>";
}
```
**Explicación:**
- Genera código JavaScript para mostrar un alert en el navegador
- Redirige al usuario de vuelta al formulario HTML
- Se usa cuando hay errores de validación

#### Función validarString():
```php
function validarString($variablePOST, $minimo, $maximo)
{
    $vacio = empty($_POST[$variablePOST]);
    $valido = false;
    if (!$vacio) {
        $valido = (strlen($_POST[$variablePOST]) >= $minimo && strlen($_POST[$variablePOST]) <= $maximo);
    }
    if ($vacio) {
        alert("$variablePOST está vacío");
    } else if (!$valido) {
        alert("$variablePOST fuera de rango (longitud entre $minimo y $maximo)");
    }
    return $valido;
}
```
**Explicación paso a paso:**
1. **empty()**: Verifica si la variable está vacía
2. **strlen()**: Obtiene la longitud de la cadena
3. Comprueba que esté entre el mínimo y máximo
4. Retorna `true` si es válido, `false` si no lo es
5. Muestra alertas descriptivas en caso de error

#### Función validarDNI():
```php
function validarDNI($dni)
{
    if (strlen($dni) == 9) {
        $numeros = substr($dni, 0, 8);
        $letra = substr($dni, 8, 1);
        $valido = is_numeric($numeros) && ctype_alpha($letra);
    }
    return $valido;
}
```
**Explicación:**
- **substr($dni, 0, 8)**: Extrae los primeros 8 caracteres (números)
- **substr($dni, 8, 1)**: Extrae el último carácter (letra)
- **is_numeric()**: Verifica que sea un número
- **ctype_alpha()**: Verifica que sea una letra
- **Operador &&**: Ambas condiciones deben cumplirse

#### Función validarInt():
```php
function validarInt($variablePOST, $minimo, $maximo)
{
    $esEntero = filter_var($_POST[$variablePOST], FILTER_VALIDATE_INT);

    if ($esEntero !== false) {
        $valido = (($_POST[$variablePOST] >= $minimo) && ($_POST[$variablePOST] <= $maximo));
    }
    return $valido;
}
```
**Explicación:**
- **filter_var()**: Función PHP para validar y filtrar datos
- **FILTER_VALIDATE_INT**: Constante que indica validación de entero
- **!== false**: Importante usar triple igual para distinguir 0 de false
- Verifica el rango después de confirmar que es entero

#### Función validarSeleccion():
```php
function validarSeleccion($variablePOST)
{
    $vacio = empty($_POST[$variablePOST]);
    if ($vacio) {
        alert("Debes seleccionar $variablePOST");
    }
    return !$vacio;
}
```
**Explicación:**
- Verifica que se haya seleccionado algo en radio/select
- **!$vacio**: Invierte el valor (si está vacío retorna false)

---

### Lógica Principal (main)

#### 1. Verificación del método HTTP:
```php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
```
- **$_SERVER**: Variable superglobal de PHP con información del servidor
- Solo procesa si es una petición POST (formulario enviado)

#### 2. Validación de todos los campos:
```php
$todoValido = validarString("nombre", 2, 30)
    && validarString("apellidos", 2, 40)
    && validarDNI($_POST["dni"])
    && validarInt("cantidad", 1, 10)
    && validarSeleccion("membresia")
    && validarSeleccion("categoria")
    && validarSeleccion("duracion");
```
**Explicación:**
- **Operador &&**: Todas las validaciones deben ser true
- Si una falla, las siguientes NO se ejecutan (evaluación cortocircuito)
- Todas las alertas se mostrarán antes de continuar

#### 3. Sanitización de datos:
```php
$nombre = htmlspecialchars($_POST["nombre"]);
```
**htmlspecialchars()**: Convierte caracteres especiales HTML en entidades
- Previene ataques XSS (Cross-Site Scripting)
- Convierte `<` en `&lt;`, `>` en `&gt;`, etc.

#### 4. Operador ternario para datos opcionales:
```php
$codigoPromoIngresado = isset($_POST["codigo"]) ? $_POST["codigo"] : "";
```
**Explicación:**
- **isset()**: Verifica si la variable existe
- **? :** : Operador ternario (if-else corto)
- **Formato**: condición ? valor_si_true : valor_si_false

#### 5. Cálculo de precios:
```php
$precioLibros = $cantidad * $precioCategoria * $multiplicadorDuracion;
```
**Explicación:**
- Accede a los arrays con las claves recibidas del formulario
- Ejemplo: si categoria="Ciencia", busca `$categorias["Ciencia"]` que vale 4€

#### 6. Procesamiento de servicios (checkboxes):
```php
if (!empty($serviciosSeleccionados) && is_array($serviciosSeleccionados)) {
    foreach ($serviciosSeleccionados as $servicio) {
        $precioServicio = $servicios[$servicio];
        $precioServicios += $precioServicio;
    }
}
```
**Explicación:**
- **is_array()**: Verifica que sea un array (en caso de que no se seleccione ninguno)
- **foreach**: Itera sobre cada elemento del array
- **+=**: Operador de suma y asignación (equivale a: `$var = $var + valor`)

#### 7. Validación de código promocional:
```php
if (array_key_exists($codigoPromoIngresado, $codigos)) {
    $descuentoPorcentaje = $codigos[$codigoPromoIngresado];
    $descuentoTasa = $descuentoPorcentaje / 100;
}
```
**Explicación:**
- **array_key_exists()**: Verifica si una clave existe en el array
- Convierte porcentaje a tasa decimal (15% → 0.15)

#### 8. Cálculos finales:
```php
$subtotal = $precioMembresia + $precioLibros + $precioServicios;
$descuentoAplicado = $subtotal * $descuentoTasa;
$totalConDescuento = $subtotal - $descuentoAplicado;
$totalIVA = $totalConDescuento * $IVA_PORCENTAJE;
$precioFinal = $totalConDescuento + $totalIVA;
```
**Orden de operaciones:**
1. Sumar todos los costes → Subtotal
2. Aplicar descuento al subtotal
3. Calcular IVA sobre el total con descuento
4. Sumar IVA para obtener precio final

---

### Parte HTML de salida

#### Uso de condicionales en HTML:
```php
<?php if ($_SERVER["REQUEST_METHOD"] == "POST" && $todoValido): ?>
    <!-- Contenido si TODO es válido -->
<?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
    <!-- Contenido si hay errores -->
<?php else: ?>
    <!-- Contenido si no se ha enviado el formulario -->
<?php endif; ?>
```
**Explicación:**
- Sintaxis alternativa de if en PHP para templates HTML
- Más legible cuando se mezcla PHP con HTML

#### Interpolación de variables:
```php
<p><strong>Nombre:</strong> <?php echo $nombre; ?></p>
```
**echo**: Imprime el contenido de la variable en HTML

#### Condicionales para mostrar secciones opcionales:
```php
<?php if ($descuentoTasa > 0): ?>
    <li><strong>Descuento:</strong> - <?php echo $descuentoAplicado; ?> €</li>
<?php endif; ?>
```
**Explicación:**
- Solo muestra el descuento si realmente hay uno aplicado
- Mejora la experiencia del usuario

#### Formateo de números:
```php
<?php echo number_format($precioFinal, 2); ?>
```
**number_format()**: Formatea números
- Primer parámetro: número a formatear
- Segundo parámetro: cantidad de decimales
- Resultado: "65.45" en lugar de "65.4500000"

---

## Conceptos Clave de PHP Utilizados

### 1. Variables Superglobales:
- **$_POST**: Array con datos enviados por POST
- **$_SERVER**: Array con información del servidor

### 2. Operadores:
- **&&**: AND lógico (todas las condiciones deben ser true)
- **||**: OR lógico (al menos una condición debe ser true)
- **!**: NOT lógico (invierte el valor booleano)
- **===**: Comparación estricta (valor Y tipo)
- **!==**: Diferente estricto (valor O tipo diferentes)

### 3. Funciones de String:
- **strlen()**: Longitud de cadena
- **substr()**: Extraer subcadena
- **htmlspecialchars()**: Escapar caracteres HTML

### 4. Funciones de Validación:
- **empty()**: Verifica si está vacío
- **isset()**: Verifica si existe
- **is_numeric()**: Verifica si es número
- **ctype_alpha()**: Verifica si es letra
- **filter_var()**: Validación genérica con filtros

### 5. Funciones de Arrays:
- **array_key_exists()**: Verifica si existe una clave
- **is_array()**: Verifica si es un array

### 6. Estructuras de Control:
- **if/else/elseif**: Condicionales
- **foreach**: Iteración sobre arrays
- **Operador ternario**: ? :

---

## Flujo Completo del Ejercicio

1. Usuario accede a **biblioteca.html**
2. Completa el formulario y hace clic en "Procesar Préstamo"
3. Los datos se envían por POST a **procesarBiblioteca.php**
4. Se incluyen los arrays de **bbddBiblioteca.php**
5. Se validan todos los campos:
   - Si hay error → Alert y redirección al formulario
   - Si todo OK → Continúa al paso 6
6. Se calculan todos los precios
7. Se genera el HTML con el resumen
8. Usuario ve el resumen completo con el precio final

---

## Buenas Prácticas Aplicadas

1. **Separación de responsabilidades**:
   - HTML: Presentación
   - PHP datos: Configuración
   - PHP lógica: Procesamiento

2. **Validación robusta**:
   - Cliente (HTML5) y servidor (PHP)
   - Mensajes de error descriptivos

3. **Seguridad**:
   - htmlspecialchars() para prevenir XSS
   - Validación de tipos de datos
   - Verificación de rangos

4. **Mantenibilidad**:
   - Funciones reutilizables
   - Código comentado
   - Nombres de variables descriptivos

5. **UX (Experiencia de Usuario)**:
   - Alertas informativas
   - Redirección automática en caso de error
   - Resumen detallado y claro
