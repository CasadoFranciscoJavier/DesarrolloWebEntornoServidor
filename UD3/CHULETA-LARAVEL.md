# Chuleta Laravel - DAW

## 📁 Rutas y Ficheros Importantes

```
/app/Models                  → Modelos (Modelo)
/resources/views             → Plantillas Blade (Vista)
/app/Http/Controllers        → Controladores (Controlador)
/routes/web.php             → Rutas de la página web
/routes/api.php             → Endpoints de la API
/database/migrations        → Migraciones
/.env                       → Configuración BD y entorno
```

**Importante:** Las vistas deben tener extensión `.blade.php`

---

## 🚀 Configurar Proyecto NUEVO

```bash
# Crear proyecto Laravel
composer create-project --prefer-dist laravel/laravel nombre-proyecto

# Configurar .env (copiar de .env.example)
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate

# Configurar BD en .env:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_bd
DB_USERNAME=root
DB_PASSWORD=tu_password

# Crear base de datos manualmente en phpMyAdmin o MySQL Workbench
# Nombre: nombre_bd

# Ejecutar migraciones
php artisan migrate

# Iniciar servidor
php artisan serve
```

---

## 🔄 Configurar Proyecto CLONADO (Academia ↔ Casa)

```bash
# 1. Clonar o hacer pull
git pull

# 2. Instalar dependencias
composer install

# 3. Copiar .env (si no existe)
cp .env.example .env

# 4. Configurar .env con tu BD local
# Editar: DB_DATABASE, DB_PASSWORD

# 5. Generar clave
php artisan key:generate

# 6. Crear base de datos manualmente en phpMyAdmin o MySQL Workbench
# Nombre: el que configuraste en .env

# 7. Ejecutar migraciones
php artisan migrate

# 8. Limpiar caché
php artisan config:clear

# 9. Iniciar servidor
php artisan serve
```

---

## 🔧 Comandos de Configuración

```bash
# Arreglar problema CORS
php artisan config:publish cors

# Instalar API (Sanctum)
php artisan install:api

# Limpiar caché de configuración
php artisan config:clear

# Ver estado de migraciones
php artisan migrate:status
```

---

## 📦 Crear Componentes

### Modelo
```bash
php artisan make:model NombreModelo -m
# -m crea la migración automáticamente
# -mfs crea migración + factory + seeder
```

**Ejemplo de modelo:**
```php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price'];
}
```

### Controlador
```bash
php artisan make:controller NombreControlador
```

### Migración
```bash
php artisan make:migration crear_tabla_nombre
```

**Ejemplo de migración:**
```php
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->float('price');
    $table->timestamps();
});
```

### Factory
```bash
php artisan make:factory NombreModeloFactory
```

**Agregar en el modelo:**
```php
use HasFactory;
```

**Ejemplo de factory:**
```php
public function definition(): array
{
    return [
        'title' => fake()->sentence(3),
        'genre' => fake()->randomElement(['Action', 'Comedy', 'Drama']),
        'releaseYear' => fake()->year(),
        'synopsis' => fake()->paragraph(3),
    ];
}
```

### Seeder
```bash
php artisan make:seeder NombreModeloSeeder
```

**Ejemplo de seeder:**
```php
use App\Models\Movie;

public function run(): void
{
    Movie::factory(10)->create();
}
```

---

## 🗄️ Comandos de Base de Datos

```bash
# Ejecutar migraciones
php artisan migrate

# Ejecutar migración + seeders
php artisan migrate:fresh --seed

# Ejecutar un seeder específico
php artisan db:seed --class=NombreModeloSeeder

# Revertir última migración
php artisan migrate:rollback

# Ver estado de migraciones
php artisan migrate:status
```

---

## 🌐 Servidor de Desarrollo

```bash
# Iniciar servidor (http://127.0.0.1:8000)
php artisan serve

# Iniciar en otro puerto
php artisan serve --port=8080
```

---

## 🔄 Flujo de Trabajo Academia ↔ Casa

### En Casa (antes de irte)
```bash
git add .
git commit -m "descripción de cambios"
git push
```

### En Academia (al llegar)
```bash
git pull
composer install
php artisan migrate  # Si hay nuevas migraciones
php artisan serve
```

### En Academia (antes de irte)
```bash
git add .
git commit -m "descripción de cambios"
git push
```

### En Casa (al llegar)
```bash
git pull
composer install
php artisan migrate  # Si hay nuevas migraciones
php artisan serve
```

---

## ⚠️ Problemas Comunes

### Error: "server.php not found"
```bash
# Crear archivo server.php en la raíz del proyecto
# (Ver archivo server.php del proyecto)
```

### Error: "Database not configured"
```bash
# Verificar .env: DB_CONNECTION=mysql (minúscula)
php artisan config:clear
```

### Error: "Unknown database"
```bash
# Crear la base de datos en phpMyAdmin o MySQL Workbench
# con el nombre que configuraste en .env
```

### Error: Composer SSL/TLS
```bash
# Es solo un warning, se puede ignorar
```

### Vendor corrupto o faltante
```bash
# Reinstalar dependencias
composer install
# O actualizar
composer update
```

---

## 📝 Notas Importantes

- **NUNCA** subir `.env` a Git (está en `.gitignore`)
- **SIEMPRE** subir `.env.example` a Git
- **SIEMPRE** ejecutar `composer install` después de `git pull`
- El archivo `vendor/` NO se sube a Git
- Las migraciones SÍ se suben a Git
- Nombres de BD en minúsculas (buena práctica)
