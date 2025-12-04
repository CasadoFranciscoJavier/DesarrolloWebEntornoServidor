# Hola Mundo en Laravel como API

En este ejemplo, configuraremos un endpoint en Laravel que actúe como una **API**. Este endpoint devolverá un mensaje en formato JSON, en lugar de una vista HTML, y será dinámico dependiendo de los parámetros enviados en la URL.

---

## Paso 0: 

Para configurar Laravel de forma que nuestra aplicación sirva una API, ejecuta el siguente comando:
```bash
php artisan install:api
```

## Paso 1: Configurar la Ruta para la API

### ¿Qué es una ruta en Laravel?
Una **ruta** es una instrucción que le dice a Laravel cómo manejar una URL específica. En este caso, configuraremos una ruta para nuestra API en el archivo `routes/api.php`. Este archivo está diseñado para manejar endpoints de API y no vistas HTML.

### 1. Abre el archivo de rutas para API

1. En tu proyecto, ve al archivo `routes/api.php`. Este archivo está configurado automáticamente para manejar rutas de API.
2. Dentro del archivo, define una nueva ruta para nuestro endpoint "Hola Mundo".

---

### 2. Define el endpoint de la API

Agrega la siguiente ruta en `routes/api.php`:

```php
use Illuminate\Support\Facades\Route;

Route::get('/hola/{nombre?}', function ($nombre = 'Mundo') {
    return response()->json([
        'mensaje' => "Hola, $nombre!",
    ]);
});
```

---

### 3. Explicación del código

- **`Route::get('/hola/{nombre?}', ...)`:**  
  - Define una ruta que responde al método HTTP `GET` en la URL `/hola`.
  - **`{nombre?}`**: Indica que el parámetro `nombre` es opcional. Si no se proporciona, se usará el valor predeterminado `'Mundo'`.

- **`function ($nombre = 'Mundo')`:**  
  - Es la acción que se ejecutará cuando alguien acceda a esta ruta. La función recibe el parámetro `nombre` desde la URL.
  - Si el parámetro no se proporciona, el valor predeterminado será `'Mundo'`.

- **`response()->json([...])`:**  
  - Laravel devuelve una respuesta en formato JSON.
  - En este caso, devuelve un array con una clave `'mensaje'` y un valor que contiene la frase `"Hola, $nombre!"`.

---

## Paso 2: Probar el Endpoint de la API

### ¿Cómo funciona el endpoint?

1. Asegúrate de que el servidor de Laravel esté corriendo:

   ```bash
   php artisan serve
   ```

2. Accede al endpoint desde tu navegador o herramienta para probar APIs (como Postman o cURL).

---

### Prueba 1: Sin parámetro

URL: [http://localhost:8000/api/hola](http://localhost:8000/api/hola)

- **Explicación:**  
  Como no se proporciona un valor para `nombre`, el endpoint usa el valor predeterminado `'Mundo'`.

- **Respuesta esperada (JSON):**
  ```json
  {
      "mensaje": "Hola, Mundo!"
  }
  ```

---

### Prueba 2: Con parámetro

URL: [http://localhost:8000/api/hola/Juan](http://localhost:8000/api/hola/Juan)

- **Explicación:**  
  Se pasa el valor `'Juan'` como parámetro `nombre` en la URL.

- **Respuesta esperada (JSON):**
  ```json
  {
      "mensaje": "Hola, Juan!"
  }
  ```