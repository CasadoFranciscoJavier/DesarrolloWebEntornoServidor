# 📽️ GUÍA COMPLETA - CRUD Películas con Laravel

## 📋 Índice
1. [Descripción del Proyecto](#descripción-del-proyecto)
2. [Configuración Inicial](#configuración-inicial)
3. [Migraciones](#migraciones)
4. [Modelos](#modelos)
5. [Seeders (Datos de Prueba)](#seeders-datos-de-prueba)
6. [Autenticación y Roles](#autenticación-y-roles)
7. [Controladores](#controladores)
8. [Rutas](#rutas)
9. [Configuración CORS](#configuración-cors-para-consumir-la-api-desde-react)
10. [Documentación API con Swagger](#documentación-api-con-swagger)
11. [Vistas](#vistas)
12. [Lista de Comandos Completa](#lista-de-comandos-completa)

---

## 📝 Descripción del Proyecto

Sistema CRUD de películas con autenticación, roles (admin/user) y comentarios.

**Funcionalidades:**
- ✅ Sistema de autenticación (login/register)
- ✅ Roles: Admin y Usuario
- ✅ Lista de películas paginada (10 por página)
- ✅ Detalle de película con comentarios
- ✅ Crear/editar/eliminar películas (solo admin)
- ✅ Crear comentarios (usuarios autenticados)
- ✅ Eliminar comentarios (solo admin)

---

## 🚀 Configuración Inicial

### 1. Crear proyecto Laravel
```bash
composer create-project laravel/laravel CRUD_Peliculas
cd CRUD_Peliculas
```

### 2. Configurar base de datos

**Crear base de datos en MySQL:**
```sql
CREATE DATABASE mi_crud_peliculas;
```

**Editar archivo `.env`:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mi_crud_peliculas
DB_USERNAME=root
DB_PASSWORD=1234
```

### 3. Instalar autenticación Laravel UI
```bash
composer require laravel/ui
php artisan ui bootstrap --auth
npm install && npm run build
```

---

## 🗄️ Migraciones

### Orden de creación

#### 1. Agregar campo `role` a tabla `users`
```bash
php artisan make:migration add_rol_to_users_table --table=users
```

**Editar migración:**
```php
public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('role')->default('user');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('role');
    });
}
```

#### 2. Crear tabla `peliculas`
```bash
php artisan make:migration create_peliculas_table
```

**Editar migración:**
```php
public function up(): void
{
    Schema::create('peliculas', function (Blueprint $table) {
        $table->id();
        $table->string('poster_url');
        $table->string('title')->unique();
        $table->integer('release_year');
        $table->json('genres');
        $table->text('synopsis');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('peliculas');
}
```

#### 3. Crear tabla `comentarios`
```bash
php artisan make:migration create_comentarios_table
```

**Editar migración:**
```php
public function up(): void
{
    Schema::create('comentarios', function (Blueprint $table) {
        $table->id();

        $table->foreignId('pelicula_id')
              ->constrained('peliculas')
              ->onDelete('cascade');

        $table->foreignId('user_id')
              ->constrained('users')
              ->onDelete('cascade');

        $table->text('content');

        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('comentarios');
}
```

#### 4. Ejecutar migraciones
```bash
php artisan migrate
```

---

## 🎯 Modelos

**IMPORTANTE:** Los modelos se crean DESPUÉS de las migraciones para seguir el flujo correcto.

### 1. Modelo User (ya existe)

**Editar `app/Models/User.php`:**

Añadir 'role' al array $fillable:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'  // Añadir este campo
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
```

### 2. Crear modelo Pelicula
```bash
php artisan make:model Pelicula
```

**Editar `app/Models/Pelicula.php`:**
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelicula extends Model
{
    protected $fillable = [
        'poster_url',
        'title',
        'release_year',
        'genres',
        'synopsis',
    ];

    protected $casts = [
        'genres' => 'array',
    ];

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public const VALID_GENRES = [
        'Action', 'Comedy', 'Drama', 'Horror',
        'Sci-Fi', 'Fantasy', 'Documentary', 'Romance'
    ];
}
```

### 3. Crear modelo Comentario
```bash
php artisan make:model Comentario
```

**Editar `app/Models/Comentario.php`:**
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $fillable = [
        'pelicula_id',
        'user_id',
        'content',
    ];

    public function pelicula()
    {
        return $this->belongsTo(Pelicula::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

---

## 🌱 Seeders (Datos de Prueba)

### Generar hash de contraseña
```bash
php artisan tinker --execute="echo bcrypt('12345678');"
```

**Resultado:** `$2y$12$.zbRm1JcsQymXdwV4tYJKOJPDDntrfX.wY2xGmyjC7u9WvdkaH4dK`

### Ejecutar seed completo

Archivo `database/seed_completo.sql` contiene:
- 10 usuarios (2 admins + 8 users)
- 20 películas de ciencia ficción/acción
- 30 comentarios

**Importar en MySQL Workbench:**
1. Abrir MySQL Workbench
2. Abrir archivo `seed_completo.sql`
3. Ejecutar script completo

**Password de todos los usuarios:** `12345678`

---

## 🔐 Autenticación y Roles

### 1. Crear middleware de roles

**Nota:** Este archivo NO existe inicialmente. Lo creamos con el comando:

```bash
php artisan make:middleware RoleMiddleware
```

**Qué hace este comando:**
- Crea el archivo `app/Http/Middleware/RoleMiddleware.php`
- Genera una estructura básica de middleware que debemos personalizar

**Contenido inicial generado por Laravel:**
```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }
}
```

**Modificar completamente `app/Http/Middleware/RoleMiddleware.php`:**

Reemplazar TODO el contenido con:

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;  // AÑADIR: Import de Auth facade

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response  // MODIFICAR: Añadir parámetro $role
    {
        // AÑADIR: Toda esta lógica de verificación de rol
        if (Auth::check() && Auth::user()->role === $role) {
            $salida = $next($request);
        }else{
            $salida = redirect('/');
        }

        return $salida;
    }
}
```

**Cambios realizados:**
1. ✅ Añadido `use Illuminate\Support\Facades\Auth;`
2. ✅ Modificado parámetro del método `handle()` para aceptar `string $role`
3. ✅ Reemplazada lógica simple por verificación de autenticación y rol

---

### 2. Registrar middleware

**Nota:** El archivo `app/Providers/AppServiceProvider.php` YA EXISTE desde que creaste el proyecto Laravel.

**Contenido original de `app/Providers/AppServiceProvider.php`:**
```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        //
    }
}
```

**Modificar `app/Providers/AppServiceProvider.php`:**

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;  // AÑADIR: Import de Paginator

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // AÑADIR: Configurar paginación con Bootstrap 5
        Paginator::useBootstrapFive();

        // AÑADIR: Registrar alias del middleware de roles
        $this->app['router']->aliasMiddleware('role', \App\Http\Middleware\RoleMiddleware::class);
    }
}
```

**Cambios realizados:**
1. ✅ Añadido `use Illuminate\Pagination\Paginator;`
2. ✅ Añadido `Paginator::useBootstrapFive();` en el método `boot()`
3. ✅ Añadido registro del middleware con alias 'role'

**¿Por qué hacemos esto?**
- `Paginator::useBootstrapFive()` → Para que la paginación use estilos de Bootstrap 5
- `aliasMiddleware('role', ...)` → Para poder usar `->middleware('role:admin')` en las rutas

---

### 3. Crear y configurar HomeController

**Nota:** Este archivo NO existe inicialmente. Laravel UI lo crea automáticamente cuando ejecutas `php artisan ui bootstrap --auth`.

**Contenido inicial generado por Laravel UI:**
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');  // Solo retorna la vista vacía
    }
}
```

**Modificar `app/Http/Controllers/HomeController.php`:**

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelicula;  // AÑADIR: Import del modelo Pelicula

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // MODIFICAR: Obtener películas paginadas y pasarlas a la vista
        $peliculas = Pelicula::paginate(10);
        return view('home', ['peliculas' => $peliculas]);
    }
}
```

**Cambios realizados:**
1. ✅ Añadido `use App\Models\Pelicula;`
2. ✅ Modificado método `index()` para obtener películas paginadas
3. ✅ Pasamos datos a la vista con `['peliculas' => $peliculas]`

**¿Por qué hacemos esto?**
- La vista `home.blade.php` mostrará el listado de películas
- `paginate(10)` divide los resultados en páginas de 10 elementos
- Sin esto, la vista home estaría vacía

---

## 🎮 Controladores

### 1. Crear controlador de películas

**Nota:** Este archivo NO existe inicialmente. Lo creamos con el comando:

```bash
php artisan make:controller peliculaControlador
```

**Qué hace este comando:**
- Crea el archivo `app/Http/Controllers/peliculaControlador.php`
- Genera un controlador vacío con la estructura básica

**Contenido inicial generado por Laravel:**
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class peliculaControlador extends Controller
{
    //
}
```

**Modificar completamente `app/Http/Controllers/peliculaControlador.php`:**

Reemplazar TODO el contenido con:
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelicula;
use Illuminate\Validation\Rule;

class peliculaControlador extends Controller
{
    public function ValidarPelicula(Request $request, $id = null)
    {
        $genresList = implode(',', Pelicula::VALID_GENRES);

        $titleRule = ['required', 'string', 'min:3', 'max:100'];

        if ($id == null) {
            $titleRule[] = 'unique:peliculas,title';
        } else {
            $titleRule[] = Rule::unique('peliculas', 'title')->ignore($id);
        }

        $rules = [
            'poster_url' => ['required', 'string', 'url', 'max:255'],
            'title' => $titleRule,
            'release_year' => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'genres' => ['required', 'array', 'min:1', 'distinct'],
            'genres.*' => ['required', 'string', 'in:' . $genresList],
            'synopsis' => ['required', 'string', 'min:10', 'max:5000'],
        ];

        $request->validate($rules);
    }

    public function RegistrarPelicula(Request $request)
    {
        $this->ValidarPelicula($request);

        $data = $request->all();

        $peliculaNueva = Pelicula::create([
            'poster_url' => $data['poster_url'],
            'title' => $data['title'],
            'release_year' => $data['release_year'],
            'genres' => $data['genres'],
            'synopsis' => $data['synopsis'],
        ]);

        return $peliculaNueva;
    }

    public function editarPelicula($id, Request $request)
    {
        $this->ValidarPelicula($request, $id);

        $data = $request->all();
        $pelicula = Pelicula::find($id);

        if($pelicula){
            $pelicula->poster_url = $data['poster_url'];
            $pelicula->title = $data['title'];
            $pelicula->release_year = $data['release_year'];
            $pelicula->genres = $data['genres'];
            $pelicula->synopsis = $data['synopsis'];

            $pelicula->save();
        }

        return $pelicula;
    }
}
```

**Cambios realizados:**
1. ✅ Añadido `use App\Models\Pelicula;`
2. ✅ Añadido `use Illuminate\Validation\Rule;`
3. ✅ Creado método `ValidarPelicula($request, $id = null)` para validaciones
4. ✅ Creado método `RegistrarPelicula($request)` para crear películas
5. ✅ Creado método `editarPelicula($id, $request)` para actualizar películas

**¿Por qué tres métodos?**
- `ValidarPelicula()` → Centraliza las reglas de validación (reutilizable para crear y editar)
- `RegistrarPelicula()` → Crea nuevas películas en la base de datos
- `editarPelicula()` → Actualiza películas existentes

**Nota importante sobre validación:**
- Para **crear**: título debe ser único → `'unique:peliculas,title'`
- Para **editar**: título único excepto el actual → `Rule::unique()->ignore($id, 'id')`

---

### 2. Crear controlador de comentarios

**Nota:** Este archivo NO existe inicialmente. Lo creamos con el comando:

```bash
php artisan make:controller ComentarioControlador
```

**Qué hace este comando:**
- Crea el archivo `app/Http/Controllers/ComentarioControlador.php`
- Genera un controlador vacío con la estructura básica

**Contenido inicial generado por Laravel:**
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComentarioControlador extends Controller
{
    //
}
```

**Modificar completamente `app/Http/Controllers/ComentarioControlador.php`:**

Reemplazar TODO el contenido con:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;
use App\Models\Pelicula;

class ComentarioControlador extends Controller
{
    public function ValidarComentario(Request $request)
    {
        $rules = [
            'pelicula_id' => ['required', 'integer', 'exists:peliculas,id'],
            'content' => ['required', 'string', 'min:3', 'max:1000'],
        ];

       $request->validate($rules);
    }

    public function RegistrarComentario(Request $request)
    {
        $this->ValidarComentario($request);

        $data = $request->all();

        $comentarioNuevo = Comentario::create([
            'user_id' => auth()->id(),
            'pelicula_id' => $data['pelicula_id'],
            'content' => $data['content'],
        ]);

        return $comentarioNuevo;
    }
}
```

**Cambios realizados:**
1. ✅ Añadido `use App\Models\Comentario;`
2. ✅ Añadido `use App\Models\Pelicula;`
3. ✅ Creado método `ValidarComentario($request)` para validaciones
4. ✅ Creado método `RegistrarComentario($request)` para crear comentarios

**¿Por qué dos métodos?**
- `ValidarComentario()` → Valida que la película exista y el contenido sea válido
- `RegistrarComentario()` → Crea el comentario asociando automáticamente el usuario autenticado

**Nota importante:**
- `auth()->id()` obtiene automáticamente el ID del usuario autenticado
- `'exists:peliculas,id'` valida que la película exista en la base de datos

---

## 🛣️ Rutas

**Nota:** El archivo `routes/web.php` YA EXISTE desde que creaste el proyecto Laravel.

**Contenido inicial de `routes/web.php`:**
```php
<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
```

### Rutas Web

**Editar `routes/web.php`:**
```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\peliculaControlador;
use App\Http\Controllers\ComentarioControlador;
use App\Models\Pelicula;
use App\Models\Comentario;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

// Lista de películas
Route::get('/', function () {
    $peliculas = Pelicula::paginate(10);
    return view('home', ['peliculas' => $peliculas]);
})->middleware('auth');

// Crear película
Route::get('/movie/create', function () {
    return view('registrar-pelicula');
})->middleware(['auth', 'role:admin']);

Route::post('/movie', function (Request $request) {
    $controlador = new peliculaControlador();

    try {
        $pelicula = $controlador->RegistrarPelicula($request);
        $respuesta = redirect("/movie/detail/" . $pelicula->id);
    } catch (ValidationException $e) {
        $respuesta = back()->withErrors($e->errors());
    }

    return $respuesta;
});

// Detalle de película
Route::get('/movie/detail/{id}', function ($id) {
    $pelicula = Pelicula::find($id);
    $comentarios = Comentario::where('pelicula_id', $id)->orderBy('created_at', 'desc')->get();
    return view('detalle-pelicula', ['pelicula' => $pelicula, 'comentarios' => $comentarios]);
})->middleware('auth');

// Editar película
Route::get('/movie/edit/{id}', function ($id) {
    $pelicula = Pelicula::find($id);
    return view('editar-pelicula', ['pelicula' => $pelicula]);
})->middleware(['auth', 'role:admin']);

Route::post('/movie/edit/{id}', function ($id, Request $request) {
    $controlador = new peliculaControlador();

    try {
        $pelicula = $controlador->editarPelicula($id, $request);
        $respuesta = redirect("/movie/detail/" . $pelicula->id);
    } catch (ValidationException $e) {
        $respuesta = back()->withErrors($e->errors());
    }

    return $respuesta;
})->middleware(['auth', 'role:admin']);

// Borrar película
Route::get('/movie/delete/{id}', function ($id) {
    $pelicula = Pelicula::find($id);

    if ($pelicula != null) {
        $pelicula->delete();
    }

    return redirect('/');
})->middleware(['auth', 'role:admin']);

// Crear comentario
Route::post('/comments/create', function (Request $request) {
    $controlador = new ComentarioControlador();

    try {
        $comentario = $controlador->RegistrarComentario($request);
        $respuesta = redirect("/movie/detail/" . $comentario->pelicula_id);
    } catch (ValidationException $e) {
        $respuesta = back()->withErrors($e->errors());
    }

    return $respuesta;
})->middleware('auth');

// Borrar comentario
Route::get('/comments/delete/{id}', function ($id) {
    $comentario = Comentario::find($id);
    $peliculaId = 1;

    if ($comentario != null) {
        $peliculaId = $comentario->pelicula_id;
        $comentario->delete();
    }

    return redirect("/movie/detail/" . $peliculaId);
})->middleware(['auth', 'role:admin']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
```

### Rutas API (REST)

**Crear archivo de rutas API:**

Laravel incluye por defecto el archivo `routes/api.php` para rutas API. Si no existe, créalo manualmente o ejecuta:

```bash
php artisan install:api
```

**Editar `routes/api.php`:**
```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PeliculaApiController;
use Illuminate\Http\Request;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas API con controlador documentado para Swagger
Route::get('/movies', [PeliculaApiController::class, 'index']);
Route::get('/movies/{id}', [PeliculaApiController::class, 'show']);
Route::post('/movies', [PeliculaApiController::class, 'store']);
Route::put('/movies/{id}', [PeliculaApiController::class, 'update']);
Route::delete('/movies/{id}', [PeliculaApiController::class, 'destroy']);
```

**Rutas API disponibles:**

| Método | Ruta | Descripción |
|--------|------|-------------|
| GET | /api/movies | Listar todas las películas |
| GET | /api/movies/{id} | Obtener detalle de una película |
| POST | /api/movies | Crear una nueva película |
| PUT | /api/movies/{id} | Actualizar una película |
| DELETE | /api/movies/{id} | Eliminar una película |

**Ejemplo de uso con Postman:**

**POST /api/movies**
```json
{
    "poster_url": "https://example.com/poster.jpg",
    "title": "Nueva Película",
    "release_year": 2024,
    "genres": ["Action", "Drama"],
    "synopsis": "Descripción de la película..."
}
```

**PUT /api/movies/2**
```json
{
    "poster_url": "https://example.com/poster.jpg",
    "title": "Título Actualizado",
    "release_year": 2024,
    "genres": ["Action", "Sci-Fi"],
    "synopsis": "Nueva sinopsis..."
}
```

**IMPORTANTE:** No incluir el campo `id` en el body del JSON, ya que el ID viene en la URL.

---

## 🌐 Configuración CORS (para consumir la API desde React)

Para permitir que el frontend React (corriendo en `http://localhost:5173`) pueda consumir la API de Laravel sin problemas de CORS:

### 1. Publicar configuración de CORS

```bash
php artisan config:publish cors
```

Este comando crea el archivo `config/cors.php` si no existe.

### 2. Configurar CORS

**Editar `config/cors.php`:**

**Para desarrollo (permitir todo):**
```php
<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,
];
```

**Para producción (más restrictivo):**
```php
<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],

    'allowed_origins' => ['http://localhost:5173'],  // URL del frontend Vite

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['Content-Type', 'X-Requested-With', 'Authorization'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,
];
```

### 3. Limpiar caché de configuración

```bash
php artisan config:clear
```

### 4. Verificar que funciona

**Probar endpoint desde el navegador o Postman:**
```
http://127.0.0.1:8000/api/movies
```

**Notas importantes:**
- En desarrollo usamos `allowed_origins => ['*']` para aceptar peticiones desde cualquier origen
- En producción deberías especificar solo las URLs permitidas: `['http://localhost:5173', 'https://tu-dominio.com']`
- El middleware de CORS viene incluido por defecto en Laravel desde la versión 7+

---

## 📖 Documentación API con Swagger

### 1. Instalar L5-Swagger

```bash
composer require darkaonline/l5-swagger
```

### 2. Publicar configuración

```bash
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
```

Esto crea:
- `config/l5-swagger.php` - Configuración de Swagger
- `resources/views/vendor/l5-swagger/` - Vistas personalizables

### 3. Crear controlador API con anotaciones

**Crear `app/Http/Controllers/Api/PeliculaApiController.php`:**

Este controlador contiene todas las anotaciones OpenAPI (Swagger) que documentan la API:

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\peliculaControlador;
use App\Models\Pelicula;
use App\Models\Comentario;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PeliculaApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/movies",
     *     tags={"Películas"},
     *     summary="Listar todas las películas",
     *     description="Obtiene la lista completa de películas",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de películas obtenida exitosamente"
     *     )
     * )
     */
    public function index()
    {
        $peliculas = Pelicula::all();
        return $peliculas;
    }

    // ... otros métodos con sus anotaciones
}
```

### 4. Añadir anotaciones generales en Controller base

**Editar `app/Http/Controllers/Controller.php`:**

```php
/**
 * @OA\Info(
 *     title="API CRUD Películas",
 *     version="1.0.0",
 *     description="API REST para gestión de películas con Laravel",
 *     @OA\Contact(
 *         email="admin@crudpeliculas.com"
 *     )
 * )
 *
 * @OA\Server(
 *     url="http://127.0.0.1:8000",
 *     description="Servidor de desarrollo local"
 * )
 *
 * @OA\Tag(
 *     name="Películas",
 *     description="Operaciones CRUD de películas"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
```

### 5. Actualizar rutas API

**Modificar `routes/api.php` para usar el controlador documentado:**

```php
use App\Http\Controllers\Api\PeliculaApiController;

Route::get('/movies', [PeliculaApiController::class, 'index']);
Route::get('/movies/{id}', [PeliculaApiController::class, 'show']);
Route::post('/movies', [PeliculaApiController::class, 'store']);
Route::put('/movies/{id}', [PeliculaApiController::class, 'update']);
Route::delete('/movies/{id}', [PeliculaApiController::class, 'destroy']);
```

### 6. Generar documentación

```bash
php artisan l5-swagger:generate
```

### 7. Acceder a Swagger UI

Inicia el servidor:
```bash
php artisan serve
```

Accede a la interfaz Swagger en tu navegador:
```
http://127.0.0.1:8000/api/documentation
```

### Características de Swagger UI

- ✅ **Interfaz interactiva** para probar todos los endpoints
- ✅ **Documentación automática** generada desde anotaciones
- ✅ **Ejemplos de request/response** para cada endpoint
- ✅ **Validaciones documentadas** (tipos, límites, formatos)
- ✅ **Probador integrado** ("Try it out" button)

### Comandos útiles Swagger

```bash
# Regenerar documentación después de cambios
php artisan l5-swagger:generate

# Publicar assets de Swagger UI
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"

# Ver configuración actual
cat config/l5-swagger.php
```

### Estructura de anotaciones

**Ejemplo completo de endpoint documentado:**

```php
/**
 * @OA\Post(
 *     path="/api/movies",
 *     tags={"Películas"},
 *     summary="Crear una nueva película",
 *     description="Crea una nueva película en la base de datos",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"poster_url", "title", "release_year", "genres", "synopsis"},
 *             @OA\Property(property="poster_url", type="string", example="https://image.tmdb.org/t/p/w500/poster.jpg"),
 *             @OA\Property(property="title", type="string", example="Inception"),
 *             @OA\Property(property="release_year", type="integer", example=2010),
 *             @OA\Property(property="genres", type="array", @OA\Items(type="string"), example={"Sci-Fi", "Action"}),
 *             @OA\Property(property="synopsis", type="string", example="Un ladrón que roba secretos...")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Película creada exitosamente"
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Error de validación"
 *     )
 * )
 */
public function store(Request $request) { ... }
```

---

## 🎨 Vistas

### 1. Actualizar navbar en layout

**Editar `resources/views/layouts/app.blade.php` (línea 68-70):**
```blade
@if (Auth::user()->role == "admin")
    <a class="dropdown-item" href="/movie/create">Nueva Película</a>
@endif
```

### 2. Vista home (lista de películas)

**Archivo:** `resources/views/home.blade.php`

Grid responsive con paginación Bootstrap 5.

### 3. Vista registrar película

**Crear:** `resources/views/registrar-pelicula.blade.php`

Formulario con:
- URL del póster
- Título
- Año
- Géneros (8 checkboxes)
- Sinopsis
- Validación con `{{ old() }}`

### 4. Vista editar película

**Crear:** `resources/views/editar-pelicula.blade.php`

Igual que registrar pero con valores precargados usando `{{ old('field', $pelicula->field) }}`.

### 5. Vista detalle película

**Crear:** `resources/views/detalle-pelicula.blade.php`

Incluye:
- Información de la película
- Botones de editar/borrar (solo admin)
- Lista de comentarios con autor y fecha
- Formulario para añadir comentario
- Botón borrar comentario (solo admin)

---

## 📦 Lista de Comandos Completa

### Secuencia para crear un proyecto desde cero:

```bash
# 1. Crear proyecto
composer create-project laravel/laravel CRUD_Peliculas
cd CRUD_Peliculas

# 2. Instalar Laravel UI y Bootstrap
composer require laravel/ui
php artisan ui bootstrap --auth
npm install && npm run build

# 3. Crear migraciones
php artisan make:migration add_rol_to_users_table --table=users
php artisan make:migration create_peliculas_table
php artisan make:migration create_comentarios_table

# 4. Ejecutar migraciones
php artisan migrate

# 5. Crear modelos
php artisan make:model Pelicula
php artisan make:model Comentario

# 6. Crear middleware
php artisan make:middleware RoleMiddleware

# 7. Crear controladores
php artisan make:controller peliculaControlador
php artisan make:controller ComentarioControlador
php artisan make:controller HomeController

# 8. Crear rutas API
php artisan install:api

# 9. Configurar CORS (para consumo desde React)
php artisan config:publish cors
# Editar config/cors.php según necesidades
php artisan config:clear

# 10. Instalar y configurar Swagger
composer require darkaonline/l5-swagger
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
# Crear app/Http/Controllers/Api/PeliculaApiController.php con anotaciones
# Actualizar routes/api.php para usar PeliculaApiController
php artisan l5-swagger:generate

# 11. Generar hash de contraseña
php artisan tinker --execute="echo bcrypt('12345678');"

# 12. Verificar migraciones
php artisan migrate:status

# 13. Iniciar servidor
php artisan serve
```

### Comandos útiles durante el desarrollo:

```bash
# Ver rutas registradas
php artisan route:list

# Regenerar documentación Swagger
php artisan l5-swagger:generate

# Limpiar caché
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Rollback migraciones
php artisan migrate:rollback
php artisan migrate:rollback --step=1

# Refrescar migraciones (BORRA DATOS)
php artisan migrate:fresh

# Verificar si columna existe
php artisan tinker --execute="echo Schema::hasColumn('users', 'role') ? 'Existe' : 'No existe';"

# Acceder a tinker (consola interactiva)
php artisan tinker
```

---

## ✅ Resumen de Archivos Modificados/Creados

### Configuración
- `.env` - Configuración de base de datos
- `app/Providers/AppServiceProvider.php` - Bootstrap pagination + middleware

### Migraciones
- `database/migrations/2025_12_05_162924_add_rol_to_users_table.php`
- `database/migrations/2025_12_05_165045_create_peliculas_table.php`
- `database/migrations/2025_12_05_170004_create_comentarios_table.php`

### Modelos
- `app/Models/User.php` - Añadido campo 'role'
- `app/Models/Pelicula.php` - Modelo completo
- `app/Models/Comentario.php` - Modelo completo

### Middleware
- `app/Http/Middleware/RoleMiddleware.php`

### Controladores
- `app/Http/Controllers/HomeController.php`
- `app/Http/Controllers/peliculaControlador.php`
- `app/Http/Controllers/ComentarioControlador.php`

### Rutas
- `routes/web.php` - Todas las rutas del CRUD
- `routes/api.php` - API REST para películas

### Vistas
- `resources/views/layouts/app.blade.php` - Navbar actualizado
- `resources/views/home.blade.php` - Lista de películas
- `resources/views/registrar-pelicula.blade.php` - Formulario crear
- `resources/views/editar-pelicula.blade.php` - Formulario editar
- `resources/views/detalle-pelicula.blade.php` - Detalle + comentarios

### Datos
- `database/seed_completo.sql` - 10 users, 20 películas, 30 comentarios
- `server.php` - En raíz del proyecto

---

## 📝 Convenciones del Código

1. **Un solo return por función**
2. **Variables descriptivas:** `$pelicula`, `$comentario` (nunca `$p`, `$c`)
3. **Comparaciones:** Usar `==` y `!=` (no `===` ni `!==`)
4. **Sin breaks ni continues**
5. **Flujo lineal:** Usar variables de control

---

## 🔍 Conceptos Clave Explicados

### Validación de título único con edición

```php
$titleRule = ['required', 'string', 'min:3', 'max:100'];

if ($id == null) {
    // CREACIÓN: El título debe ser único
    $titleRule[] = 'unique:peliculas,title';
} else {
    // EDICIÓN: El título debe ser único EXCEPTO para este ID
    $titleRule[] = Rule::unique('peliculas', 'title')->ignore($id);
}
```

**¿Por qué?**
- Al crear: No puede haber 2 películas con el mismo título
- Al editar: Si no cambias el título, no debe dar error de duplicado

### Paginación

```php
// En la ruta
$peliculas = Pelicula::paginate(10);

// En la vista
{{ $peliculas->links() }}
```

- `paginate(10)` → Solo trae 10 registros
- Laravel lee `?page=2` de la URL automáticamente
- `links()` → Genera botones de paginación

---

**Última actualización:** 2025-12-06
**Versión Laravel:** 12.41.1
**Versión PHP:** 8.2.12
