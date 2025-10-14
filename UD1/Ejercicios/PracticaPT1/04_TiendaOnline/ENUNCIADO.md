# Ejercicio 4: Tienda Online - Carrito de Compra

## Descripci�n

Crear un formulario HTML para simular una compra en una tienda online de electr�nica. El sistema permitir� seleccionar productos, indicar cantidad, elegir m�todo de env�o, seguros adicionales y aplicar cupones de descuento.

El script PHP calcular� el precio total bas�ndose en los productos seleccionados, sus cantidades, el m�todo de env�o, seguros opcionales y aplicar� descuentos con cupones v�lidos. Se calcular� el IVA (21%) sobre el total.

## Instrucciones para el Formulario

### Estructura del Formulario

1. **Datos del Cliente:**
   - Nombre (m�x. 30 caracteres) - `text` obligatorio
   - Email (formato v�lido) - `email` obligatorio
   - Direcci�n de env�o (m�x. 100 caracteres) - `text` obligatorio

2. **Selecci�n de Productos (Obligatorio al menos 1)** - `checkboxes`:
   - Port�til Gaming
   - Smartphone 5G
   - Tablet 10"
   - Auriculares Bluetooth
   - Smartwatch
   - Teclado Mec�nico

3. **Cantidad por Producto** - `number` (1-5 por producto)

4. **M�todo de Env�o (Obligatorio)** - `radio buttons`:
   - Env�o Est�ndar (5-7 d�as)
   - Env�o Express (2-3 d�as)
   - Env�o Premium (24h)

5. **Servicios Adicionales (Opcionales)** - `checkboxes`:
   - Seguro de Robo y Da�os
   - Garant�a Extendida (2 a�os)
   - Instalaci�n/Configuraci�n
   - Embalaje Regalo

6. **Cup�n de Descuento** - `text` opcional

### Script PHP

Debe realizar:
- Validaci�n de nombre, email y direcci�n
- Verificar que al menos un producto est� seleccionado
- Calcular precio total de productos seg�n cantidades
- Sumar coste de env�o
- Sumar servicios adicionales
- Aplicar cup�n si es v�lido
- Calcular IVA (21%)
- Mostrar resumen detallado

## Arrays Predefinidos

```php
// Productos disponibles
$productos = [
    "Port�til Gaming" => 899,
    "Smartphone 5G" => 599,
    "Tablet 10\"" => 349,
    "Auriculares Bluetooth" => 79,
    "Smartwatch" => 199,
    "Teclado Mec�nico" => 129
];

// M�todos de env�o
$envios = [
    "Env�o Est�ndar (5-7 d�as)" => 5,
    "Env�o Express (2-3 d�as)" => 12,
    "Env�o Premium (24h)" => 20
];

// Servicios adicionales
$servicios = [
    "Seguro de Robo y Da�os" => 25,
    "Garant�a Extendida (2 a�os)" => 50,
    "Instalaci�n/Configuraci�n" => 40,
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
2. Email: formato v�lido
3. Direcci�n: entre 10 y 100 caracteres
4. Al menos 1 producto seleccionado
5. M�todo de env�o obligatorio
6. Cantidades entre 1 y 5

## Ejemplo de Salida

```
TECH STORE - RESUMEN DE COMPRA

Datos del Cliente:
- Nombre: Ana Garc�a
- Email: ana@example.com
- Direcci�n: Calle Mayor 123, Madrid

Productos en el Carrito:
- Port�til Gaming � 1 = 899�
- Auriculares Bluetooth � 2 = 158�
- Total productos: 1,057�

M�todo de Env�o: Env�o Express (2-3 d�as) - 12�

Servicios Adicionales:
- Seguro de Robo y Da�os - 25�
- Garant�a Extendida - 50�
- Total servicios: 75�

Subtotal: 1,144�

Cup�n: TECH20 (20% descuento)
- Descuento: 228.80�
- Total con descuento: 915.20�

IVA (21%): 192.19�

TOTAL FINAL: 1,107.39�
```
