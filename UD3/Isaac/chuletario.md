# Resumen Laravel

## Rutas y ficheros importantes:
- **`/app/Models`**: Modelos (Modelo).
- **`/public/resources/views`**: Plantillas de Blade (Vista).
- **`/app/Http/Controllers`**: Controladores (Controlador).
---
- **`/routes/web.php`**: Rutas de mi página.
- **`/routes/api.php`**: *Endpoints* de mi API.
- **`/database/migrations`**: migraciones.
- **`/.env`**: configuración de la conexión a base de datos.

> [!TIP] 
> Las vistas deben tener la extensión `.blade.php`.

## Resumen comandos

### Configurar proyecto CLONADO
```bash
composer install
php artisan key:generate
php artisan migrate
```

### Arreglar problema CORS
```bash
php artisan config:publish cors
```

### Crear proyecto
```bash
composer create-project --prefer-dist laravel/laravel nombre-proyecto
```
> [!WARNING] 
> Si te aparece el error `PHP error: "The zip extension and unzip command are both missing, skipping."`, [sigue estos pasos](https://stackoverflow.com/a/76529283).

### Crear API
```bash
php artisan install:api
```

### Crear Modelo
```bash
php artisan make:model nombre-modelo -m
```
> [!NOTE] 
> `-m` nos crea automáticamente la migración en `/database/migrations`.
> `-mfs` nos crea automáticamente la migración, el factory y el seeder.

> [!WARNING] 
> Tanto el modelo como la migración deben ser modificadas y completadas.

***Ejemplo de modelo:***
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price'
    ];
}
```

### Crear Controlador
```bash
php artisan make:controller nombre-controlador
```

### Crear migración
```bash
php artisan make:migration crear_tabla_nombre_objeto
```

***Ejemplo de migración:***
```php
Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('price');
            $table->timestamps();
        });
``` 

### Ejecutar migración
```bash
php artisan migrate
```

> [!TIP] 
> Para que la base de datos se borre si ya existe y se ejecuten los seeders, podemos usar `php artisan migrate:fresh --seed`.

### Ejecutar servidor de desarrollo
```bash
php artisan serve
```

---

### Crear Factory
```bash
php artisan make:factory NombreDelModeloFactory.php
```

> [!WARNING] 
> En la clase del modelo hay que añadir `use HasFactory;` para indicar que tiene un Factory.

***Ejemplo de factory:***
```php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3), // Genera un título con 3 palabras.
            'genre' => fake()->randomElement(['Action', 'Comedy', 'Drama', 'Horror', 'Sci-Fi', 'Fantasy', 'Documentary', 'Romance']), // Género aleatorio.
            'releaseYear' => fake()->year(), // Genera un año aleatorio.
            'synopsis' => fake()->paragraph(3), // Sinopsis más detallada con 3 frases.
            'posterURL' => fake()->imageUrl(300, 450, 'movies', true, 'Faker'), // URL para una imagen de 300x450 de categoría "movies".
        ];
    }
}
```

### Crear Seeder
```bash
php artisan make:seeder NombreDelModeloSeeder.php
```

***Ejemplo de seeder:***
```php
use App\Models\Movie;

class MovieSeeder extends Seeder
{

    public function run(): void
    {
        Movie::factory(10)->create(); // Crea 10 películas usando su factory
    }
}

```

### Ejecutar Seeder
```bash
php artisan db:seed --class=NombreDelModeloSeeder
```