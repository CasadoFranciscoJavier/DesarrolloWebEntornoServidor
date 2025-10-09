# Ejercicio 1: Sistema de Préstamos de Biblioteca

## Descripción

El objetivo de este ejercicio es crear un formulario HTML para gestionar préstamos de libros en una biblioteca. El formulario permitirá a los usuarios ingresar sus datos personales, seleccionar libros para préstamo, elegir el tipo de membresía y la duración del préstamo. Además, podrán contratar servicios adicionales como reserva de salas o acceso a recursos digitales.

Una vez que el usuario complete el formulario, un archivo PHP procesará las selecciones y calculará el coste total del servicio según el tipo de membresía, cantidad de libros, duración del préstamo y servicios adicionales. Si el usuario ingresa un código de promoción válido, se aplicará un descuento al precio final.

## Instrucciones para el Formulario en HTML

### 1. Estructura del Formulario

Crea un formulario con las siguientes secciones:

1. **Datos del Usuario:**
   - Nombre (máx. 30 caracteres) - `text` obligatorio
   - Apellidos (máx. 40 caracteres) - `text` obligatorio
   - DNI (formato: 8 dígitos + letra) - `text` obligatorio

2. **Tipo de Membresía (Obligatorio)** - Usa `radio buttons`:
   - Básica
   - Premium
   - VIP

3. **Categoría de Libros (Obligatorio)** - Usa `select`:
   - Novela
   - Ensayo
   - Ciencia
   - Historia
   - Arte

4. **Cantidad de Libros** - Usa `number` (mínimo 1, máximo 10)

5. **Duración del Préstamo (Obligatorio)** - Usa `radio buttons`:
   - 7 días
   - 14 días
   - 30 días

6. **Servicios Adicionales (Opcionales)** - Usa `checkboxes`:
   - Reserva de Sala de Estudio
   - Acceso a Base de Datos Digital
   - Préstamo de Tableta Electrónica
   - Servicio de Escaneo de Documentos
   - Asesoría de Investigación

7. **Código de Promoción (Opcional)** - Campo de texto para códigos de descuento

### 2. Script PHP

Crea un archivo PHP que realice las siguientes operaciones:

- Define arrays asociativos con:
  - Precios base por tipo de membresía
  - Coste por libro según la categoría
  - Multiplicadores según duración del préstamo
  - Precios de servicios adicionales
  - Códigos de promoción válidos con sus porcentajes

- Valida todos los campos obligatorios:
  - Nombre y apellidos (longitud mínima y máxima)
  - DNI (formato correcto)
  - Cantidad de libros (rango 1-10)
  - Selecciones obligatorias

- Calcula el precio total:
  - Precio base según membresía
  - Coste de libros (cantidad × precio categoría × multiplicador duración)
  - Suma de servicios adicionales
  - Aplica descuento si hay código válido
  - Calcula IVA (10%)

- Muestra un resumen detallado con todos los componentes del precio

### 3. Salida Esperada

El script PHP debe mostrar:
- Datos del usuario
- Tipo de membresía y precio base
- Detalles de los libros (categoría, cantidad, duración)
- Lista de servicios adicionales contratados con precios
- Desglose de costes (subtotal, descuento si aplica, IVA)
- Precio final total

## Arrays Predefinidos

```php
// Precios de membresía (mensuales)
$membresias = [
    "Básica" => 5,
    "Premium" => 12,
    "VIP" => 25
];

// Precio por libro según categoría
$categorias = [
    "Novela" => 2,
    "Ensayo" => 3,
    "Ciencia" => 4,
    "Historia" => 3,
    "Arte" => 3.5
];

// Multiplicador según duración
$duraciones = [
    "7 días" => 1.0,
    "14 días" => 1.5,
    "30 días" => 2.0
];

// Servicios adicionales
$servicios = [
    "Reserva de Sala de Estudio" => 8,
    "Acceso a Base de Datos Digital" => 15,
    "Préstamo de Tableta Electrónica" => 20,
    "Servicio de Escaneo de Documentos" => 5,
    "Asesoría de Investigación" => 25
];

// Códigos de promoción
$codigos = [
    "LIBRO2024" => 10,      // 10% descuento
    "ESTUDIANTE" => 15,     // 15% descuento
    "VERANO50" => 5         // 5% descuento
];
```

## Ejemplo de Salida

```
BIBLIOTECA MUNICIPAL - RESUMEN DE PRÉSTAMO

Datos del Usuario:
- Nombre Completo: Juan Pérez García
- DNI: 12345678A

Membresía Seleccionada: Premium - 12 €/mes

Préstamo de Libros:
- Categoría: Ciencia
- Cantidad: 3 libros
- Duración: 14 días
- Coste libros: 18 € (3 libros × 4 € × 1.5)

Servicios Adicionales:
- Acceso a Base de Datos Digital - 15 €
- Asesoría de Investigación - 25 €
- Total servicios: 40 €

Resumen de Costes:
- Membresía: 12 €
- Libros: 18 €
- Servicios: 40 €
- Subtotal: 70 €

Código Promoción: ESTUDIANTE (15% aplicado)
- Descuento: 10.50 €
- Total con descuento: 59.50 €

IVA (10%): 5.95 €

TOTAL FINAL: 65.45 €
```

## Validaciones Requeridas

1. Nombre: entre 2 y 30 caracteres
2. Apellidos: entre 2 y 40 caracteres
3. DNI: exactamente 9 caracteres (8 números + 1 letra)
4. Cantidad de libros: entre 1 y 10
5. Todos los campos radio/select obligatorios deben estar seleccionados
6. Mostrar mensajes de error específicos para cada validación fallida
