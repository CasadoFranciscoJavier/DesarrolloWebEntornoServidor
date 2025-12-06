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
9. [Vistas](#vistas)
10. [Lista de Comandos Completa](#lista-de-comandos-completa)

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
```php
protected $fillable = [
    'name',
    'email',
    'password',
    'role'  // Añadir este campo
];
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
```bash
php artisan make:middleware RoleMiddleware
```

**Editar `app/Http/Middleware/RoleMiddleware.php`:**
```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $respuesta = null;

        if ($request->user() == null) {
            $respuesta = redirect('/login');
        }

        if ($respuesta == null && $request->user()->role != $role) {
            $respuesta = abort(403, 'No tienes permisos para acceder a esta página');
        }

        if ($respuesta == null) {
            $respuesta = $next($request);
        }

        return $respuesta;
    }
}
```

### 2. Registrar middleware

**Editar `app/Providers/AppServiceProvider.php`:**
```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        $this->app['router']->aliasMiddleware('role', \App\Http\Middleware\RoleMiddleware::class);
    }
}
```

### 3. Actualizar HomeController

**Editar `app/Http/Controllers/HomeController.php`:**
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelicula;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $peliculas = Pelicula::paginate(10);
        return view('home', ['peliculas' => $peliculas]);
    }
}
```

---

## 🎮 Controladores

### 1. Crear controlador de películas
```bash
php artisan make:controller peliculaControlador
```

**Editar `app/Http/Controllers/peliculaControlador.php`:**
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

### 2. Crear controlador de comentarios
```bash
php artisan make:controller ComentarioControlador
```

**Editar `app/Http/Controllers/ComentarioControlador.php`:**
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

---

## 🛣️ Rutas

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
use App\Http\Controllers\peliculaControlador;
use App\Models\Pelicula;
use App\Http\Controllers\ComentarioControlador;
use App\Models\Comentario;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Listar todas las películas
Route::get('/movies', function () {
    $peliculas = Pelicula::all();
    return $peliculas;
});

// Obtener detalle de película con comentarios
Route::get('/movies/{id}', function ($id) {
    $pelicula = Pelicula::find($id);
    $comentarios = Comentario::where('pelicula_id', $id)->orderBy('created_at', 'desc')->get();
    return [$pelicula, $comentarios];
});

// Crear nueva película
Route::post('/movies', function (Request $request) {
    $controlador = new peliculaControlador();

    try {
        $respuesta = $controlador->RegistrarPelicula($request);
    } catch (ValidationException $e) {
        $respuesta = $e->errors();
    }

    return $respuesta;
});

// Actualizar película
Route::put('/movies/{id}', function ($id, Request $request) {
    $controlador = new peliculaControlador();

    try {
        $respuesta = $controlador->editarPelicula($id,$request);
    } catch (ValidationException $e) {
        $respuesta = $e->errors();
    }

    return $respuesta;
});

// Eliminar película
Route::delete('/movies/{id}', function ($id) {
    $pelicula = Pelicula::find($id);

    if ($pelicula) {
        $pelicula->delete();
        return ['message' => 'Película eliminada correctamente'];
    }

    return ['error' => 'Película no encontrada'];
});
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

# 9. Generar hash de contraseña
php artisan tinker --execute="echo bcrypt('12345678');"

# 10. Verificar migraciones
php artisan migrate:status

# 11. Iniciar servidor
php artisan serve
```

### Comandos útiles durante el desarrollo:

```bash
# Ver rutas registradas
php artisan route:list

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
