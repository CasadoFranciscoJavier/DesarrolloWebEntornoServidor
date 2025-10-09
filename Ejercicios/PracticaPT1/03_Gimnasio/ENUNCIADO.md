# Ejercicio 3: Sistema de Inscripción a Gimnasio

## Descripción

Crear un formulario HTML para gestionar inscripciones en un gimnasio. El sistema permitirá seleccionar el tipo de plan (mensual, trimestral, anual), clases grupales, servicios adicionales como entrenador personal, nutricionista o taquilla, y aplicar códigos promocionales.

El script PHP calculará el precio total basándose en el plan seleccionado, clases elegidas, servicios adicionales y aplicará descuentos con códigos válidos. Se calculará el IVA (21%) sobre el total.

## Instrucciones para el Formulario

### Estructura del Formulario

1. **Datos Personales:**
   - Nombre (máx. 30 caracteres) - `text` obligatorio
   - Apellidos (máx. 40 caracteres) - `text` obligatorio
   - Edad (18-80 años) - `number` obligatorio

2. **Tipo de Plan (Obligatorio)** - `radio buttons`:
   - Plan Básico Mensual
   - Plan Premium Mensual
   - Plan Básico Trimestral
   - Plan Premium Trimestral
   - Plan Anual

3. **Clases Grupales (Opcionales)** - `checkboxes`:
   - Yoga
   - Spinning
   - Pilates
   - CrossFit
   - Zumba
   - Box

4. **Servicios Adicionales (Opcionales)** - `checkboxes`:
   - Entrenador Personal (4 sesiones/mes)
   - Nutricionista (2 consultas/mes)
   - Taquilla Privada
   - Acceso a Piscina
   - Acceso a Sauna

5. **Horario Preferido (Obligatorio)** - `select`:
   - Mañana (6:00-14:00)
   - Tarde (14:00-22:00)
   - Todo el día

6. **Código Promocional** - `text` opcional

### Script PHP

Debe realizar:
- Validación de nombre y apellidos (longitud)
- Validación de edad (18-80)
- Validación de selecciones obligatorias
- Cálculo del precio del plan
- Suma de clases grupales seleccionadas
- Suma de servicios adicionales
- Aplicar código promocional si es válido
- Calcular IVA (21%)
- Mostrar resumen detallado

## Arrays Predefinidos

```php
// Planes de gimnasio
$planes = [
    "Plan Básico Mensual" => 30,
    "Plan Premium Mensual" => 50,
    "Plan Básico Trimestral" => 75,
    "Plan Premium Trimestral" => 135,
    "Plan Anual" => 450
];

// Clases grupales (precio mensual adicional)
$clases = [
    "Yoga" => 15,
    "Spinning" => 20,
    "Pilates" => 18,
    "CrossFit" => 25,
    "Zumba" => 12,
    "Box" => 22
];

// Servicios adicionales (precio mensual)
$servicios = [
    "Entrenador Personal (4 sesiones/mes)" => 80,
    "Nutricionista (2 consultas/mes)" => 40,
    "Taquilla Privada" => 10,
    "Acceso a Piscina" => 15,
    "Acceso a Sauna" => 12
];

// Recargo por horario
$horarios = [
    "Mañana (6:00-14:00)" => 1.0,
    "Tarde (14:00-22:00)" => 1.0,
    "Todo el día" => 1.2
];

// Códigos promocionales
$codigos = [
    "FITNESS2024" => 15,
    "VERANO20" => 20,
    "AMIGO10" => 10
];
```

## Validaciones Requeridas

1. Nombre: entre 2 y 30 caracteres
2. Apellidos: entre 2 y 40 caracteres
3. Edad: entre 18 y 80 años
4. Plan obligatorio
5. Horario obligatorio

## Ejemplo de Salida

```
GIMNASIO FIT CENTER - RESUMEN DE INSCRIPCIÓN

Datos Personales:
- Nombre Completo: Carlos Martínez López
- Edad: 28 años

Plan Contratado: Plan Premium Mensual - 50¬

Clases Grupales Seleccionadas:
- Spinning - 20¬
- CrossFit - 25¬
- Total clases: 45¬

Servicios Adicionales:
- Entrenador Personal - 80¬
- Taquilla Privada - 10¬
- Total servicios: 90¬

Horario: Todo el día (recargo 20%)

Cálculo:
- Subtotal base: 185¬ (50 + 45 + 90)
- Con horario: 222¬ (×1.2)

Código Promoción: FITNESS2024 (15% descuento)
- Descuento: 33.30¬
- Total con descuento: 188.70¬

IVA (21%): 39.63¬

TOTAL FINAL: 228.33¬
```
