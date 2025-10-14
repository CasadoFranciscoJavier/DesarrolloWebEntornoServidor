# Ejercicio 4: Tienda Online - Carrito de Compra

## Descripción

Crear un formulario HTML para simular una compra en una tienda online de electrónica. El sistema permitirá seleccionar productos, indicar cantidad, elegir método de envío, seguros adicionales y aplicar cupones de descuento.

El script PHP calculará el precio total basándose en los productos seleccionados, sus cantidades, el método de envío, seguros opcionales y aplicará descuentos con cupones válidos. Se calculará el IVA (21%) sobre el total.

## Instrucciones para el Formulario

### Estructura del Formulario

1. **Datos del Cliente:**
   - Nombre (máx. 30 caracteres) - `text` obligatorio
   - Email (formato válido) - `email` obligatorio
   - Dirección de envío (máx. 100 caracteres) - `text` obligatorio

2. **Selección de Productos (Obligatorio al menos 1)** - `checkboxes`:
   - Portátil Gaming
   - Smartphone 5G
   - Tablet 10"
   - Auriculares Bluetooth
   - Smartwatch
   - Teclado Mecánico

3. **Cantidad por Producto** - `number` (1-5 por producto)

4. **Método de Envío (Obligatorio)** - `radio buttons`:
   - Envío Estándar (5-7 días)
   - Envío Express (2-3 días)
   - Envío Premium (24h)

5. **Servicios Adicionales (Opcionales)** - `checkboxes`:
   - Seguro de Robo y Daños
   - Garantía Extendida (2 años)
   - Instalación/Configuración
   - Embalaje Regalo

6. **Cupón de Descuento** - `text` opcional

### Script PHP

Debe realizar:
- Validación de nombre, email y dirección
- Verificar que al menos un producto esté seleccionado
- Calcular precio total de productos según cantidades
- Sumar coste de envío
- Sumar servicios adicionales
- Aplicar cupón si es válido
- Calcular IVA (21%)
- Mostrar resumen detallado

## Arrays Predefinidos

```php
// Productos disponibles
$productos = [
    "Portátil Gaming" => 899,
    "Smartphone 5G" => 599,
    "Tablet 10\"" => 349,
    "Auriculares Bluetooth" => 79,
    "Smartwatch" => 199,
    "Teclado Mecánico" => 129
];

// Métodos de envío
$envios = [
    "Envío Estándar (5-7 días)" => 5,
    "Envío Express (2-3 días)" => 12,
    "Envío Premium (24h)" => 20
];

// Servicios adicionales
$servicios = [
    "Seguro de Robo y Daños" => 25,
    "Garantía Extendida (2 años)" => 50,
    "Instalación/Configuración" => 40,
    "Embalaje Regalo" => 8
];

// Cupones de descuento
$cupones = [
    "TECH20" => 20,
    "PRIMERACOMPRA" => 15,
    "BLACKFRIDAY" => 30
];
```

## Validaciones Requeridas

1. Nombre: entre 2 y 30 caracteres
2. Email: formato válido
3. Dirección: entre 10 y 100 caracteres
4. Al menos 1 producto seleccionado
5. Método de envío obligatorio
6. Cantidades entre 1 y 5

## Ejemplo de Salida

```
TECH STORE - RESUMEN DE COMPRA

Datos del Cliente:
- Nombre: Ana García
- Email: ana@example.com
- Dirección: Calle Mayor 123, Madrid

Productos en el Carrito:
- Portátil Gaming × 1 = 899¬
- Auriculares Bluetooth × 2 = 158¬
- Total productos: 1,057¬

Método de Envío: Envío Express (2-3 días) - 12¬

Servicios Adicionales:
- Seguro de Robo y Daños - 25¬
- Garantía Extendida - 50¬
- Total servicios: 75¬

Subtotal: 1,144¬

Cupón: TECH20 (20% descuento)
- Descuento: 228.80¬
- Total con descuento: 915.20¬

IVA (21%): 192.19¬

TOTAL FINAL: 1,107.39¬
```
