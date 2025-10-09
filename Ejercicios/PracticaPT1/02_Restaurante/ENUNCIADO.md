# Ejercicio 2: Sistema de Reservas de Restaurante

## Descripción

Crear un formulario HTML para gestionar reservas en un restaurante. El sistema permitirá seleccionar el tipo de menú, número de comensales, día de la semana, turno (comida/cena), y servicios adicionales como vino premium, postre especial o menú infantil.

El script PHP calculará el precio total basándose en el menú seleccionado, cantidad de personas, día (fines de semana más caros), turno y extras. Se aplicarán descuentos con códigos promocionales válidos.

## Instrucciones para el Formulario

### Estructura del Formulario

1. **Datos de Contacto:**
   - Nombre (máx. 30 caracteres) - `text` obligatorio
   - Teléfono (9 dígitos) - `text` obligatorio
   - Email (validar formato) - `email` obligatorio

2. **Tipo de Menú (Obligatorio)** - `select`:
   - Menú del Día
   - Menú Ejecutivo
   - Menú Degustación
   - Menú Gourmet
   - A la Carta

3. **Número de Comensales** - `number` (mínimo 1, máximo 20)

4. **Día de la Semana (Obligatorio)** - `radio buttons`:
   - Lunes a Jueves
   - Viernes
   - Sábado
   - Domingo

5. **Turno (Obligatorio)** - `radio buttons`:
   - Comida (13:00-16:00)
   - Cena (20:00-23:00)

6. **Servicios Adicionales (Opcionales)** - `checkboxes`:
   - Bodega Premium (vino seleccionado)
   - Postre Especial del Chef
   - Menú Infantil (por cada niño)
   - Decoración de Mesa
   - Música en Vivo

7. **Código Promocional** - `text` opcional

### Script PHP

Debe realizar:
- Validación de nombre, teléfono y email
- Validación de número de comensales
- Cálculo del precio base según menú
- Aplicar multiplicador por día de la semana
- Sumar extras seleccionados
- Aplicar código promocional si es válido
- Calcular IVA (10%)
- Mostrar resumen detallado

## Arrays Predefinidos

```php
// Precios base por menú (por persona)
$menus = [
    "Menú del Día" => 12,
    "Menú Ejecutivo" => 18,
    "Menú Degustación" => 35,
    "Menú Gourmet" => 55,
    "A la Carta" => 30
];

// Multiplicador según día
$dias = [
    "Lunes a Jueves" => 1.0,
    "Viernes" => 1.15,
    "Sábado" => 1.3,
    "Domingo" => 1.2
];

// Multiplicador según turno
$turnos = [
    "Comida (13:00-16:00)" => 1.0,
    "Cena (20:00-23:00)" => 1.1
];

// Servicios adicionales (precio total, no por persona)
$servicios = [
    "Bodega Premium (vino seleccionado)" => 45,
    "Postre Especial del Chef" => 25,
    "Menú Infantil (por cada niño)" => 8,
    "Decoración de Mesa" => 20,
    "Música en Vivo" => 80
];

// Códigos promocionales
$codigos = [
    "GOURMET20" => 20,
    "FAMILIA10" => 10,
    "PRIMERAVEZ" => 15
];
```

## Validaciones Requeridas

1. Nombre: entre 2 y 30 caracteres
2. Teléfono: exactamente 9 dígitos numéricos
3. Email: formato válido (usar filter_var con FILTER_VALIDATE_EMAIL)
4. Número de comensales: entre 1 y 20
5. Todos los radio/select obligatorios seleccionados

## Ejemplo de Salida

```
RESTAURANTE LA BUENA MESA - RESUMEN DE RESERVA

Datos de Contacto:
- Nombre: María González
- Teléfono: 654321987
- Email: maria@example.com

Detalles de la Reserva:
- Menú: Menú Degustación (35€ por persona)
- Comensales: 4 personas
- Día: Sábado (recargo 30%)
- Turno: Cena (recargo 10%)

Cálculo de Menús:
- Base: 140€ (4 × 35€)
- Con día Sábado: 182€ (×1.3)
- Con turno Cena: 200.20€ (×1.1)

Servicios Adicionales:
- Bodega Premium: 45€
- Postre Especial: 25€
- Total servicios: 70€

Resumen:
- Subtotal menús: 200.20€
- Subtotal servicios: 70€
- Total: 270.20€

Código Promoción: GOURMET20 (20% descuento)
- Descuento: 54.04€
- Total con descuento: 216.16€

IVA (10%): 21.62€

TOTAL FINAL: 237.78€
```
