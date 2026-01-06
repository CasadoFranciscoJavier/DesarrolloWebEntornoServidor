# Guía Completa: Configuración Laravel con Autenticación Bootstrap

Esta guía te permitirá crear un proyecto Laravel funcional con autenticación y roles desde cero.

## 1. Crear Proyecto Laravel

```bash
composer create-project --prefer-dist laravel/laravel repaso-navidades
cd repaso-navidades
```

## 2. Configurar Base de Datos

### Editar `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=repaso-navidades
DB_USERNAME=root
DB_PASSWORD=1234
```

### Crear la base de datos:
```bash
mysql -u root -p1234 -e "CREATE DATABASE IF NOT EXISTS \`repaso-navidades\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

## 3. Instalar Laravel UI y Bootstrap

```bash
composer require laravel/ui
php artisan ui bootstrap --auth
```

## 4. Instalar Dependencias NPM

```bash
npm install
npm install -D sass-embedded bootstrap @popperjs/core
```

## 5. Configurar Archivos

### 5.1. Actualizar `app/Http/Controllers/Controller.php`:
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
```

### 5.2. Actualizar `vite.config.js`:
```js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/sass/app.scss', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
```

### 5.3. Actualizar `resources/js/bootstrap.js`:
```js
import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;
```

## 6. Crear Migración para Roles

```bash
php artisan make:migration add_rol_to_users_table --table=users
```

### Editar `database/migrations/XXXX_XX_XX_XXXXXX_add_rol_to_users_table.php`:
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
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
};
```

## 7. Crear Middleware de Roles

```bash
php artisan make:middleware RoleMiddleware
```

### Editar `app/Http/Middleware/RoleMiddleware.php`:
```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (Auth::check() && Auth::user()->role == $role) {
            $salida = $next($request);
        } else {
            $salida = redirect('/');
        }

        return $salida;
    }
}
```

## 8. Registrar Middleware

### Editar `bootstrap/app.php`:
```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
```

## 9. Configurar Rutas

### Editar `routes/web.php`:
```php
<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->middleware('auth');

Route::get('/panel-admin', function () {
    return view('panel-admin');
})->middleware('role:admin');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
```

## 10. Actualizar Layout (Opcional)

### Editar `resources/views/layouts/app.blade.php` (línea 68-70):
Agregar enlace al panel admin para usuarios con rol admin:
```php
@if (Auth::user()->role == "admin")
    <a class="dropdown-item" href="/panel-admin">Panel del admin</a>
@endif
```

Este código se coloca dentro del dropdown del usuario, después del enlace de logout.

## 11. Ejecutar Migraciones

```bash
php artisan migrate
```

## 12. Compilar Assets y Levantar Servidores

### Terminal 1 - Servidor Laravel:
```bash
php artisan serve
```

### Terminal 2 - Vite (desarrollo):
```bash
npm run dev
```

O para producción:
```bash
npm run build
```

## 13. Crear Usuario Admin (Opcional)

Puedes crear un usuario directamente en MySQL:
```sql
INSERT INTO users (name, email, email_verified_at, password, role, created_at, updated_at)
VALUES ('Admin', 'admin@example.com', NOW(), '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5idGSoy0r606K', 'admin', NOW(), NOW());
```
Password: `password`

O registrarte normalmente y cambiar el rol en la base de datos:
```sql
UPDATE users SET role = 'admin' WHERE email = 'tuemail@example.com';
```

## URLs de Acceso

- **Página principal**: http://127.0.0.1:8000
- **Login**: http://127.0.0.1:8000/login
- **Registro**: http://127.0.0.1:8000/register
- **Panel Admin**: http://127.0.0.1:8000/panel-admin (solo para usuarios con role='admin')

## Resumen de Archivos Modificados/Creados

1. `.env` - Configuración de base de datos
2. `app/Http/Controllers/Controller.php` - Agregar traits necesarios
3. `vite.config.js` - Cambiar a SCSS
4. `resources/js/bootstrap.js` - Importar Bootstrap JS
5. `database/migrations/XXXX_add_rol_to_users_table.php` - Migración de roles
6. `app/Http/Middleware/RoleMiddleware.php` - Middleware de roles
7. `bootstrap/app.php` - Registrar middleware
8. `routes/web.php` - Configurar rutas
9. `resources/views/layouts/app.blade.php` - Agregar enlace admin (opcional)

## Solución de Problemas Comunes

### Error: "Controller.php no tiene método middleware()"
**Solución**: Asegúrate de que `app/Http/Controllers/Controller.php` extienda de `BaseController` y use los traits necesarios (ver paso 5.1).

### Error: "Unable to locate file in Vite manifest: resources/sass/app.scss"
**Solución**: Verifica que `vite.config.js` tenga configurado `resources/sass/app.scss` en lugar de `resources/css/app.css` (ver paso 5.2).

### Error: "Preprocessor dependency sass-embedded not found"
**Solución**: Instala sass-embedded con `npm install -D sass-embedded`.

### Error: "Can't find stylesheet to import bootstrap/scss/bootstrap"
**Solución**: Instala Bootstrap con `npm install -D bootstrap @popperjs/core`.

### La base de datos no existe
**Solución**: Crea la base de datos manualmente o usa el comando MySQL del paso 2.

## Comandos Útiles

```bash
# Limpiar caché de Laravel
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Ver rutas
php artisan route:list

# Crear migración
php artisan make:migration nombre_migracion

# Ejecutar migraciones
php artisan migrate

# Revertir última migración
php artisan migrate:rollback

# Crear controlador
php artisan make:controller NombreController

# Crear modelo con migración
php artisan make:model NombreModelo -m

# Limpiar y reinstalar node_modules
rm -rf node_modules package-lock.json
npm install
```

---

**Proyecto creado exitosamente con Laravel 12, Bootstrap 5 y sistema de autenticación con roles.**
