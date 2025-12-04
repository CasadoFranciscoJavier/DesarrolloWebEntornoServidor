# Unidad Didáctica 3: Laravel

## **1. ¿Qué es Laravel?**

### **1.1 Definición y propósito**

Laravel es un **framework de PHP**, es decir, un conjunto de herramientas y reglas predefinidas que te ayudan a crear aplicaciones web de manera más rápida y organizada. Si alguna vez has intentado crear una página web desde cero, habrás notado que hay tareas que se repiten, como conectar a una base de datos, gestionar usuarios o mostrar páginas. Laravel simplifica todo esto.

Laravel está diseñado para que escribir código sea más sencillo y organizado. Incluye soluciones para manejar tareas comunes como:
- **Rutas:** Decidir qué página se muestra cuando alguien visita una URL específica.
- **Controladores:** Organizar qué hace tu aplicación en respuesta a las acciones de los usuarios.
- **Autenticación:** Manejar inicios de sesión y permisos de usuarios.
- **Bases de datos:** Interactuar con bases de datos sin tener que escribir montones de código complicado.

Laravel se basa en un concepto llamado **MVC (Modelo-Vista-Controlador)**:
1. **Modelo:** Se ocupa de los datos y las reglas de negocio. Por ejemplo, un "modelo de usuario" podría representar la información de un usuario en una base de datos.
2. **Vista:** Es lo que el usuario ve, como una página HTML con botones, texto, imágenes, etc.
3. **Controlador:** Se encarga de conectar el modelo y la vista. Por ejemplo, decide qué datos mostrar en una página y cómo reaccionar si un usuario hace clic en un botón.

El propósito de Laravel es facilitar que los desarrolladores escriban aplicaciones web limpias, rápidas y fáciles de mantener.

### **1.2 Características principales**

Laravel ofrece varias herramientas que lo hacen destacar:

1. **Simplicidad:**  
   Laravel incluye un sistema fácil para definir rutas (URLs) y controladores (acciones que realiza tu aplicación). Por ejemplo, puedes decidir fácilmente qué hacer cuando alguien visita la URL `/contacto`.

   ```php
   Route::get('/contacto', function () {
       return 'Esta es la página de contacto.';
   });
   ```

2. **Blade:**  
   Es un motor de plantillas que hace que escribir código HTML dinámico sea más fácil y organizado. Puedes insertar variables y lógica dentro de las páginas web de forma limpia.

   Por ejemplo, puedes crear un encabezado que salude al usuario:
   ```html
   <h1>Hola, {{ $nombre }}</h1>
   ```

3. **Eloquent ORM:**  
   Es una herramienta para trabajar con bases de datos de una manera sencilla y usando el paradigma orientado a objetos. En lugar de escribir consultas SQL complicadas, puedes interactuar con los datos como si fueran objetos.

   Por ejemplo, en lugar de escribir:
   ```sql
   SELECT * FROM usuarios WHERE id = 1;
   ```

   Con Eloquent solo escribes:
   ```php
   $usuario = Usuario::find(1);
   ```

4. **Tareas comunes simplificadas:**  
   Laravel ya incluye soluciones para tareas como:
   - Crear usuarios y manejar inicios de sesión.
   - Validar formularios (asegurar que los datos enviados por el usuario son correctos).
   - Enviar correos electrónicos.
   - Manejar sesiones de usuarios (como recordar quién está conectado).

Laravel ahorra tiempo y esfuerzo al incluir todo esto listo para usar.

---

## **2. Composer: El Administrador de Dependencias de PHP**

### **2.1 ¿Qué es Composer?**

Composer es una **herramienta que se usa junto con PHP** para administrar "dependencias". Una dependencia es básicamente un conjunto de herramientas o bibliotecas externas que necesitas para tu proyecto. Por ejemplo, si necesitas una biblioteca para enviar correos electrónicos, puedes usar Composer para instalarla rápidamente y asegurarte de que funcione correctamente.

Composer hace que trabajar con bibliotecas sea sencillo porque:
- **Instala automáticamente las herramientas necesarias:** Si tu proyecto necesita varias bibliotecas, Composer las descarga y configura por ti.
- **Actualiza las herramientas fácilmente:** Si las bibliotecas que usas tienen una nueva versión, Composer las actualiza sin que tengas que hacer nada complicado.
- **Evita conflictos:** Asegura que todas las herramientas funcionen juntas sin errores.

### **2.2 Uso de Composer en Laravel**

Laravel se descarga, instala y actualiza a través de Composer. Esto significa que Composer es la herramienta que te permite iniciar un proyecto Laravel sin tener que descargar nada manualmente.

Además, Laravel utiliza Composer para manejar sus propias "dependencias internas". Por ejemplo:
- **Blade** (para manejar las vistas).
- **Eloquent** (para interactuar con bases de datos).
- **Paquetes externos:** Puedes instalar herramientas adicionales para agregar más funcionalidades a tu proyecto, como manejo avanzado de gráficos, APIs de terceros, etc.

### **2.3 Comandos básicos de Composer**

#### **Instalar Laravel:**
Si quieres empezar un nuevo proyecto Laravel, puedes usar el siguiente comando en tu terminal:
```bash
composer create-project --prefer-dist laravel/laravel nombre-proyecto
```

**¿Qué hace este comando?**
- **`composer create-project`:** Le dice a Composer que cree un nuevo proyecto.
- **`--prefer-dist`:** Descarga una versión lista para usar (más rápida y limpia).
- **`laravel/laravel`:** Especifica que queremos instalar Laravel.
- **`nombre-proyecto`:** Es el nombre que tendrá la carpeta de tu proyecto. Puedes poner el nombre que quieras.

Por ejemplo:
```bash
composer create-project --prefer-dist laravel/laravel mi-sitio
```
Este comando descargará Laravel y creará una carpeta llamada `mi-sitio` con todos los archivos necesarios para empezar a trabajar.

#### **Actualizar dependencias:**
Con el tiempo, las herramientas que usa Laravel pueden tener nuevas versiones. Para actualizar todas las dependencias, ejecuta:
```bash
composer update
```

Esto asegura que todas las bibliotecas estén en su última versión compatible con tu proyecto.

---

## **3. Blade: El Motor de Plantillas de Laravel**

### **3.1 ¿Qué es Blade?**

Blade es el **motor de plantillas oficial de Laravel**, una herramienta que te permite generar contenido HTML dinámico de una manera sencilla, limpia y eficiente. En lugar de escribir bloques de PHP puro dentro de tus archivos HTML, Blade te ofrece una sintaxis más clara y fácil de leer.

#### **¿Qué es un motor de plantillas?**
Un motor de plantillas es una herramienta que te permite combinar código HTML con lógica del lado del servidor (como PHP) para crear páginas dinámicas. Esto significa que puedes insertar variables, condicionales y bucles directamente en tus archivos HTML para mostrar contenido dinámico, como el nombre de un usuario o una lista de productos.

#### **¿Por qué usar Blade?**
1. **Simplicidad:** La sintaxis de Blade es más limpia y amigable que escribir PHP puro en los archivos HTML.
2. **Rendimiento:** Aunque Blade te ofrece una sintaxis especial, detrás de escena convierte todo en código PHP estándar, por lo que es muy rápido.
3. **Integración con Laravel:** Blade está diseñado para funcionar perfectamente con las herramientas y características de Laravel, como rutas, controladores y modelos.

Por ejemplo, con Blade, puedes escribir:
```html
<h1>Hola, {{ $nombre }}</h1>
```
Esto mostrará el valor de la variable `$nombre` directamente en la página HTML.

### **3.2 Características de Blade**

Blade incluye una serie de características que facilitan el desarrollo de aplicaciones web dinámicas. Aquí te explicamos las más importantes:

#### **1. Herencia de plantillas**
Blade permite usar **layouts** (plantillas base) para definir la estructura general de tu aplicación y reutilizarla en múltiples páginas. Esto es útil para evitar repetir el mismo código HTML en cada vista.

Por ejemplo:
- **Layout principal (`layout.blade.php`)**:
  ```html
  <!DOCTYPE html>
  <html>
  <head>
      <title>@yield('titulo')</title>
  </head>
  <body>
      <header>
          <h1>Mi Sitio Web</h1>
      </header>
      <main>
          @yield('contenido')
      </main>
      <footer>
          <p>© 2024 Mi Sitio Web</p>
      </footer>
  </body>
  </html>
  ```

- **Vista específica (`inicio.blade.php`)**:
  ```html
  @extends('layout')

  @section('titulo', 'Página de Inicio')

  @section('contenido')
      <h1>Bienvenido a mi página de inicio</h1>
      <p>Esta es la primera página de mi aplicación Laravel.</p>
  @endsection
  ```

Cuando visitas la página asociada a esta vista, Laravel combina el layout con el contenido específico para generar el HTML completo. Esto hace que sea más fácil mantener la coherencia en el diseño de tu sitio.

#### **2. Sintaxis limpia**
Blade utiliza **directivas** para incluir lógica en los archivos de vista. Algunas de las directivas más comunes son:

- **Condicionales (`@if`, `@elseif`, `@else`, `@endif`)**:
  ```html
  @if($usuario->esAdmin)
      <p>Bienvenido, administrador.</p>
  @else
      <p>Hola, usuario.</p>
  @endif
  ```

- **Bucles (`@foreach`, `@for`, `@while`)**:
  ```html
  <ul>
      @foreach($productos as $producto)
          <li>{{ $producto->nombre }}</li>
      @endforeach
  </ul>
  ```

- **Incluir otras vistas (`@include`)**:
  Puedes reutilizar fragmentos de código insertando otras vistas dentro de una vista:
  ```html
  @include('partials.navbar')
  ```

Estas directivas hacen que el código sea más legible y que la lógica esté mejor separada del contenido HTML.

#### **3. Soporte para componentes**
Blade permite crear **componentes** reutilizables, lo que es especialmente útil para elementos repetitivos como formularios, botones o tarjetas.

Por ejemplo, supongamos que necesitas un botón personalizado:
- **Componente de Blade (`resources/views/components/boton.blade.php`)**:
  ```html
  <button class="btn btn-{{ $tipo ?? 'primary' }}">
      {{ $slot }}
  </button>
  ```

- **Uso del componente en una vista**:
  ```html
  <x-boton tipo="success">Guardar</x-boton>
  <x-boton tipo="danger">Eliminar</x-boton>
  ```

Esto genera el siguiente HTML:
```html
<button class="btn btn-success">Guardar</button>
<button class="btn btn-danger">Eliminar</button>
```

Los componentes permiten que el código sea más modular y fácil de mantener.

#### **4. Escape de datos**
Blade protege automáticamente tus datos para evitar vulnerabilidades como **inyecciones XSS**. Si usas `{{ }}`, Blade escapa los caracteres especiales para que no puedan ejecutarse como código malicioso.

Por ejemplo:
```html
{{ $usuario->nombre }}
```
Si `$usuario->nombre` contiene algo como `<script>alert('Hackeado');</script>`, Blade lo convertirá a texto plano para evitar problemas:
```html
&lt;script&gt;alert('Hackeado');&lt;/script&gt;
```

Si necesitas incluir contenido HTML sin escapar, puedes usar `{!! !!}`:
```html
{!! $contenidoHTML !!}
```

#### **5. Plantillas condicionales y bucles anidados**
Blade simplifica el manejo de condiciones complejas y bucles anidados:

- **Condicionales en un bucle**:
  ```html
  <ul>
      @foreach($productos as $producto)
          @if($producto->disponible)
              <li>{{ $producto->nombre }} - Disponible</li>
          @else
              <li>{{ $producto->nombre }} - No disponible</li>
          @endif
      @endforeach
  </ul>
  ```

- **Bucle anidado**:
  ```html
  @foreach($categorias as $categoria)
      <h2>{{ $categoria->nombre }}</h2>
      <ul>
          @foreach($categoria->productos as $producto)
              <li>{{ $producto->nombre }}</li>
          @endforeach
      </ul>
  @endforeach
  ```

### **3.3 Ejemplo básico**

Supongamos que queremos crear una página web con una estructura común para todas las vistas y un contenido específico para cada página.

1. **Crear el layout base (`layout.blade.php`)**:
   ```html
   <!DOCTYPE html>
   <html>
   <head>
       <title>@yield('titulo')</title>
   </head>
   <body>
       <header>
           <h1>Mi Aplicación</h1>
       </header>
       <main>
           @yield('contenido')
       </main>
       <footer>
           <p>© 2024 Mi Aplicación</p>
       </footer>
   </body>
   </html>
   ```

2. **Crear una vista específica (`inicio.blade.php`)**:
   ```html
   @extends('layout')

   @section('titulo', 'Página de Inicio')

   @section('contenido')
       <h1>Bienvenido a Laravel</h1>
       <p>Esta es la página de inicio de mi aplicación.</p>
   @endsection
   ```

3. **Definir una ruta en `web.php`**:
   ```php
   Route::get('/', function () {
       return view('inicio');
   });
   ```

Cuando visitas la página principal, Laravel combina el layout y la vista específica para generar la página completa.

---

## **4. Estructura de un Proyecto Laravel**

Cuando trabajas con Laravel, uno de los aspectos más importantes es entender cómo está organizado un proyecto. Laravel sigue una estructura bien definida que facilita el desarrollo, el mantenimiento y la colaboración. Esta estructura asegura que cada archivo y carpeta tenga un propósito claro, ayudándote a mantener tu código ordenado y fácil de entender.

### **4.1 Organización básica**

Cuando creas un proyecto Laravel, obtienes un conjunto de carpetas y archivos organizados de manera lógica. Cada una de estas carpetas tiene un rol específico en el funcionamiento de tu aplicación.

#### **Carpetas principales y su propósito:**

1. **`app/`**:  
   - Esta carpeta contiene **el núcleo de la lógica de tu aplicación**.
   - Aquí es donde se encuentran los **modelos**, los **controladores** y otras clases esenciales.
   - Subcarpetas importantes dentro de `app/`:
     - **`Http/Controllers`**: Aquí defines los controladores, que son responsables de procesar las solicitudes y devolver respuestas.
     - **`Http/Middleware`**: Contiene middlewares, que son filtros para las solicitudes HTTP (por ejemplo, verificar si un usuario está autenticado).
     - **`Models`**: Aquí defines los modelos, que representan tus tablas en la base de datos y contienen la lógica relacionada con los datos.

   **Ejemplo:**
   Si tienes una aplicación para gestionar usuarios, podrías tener un archivo llamado `User.php` dentro de `app/Models` y un controlador llamado `UserController.php` en `app/Http/Controllers`.

2. **`routes/`**:  
   - Aquí defines todas las **rutas** de tu aplicación. Una ruta conecta una URL con una acción específica.
   - Archivos importantes dentro de esta carpeta:
     - **`web.php`**: Para las rutas accesibles desde un navegador (usualmente retornan vistas HTML).
     - **`api.php`**: Para las rutas de una API (generalmente retornan datos en formato JSON).
   
   **Ejemplo:**
   En `web.php`, podrías definir una ruta para mostrar la página de inicio:
   ```php
   Route::get('/', function () {
       return view('inicio');
   });
   ```

3. **`resources/views/`**:  
   - Aquí se guardan las vistas de tu aplicación. Las vistas son archivos que contienen código HTML combinado con lógica de Blade para generar páginas dinámicas.
   - Cada vista tiene un archivo con la extensión `.blade.php`. Por ejemplo, puedes tener un archivo `inicio.blade.php` para mostrar la página de inicio.

   **Ejemplo:**
   Si quieres mostrar un saludo en la página de inicio, podrías crear un archivo `inicio.blade.php` con este contenido:
   ```html
   <h1>Bienvenido, {{ $nombre }}</h1>
   ```

4. **`config/`**:  
   - Contiene los archivos de configuración de tu aplicación, como la configuración de la base de datos, el sistema de almacenamiento o el entorno.
   - Archivos clave:
     - **`app.php`**: Configuración general de la aplicación.
     - **`database.php`**: Configuración de la conexión a la base de datos.

#### **Otras carpetas importantes:**

- **`public/`**:  
  Contiene los archivos accesibles públicamente, como imágenes, CSS, y JavaScript. Este es el punto de entrada de tu aplicación (archivo `index.php`).
  
- **`storage/`**:  
  Almacena archivos generados por la aplicación, como registros (logs) y archivos subidos por los usuarios.

- **`database/`**:  
  Contiene migraciones, seeds y factories para manejar la estructura y datos iniciales de la base de datos.

- **`vendor/`**:  
  Aquí es donde Composer guarda todas las dependencias de la aplicación. No deberías editar nada dentro de esta carpeta.

- **`.env`**:  
  Este archivo contiene las configuraciones específicas del entorno, como la conexión a la base de datos, claves API y otros ajustes.

### **4.2 Flujo de una solicitud**

Laravel sigue un flujo definido para procesar cada solicitud que recibe. Este flujo asegura que todas las partes de tu aplicación trabajen juntas de manera eficiente y ordenada.

#### **1. La solicitud llega al archivo `public/index.php`:**
   - Este es el archivo principal que Laravel utiliza para manejar todas las solicitudes.
   - Carga el framework y redirige la solicitud al lugar correcto (por ejemplo, las rutas definidas en `web.php` o `api.php`).

#### **2. Laravel busca la ruta correspondiente:**
   - Laravel revisa los archivos de rutas (como `routes/web.php`) para encontrar una coincidencia con la URL solicitada.
   - Si encuentra una coincidencia, ejecuta la acción asociada.
   
   **Ejemplo:**
   Supongamos que un usuario visita `http://miapp.com/usuarios`.
   - Laravel buscará una ruta como esta en `web.php`:
     ```php
     Route::get('/usuarios', [UsuarioController::class, 'index']);
     ```

#### **3. Se ejecuta el controlador:**
   - En el ejemplo anterior, Laravel llama al método `index` del `UsuarioController`.
   - Los controladores son responsables de manejar la lógica de negocio, como obtener datos de la base de datos o realizar cálculos.
   
   **Ejemplo:**
   ```php
   class UsuarioController extends Controller
   {
       public function index() {
           $usuarios = Usuario::all(); // Obtener todos los usuarios de la base de datos.
           return view('usuarios.index', ['usuarios' => $usuarios]); // Pasar los datos a la vista.
       }
   }
   ```

#### **4. Laravel genera la vista:**
   - El controlador devuelve una vista (un archivo Blade) con los datos que necesita.
   - Blade procesa la vista, reemplaza las variables y genera el HTML que se envía al navegador.

   **Ejemplo:**
   En `resources/views/usuarios/index.blade.php`:
   ```html
   <h1>Lista de usuarios</h1>
   <ul>
       @foreach ($usuarios as $usuario)
           <li>{{ $usuario->nombre }}</li>
       @endforeach
   </ul>
   ```

#### **5. El navegador muestra la página generada:**
   - El resultado final es una página HTML completamente renderizada que se envía al navegador del usuario.

---

## **5. Programación con Laravel**

Laravel es un framework que organiza la lógica de tu aplicación en diferentes partes, como rutas, controladores y middlewares. Esto hace que el código sea más fácil de mantener y entender. En esta sección aprenderemos cómo manejar estos elementos.

### **5.1 Enrutamiento**

#### **¿Qué es una ruta en Laravel?**
Una **ruta** en Laravel es una instrucción que define cómo la aplicación responde a una URL específica. Por ejemplo, puedes configurar que cuando un usuario visite `http://tusitio.com/saludo`, el sistema muestre un mensaje o cargue una página.

Las rutas se definen en el archivo `routes/web.php` para las páginas web estándar, o en `routes/api.php` para las APIs.

#### **Definiendo una ruta básica**
```php
Route::get('/saludo', function () {
    return "¡Hola, mundo!";
});
```

- **`Route::get('/saludo', ...)`:**
  - Define una ruta que responde a solicitudes HTTP del tipo `GET` (las que hace tu navegador al visitar una página).
  - La URL asociada es `/saludo`.

- **`function () { return "¡Hola, mundo!"; }`:**
  - Este código indica lo que Laravel debe hacer cuando alguien visita `/saludo`. En este caso, devuelve el texto `¡Hola, mundo!`.

Si ahora abres tu navegador y visitas `http://localhost/saludo`, verás `¡Hola, mundo!`.

#### **Tipos de métodos en las rutas**
Laravel soporta diferentes tipos de solicitudes HTTP. Cada uno tiene su propio propósito:
- **`GET`**: Usado para obtener datos o mostrar una página.
- **`POST`**: Usado para enviar datos al servidor (como al enviar un formulario).
- **`PUT` o `PATCH`**: Usado para actualizar datos existentes.
- **`DELETE`**: Usado para eliminar datos.

Ejemplo:
```php
Route::post('/formulario', function () {
    return "Datos enviados correctamente.";
});
```

#### **Rutas con parámetros dinámicos**
Puedes definir rutas que acepten valores dinámicos en la URL:
```php
Route::get('/saludo/{nombre}', function ($nombre) {
    return "¡Hola, $nombre!";
});
```

Si visitas `http://localhost/saludo/Juan`, Laravel mostrará `¡Hola, Juan!`.

También puedes establecer valores predeterminados para los parámetros:
```php
Route::get('/saludo/{nombre?}', function ($nombre = 'amigo') {
    return "¡Hola, $nombre!";
});
```

En este caso, si visitas `http://localhost/saludo`, Laravel mostrará `¡Hola, amigo!`.

### **5.2 Controladores**

#### **¿Qué es un controlador?**
Un **controlador** es una clase en Laravel que organiza la lógica de tu aplicación. En lugar de escribir toda la lógica directamente en las rutas, puedes delegar esas tareas a un controlador.

Esto es útil cuando tienes muchas rutas que comparten la misma lógica o cuando quieres mantener el código ordenado y modular.

#### **Creando un controlador**
Laravel incluye una herramienta llamada **Artisan** que simplifica muchas tareas. Para crear un controlador, usa el siguiente comando en tu terminal:
```bash
php artisan make:controller MiControlador
```

Esto generará un archivo llamado `MiControlador.php` en `app/Http/Controllers`.

#### **Definiendo métodos en el controlador**
Dentro del controlador, puedes definir métodos para manejar diferentes acciones. Por ejemplo:
```php
class MiControlador extends Controller {
    public function saludo() {
        return "¡Hola desde un controlador!";
    }
}
```

Este método `saludo()` contiene la lógica para mostrar un mensaje.

#### **Usando un controlador en una ruta**
Puedes conectar una ruta con un controlador y un método específico:
```php
Route::get('/saludo', [MiControlador::class, 'saludo']);
```

Cuando visitas `http://localhost/saludo`, Laravel ejecutará el método `saludo()` del controlador `MiControlador`.

#### **Controladores con múltiples métodos**
Un controlador puede tener varios métodos para manejar diferentes acciones:
```php
class MiControlador extends Controller {
    public function saludo() {
        return "¡Hola desde el controlador!";
    }

    public function despedida() {
        return "¡Adiós desde el controlador!";
    }
}
```

Puedes definir rutas para cada método:
```php
Route::get('/saludo', [MiControlador::class, 'saludo']);
Route::get('/despedida', [MiControlador::class, 'despedida']);
```

Esto hace que el código sea más organizado y fácil de mantener.

### **5.3 Middlewares**

#### **¿Qué es un middleware?**
Un **middleware** es una capa intermedia entre la solicitud del usuario y la respuesta del servidor. Su trabajo es filtrar o modificar las solicitudes antes de que lleguen al controlador, o las respuestas antes de que se envíen al navegador.

Por ejemplo, un middleware puede verificar si un usuario está autenticado antes de permitirle acceder a ciertas páginas.

#### **Usando middlewares en rutas**
Laravel incluye varios middlewares predeterminados, como `auth` para manejar autenticación. Puedes aplicar un middleware a una ruta de esta manera:
```php
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');
```

- **`->middleware('auth')`:**  
  Este middleware verifica si el usuario está autenticado. Si no lo está, lo redirige a la página de inicio de sesión.

#### **Creando un middleware personalizado**
Si necesitas un middleware específico, puedes crearlo con Artisan:
```bash
php artisan make:middleware VerificarRol
```

Esto genera un archivo en `app/Http/Middleware`. En este archivo, puedes definir la lógica del middleware:
```php
class VerificarRol {
    public function handle($request, Closure $next) {
        if ($request->user()->rol !== 'admin') {
            return redirect('/');
        }
        return $next($request);
    }
}
```

En este ejemplo, el middleware verifica si el usuario tiene el rol de administrador. Si no lo tiene, lo redirige a la página principal.

#### **Asignar middleware a rutas**
Para usar este middleware, debes registrarlo en `app/Http/Kernel.php`. Luego, puedes aplicarlo a una ruta:
```php
Route::get('/admin', function () {
    return "Bienvenido al panel de administración.";
})->middleware('verificarRol');
```

---

## **6. Eloquent ORM: Manejo de Bases de Datos**

Laravel incluye una herramienta llamada **Eloquent ORM (Object-Relational Mapper)**, que simplifica el trabajo con bases de datos al permitirte interactuar con ellas usando **modelos de PHP** en lugar de escribir consultas SQL. Esto hace que el código sea más legible, fácil de mantener y más seguro contra errores.

### **6.1 ¿Qué es Eloquent?**

Eloquent es un **ORM (Object-Relational Mapper)**, lo que significa que te permite trabajar con bases de datos como si estuvieras manejando objetos en PHP. Cada tabla de tu base de datos está representada por un **modelo**, que es una clase en PHP. Este modelo contiene toda la lógica para interactuar con los datos de esa tabla.

#### **Ventajas de usar Eloquent:**
1. **Simplicidad:** Puedes crear, leer, actualizar y eliminar datos de la base de datos sin escribir consultas SQL manuales.
2. **Legibilidad:** El código es más fácil de entender porque se parece al lenguaje natural.
3. **Manejo de relaciones:** Puedes definir relaciones entre tablas (uno a uno, uno a muchos, muchos a muchos) directamente en los modelos.
4. **Compatibilidad con múltiples bases de datos:** Eloquent funciona con MySQL, PostgreSQL, SQLite, SQL Server, entre otros.

#### **Ejemplo básico de Eloquent:**
En lugar de escribir esta consulta SQL:
```sql
SELECT * FROM usuarios WHERE id = 1;
```
Con Eloquent puedes hacer:
```php
$usuario = Usuario::find(1);
```
Aquí, `Usuario` es el modelo que representa la tabla `usuarios`.

### **6.2 Configuración de la base de datos**

Antes de usar Eloquent, necesitas configurar tu conexión a la base de datos. Esto se hace en el archivo `.env`, que se encuentra en la raíz de tu proyecto Laravel.

#### **Contenido del archivo `.env`:**
```env
DB_CONNECTION=mysql      # Tipo de base de datos (MySQL, SQLite, PostgreSQL, etc.)
DB_HOST=127.0.0.1        # Dirección del servidor de la base de datos
DB_PORT=3306             # Puerto de la base de datos (3306 es el predeterminado para MySQL)
DB_DATABASE=mi_base_datos # Nombre de tu base de datos
DB_USERNAME=mi_usuario   # Usuario de la base de datos
DB_PASSWORD=mi_contraseña # Contraseña del usuario
```

#### **Ejemplo práctico:**
Supongamos que estás usando MySQL y tienes una base de datos llamada `tienda`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tienda
DB_USERNAME=root
DB_PASSWORD=123456
```
Después de configurar `.env`, Laravel se conectará automáticamente a esta base de datos cuando uses Eloquent.

### **6.3 Definición de modelos**

Un **modelo** en Laravel es una clase PHP que representa una tabla en la base de datos. Puedes usar el comando Artisan para crear un modelo:

```bash
php artisan make:model Usuario
```

Este comando generará un archivo llamado `Usuario.php` en la carpeta `app/Models`.

#### **Ejemplo básico de un modelo:**
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model {
    // Especifica qué columnas pueden ser rellenadas masivamente
    protected $fillable = ['nombre', 'email'];
}
```

#### **¿Qué es `$fillable`?**
La propiedad `$fillable` indica qué columnas de la tabla pueden ser **asignadas masivamente**. Esto significa que puedes insertar o actualizar múltiples columnas de una vez, de forma segura.

Ejemplo:
```php
Usuario::create([
    'nombre' => 'Juan',
    'email' => 'juan@example.com',
]);
```
Laravel insertará estos datos en la tabla `usuarios`.

#### **Operaciones básicas con Eloquent:**
1. **Obtener todos los registros:**
   ```php
   $usuarios = Usuario::all();
   ```
2. **Encontrar un registro por ID:**
   ```php
   $usuario = Usuario::find(1);
   ```
3. **Insertar un registro:**
   ```php
   Usuario::create([
       'nombre' => 'Ana',
       'email' => 'ana@example.com',
   ]);
   ```
4. **Actualizar un registro:**
   ```php
   $usuario = Usuario::find(1);
   $usuario->email = 'nuevo_email@example.com';
   $usuario->save();
   ```
5. **Eliminar un registro:**
   ```php
   Usuario::destroy(1);
   ```

### **6.4 Relaciones en Eloquent**

Eloquent te permite definir relaciones entre tablas en tus modelos, lo que facilita trabajar con datos relacionados.

#### **Tipos de relaciones:**

1. **Uno a muchos:**
   Supongamos que tienes dos tablas: `posts` y `comentarios`. Cada post puede tener varios comentarios.

   - **Modelo Post:**
     ```php
     class Post extends Model {
         public function comentarios() {
             return $this->hasMany(Comentario::class);
         }
     }
     ```

   - **Uso en el código:**
     ```php
     $post = Post::find(1);
     $comentarios = $post->comentarios;
     ```

2. **Muchos a muchos:**
   Supongamos que tienes dos tablas: `usuarios` y `roles`, conectadas por una tabla intermedia `rol_usuario`.

   - **Modelo Usuario:**
     ```php
     class Usuario extends Model {
         public function roles() {
             return $this->belongsToMany(Rol::class);
         }
     }
     ```

   - **Uso en el código:**
     ```php
     $usuario = Usuario::find(1);
     $roles = $usuario->roles;
     ```

3. **Uno a uno:**
   Supongamos que cada usuario tiene un perfil asociado.

   - **Modelo Usuario:**
     ```php
     class Usuario extends Model {
         public function perfil() {
             return $this->hasOne(Perfil::class);
         }
     }
     ```

   - **Uso en el código:**
     ```php
     $perfil = Usuario::find(1)->perfil;
     ```

### **6.5 Migraciones**

Una **migración** es una clase de Laravel que define la estructura de una tabla en la base de datos. Con migraciones, puedes crear, modificar o eliminar tablas de manera programática, lo que es ideal para trabajar en equipo y mantener un control sobre los cambios en la base de datos.

#### **Crear una migración:**
Usa el comando Artisan:
```bash
php artisan make:migration crear_tabla_usuarios
```

Esto generará un archivo en la carpeta `database/migrations`.

#### **Estructura básica de una migración:**
```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaUsuarios extends Migration {
    public function up() {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('email')->unique();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('usuarios');
    }
}
```

- **`up`:** Define lo que sucede cuando se ejecuta la migración (por ejemplo, crear una tabla).
- **`down`:** Define cómo revertir la migración (por ejemplo, eliminar la tabla).

#### **Ejecutar migraciones:**
Para aplicar las migraciones, usa:
```bash
php artisan migrate
```

Esto creará las tablas definidas en tus migraciones.

#### **Revertir una migración:**
Si necesitas deshacer una migración, usa:
```bash
php artisan migrate:rollback
```