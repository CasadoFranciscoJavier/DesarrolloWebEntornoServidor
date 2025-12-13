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
    protected $table = 'autores';

    protected $fillable = [
        'nombre',
        'pais',
        'periodo',
        'foto_url',
    ];

    public function obras()
    {
        return $this->hasMany(Obra::class);
    }

    // Constante con valores válidos para validación
    public const VALID_PERIODOS = [
        'Renacimiento',
        'Renacimiento tardío',
        'Barroco temprano',
        'Barroco',
        'Clasicismo',
        'Romanticismo'
    ];
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
        'autor_id',
    ];

    public function autor()
    {
        return $this->belongsTo(Autor::class);
    }

    // Constante con valores válidos para validación
    public const VALID_TIPOS = [
        'Misa',
        'Motete',
        'Pasión',
        'Magnificat',
        'Oficio de difuntos',
        'Responsorios',
        'Anthem',
        'Lamentaciones',
        'Madrigal espiritual',
        'Vísperas',
        'Colección sacra',
        'Salmo',
        'Oratorio',
        'Gloria',
        'Stabat Mater',
        'Requiem',
        'Himno'
    ];
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

### Paso 4.2: Editar controladores con validaciones centralizadas

**Ejemplo AutorControlador.php:**
```php
<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AutorControlador extends Controller
{
    // Método centralizado de validación (evita duplicación)
    private function ValidarAutor(Request $request, $id = null)
    {
        $periodosList = implode(',', Autor::VALID_PERIODOS);

        $nombreRule = ['required', 'string', 'min:3', 'max:100'];

        // Validación unique excepto para el registro actual
        if ($id == null) {
            $nombreRule[] = 'unique:autores,nombre';
        } else {
            $nombreRule[] = Rule::unique('autores', 'nombre')->ignore((int)$id, 'id');
        }

        $rules = [
            'nombre' => $nombreRule,
            'pais' => ['nullable', 'string', 'max:100'],
            'periodo' => ['nullable', 'string', 'in:' . $periodosList],
            'foto_url' => ['nullable', 'string', 'url', 'max:255'],
        ];

        $request->validate($rules);
    }

    // Registrar nuevo autor
    public function RegistrarAutor(Request $request)
    {
        $this->ValidarAutor($request);

        $data = $request->all();

        // Generar foto por defecto si no se proporciona
        if (empty($data['foto_url'])) {
            $nombreEncoded = urlencode($data['nombre']);
            $data['foto_url'] = "https://ui-avatars.com/api/?name={$nombreEncoded}&background=random&size=256";
        }

        $autorNuevo = Autor::create([
            'foto_url' => $data['foto_url'],
            'nombre' => $data['nombre'],
            'pais' => $data['pais'],
            'periodo' => $data['periodo'],
        ]);

        return $autorNuevo;
    }

    // Editar autor existente
    public function editarAutor($id, Request $request)
    {
        $this->ValidarAutor($request, $id);

        $data = $request->all();
        $autor = Autor::find($id);

        if (empty($data['foto_url'])) {
            $nombreEncoded = urlencode($data['nombre']);
            $data['foto_url'] = "https://ui-avatars.com/api/?name={$nombreEncoded}&background=random&size=256";
        }

        if ($autor) {
            $autor->foto_url = $data['foto_url'];
            $autor->nombre = $data['nombre'];
            $autor->pais = $data['pais'];
            $autor->periodo = $data['periodo'];

            $autor->save();
        }

        return $autor;
    }
}
```

**Ejemplo ObraControlador.php:**
```php
<?php

namespace App\Http\Controllers;

use App\Models\Obra;
use Illuminate\Http\Request;

class ObraControlador extends Controller
{
    // Método centralizado de validación
    private function ValidarObra(Request $request)
    {
        $tiposList = implode(',', Obra::VALID_TIPOS);

        $rules = [
            'titulo' => ['required', 'string', 'min:3', 'max:200'],
            'tipo' => ['nullable', 'string', 'in:' . $tiposList],
            'anio' => ['nullable', 'integer', 'min:1000', 'max:' . (date('Y') + 10)],
            'autor_id' => ['required', 'integer', 'exists:autores,id'],
        ];

        $request->validate($rules);
    }

    // Registrar nueva obra
    public function RegistrarObra(Request $request)
    {
        $this->ValidarObra($request);

        $data = $request->all();

        $obraNueva = Obra::create([
            'titulo' => $data['titulo'],
            'tipo' => $data['tipo'],
            'anio' => $data['anio'],
            'autor_id' => $data['autor_id'],
        ]);

        return $obraNueva;
    }
}
```

---

## 5. DEFINIR RUTAS

### Paso 5.1: Editar `routes/web.php`

**Importante:** Las rutas usan closures (funciones anónimas) en lugar de controladores resource. Esto da más flexibilidad.

```php
<?php

use App\Models\Autor;
use App\Models\Obra;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AutorControlador;
use App\Http\Controllers\ObraControlador;
use Illuminate\Validation\ValidationException;

// Ruta principal (home) - listado de autores
Route::get('/', function () {
    $autores = Autor::all();
    return view('home', ['autores' => $autores]);
});

// Ver detalles de un autor
Route::get('/autor/detalle/{id}', function ($id) {
    $autor = Autor::find($id);
    $obras = Obra::where('autor_id', $id)->orderBy('created_at', 'desc')->get();
    return view('detallesAutor', ['autor' => $autor, 'obras' => $obras]);
});

// Formulario crear autor
Route::get('/autor/create', function () {
    return view('crearAutor', [
        'periodos' => Autor::VALID_PERIODOS
    ]);
});

// Procesar formulario crear autor
Route::post('/autor', function (Request $request) {
    $controlador = new AutorControlador();

    try {
        $autor = $controlador->RegistrarAutor($request);
        $respuesta = redirect("/autor/detalle/" . $autor->id);
    } catch (ValidationException $e) {
        $respuesta = back()->withErrors($e->errors())->withInput();
    }

    return $respuesta;
});

// Formulario editar autor
Route::get('/autor/edit/{id}', function ($id) {
    $autor = Autor::find($id);
    return view('editarAutor', ['autor' => $autor], [
        'periodos' => Autor::VALID_PERIODOS
    ]);
});

// Procesar formulario editar autor
Route::post('/autor/edit/{id}', function ($id, Request $request) {
    $controlador = new AutorControlador();

    try {
        $autor = $controlador->editarAutor($id, $request);
        $respuesta = redirect("/autor/detalle/" . $autor->id);
    } catch (ValidationException $e) {
        $respuesta = back()->withErrors($e->errors());
    }

    return $respuesta;
});

// Eliminar autor
Route::get('/autor/delete/{id}', function ($id) {
    $autor = Autor::find($id);

    if ($autor != null) {
        $autor->delete();
    }

    return redirect('/');
});

// Formulario crear obra
Route::get('/obra/create/{autor_id}', function ($autor_id) {
    $autor = Autor::find($autor_id);
    return view('crearObra', [
        'autor' => $autor,
        'tipos' => Obra::VALID_TIPOS
    ]);
});

// Procesar formulario crear obra
Route::post('/obra', function (Request $request) {
    $controlador = new ObraControlador();

    try {
        $obra = $controlador->RegistrarObra($request);
        $respuesta = redirect("/autor/detalle/" . $obra->autor_id);
    } catch (ValidationException $e) {
        $respuesta = back()->withErrors($e->errors())->withInput();
    }

    return $respuesta;
});

// Eliminar obra (UN SOLO RETURN)
Route::get('/obra/delete/{id}', function ($id) {
    $obra = Obra::find($id);
    $ruta = '/';

    if ($obra != null) {
        $autorId = $obra->autor_id;
        $obra->delete();
        $ruta = '/autor/detalle/' . $autorId;
    }

    return redirect($ruta);
});
```

**Ventajas de este enfoque:**
- ✅ Control total sobre cada ruta
- ✅ UN SOLO `return` por función (buena práctica)
- ✅ Manejo de excepciones con try-catch
- ✅ Redirecciones personalizadas
- ✅ Paso de datos específicos a las vistas

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

### Paso 7.5: Vista SHOW (Ver detalle de autor con obras)

Crear: `resources/views/detallesAutor.blade.php`

**Mejoras aplicadas:**
- ✅ Operadores ternarios `?:` y null coalescing `??` (código más limpio)
- ✅ Lista de obras con diseño moderno usando `list-group`
- ✅ Botones de acción alineados a la derecha
- ✅ Confirmación JavaScript al eliminar

```blade
@extends('layouts.app')

@section('title', 'Detalle - {{ $autor->nombre }}')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="card shadow">
                    <div class="row g-0">
                        <!-- Imagen a la izquierda -->
                        <div class="col-md-4">
                            <img src="{{ $autor->foto_url }}" class="img-fluid w-100 h-100" style="object-fit: cover;"
                                alt="{{ $autor->nombre }}">
                        </div>

                        <!-- Contenido a la derecha -->
                        <div class="col-md-8 d-flex flex-column">
                            <div class="card-body p-4 flex-grow-1">
                                <h2 class="card-title text-primary mb-3">{{ $autor->nombre }}</h2>

                                <p class="mb-2"><strong>Pais:</strong> {{ $autor->pais ?? 'N/A' }}</p>
                                <p class="mb-3">
                                    <strong>Periodo:</strong>
                                    <span class="badge bg-success">{{ $autor->periodo ?? 'N/A' }}</span>
                                </p>

                                <hr>

                                <h5 class="mt-3 mb-3"><strong>Obras ({{ $autor->obras->count() }})</strong></h5>
                                @if($autor->obras->count() > 0)
                                    <div class="list-group">
                                        @foreach ($autor->obras as $obra)
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $obra->titulo }}</strong>
                                                    <span class="text-muted ms-2">{{ $obra->anio ? '(' . $obra->anio . ')' : '' }}</span>
                                                    <span class="badge bg-secondary ms-2">{{ $obra->tipo ?? '' }}</span>
                                                </div>
                                                <a href="/obra/delete/{{ $obra->id }}"
                                                   class="btn btn-danger btn-sm"
                                                   onclick="return confirm('¿Seguro que quieres borrar {{ $obra->titulo }}?')">
                                                    <i class="bi bi-trash"></i> Borrar
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted">No hay obras registradas</p>
                                @endif

                                <div class="d-flex gap-2">
                                    <a href="/obra/create/{{ $autor->id }}" class="btn btn-outline-info btn-sm mt-3">Añadir Obra</a>
                                </div>
                            </div>

                            <!-- Botones de accion -->
                            <div class="card-footer bg-light border-top">
                                <div class="d-flex gap-2 justify-content-between">
                                    <a href="/" class="btn btn-secondary btn-sm">Volver</a>
                                    <div class="d-flex gap-2">
                                        <a href="/autor/edit/{{ $autor->id }}" class="btn btn-warning btn-sm">Editar</a>
                                        <a href="/autor/delete/{{ $autor->id }}" class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Seguro que quieres borrar a {{ $autor->nombre }}?')">
                                            Eliminar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

### Buenas prácticas aplicadas en este proyecto:

#### 1. **UN SOLO RETURN por función**
```php
// ❌ MAL - Múltiples returns
function ejemplo($id) {
    if ($condicion) {
        return redirect('/ruta1');
    }
    return redirect('/ruta2');
}

// ✅ BIEN - Un solo return
function ejemplo($id) {
    $ruta = '/ruta2';

    if ($condicion) {
        $ruta = '/ruta1';
    }

    return redirect($ruta);
}
```

#### 2. **Constantes en Modelos para validación**
- Definir valores válidos (ENUM) como constantes en el modelo
- Usar `implode()` para convertirlas en reglas de validación
- Ejemplo: `Autor::VALID_PERIODOS`, `Obra::VALID_TIPOS`

#### 3. **Validaciones centralizadas**
- Crear método privado `ValidarAutor()` o `ValidarObra()`
- Reutilizar validaciones en crear/editar
- Evitar duplicación de código

#### 4. **Operadores ternarios y null coalescing en Blade**
```blade
{{-- ❌ MAL - Demasiado verboso --}}
@if($obra->anio)
    <span>({{ $obra->anio }})</span>
@endif

{{-- ✅ BIEN - Más limpio --}}
<span>{{ $obra->anio ? '(' . $obra->anio . ')' : '' }}</span>
<span>{{ $obra->tipo ?? 'Sin tipo' }}</span>
```

#### 5. **Guardar datos antes de eliminar**
```php
// ✅ IMPORTANTE: Guardar autor_id ANTES de delete()
$autorId = $obra->autor_id;
$obra->delete();
return redirect('/autor/detalle/' . $autorId);
```

#### 6. **Validación unique con excepción**
```php
// Para editar sin que falle el unique en el mismo registro
Rule::unique('autores', 'nombre')->ignore((int)$id, 'id')
```

#### 7. **Confirmaciones JavaScript**
```blade
<a href="/delete/{{ $id }}"
   onclick="return confirm('¿Seguro?')">
   Eliminar
</a>
```

### Recordatorios generales:

- **Siempre** estar en la carpeta del proyecto al ejecutar comandos `php artisan`
- **Bootstrap** se carga desde CDN (no requiere npm ni compilacion)
- **Validaciones** centralizadas en métodos privados del controlador
- **Relaciones** se definen en los modelos (hasMany, belongsTo)
- **@csrf** es obligatorio en todos los formularios
- **try-catch** para manejar ValidationException en rutas

---

## ERRORES COMUNES Y SOLUCIONES

### Error: "Attempt to read property on null"
**Causa:** Intentar acceder a propiedades de un objeto después de eliminarlo
**Solución:** Guardar datos necesarios ANTES de `delete()`

### Error: URL mal formada en redirect
**Causa:** Comillas incorrectas o concatenación mal hecha
**Solución:** Usar comillas dobles y operador `.` para concatenar

### Error: Badge vacío se muestra
**Causa:** Usar `{{ $var ?? '' }}` en un `<span>` siempre visible
**Solución:** Usar operador ternario completo o `@if`

---

Esta guia es adaptable a cualquier proyecto CRUD cambiando los nombres de entidades, campos y validaciones segun tus necesidades.
