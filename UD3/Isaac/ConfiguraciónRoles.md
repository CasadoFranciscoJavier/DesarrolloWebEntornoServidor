## **1. Instalar Laravel UI**

Primero, instala Laravel UI si no lo tienes:

```bash
composer require laravel/ui
```

Luego genera las vistas de autenticación:

```bash
php artisan ui bootstrap --auth
```

Esto generará las vistas de inicio de sesión, registro y recuperación de contraseñas.

Después instala y compila las dependencias necesarias:
```bash
npm install
npm run build
```

Por último es importante editar el fichero `web.php` dejando la ruta raíz de esta forma:
```php
Route::get('/', function () {
    return view('home');
});
```

---

## **2. Modificar la tabla `users` para añadir la columna `rol`**

Crea una migración para añadir la columna `rol` a la tabla `users`:

```bash
php artisan make:migration add_rol_to_users_table --table=users
```

En la migración generada (`database/migrations/xxxx_xx_xx_xxxxxx_add_rol_to_users_table.php`), añade lo siguiente en el método `up`:

```php
public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('role')->default('user'); // Rol por defecto: 'user'
    });
}

/**
 * Reverse the migrations.
 */
public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('role');
    });
}
```

Ejecuta la migración:

```bash
php artisan migrate
```

---

## **3. Añadir el atributo `rol` al modelo `User`**

Edita el modelo `User` (`app/Models/User.php`) para asegurarte de que el atributo `rol` sea asignable en masa:

```php
protected $fillable = [
    'name',
    'email',
    'password',
    'rol', // Añade este campo
];
```

---

## **4. Crear Middleware para Roles**

Crea un middleware para verificar roles:

```bash
php artisan make:middleware RoleMiddleware
```

Edita el middleware generado en `app/Http/Middleware/RoleMiddleware.php`:

```php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (Auth::check() && Auth::user()->role === $role) {
            $salida = $next($request);
        }else{
            $salida = redirect('/');
        }

        return $salida;
    }
}
```

---

## **5. Registrar el Middleware**

Abre `app/Providers/AppServiceProvider.php` y registra el middleware:

```php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        $this->app['router']->aliasMiddleware('role', \App\Http\Middleware\RoleMiddleware::class);
    }
}
```