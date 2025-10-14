# Ejercicio 3: Sistema de Inscripci�n a Gimnasio

## Descripci�n

Crear un formulario HTML para gestionar inscripciones en un gimnasio. El sistema permitir� seleccionar el tipo de plan (mensual, trimestral, anual), clases grupales, servicios adicionales como entrenador personal, nutricionista o taquilla, y aplicar c�digos promocionales.

El script PHP calcular� el precio total bas�ndose en el plan seleccionado, clases elegidas, servicios adicionales y aplicar� descuentos con c�digos v�lidos. Se calcular� el IVA (21%) sobre el total.

## Instrucciones para el Formulario

### Estructura del Formulario

1. **Datos Personales:**
   - Nombre (m�x. 30 caracteres) - `text` obligatorio
   - Apellidos (m�x. 40 caracteres) - `text` obligatorio
   - Edad (18-80 a�os) - `number` obligatorio

2. **Tipo de Plan (Obligatorio)** - `radio buttons`:
   - Plan B�sico Mensual
   - Plan Premium Mensual
   - Plan B�sico Trimestral
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
   - Ma�ana (6:00-14:00)
   - Tarde (14:00-22:00)
   - Todo el d�a

6. **C�digo Promocional** - `text` opcional

### Script PHP

Debe realizar:
- Validaci�n de nombre y apellidos (longitud)
- Validaci�n de edad (18-80)
- Validaci�n de selecciones obligatorias
- C�lculo del precio del plan
- Suma de clases grupales seleccionadas
- Suma de servicios adicionales
- Aplicar c�digo promocional si es v�lido
- Calcular IVA (21%)
- Mostrar resumen detallado

## Arrays Predefinidos

```php
// Planes de gimnasio
$planes = [
    "Plan B�sico Mensual" => 30,
    "Plan Premium Mensual" => 50,
    "Plan B�sico Trimestral" => 75,
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
    "Ma�ana (6:00-14:00)" => 1.0,
    "Tarde (14:00-22:00)" => 1.0,
    "Todo el d�a" => 1.2
];

// C�digos promocionales
$codigos = [
    "FITNESS2024" => 15,
    "VERANO20" => 20,
    "AMIGO10" => 10
];
```

## Validaciones Requeridas

1. Nombre: entre 2 y 30 caracteres
2. Apellidos: entre 2 y 40 caracteres
3. Edad: entre 18 y 80 a�os
4. Plan obligatorio
5. Horario obligatorio

## Ejemplo de Salida

```
GIMNASIO FIT CENTER - RESUMEN DE INSCRIPCI�N

Datos Personales:
- Nombre Completo: Carlos Mart�nez L�pez
- Edad: 28 a�os

Plan Contratado: Plan Premium Mensual - 50�

Clases Grupales Seleccionadas:
- Spinning - 20�
- CrossFit - 25�
- Total clases: 45�

Servicios Adicionales:
- Entrenador Personal - 80�
- Taquilla Privada - 10�
- Total servicios: 90�

Horario: Todo el d�a (recargo 20%)

C�lculo:
- Subtotal base: 185� (50 + 45 + 90)
- Con horario: 222� (�1.2)

C�digo Promoci�n: FITNESS2024 (15% descuento)
- Descuento: 33.30�
- Total con descuento: 188.70�

IVA (21%): 39.63�

TOTAL FINAL: 228.33�
```
