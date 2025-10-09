# Ejercicio 2: Sistema de Reservas de Restaurante - EXPLICACIÓN

## Estructura del Ejercicio

Este ejercicio consta de 4 archivos principales:

1. **ENUNCIADO.md** - El enunciado del ejercicio
2. **restaurante.html** - Formulario HTML para capturar datos de reserva
3. **bbddRestaurante.php** - Arrays asociativos con menús, precios y códigos
4. **procesarRestaurante.php** - Lógica de validación y cálculo
5. **README.md** - Este archivo con explicaciones

---

## Explicación Detallada del Código

### 1. Archivo: restaurante.html

Formulario HTML para reservas de restaurante con los siguientes elementos:

#### Campos de contacto:
```html
<input type="email" id="email" name="email" required>
```
- **type="email"**: HTML5 valida formato de email automáticamente
- Incluye validación básica del navegador antes de enviar

#### Select para menús:
```html
<select name="menu" required>
    <option value="">Selecciona un menú</option>
    <option value="Menú del Día">Menú del Día (12€)</option>
</select>
```
- Primera opción vacía obliga a seleccionar
- Los valores deben coincidir exactamente con las claves del array PHP

#### Radio buttons para días de la semana:
```html
<input type="radio" name="dia" value="Lunes a Jueves" required>
<input type="radio" name="dia" value="Viernes">
```
- Todos comparten el mismo **name** para que solo se pueda seleccionar uno
- Información visual del recargo en la etiqueta

---

### 2. Archivo: bbddRestaurante.php

Contiene 5 arrays principales con la estructura de precios del restaurante.

#### Array de menús (precio por persona):
```php
$menus = [
    "Menú del Día" => 12,
    "Menú Ejecutivo" => 18,
    "Menú Degustación" => 35
];
```
**Explicación:**
- El precio es por comensal
- Se multiplicará por el número de comensales

#### Arrays de multiplicadores:
```php
$dias = [
    "Lunes a Jueves" => 1.0,
    "Viernes" => 1.15,
    "Sábado" => 1.3
];
```
**Explicación:**
- **1.0**: Sin recargo (100%)
- **1.15**: +15% (115% del precio)
- **1.3**: +30% (130% del precio)
- Se aplican multiplicaciones sucesivas

#### Servicios adicionales (precio fijo):
```php
$servicios = [
    "Bodega Premium (vino seleccionado)" => 45,
    "Música en Vivo" => 80
];
```
**Explicación:**
- NO es por persona, es precio total
- Se suman al final del cálculo

---

### 3. Archivo: procesarRestaurante.php

#### Función validarTelefono():
```php
function validarTelefono($telefono)
{
    $valido = (strlen($telefono) == 9 && is_numeric($telefono));
    return $valido;
}
```
**Explicación:**
- **strlen($telefono) == 9**: Exactamente 9 caracteres
- **is_numeric()**: Todos deben ser números
- **Operador &&**: Ambas condiciones deben cumplirse

#### Función validarEmail():
```php
function validarEmail($email)
{
    $valido = filter_var($email, FILTER_VALIDATE_EMAIL);
    return $valido;
}
```
**Explicación:**
- **filter_var()**: Función de PHP para validar datos
- **FILTER_VALIDATE_EMAIL**: Filtro específico para emails
- Valida formato: `usuario@dominio.ext`
- Retorna el email si es válido, `false` si no lo es

---

### Lógica Principal - Cálculos Específicos del Restaurante

#### 1. Cálculo del precio base de menús:
```php
$precioMenuPorPersona = $menus[$menu];
$precioMenu = $comensales * $precioMenuPorPersona;
```
**Ejemplo:**
- Menú Degustación: 35€
- Comensales: 4
- Resultado: 4 × 35 = 140€

#### 2. Aplicar multiplicador de día:
```php
$multiplicadorDia = $dias[$dia];
$precioMenuConDia = $precioMenu * $multiplicadorDia;
```
**Ejemplo:**
- Precio base: 140€
- Día: Sábado (multiplicador 1.3)
- Resultado: 140 × 1.3 = 182€

#### 3. Aplicar multiplicador de turno:
```php
$multiplicadorTurno = $turnos[$turno];
$precioMenuConMultiplicadores = $precioMenuConDia * $multiplicadorTurno;
```
**Ejemplo:**
- Precio con día: 182€
- Turno: Cena (multiplicador 1.1)
- Resultado: 182 × 1.1 = 200.20€

#### 4. Sumar servicios adicionales:
```php
$subtotal = $precioMenuConMultiplicadores + $precioServicios;
```
**Ejemplo:**
- Menús: 200.20€
- Bodega Premium: 45€
- Postre Especial: 25€
- Subtotal: 200.20 + 70 = 270.20€

---

### Diferencias Clave con el Ejercicio de Biblioteca

#### 1. Multiplicadores sucesivos vs suma directa:
**Restaurante:**
```php
$precio = $precioBase * $multiplicadorDia * $multiplicadorTurno;
```
Los recargos se aplican uno después del otro (compuesto)

**Biblioteca:**
```php
$precio = $cantidad * $precioCategoria * $multiplicadorDuracion;
```
Similar estructura pero aplicada diferente

#### 2. Validaciones específicas:
**Restaurante:**
- Teléfono: exactamente 9 dígitos
- Email: formato válido con filter_var

**Biblioteca:**
- DNI: 8 números + 1 letra
- Validación de formato personalizado

#### 3. Estructura de precios:
**Restaurante:**
- Precio por persona × comensales
- Luego se aplican multiplicadores
- Servicios son precio fijo total

**Biblioteca:**
- Precio de membresía (fijo)
- Precio de libros (cantidad × precio × multiplicador)
- Servicios son precio fijo total

---

### Mostrar Cálculos Detallados en HTML

```php
<h2>Cálculo de Menús</h2>
<ul>
    <li><strong>Base:</strong> <?php echo number_format($precioMenu, 2); ?>€
        (<?php echo $comensales; ?> × <?php echo $precioMenuPorPersona; ?>€)</li>
    <li><strong>Con día:</strong> <?php echo number_format($precioMenuConDia, 2); ?>€
        (×<?php echo $multiplicadorDia; ?>)</li>
    <li><strong>Con turno:</strong> <?php echo number_format($precioMenuConMultiplicadores, 2); ?>€
        (×<?php echo $multiplicadorTurno; ?>)</li>
</ul>
```

**Explicación:**
- Muestra cada paso del cálculo por separado
- **number_format($numero, 2)**: Formatea a 2 decimales
- Ayuda al usuario a entender cómo se llegó al precio final
- Transparencia en los cálculos = mejor experiencia de usuario

---

### Cálculo de recargos porcentuales para mostrar:

```php
<p><strong>Día:</strong> <?php echo htmlspecialchars($dia); ?>
    (recargo <?php echo ($multiplicadorDia - 1) * 100; ?>%)</p>
```

**Explicación matemática:**
- **$multiplicadorDia** = 1.3 (para sábado)
- **$multiplicadorDia - 1** = 0.3
- **0.3 × 100** = 30 (el porcentaje de recargo)
- Se muestra: "recargo 30%"

---

## Conceptos Clave de PHP Nuevos en Este Ejercicio

### 1. FILTER_VALIDATE_EMAIL:
```php
filter_var($email, FILTER_VALIDATE_EMAIL);
```
- Constante de PHP para validar emails
- Verifica formato estándar: `usuario@dominio.ext`
- Retorna el valor si es válido, `false` si no

### 2. Cálculos con múltiples multiplicadores:
```php
$resultado = $base * $mult1 * $mult2;
```
- Los multiplicadores se aplican en cascada
- El orden no importa (propiedad conmutativa)
- Útil para recargos escalonados

### 3. Mostrar porcentajes calculados:
```php
($multiplicador - 1) * 100
```
- Convierte multiplicador a porcentaje de recargo
- Ejemplo: 1.15 → 15%
- Ejemplo: 1.3 → 30%

---

## Flujo Completo del Ejercicio

1. **Usuario accede** a `restaurante.html`
2. **Completa el formulario** con datos de contacto y preferencias
3. **Envío por POST** a `procesarRestaurante.php`
4. **Inclusión de datos** desde `bbddRestaurante.php`
5. **Validaciones**:
   - Nombre (longitud 2-30)
   - Teléfono (9 dígitos)
   - Email (formato válido)
   - Comensales (1-20)
   - Selecciones obligatorias
6. **Si hay errores** → Alert y redirección
7. **Si todo OK** → Cálculos:
   - Precio base por menú × comensales
   - Aplicar multiplicador de día
   - Aplicar multiplicador de turno
   - Sumar servicios adicionales
   - Aplicar código promocional si existe
   - Calcular IVA (10%)
8. **Generar HTML** con resumen detallado paso a paso
9. **Mostrar al usuario** el desglose completo y precio final

---

## Buenas Prácticas Aplicadas

### 1. Transparencia en precios:
- Se muestra cada paso del cálculo
- El usuario ve cómo se llegó al precio final
- Recargos claramente indicados

### 2. Validaciones específicas del dominio:
- Teléfono: 9 dígitos (España)
- Email: formato estándar
- Rango de comensales realista (1-20)

### 3. Experiencia de usuario:
- Información de precios en el formulario
- Información de recargos junto a las opciones
- Resumen claro y detallado

### 4. Escalabilidad:
- Fácil agregar nuevos menús
- Fácil ajustar multiplicadores
- Fácil agregar nuevos servicios

### 5. Cálculos precisos:
- Uso de `number_format()` para decimales
- Redondeo adecuado para moneda
- Operaciones en orden correcto

---

## Comparación: Biblioteca vs Restaurante

| Aspecto | Biblioteca | Restaurante |
|---------|-----------|-------------|
| **Validación especial** | DNI (8 nums + letra) | Teléfono (9 dígitos) + Email |
| **Cálculo principal** | Cantidad × Precio × Duración | Comensales × Precio × Día × Turno |
| **IVA** | 10% | 10% |
| **Multiplicadores** | Uno (duración) | Dos (día + turno) |
| **Servicios extra** | Precio fijo | Precio fijo |
| **Complejidad** | Media | Media-Alta |

Ambos ejercicios comparten la estructura base pero difieren en:
- Tipo de validaciones específicas
- Forma de calcular los precios
- Cantidad de multiplicadores aplicados
