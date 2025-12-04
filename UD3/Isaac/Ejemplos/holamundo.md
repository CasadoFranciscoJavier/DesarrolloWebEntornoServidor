# Hola mundo! en Laravel con Blade

## Paso 1: Instalar Laravel

### ¿Qué es Laravel?
Laravel es un marco de trabajo (framework) de PHP diseñado para ayudarte a crear aplicaciones web más fácilmente. Piensa en Laravel como una caja de herramientas que organiza y simplifica el desarrollo de tu aplicación. Entre otras cosas, Laravel incluye soluciones para gestionar rutas, bases de datos, plantillas, autenticación, y mucho más.

### ¿Qué es Composer?
Composer es un administrador de dependencias para PHP. Esto significa que se encarga de descargar y organizar las bibliotecas o herramientas externas que tu proyecto necesite, como Laravel.

### 1. Asegúrate de tener Composer instalado

Para instalar Laravel, necesitas Composer. Sigue estos pasos:

- Ve a la página oficial de Composer: [https://getcomposer.org/](https://getcomposer.org/).
- Descarga el instalador según tu sistema operativo (Windows, macOS o Linux).
- Sigue las instrucciones de instalación.

Para verificar que Composer se haya instalado correctamente, abre la terminal y escribe:

```bash
composer
```

Si ves un mensaje indicando las opciones de uso de Composer, significa que está instalado y listo para usarse.

### 2. Crear un nuevo proyecto Laravel

Ahora que tienes Composer instalado, puedes usarlo para crear un proyecto Laravel. Un proyecto es simplemente una carpeta que contiene todos los archivos necesarios para construir tu aplicación.

1. Abre tu terminal.
2. Escribe el siguiente comando para crear un proyecto llamado `holaMundo`:

   ```bash
   composer create-project --prefer-dist laravel/laravel holaMundo
   ```
   **Si sale algún error mencionando "zip" -> descargar e instalar 7zip**
   **¿Qué hace este comando?**
   - **`composer create-project`**: Indica que queremos crear un nuevo proyecto.
   - **`--prefer-dist`**: Descarga la versión lista para usar de Laravel (en lugar del código fuente completo).
   - **`laravel/laravel`**: Especifica que queremos instalar Laravel.
   - **`holaMundo`**: Es el nombre del proyecto que queremos crear. Puedes usar cualquier nombre.

   **¿Qué sucede al ejecutar este comando?**
   - Composer descargará Laravel desde internet.
   - Creará una carpeta llamada `holaMundo` y pondrá todos los archivos de Laravel dentro de ella.
   - Configurará el proyecto para que puedas empezar a trabajar de inmediato.

   Cuando el proceso termine, verás un mensaje indicando que Laravel se ha instalado correctamente.

3. Navega al directorio de tu proyecto recién creado:

   ```bash
   cd holaMundo
   ```

### 3. Inicia el servidor de desarrollo

Laravel incluye un servidor de desarrollo integrado que te permite probar tu aplicación localmente. Esto significa que puedes ejecutar tu proyecto en tu computadora sin necesidad de configurar un servidor como Apache o Nginx.

1. Asegúrate de estar en el directorio del proyecto (`holaMundo`).
2. Ejecuta este comando para iniciar el servidor:

   ```bash
   php artisan serve
   ```

   **¿Qué hace este comando?**
   - **`php`**: Ejecuta el intérprete de PHP.
   - **`artisan serve`**: Artisan es una herramienta que Laravel incluye para automatizar tareas. El comando `serve` inicia un servidor local.

   Si todo está bien, verás algo como esto en la terminal:

   ```
   Starting Laravel development server: http://127.0.0.1:8000
   [Sun Nov 24 2024 14:35:01] PHP 8.1.12 Development Server (http://127.0.0.1:8000) started
   ```

3. Abre tu navegador y visita [http://127.0.0.1:8000](http://127.0.0.1:8000) o [http://localhost:8000](http://localhost:8000).

   **¿Qué verás en el navegador?**
   - Deberías ver la página de inicio de Laravel, que dice algo como "Laravel" con un logotipo. Esto significa que tu proyecto está funcionando correctamente.

---

## Paso 2: Configurar la Ruta 

### ¿Qué son las rutas en Laravel?
Las rutas son instrucciones que le dicen a Laravel cómo manejar una URL específica. Por ejemplo, cuando visitas `http://localhost/hola`, Laravel necesita saber qué debe hacer: ¿Mostrar una página? ¿Enviar datos? ¿Ejecutar alguna lógica? Aquí es donde las rutas entran en acción.

Laravel utiliza un archivo llamado `web.php`, ubicado en el directorio `routes/`, para definir las rutas de tu aplicación.

### 1. Abre el archivo de rutas

1. Ve a la carpeta de tu proyecto en tu editor de texto o IDE (por ejemplo, Visual Studio Code).
2. Busca el archivo `routes/web.php`. Este archivo es el lugar donde definirás todas las rutas accesibles desde el navegador.

   **Estructura del archivo `web.php`:**
   Este archivo ya contiene algunas rutas predeterminadas como ejemplo. Una de ellas puede verse así:

   ```php
   Route::get('/', function () {
       return view('welcome');
   });
   ```

   **¿Qué significa esto?**
   - **`Route::get('/')`:** Define una ruta que responde a solicitudes GET (las que hace tu navegador por defecto) en la URL raíz `/` (es decir, `http://localhost/`).
   - **`function () { return view('welcome'); }`:** Cuando alguien visita esta URL, se ejecuta la función que retorna la vista llamada `welcome` (ubicada en `resources/views/welcome.blade.php`).
   [**Explicación más detallada de la función anónima (similar a la función flecha de JS)**](https://chat.openai.com/?q=no%20entiendo%20la%20sintaxis%20de%20esto%20en%20laravel,%20explicamelo%20y%20las%20funciones%20anonimas%20de%20php:%20%20%20%20-%20**function%20()%20{%20return%20view('welcome');%20}:**%20Cuando%20alguien%20visita%20esta%20URL,%20se%20ejecuta%20la%20función%20que%20retorna%20la%20vista%20llamada%20welcome%20(ubicada%20en%20resources/views/welcome.blade.php))

---

### 2. Define tu propia ruta

Ahora vamos a agregar una nueva ruta que responda a la URL `/hola` y acepte un parámetro opcional llamado `nombre`.

1. Dentro del archivo `web.php`, agrega el siguiente código:

   ```php
   use Illuminate\Support\Facades\Route; // Importamos la clase Route

   Route::get('/hola/{nombre?}', function ($nombre = 'Mundo') {
       return view('hola', ['nombre' => $nombre]);
   });
   ```

2. **¿Qué significa este código?**

   - **`Route::get('/hola/{nombre?}'`:**  
     - Define una ruta que responde a solicitudes GET en la URL `/hola`.  
     - **`{nombre?}`** indica que esta ruta acepta un parámetro llamado `nombre`.  
     - El signo de interrogación (`?`) significa que este parámetro es opcional. Si no se proporciona, usaremos un valor predeterminado.
   - **`function ($nombre = 'Mundo')`:**  
     - La función recibe el valor del parámetro `nombre`. Si no se proporciona en la URL, el valor predeterminado será `'Mundo'`.
   - **`return view('hola', ['nombre' => $nombre]);`:**  
     - **`view('hola')`:** Carga una vista llamada `hola` (que crearemos en el próximo paso).
     - **`['nombre' => $nombre]`:** Pasa el valor de la variable `$nombre` a la vista como un array asociativo. Dentro de la vista, esta variable estará disponible como `{{ $nombre }}`.

### 3. ¿Cómo funciona esta ruta?

Después de agregar esta ruta, tu aplicación ahora puede responder a URLs como estas:

- **Sin parámetro:**  
  URL: [http://localhost:8000/hola](http://localhost:8000/hola)  
  - Como no se proporciona el parámetro `nombre`, Laravel usará el valor predeterminado `'Mundo'`.  
  - Resultado esperado: La vista mostrará `Hola, Mundo!`.

- **Con parámetro:**  
  URL: [http://localhost:8000/hola/Juan](http://localhost:8000/hola/Juan)  
  - El valor del parámetro `nombre` será `'Juan'`.  
  - Resultado esperado: La vista mostrará `Hola, Juan!`.

### 4. ¿Cómo sé que la ruta está funcionando?

Para verificar que la ruta está funcionando correctamente:

1. Asegúrate de que el servidor de Laravel está en ejecución:
   ```bash
   php artisan serve
   ```

2. Abre tu navegador e ingresa las URLs mencionadas anteriormente:
   - [http://localhost:8000/hola](http://localhost:8000/hola)
   - [http://localhost:8000/hola/Juan](http://localhost:8000/hola/Juan)

Si ves un error que dice "view [hola] not found" (vista [hola] no encontrada), no te preocupes. Esto se debe a que aún no hemos creado la vista. Esto se solucionará en el próximo paso.

---

## Paso 3: Crear la Vista Blade

### ¿Qué es una vista en Laravel?
En Laravel, una vista es un archivo que contiene el código HTML que se mostrará en el navegador. Este archivo puede incluir variables y lógica sencilla para personalizar su contenido. Las vistas se encuentran en el directorio `resources/views` y utilizan el motor de plantillas llamado **Blade**.

Blade permite insertar dinámicamente datos en tus páginas de una manera fácil y limpia. Esto significa que puedes escribir código PHP dentro de tus archivos HTML para personalizar lo que ve el usuario.

### 1. Localiza el directorio de vistas

1. En tu proyecto Laravel, ve a la carpeta `resources/views`.  
   - Si estás usando un editor de código como Visual Studio Code, la estructura se verá así:
     ```
     resources/
         views/
             welcome.blade.php
     ```
   - Laravel incluye por defecto una vista llamada `welcome.blade.php`. Esta es la página de bienvenida que aparece cuando visitas la URL raíz (`http://localhost:8000`).

### 2. Crear un archivo de vista llamado `hola.blade.php`

1. Dentro de la carpeta `views`, crea un nuevo archivo llamado `hola.blade.php`.
   - Si estás en un editor de texto, haz clic derecho en la carpeta `views` y selecciona "Nuevo archivo".
   - Nombra el archivo como `hola.blade.php`.

   **¿Qué es `.blade.php`?**
   - **`.blade`** indica que el archivo utiliza el motor de plantillas Blade.
   - **`.php`** muestra que sigue siendo un archivo PHP.

   Tu estructura de carpetas ahora debería verse así:
   ```
   resources/
       views/
           welcome.blade.php
           hola.blade.php
   ```

### 3. Agrega contenido al archivo `hola.blade.php`

Abre el archivo `hola.blade.php` y escribe el siguiente código:

```html
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hola Mundo</title>
</head>
<body>
    <h1>Hola, {{ $nombre }}!</h1>
    <p>Bienvenido a nuestra aplicación de ejemplo construida en Laravel.</p>
</body>
</html>
```

**¿Qué significa `{{ $nombre }}`?**
 - Blade usa `{{ }}` para mostrar datos dinámicos.
 - La variable `$nombre` fue pasada a esta vista desde la ruta que configuraste en el paso anterior (`web.php`).
 - Cuando el navegador carga esta vista, Laravel reemplaza `{{ $nombre }}` con el valor real que recibió desde la URL.

### 4. Probar la vista

1. Asegúrate de que el servidor de Laravel está en ejecución:
   ```bash
   php artisan serve
   ```
2. Ve al navegador y accede a las siguientes URLs:
   - **Sin parámetro:**  
     URL: [http://localhost:8000/hola](http://localhost:8000/hola)  
     Resultado esperado:  
     ```
     Hola, Mundo!
     ```
   - **Con parámetro:**  
     URL: [http://localhost:8000/hola/Juan](http://localhost:8000/hola/Juan)  
     Resultado esperado:  
     ```
     Hola, Juan!
     ```