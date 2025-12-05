# 📽️ GUÍA DEL PROYECTO - CRUD Películas

## 📋 Índice
1. [Descripción del Proyecto](#descripción-del-proyecto)
2. [Comandos Iniciales](#comandos-iniciales)
3. [Estructura de la Base de Datos](#estructura-de-la-base-de-datos)
4. [Modelos](#modelos)
5. [Sistema de Autenticación](#sistema-de-autenticación)
6. [Rutas](#rutas)
7. [Vistas](#vistas)
8. [Paginación](#paginación)
9. [Datos de Prueba](#datos-de-prueba)
10. [Problemas Comunes](#problemas-comunes)

---

## 📝 Descripción del Proyecto

Aplicación web de gestión de películas con sistema de roles (admin/usuario) y comentarios.

**Funcionalidades:**
- ✅ Lista de películas paginada (10 por página)
- ✅ Sistema de autenticación (login/register)
- ✅ Roles: Admin y Usuario
- ⏳ Detalle de película con comentarios (pendiente)
- ⏳ Crear/eliminar películas (solo admin) (pendiente)
- ⏳ Crear/eliminar comentarios (pendiente)

---

## 🚀 Comandos Iniciales

### 1. Crear el proyecto Laravel
```bash
composer create-project laravel/laravel CRUD_Peliculas
cd CRUD_Peliculas
```

### 2. Configurar base de datos
**Archivo:** [.env](.env)
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mi_crud_peliculas
DB_USERNAME=root
DB_PASSWORD=1234
```

### 3. Crear la base de datos en MySQL
Ejecutar en MySQL Workbench:
```sql
CREATE DATABASE mi_crud_peliculas;
```

---

## 🗄️ Estructura de la Base de Datos

### Migraciones

#### 1. Tabla `users` (ya existía)
**Archivo:** [database/migrations/0001_01_01_000000_create_users_table.php](database/migrations/0001_01_01_000000_create_users_table.php)

Campos originales:
- `id`
- `name`
- `email`
- `password`
- `remember_token`
- `timestamps`

#### 2. Agregar campo `role` a `users`
**Comando:**
```bash
php artisan make:migration add_rol_to_users_table --table=users
```

**Archivo:** [database/migrations/2025_12_05_162924_add_rol_to_users_table.php](database/migrations/2025_12_05_162924_add_rol_to_users_table.php)

**Contenido:**
```php
public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('role')->default('user');
    });
}
```

**Problema encontrado:** La migración se marcó como ejecutada pero la columna no se creó.

**Solución:** Eliminar registro de la tabla `migrations` y volver a ejecutar:
```bash
php artisan tinker --execute="DB::table('migrations')->where('migration', '2025_12_05_162924_add_rol_to_users_table')->delete();"
php artisan migrate --path=database/migrations/2025_12_05_162924_add_rol_to_users_table.php
```

#### 3. Tabla `peliculas`
**Comando:**
```bash
php artisan make:migration create_peliculas_table
```

**Archivo:** [database/migrations/2025_12_05_165045_create_peliculas_table.php](database/migrations/2025_12_05_165045_create_peliculas_table.php)

**Campos:**
- `id`
- `poster_url` (string) - URL de la imagen del póster
- `title` (string, unique) - Título de la película
- `release_year` (integer) - Año de estreno
- `genres` (json) - Array de géneros
- `synopsis` (text) - Sinopsis
- `timestamps`

#### 4. Tabla `comentarios`
**Comando:**
```bash
php artisan make:migration create_comentarios_table
```

**Archivo:** [database/migrations/2025_12_05_170004_create_comentarios_table.php](database/migrations/2025_12_05_170004_create_comentarios_table.php)

**Campos:**
- `id`
- `pelicula_id` (foreign key → peliculas)
- `user_id` (foreign key → users)
- `content` (text) - Contenido del comentario
- `timestamps`

### Ejecutar todas las migraciones
```bash
php artisan migrate
```

---

## 🎯 Modelos

### 1. Modelo User
**Archivo:** [app/Models/User.php](app/Models/User.php)

**Problema:** El nombre del campo en `$fillable` no coincidía con la base de datos.
- ❌ Antes: `'rol'` (español)
- ✅ Ahora: `'role'` (inglés)

**Código actual:**
```php
protected $fillable = [
    'name',
    'email',
    'password',
    'role'  // ← Debe coincidir con el nombre en la base de datos
];
```

### 2. Modelo Pelicula
**Problema inicial:** El modelo se llamaba `PeliculasModel` y Laravel buscaba la tabla `peliculas_models`.

**Solución:** Renombrar a `Pelicula` para que Laravel busque automáticamente la tabla `peliculas`.

**Archivo:** [app/Models/Pelicula.php](app/Models/Pelicula.php)

**Código:**
```php
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
        'genres' => 'array',  // Convierte JSON a array automáticamente
    ];

    public function comments()
    {
        return $this->hasMany(Comentario::class);
    }

    public const VALID_GENRES = [
        'Action', 'Comedy', 'Drama', 'Horror',
        'Sci-Fi', 'Fantasy', 'Documentary', 'Romance'
    ];
}
```

**Convención Laravel:**
- Modelo: `Pelicula` → Tabla: `peliculas`
- Modelo: `Usuario` → Tabla: `usuarios`
- Modelo: `Comentario` → Tabla: `comentarios`

### 3. Modelo Comentario
**Problema inicial:** Se llamaba `ComentariosModel`.

**Solución:** Renombrado a `Comentario`.

**Archivo:** [app/Models/Comentario.php](app/Models/Comentario.php)

**Código:**
```php
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

## 🔐 Sistema de Autenticación

### 1. Instalar Laravel UI
```bash
composer require laravel/ui
php artisan ui bootstrap --auth
npm install && npm run build
```

Esto crea:
- Rutas de autenticación (`Auth::routes()`)
- Vistas de login/register en `resources/views/auth/`
- Layout base en `resources/views/layouts/app.blade.php`

### 2. Middleware de Roles
**Comando:**
```bash
php artisan make:middleware RoleMiddleware
```

**Archivo:** [app/Http/Middleware/RoleMiddleware.php](app/Http/Middleware/RoleMiddleware.php)

**Código:**
```php
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
```

**Reglas del código:**
- ✅ Solo UN return al final
- ✅ Variables con nombres descriptivos
- ✅ Usar `==` en lugar de `===`
- ❌ No usar `break`, `continue` ni múltiples `return`

### 3. Registrar middleware
**Archivo:** [app/Providers/AppServiceProvider.php](app/Providers/AppServiceProvider.php)

```php
public function boot(): void
{
    Paginator::useBootstrapFive();
    $this->app['router']->aliasMiddleware('role', \App\Http\Middleware\RoleMiddleware::class);
}
```

---

## 🛣️ Rutas

**Archivo:** [routes/web.php](routes/web.php)

### Ruta principal (lista de películas)
```php
use App\Models\Pelicula;

Route::get('/', function () {
    $peliculas = Pelicula::paginate(10);
    return view('home', ['peliculas' => $peliculas]);
})->middleware('auth');
```

**Explicación:**
- `Pelicula::paginate(10)` → Trae 10 películas por página
- Si la URL es `/?page=2` → Laravel trae películas 11-20
- `middleware('auth')` → Solo usuarios autenticados pueden acceder

### Ruta de panel admin (ejemplo de uso de roles)
```php
Route::get('/panel-admin', function () {
    return view('panel-admin');
})->middleware('role:admin');
```

**Explicación:**
- `middleware('role:admin')` → Solo usuarios con `role = 'admin'` pueden acceder

### Rutas de autenticación
```php
Auth::routes();
```

Esto genera automáticamente:
- `/login` - Formulario de login
- `/register` - Formulario de registro
- `/logout` - Cerrar sesión
- `/password/reset` - Recuperar contraseña

---

## 🎨 Vistas

### Vista principal (lista de películas)
**Archivo:** [resources/views/home.blade.php](resources/views/home.blade.php)

**Características:**
- Grid responsive: 5 columnas en desktop, 3 en tablet, 2 en móvil
- Tarjetas con póster, título y año
- Botón "Ver detalles" en cada película
- Paginación al final

**Código clave:**
```blade
<div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-3">
    @foreach($peliculas as $pelicula)
    <div class="col">
        <div class="card">
            <img src="{{ $pelicula->poster_url }}" class="card-img-top" alt="{{ $pelicula->title }}">
            <div class="card-body p-2">
                <h6 class="card-title">{{ $pelicula->title }}</h6>
                <p class="card-text small mb-2"><strong>Año:</strong> {{ $pelicula->release_year }}</p>
                <a href="/movie/detail/{{ $pelicula->id }}" class="btn btn-primary btn-sm w-100">Ver detalles</a>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $peliculas->links() }}
</div>
```

**Clases Bootstrap usadas:**
- `row-cols-*` - Define cuántas columnas por fila
- `g-3` - Gap (espacio) entre columnas
- `card` - Tarjeta de Bootstrap
- `btn-sm` - Botón pequeño
- `w-100` - Ancho completo

### Layout base
**Archivo:** [resources/views/layouts/app.blade.php](resources/views/layouts/app.blade.php)

Incluye:
- Navbar con logo y menú de usuario
- Bootstrap 5 CSS/JS
- Links de login/register/logout

---

## 📄 Paginación

### ¿Cómo funciona?

**1. En la ruta** [routes/web.php:7](routes/web.php#L7)
```php
$peliculas = Pelicula::paginate(10);
```

**Explicación:**
- `paginate(10)` → Solo trae 10 películas, no todas
- Laravel mira la URL para saber qué página mostrar:
  - `http://localhost:8000/` → Página 1 (películas 1-10)
  - `http://localhost:8000/?page=2` → Página 2 (películas 11-20)

**2. En la vista** [home.blade.php:22-24](resources/views/home.blade.php#L22-L24)
```blade
{{ $peliculas->links() }}
```

**Explicación:**
- Genera automáticamente los botones de paginación: `[1] [2] [Next]`
- Los botones apuntan a `/?page=1`, `/?page=2`, etc.

**3. Configurar estilo Bootstrap** [AppServiceProvider.php:23](app/Providers/AppServiceProvider.php#L23)
```php
use Illuminate\Pagination\Paginator;

public function boot(): void
{
    Paginator::useBootstrapFive();
    // ...
}
```

**Explicación:**
- Por defecto Laravel usa Tailwind CSS (botones feos)
- `useBootstrapFive()` → Usa estilos de Bootstrap 5 (botones bonitos)

### Cambiar cantidad por página
```php
// 5 por página (4 páginas con 20 películas)
Pelicula::paginate(5);

// 20 por página (1 página con 20 películas)
Pelicula::paginate(20);
```

---

## 🌱 Datos de Prueba

### Archivo SQL completo
**Archivo:** [database/seed_completo.sql](database/seed_completo.sql)

**Contenido:**
- **10 usuarios:** 2 admins + 8 usuarios normales
- **20 películas:** Clásicos con pósters reales de TMDB
- **30 comentarios:** Distribuidos en varias películas

### Usuarios de prueba
**Password para todos:** `12345678`

| Email | Nombre | Role |
|-------|--------|------|
| admin1@test.com | Admin1 | admin |
| admin2@test.com | Admin2 | admin |
| user1@test.com | User1 | user |
| user2@test.com | User2 | user |
| ... | ... | user |

### Hash de contraseña
**Problema:** El hash de la contraseña debe generarse con Laravel, no con un generador externo.

**Solución:**
```bash
php artisan tinker --execute="echo bcrypt('12345678');"
```

Esto genera: `$2y$12$.zbRm1JcsQymXdwV4tYJKOJPDDntrfX.wY2xGmyjC7u9WvdkaH4dK`

### Cómo usar el seed
1. Abrir MySQL Workbench
2. Abrir el archivo `database/seed_completo.sql`
3. Ejecutar todo el script
4. Verificar: `SELECT COUNT(*) FROM peliculas;` → Debe dar 20

---

## ⚠️ Problemas Comunes

### 1. server.php se borra constantemente
**Causa:** Windows Defender detecta `server.php` como amenaza.

**Solución:** Crear `server.php` en la RAÍZ del proyecto (no en vendor).

**Archivo:** [server.php](server.php)
```php
<?php
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '');
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}
require_once __DIR__.'/public/index.php';
```

**Ubicación:** `CRUD_Peliculas/server.php` (raíz)

### 2. Error: "Table 'peliculas_models' doesn't exist"
**Causa:** El modelo se llamaba `PeliculasModel` y Laravel busca la tabla `peliculas_models`.

**Solución:** Renombrar modelo a `Pelicula` (singular, sin "Model").

### 3. Error: "Column 'role' not found"
**Causa:** La migración se marcó como ejecutada pero la columna no se creó.

**Solución:**
```bash
# Eliminar registro de la tabla migrations
php artisan tinker --execute="DB::table('migrations')->where('migration', '2025_12_05_162924_add_rol_to_users_table')->delete();"

# Ejecutar migración de nuevo
php artisan migrate --path=database/migrations/2025_12_05_162924_add_rol_to_users_table.php
```

### 4. Credenciales no coinciden al hacer login
**Causa:** El hash de la contraseña en la base de datos no es correcto.

**Solución:** Generar hash con Laravel:
```bash
php artisan tinker --execute="echo bcrypt('12345678');"
```

Copiar el hash y usarlo en el SQL.

### 5. Paginación con estilos feos (Tailwind)
**Causa:** Laravel usa Tailwind por defecto.

**Solución:** Configurar Bootstrap en [AppServiceProvider.php:23](app/Providers/AppServiceProvider.php#L23):
```php
Paginator::useBootstrapFive();
```

---

## 📚 Resumen de Archivos Importantes

### Configuración
- [.env](.env) - Configuración de base de datos
- [app/Providers/AppServiceProvider.php](app/Providers/AppServiceProvider.php) - Configuración de paginación y middleware

### Modelos
- [app/Models/User.php](app/Models/User.php) - Modelo de usuarios
- [app/Models/Pelicula.php](app/Models/Pelicula.php) - Modelo de películas
- [app/Models/Comentario.php](app/Models/Comentario.php) - Modelo de comentarios

### Migraciones
- [database/migrations/0001_01_01_000000_create_users_table.php](database/migrations/0001_01_01_000000_create_users_table.php)
- [database/migrations/2025_12_05_162924_add_rol_to_users_table.php](database/migrations/2025_12_05_162924_add_rol_to_users_table.php)
- [database/migrations/2025_12_05_165045_create_peliculas_table.php](database/migrations/2025_12_05_165045_create_peliculas_table.php)
- [database/migrations/2025_12_05_170004_create_comentarios_table.php](database/migrations/2025_12_05_170004_create_comentarios_table.php)

### Middleware
- [app/Http/Middleware/RoleMiddleware.php](app/Http/Middleware/RoleMiddleware.php) - Control de acceso por roles

### Rutas
- [routes/web.php](routes/web.php) - Rutas de la aplicación

### Vistas
- [resources/views/layouts/app.blade.php](resources/views/layouts/app.blade.php) - Layout base
- [resources/views/home.blade.php](resources/views/home.blade.php) - Lista de películas

### Datos de prueba
- [database/seed_completo.sql](database/seed_completo.sql) - Usuarios, películas y comentarios
- [server.php](server.php) - Servidor de desarrollo

---

## ✅ Estado Actual del Proyecto

### Completado
- ✅ Base de datos con 3 tablas: users, peliculas, comentarios
- ✅ Modelos con relaciones
- ✅ Sistema de autenticación (login/register)
- ✅ Middleware de roles (admin/user)
- ✅ Lista de películas paginada (10 por página)
- ✅ Vista responsive con Bootstrap 5
- ✅ Datos de prueba (20 películas, 10 usuarios, 30 comentarios)

### Pendiente
- ⏳ Detalle de película con comentarios
- ⏳ Crear película (solo admin)
- ⏳ Eliminar película (solo admin)
- ⏳ Crear comentario (usuarios logados)
- ⏳ Eliminar comentario (solo admin)
- ⏳ Botón "Nueva Película" en navbar (solo visible para admin)

---

## 📝 Notas Adicionales

### Convenciones del proyecto
- **Un solo return por función**
- **Variables descriptivas:** `$usuario`, `$pelicula` (nunca `$u`, `$p`)
- **Comparaciones:** Usar `==` y `!=` (no `===`)
- **Sin breaks ni continues en bucles**
- **Flujo lineal:** Usar variables de control en lugar de salidas tempranas

### Comandos útiles
```bash
# Servidor de desarrollo
php artisan serve

# Ejecutar migraciones
php artisan migrate

# Refrescar migraciones (borra datos)
php artisan migrate:fresh

# Ver estado de migraciones
php artisan migrate:status

# Tinker (consola interactiva)
php artisan tinker

# Verificar si columna existe
php artisan tinker --execute="echo Schema::hasColumn('users', 'role') ? 'Existe' : 'No existe';"

# Generar hash de contraseña
php artisan tinker --execute="echo bcrypt('12345678');"
```

---

**Última actualización:** 2025-12-05
**Versión Laravel:** 12.41.1
**Versión PHP:** 8.2.12
