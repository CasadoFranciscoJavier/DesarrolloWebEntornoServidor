# Guia Completa: Crear CRUD en Laravel desde Cero

Esta guia te permite crear cualquier proyecto CRUD en Laravel siguiendo estos pasos.

---

## 1. CREAR PROYECTO LARAVEL

### Paso 1.1: Navegar a la carpeta donde quieres crear el proyecto
```bash
cd ~/Documents/GitHub/2DAW/DesarrolloWebEntornoServidor/UD3
```

### Paso 1.2: Crear el proyecto Laravel
```bash
composer create-project --prefer-dist laravel/laravel nombre-proyecto
```
**Ejemplo:** `composer create-project --prefer-dist laravel/laravel crud-musica`

### Paso 1.3: Entrar al proyecto
```bash
cd nombre-proyecto
```

---

## 2. CONFIGURAR BASE DE DATOS

### Paso 2.1: Editar el archivo `.env`
Abrir el archivo `.env` en la raiz del proyecto y configurar:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_base_datos
DB_USERNAME=root
DB_PASSWORD=
```

**Ejemplo:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=crud_musica
DB_USERNAME=root
DB_PASSWORD=
```

### Paso 2.2: Generar la clave de aplicacion
```bash
php artisan key:generate
```

---

## 3. CREAR MODELOS Y MIGRACIONES

### Paso 3.1: Crear modelo con migracion
```bash
php artisan make:model NombreModelo -m
```

**Ejemplos:**
```bash
php artisan make:model Autor -m
php artisan make:model Obra -m
```

Esto crea:
- `app/Models/Autor.php`
- `database/migrations/YYYY_MM_DD_HHMMSS_create_autors_table.php`

### Paso 3.2: Editar las migraciones

Abrir cada archivo de migracion en `database/migrations/` y definir los campos.

**Ejemplo para Autores:**
```php
// database/migrations/XXXX_create_autors_table.php

public function up(): void
{
    Schema::create('autors', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('pais')->nullable();
        $table->enum('periodo', [
            'Renacimiento',
            'Renacimiento tardio',
            'Barroco temprano',
            'Barroco',
            'Clasicismo',
            'Romanticismo'
        ])->nullable();
        $table->string('foto_url')->nullable();
        $table->timestamps();
    });
}
```

**Ejemplo para Obras:**
```php
// database/migrations/XXXX_create_obras_table.php

public function up(): void
{
    Schema::create('obras', function (Blueprint $table) {
        $table->id();
        $table->string('titulo');
        $table->enum('tipo', [
            'Misa', 'Motete', 'Pasion', 'Magnificat',
            'Oficio de difuntos', 'Responsorios', 'Anthem',
            'Lamentaciones', 'Madrigal espiritual', 'Visperas',
            'Coleccion sacra', 'Salmo', 'Oratorio',
            'Gloria', 'Stabat Mater', 'Requiem', 'Himno'
        ])->nullable();
        $table->integer('anio')->nullable();
        $table->foreignId('autor_id')->constrained('autors')->onDelete('cascade');
        $table->timestamps();
    });
}
```

### Paso 3.3: Editar los modelos

**Ejemplo Autor.php:**
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    protected $fillable = [
        'nombre',
        'pais',
        'periodo',
        'foto_url'
    ];

    public function obras()
    {
        return $this->hasMany(Obra::class);
    }
}
```

**Ejemplo Obra.php:**
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obra extends Model
{
    protected $fillable = [
        'titulo',
        'tipo',
        'anio',
        'autor_id'
    ];

    public function autor()
    {
        return $this->belongsTo(Autor::class);
    }
}
```

### Paso 3.4: Ejecutar las migraciones
```bash
php artisan migrate
```

Si la base de datos no existe, Laravel preguntara si quieres crearla. Responder `yes`.

---

## 4. CREAR CONTROLADORES

### Paso 4.1: Crear controladores
```bash
php artisan make:controller NombreControlador
```

**Ejemplos:**
```bash
php artisan make:controller AutorControlador
php artisan make:controller ObraControlador
```

### Paso 4.2: Editar controladores

**Ejemplo AutorControlador.php:**
```php
<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Http\Request;

class AutorControlador extends Controller
{
    // Listar todos los autores
    public function index()
    {
        $autores = Autor::all();
        return view('autores.index', compact('autores'));
    }

    // Mostrar formulario de crear
    public function create()
    {
        return view('autores.create');
    }

    // Guardar nuevo autor
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'pais' => 'nullable|string|max:255',
            'periodo' => 'nullable|in:Renacimiento,Renacimiento tardio,Barroco temprano,Barroco,Clasicismo,Romanticismo',
            'foto_url' => 'nullable|url'
        ]);

        Autor::create($request->all());

        return redirect()->route('autores.index')
            ->with('success', 'Autor creado exitosamente');
    }

    // Mostrar un autor especifico
    public function show(Autor $autor)
    {
        return view('autores.show', compact('autor'));
    }

    // Mostrar formulario de editar
    public function edit(Autor $autor)
    {
        return view('autores.edit', compact('autor'));
    }

    // Actualizar autor
    public function update(Request $request, Autor $autor)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'pais' => 'nullable|string|max:255',
            'periodo' => 'nullable|in:Renacimiento,Renacimiento tardio,Barroco temprano,Barroco,Clasicismo,Romanticismo',
            'foto_url' => 'nullable|url'
        ]);

        $autor->update($request->all());

        return redirect()->route('autores.index')
            ->with('success', 'Autor actualizado exitosamente');
    }

    // Eliminar autor
    public function destroy(Autor $autor)
    {
        $autor->delete();

        return redirect()->route('autores.index')
            ->with('success', 'Autor eliminado exitosamente');
    }
}
```

---

## 5. DEFINIR RUTAS

### Paso 5.1: Editar `routes/web.php`

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutorControlador;
use App\Http\Controllers\ObraControlador;

// Ruta principal (home) - listado de obras
Route::get('/', [ObraControlador::class, 'index'])->name('home');

// Rutas resource para Autores (CRUD completo)
Route::resource('autores', AutorControlador::class);

// Rutas para Obras
Route::get('/autores/{autor}/obras/create', [ObraControlador::class, 'create'])->name('obras.create');
Route::post('/autores/{autor}/obras', [ObraControlador::class, 'store'])->name('obras.store');
Route::delete('/obras/{obra}', [ObraControlador::class, 'destroy'])->name('obras.destroy');
```

**Nota:** `Route::resource()` crea automaticamente todas estas rutas:
- GET `/autores` → index
- GET `/autores/create` → create
- POST `/autores` → store
- GET `/autores/{id}` → show
- GET `/autores/{id}/edit` → edit
- PUT/PATCH `/autores/{id}` → update
- DELETE `/autores/{id}` → destroy

---

## 6. CREAR LAYOUT BASE

### Paso 6.1: Crear archivo de layout

Crear el archivo: `resources/views/layouts/app.blade.php`

```blade
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'CRUD Proyecto')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                    CRUD Proyecto
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/autores') }}">Autores</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/autores/create') }}">Crear Autor</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>
```

---

## 7. CREAR VISTAS

### Paso 7.1: Crear estructura de carpetas
```
resources/views/
├── layouts/
│   └── app.blade.php
├── autores/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
└── obras/
    └── create.blade.php
```

### Paso 7.2: Vista INDEX (Listar autores)

Crear: `resources/views/autores/index.blade.php`

```blade
@extends('layouts.app')

@section('title', 'Listado de Autores')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Listado de Autores</h1>
            <a href="{{ route('autores.create') }}" class="btn btn-primary">Crear Autor</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Pais</th>
                    <th>Periodo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($autores as $autor)
                    <tr>
                        <td>{{ $autor->id }}</td>
                        <td>{{ $autor->nombre }}</td>
                        <td>{{ $autor->pais ?? 'N/A' }}</td>
                        <td>{{ $autor->periodo ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('autores.show', $autor) }}" class="btn btn-sm btn-info">Ver</a>
                            <a href="{{ route('autores.edit', $autor) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('autores.destroy', $autor) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Seguro?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No hay autores registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
```

### Paso 7.3: Vista CREATE (Crear autor)

Crear: `resources/views/autores/create.blade.php`

```blade
@extends('layouts.app')

@section('title', 'Crear Autor')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h1>Crear Nuevo Autor</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('autores.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre *</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" required>
            </div>

            <div class="mb-3">
                <label for="pais" class="form-label">Pais</label>
                <input type="text" name="pais" id="pais" class="form-control" value="{{ old('pais') }}">
            </div>

            <div class="mb-3">
                <label for="periodo" class="form-label">Periodo</label>
                <select name="periodo" id="periodo" class="form-select">
                    <option value="">Seleccionar...</option>
                    <option value="Renacimiento">Renacimiento</option>
                    <option value="Renacimiento tardio">Renacimiento tardio</option>
                    <option value="Barroco temprano">Barroco temprano</option>
                    <option value="Barroco">Barroco</option>
                    <option value="Clasicismo">Clasicismo</option>
                    <option value="Romanticismo">Romanticismo</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="foto_url" class="form-label">URL Foto</label>
                <input type="url" name="foto_url" id="foto_url" class="form-control" value="{{ old('foto_url') }}">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('autores.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
```

### Paso 7.4: Vista EDIT (Editar autor)

Crear: `resources/views/autores/edit.blade.php`

```blade
@extends('layouts.app')

@section('title', 'Editar Autor')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h1>Editar Autor</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('autores.update', $autor) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre *</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $autor->nombre) }}" required>
            </div>

            <div class="mb-3">
                <label for="pais" class="form-label">Pais</label>
                <input type="text" name="pais" id="pais" class="form-control" value="{{ old('pais', $autor->pais) }}">
            </div>

            <div class="mb-3">
                <label for="periodo" class="form-label">Periodo</label>
                <select name="periodo" id="periodo" class="form-select">
                    <option value="">Seleccionar...</option>
                    <option value="Renacimiento" {{ old('periodo', $autor->periodo) == 'Renacimiento' ? 'selected' : '' }}>Renacimiento</option>
                    <option value="Renacimiento tardio" {{ old('periodo', $autor->periodo) == 'Renacimiento tardio' ? 'selected' : '' }}>Renacimiento tardio</option>
                    <option value="Barroco temprano" {{ old('periodo', $autor->periodo) == 'Barroco temprano' ? 'selected' : '' }}>Barroco temprano</option>
                    <option value="Barroco" {{ old('periodo', $autor->periodo) == 'Barroco' ? 'selected' : '' }}>Barroco</option>
                    <option value="Clasicismo" {{ old('periodo', $autor->periodo) == 'Clasicismo' ? 'selected' : '' }}>Clasicismo</option>
                    <option value="Romanticismo" {{ old('periodo', $autor->periodo) == 'Romanticismo' ? 'selected' : '' }}>Romanticismo</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="foto_url" class="form-label">URL Foto</label>
                <input type="url" name="foto_url" id="foto_url" class="form-control" value="{{ old('foto_url', $autor->foto_url) }}">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('autores.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
```

### Paso 7.5: Vista SHOW (Ver detalle de autor)

Crear: `resources/views/autores/show.blade.php`

```blade
@extends('layouts.app')

@section('title', 'Detalle del Autor')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>{{ $autor->nombre }}</h1>
            <div>
                <a href="{{ route('autores.edit', $autor) }}" class="btn btn-warning">Editar</a>
                <a href="{{ route('autores.index') }}" class="btn btn-secondary">Volver</a>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <p><strong>Pais:</strong> {{ $autor->pais ?? 'N/A' }}</p>
                <p><strong>Periodo:</strong> {{ $autor->periodo ?? 'N/A' }}</p>
                @if($autor->foto_url)
                    <p><strong>Foto:</strong></p>
                    <img src="{{ $autor->foto_url }}" alt="{{ $autor->nombre }}" class="img-fluid" style="max-width: 300px;">
                @endif
            </div>
        </div>

        <h3>Obras de este autor</h3>
        <a href="{{ route('obras.create', $autor) }}" class="btn btn-primary mb-3">Agregar Obra</a>

        @if($autor->obras->count() > 0)
            <ul class="list-group">
                @foreach($autor->obras as $obra)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $obra->titulo }}</strong>
                            @if($obra->tipo)
                                <span class="badge bg-secondary">{{ $obra->tipo }}</span>
                            @endif
                            @if($obra->anio)
                                <span class="text-muted">({{ $obra->anio }})</span>
                            @endif
                        </div>
                        <form action="{{ route('obras.destroy', $obra) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Seguro?')">Eliminar</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-muted">Este autor aun no tiene obras registradas.</p>
        @endif
    </div>
</div>
@endsection
```

---

## 8. INICIAR SERVIDOR

```bash
php artisan serve
```

Abrir navegador en: `http://127.0.0.1:8000`

---

## 9. COMANDOS UTILES

### Limpiar cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### Ver rutas disponibles
```bash
php artisan route:list
```

### Revertir migraciones
```bash
php artisan migrate:rollback
```

### Refrescar todas las migraciones (CUIDADO: borra datos)
```bash
php artisan migrate:fresh
```

---

## 10. RESUMEN DE ARCHIVOS A CREAR/EDITAR

1. `.env` - Configuracion de base de datos
2. `database/migrations/XXXX_create_TABLA_table.php` - Definir estructura de tablas
3. `app/Models/Modelo.php` - Definir modelos y relaciones
4. `app/Http/Controllers/Controlador.php` - Logica del CRUD
5. `routes/web.php` - Definir rutas
6. `resources/views/layouts/app.blade.php` - Layout base
7. `resources/views/entidad/index.blade.php` - Vista de listado
8. `resources/views/entidad/create.blade.php` - Vista de crear
9. `resources/views/entidad/edit.blade.php` - Vista de editar
10. `resources/views/entidad/show.blade.php` - Vista de detalle

---

## NOTAS IMPORTANTES

- **Siempre** estar en la carpeta del proyecto al ejecutar comandos `php artisan`
- **Bootstrap** se carga desde CDN (no requiere npm ni compilacion)
- **Validaciones** se hacen en el controlador con `$request->validate()`
- **Relaciones** se definen en los modelos (hasMany, belongsTo)
- **Route::resource** crea automaticamente 7 rutas CRUD
- **@csrf** es obligatorio en todos los formularios
- **@method('PUT')** o **@method('DELETE')** para editar/eliminar

---

Esta guia es adaptable a cualquier proyecto CRUD cambiando los nombres de entidades, campos y validaciones segun tus necesidades.
