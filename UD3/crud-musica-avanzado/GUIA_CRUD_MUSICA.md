# Guía CRUD Música Avanzado - Relaciones Muchos a Muchos

Esta guía explica paso a paso cómo funciona el proyecto **crud-musica-avanzado**, un CRUD de Laravel con relaciones **muchos a muchos** usando **tablas pivote**.

---

## ¿Qué es diferente en este proyecto?

En el proyecto **crud-musica** básico:
- Un autor tenía **UN solo periodo** (enum en la base de datos)
- Una obra tenía **UN solo tipo** (enum en la base de datos)

En **crud-musica-avanzado**:
- Un autor puede tener **VARIOS periodos** (Beethoven es Clasicismo Y Romanticismo)
- Una obra puede ser de **VARIOS tipos** (Una misa puede ser también un oratorio)

Esto se logra usando **relaciones muchos a muchos** con **tablas pivote**.

---

## 1. Estructura de Base de Datos

### Tablas Principales

#### `autores`
```
id          - Identificador único
nombre      - Nombre del autor
pais        - País del autor
foto_url    - URL de la foto
created_at  - Fecha de creación
updated_at  - Fecha de actualización
```

#### `periodos`
```
id          - Identificador único
nombre      - Nombre del periodo (ej: "Barroco", "Clasicismo")
created_at
updated_at
```

#### `tipos`
```
id          - Identificador único
nombre      - Nombre del tipo (ej: "Misa", "Ópera", "Concierto")
created_at
updated_at
```

#### `obras`
```
id          - Identificador único
titulo      - Título de la obra
anio        - Año de composición
autor_id    - ID del autor (clave foránea)
created_at
updated_at
```

### Tablas Pivote (Intermedias)

#### `autor_periodo`
```
id          - Identificador único
autor_id    - ID del autor (clave foránea)
periodo_id  - ID del periodo (clave foránea)
created_at
updated_at
```
**Función**: Conecta autores con sus periodos. Si Beethoven tiene ID 3 y Clasicismo tiene ID 5, habrá una fila con `autor_id=3` y `periodo_id=5`.

#### `obra_tipo`
```
id          - Identificador único
obra_id     - ID de la obra (clave foránea)
tipo_id     - ID del tipo (clave foránea)
created_at
updated_at
```
**Función**: Conecta obras con sus tipos. Si "Misa en Si menor" tiene ID 1 y puede ser "Misa" (ID 1) y "Oratorio" (ID 5), habrá dos filas en esta tabla.

---

## 2. Migraciones

### ¿Qué son las migraciones?
Las migraciones son como "instrucciones" para crear las tablas en la base de datos. Laravel las ejecuta en orden según la fecha en el nombre del archivo.

### Crear tablas principales

**`2025_12_13_000001_create_autores_table.php`**
```php
Schema::create('autores', function (Blueprint $table) {
    $table->id();                          // Crea el campo id
    $table->string('nombre');              // Campo nombre (obligatorio)
    $table->string('pais')->nullable();    // Campo pais (opcional)
    $table->string('foto_url')->nullable();// Campo foto_url (opcional)
    $table->timestamps();                  // Crea created_at y updated_at
});
```

**`2025_12_13_000002_create_periodos_table.php`**
```php
Schema::create('periodos', function (Blueprint $table) {
    $table->id();
    $table->string('nombre')->unique();    // Nombre único (no repetidos)
    $table->timestamps();
});
```

### Crear tablas pivote

**`2025_12_13_000005_create_autor_periodo_table.php`**
```php
Schema::create('autor_periodo', function (Blueprint $table) {
    $table->id();
    // Crea la clave foránea hacia autores
    $table->foreignId('autor_id')
          ->constrained('autores')         // Se conecta a la tabla autores
          ->onDelete('cascade');           // Si se borra el autor, borra la relación

    // Crea la clave foránea hacia periodos
    $table->foreignId('periodo_id')
          ->constrained('periodos')
          ->onDelete('cascade');

    $table->timestamps();
});
```

**Importante**: El nombre de la tabla pivote puede ser personalizado. Laravel sugiere usar el orden alfabético (`autor_periodo` en vez de `periodo_autor`), pero puedes usar el nombre que quieras.

---

## 3. Modelos y Relaciones

### Modelo Autor

**`app/Models/Autor.php`**
```php
class Autor extends Model
{
    protected $table = 'autores';  // Especifica el nombre de la tabla

    protected $fillable = ['nombre', 'pais', 'foto_url'];  // Campos editables

    // Relación UNO A MUCHOS: Un autor tiene muchas obras
    public function obras()
    {
        return $this->hasMany(Obra::class);
    }

    // Relación MUCHOS A MUCHOS: Un autor puede tener varios periodos
    public function periodos()
    {
        return $this->belongsToMany(
            Periodo::class,        // Modelo relacionado
            'autor_periodo'        // Nombre de la tabla pivote
        );
    }

    // Método helper: Devuelve array de nombres de periodos
    public function getPeriodos()
    {
        $periodos = [];
        foreach ($this->periodos as $periodo) {
            $periodos[] = $periodo->nombre;
        }
        return $periodos;  // ['Clasicismo', 'Romanticismo']
    }
}
```

**¿Qué significa `belongsToMany`?**
- Le dice a Laravel: "Este autor está conectado a varios periodos a través de la tabla `autor_periodo`"
- Laravel automáticamente buscará los campos `autor_id` y `periodo_id` en esa tabla

### Modelo Obra

**`app/Models/Obra.php`**
```php
class Obra extends Model
{
    protected $table = 'obras';
    protected $fillable = ['titulo', 'anio', 'autor_id'];

    // EAGER LOADING: Siempre carga los tipos automáticamente
    protected $with = ['tipos'];

    // Relación MUCHOS A UNO: Una obra pertenece a un autor
    public function autor()
    {
        return $this->belongsTo(Autor::class);
    }

    // Relación MUCHOS A MUCHOS: Una obra puede tener varios tipos
    public function tipos()
    {
        return $this->belongsToMany(Tipo::class, 'obra_tipo');
    }

    // Método helper
    public function getTipos()
    {
        $tipos = [];
        foreach ($this->tipos as $tipo) {
            $tipos[] = $tipo->nombre;
        }
        return $tipos;
    }
}
```

**¿Qué es `protected $with = ['tipos']`?**
- Se llama **eager loading** (carga anticipada)
- Cada vez que cargas una obra, Laravel AUTOMÁTICAMENTE trae también sus tipos
- Evita el problema de "consultas N+1" (hacer demasiadas consultas a la base de datos)

---

## 4. Controladores - Crear y Editar con Relaciones

### AutorControlador - Método `registrarAutor`

**`app/Http/Controllers/AutorControlador.php`**
```php
public function registrarAutor(Request $request)
{
    // 1. VALIDAR los datos del formulario
    $request->validate([
        'nombre' => 'required|string|max:255',
        'pais' => 'nullable|string|max:255',
        'foto_url' => 'nullable|url|max:500',
        'periodos' => 'required|array|min:1',           // Debe ser array
        'periodos.*' => 'string|exists:periodos,nombre', // Cada elemento debe existir
    ]);

    // 2. CREAR el autor (solo los datos básicos)
    $autor = Autor::create([
        'nombre' => $request->nombre,
        'pais' => $request->pais,
        'foto_url' => $request->foto_url,
    ]);

    // 3. OBTENER los IDs de los periodos desde sus nombres
    // Si el usuario seleccionó ['Clasicismo', 'Romanticismo']
    // Esta línea busca esos nombres en la tabla periodos y obtiene [5, 6]
    $periodosIDs = Periodo::whereIn('nombre', $request->periodos)->pluck('id');

    // 4. ATTACH: Vincular los periodos al autor
    // Inserta filas en la tabla autor_periodo
    $autor->periodos()->attach($periodosIDs);

    // 5. CARGAR las relaciones antes de devolver
    $autor->load('periodos');

    return redirect('/')->with('success', 'Autor creado exitosamente');
}
```

**¿Qué hace `attach()`?**
- **Añade** relaciones en la tabla pivote
- Si el autor tiene ID 3 y los periodos son [5, 6], insertará:
  ```
  autor_id | periodo_id
  ---------|----------
     3     |    5
     3     |    6
  ```
- No borra las relaciones anteriores, solo añade nuevas

### AutorControlador - Método `editarAutor`

```php
public function editarAutor(Request $request, $id)
{
    // 1. Validar
    $request->validate([...]);

    // 2. Buscar el autor
    $autor = Autor::findOrFail($id);

    // 3. Actualizar datos básicos
    $autor->update([
        'nombre' => $request->nombre,
        'pais' => $request->pais,
        'foto_url' => $request->foto_url,
    ]);

    // 4. Obtener IDs de periodos
    $periodosIDs = Periodo::whereIn('nombre', $request->periodos)->pluck('id');

    // 5. SYNC: Reemplazar completamente los periodos
    $autor->periodos()->sync($periodosIDs);

    return redirect('/autor/detalle/' . $id);
}
```

**¿Qué hace `sync()`?**
- **Reemplaza completamente** las relaciones en la tabla pivote
- Si el autor tenía periodos [5, 6] y ahora seleccionas [5, 7]:
  1. Borra la fila con periodo_id=6
  2. Mantiene la fila con periodo_id=5 (ya existe)
  3. Añade la fila con periodo_id=7
- Es perfecto para editar, porque actualiza todo de una vez

---

## 5. Vistas con Checkboxes

### Crear Autor - `crearAutor.blade.php`

```blade
<form action="/autor" method="POST">
    @csrf

    <input type="text" name="nombre" required>
    <input type="text" name="pais">

    <!-- CHECKBOXES para seleccionar múltiples periodos -->
    <label>Periodos (selecciona al menos uno)</label>
    @foreach ($periodos as $periodo)
        <div class="form-check">
            <input class="form-check-input"
                   type="checkbox"
                   name="periodos[]"              <!-- El [] convierte en array -->
                   value="{{ $periodo->nombre }}" <!-- Valor que se enviará -->
                   id="periodo{{ $periodo->id }}"
                   @if(in_array($periodo->nombre, old('periodos', [])))
                       checked
                   @endif>
            <label for="periodo{{ $periodo->id }}">
                {{ $periodo->nombre }}
            </label>
        </div>
    @endforeach

    <button type="submit">Crear Autor</button>
</form>
```

**¿Por qué `name="periodos[]"`?**
- El `[]` le dice a PHP que cree un **array**
- Si seleccionas "Barroco" y "Clasicismo", el servidor recibirá:
  ```php
  $request->periodos = ['Barroco', 'Clasicismo']
  ```

**¿Qué hace `old('periodos', [])`?**
- Si hay un error de validación, mantiene los checkboxes marcados
- `old()` recupera los valores previos del formulario

### Editar Autor - `editarAutor.blade.php`

```blade
@foreach ($periodos as $periodo)
    <input type="checkbox"
           name="periodos[]"
           value="{{ $periodo->nombre }}"
           @if(in_array($periodo->nombre, old('periodos', $autor->getPeriodos())))
               checked
           @endif>
    <label>{{ $periodo->nombre }}</label>
@endforeach
```

**Explicación del `checked`:**
- `old('periodos', $autor->getPeriodos())` hace lo siguiente:
  1. Si hay datos antiguos del formulario (por error de validación), usa `old('periodos')`
  2. Si no, usa `$autor->getPeriodos()` que devuelve los periodos actuales del autor
- `in_array()` verifica si el periodo está en la lista
- Si está, añade el atributo `checked` al checkbox

### Mostrar en la Vista Home

```blade
@foreach ($autores as $autor)
    <div class="card">
        <h6>{{ $autor->nombre }}</h6>

        <!-- Mostrar periodos como badges -->
        <p><strong>Periodos:</strong>
            @foreach ($autor->periodos as $periodo)
                <span class="badge bg-success">{{ $periodo->nombre }}</span>
            @endforeach
        </p>

        <p><strong>Obras:</strong> {{ $autor->obras->count() }}</p>
    </div>
@endforeach
```

---

## 6. Rutas con Eager Loading

**`routes/web.php`**
```php
// Ruta home: Lista autores con sus periodos y obras
Route::get('/', function () {
    // with() hace eager loading: carga todo de una vez
    $autores = Autor::with('periodos', 'obras')->get();
    return view('home', ['autores' => $autores]);
});

// Ruta detalle: Carga autor con periodos, obras y tipos de obras
Route::get('/autor/detalle/{id}', function ($id) {
    // 'obras.tipos' carga las obras Y los tipos de cada obra
    $autor = Autor::with('periodos', 'obras.tipos')->findOrFail($id);
    return view('detallesAutor', ['autor' => $autor]);
});
```

**¿Por qué usar `with()`?**
- **Sin `with()`**: Laravel haría 1 consulta por el autor + 1 consulta por cada periodo = muchas consultas
- **Con `with()`**: Laravel hace solo 2 consultas (una para autores, una para periodos) y las combina inteligentemente

---

## 7. Seeders - Poblar la Base de Datos

**`database/seeders/DatabaseSeeder.php`**
```php
public function run(): void
{
    // 1. Crear periodos
    $periodos = ['Renacimiento', 'Barroco', 'Clasicismo', 'Romanticismo'];
    foreach ($periodos as $periodo) {
        Periodo::create(['nombre' => $periodo]);
    }

    // 2. Crear tipos
    $tipos = ['Misa', 'Ópera', 'Concierto', 'Sinfonía'];
    foreach ($tipos as $tipo) {
        Tipo::create(['nombre' => $tipo]);
    }

    // 3. Crear autor
    $beethoven = Autor::create([
        'nombre' => 'Ludwig van Beethoven',
        'pais' => 'Alemania',
    ]);

    // 4. Vincular periodos al autor (muchos a muchos)
    $beethoven->periodos()->attach(
        Periodo::whereIn('nombre', ['Clasicismo', 'Romanticismo'])->pluck('id')
    );

    // 5. Crear obra
    $sinfonia9 = Obra::create([
        'titulo' => 'Sinfonía n.º 9',
        'anio' => 1824,
        'autor_id' => $beethoven->id,
    ]);

    // 6. Vincular tipos a la obra (muchos a muchos)
    $sinfonia9->tipos()->attach(
        Tipo::whereIn('nombre', ['Sinfonía', 'Oratorio'])->pluck('id')
    );
}
```

**Ejecutar seeders:**
```bash
php artisan migrate:fresh --seed
```
- `migrate:fresh`: Borra todas las tablas y las vuelve a crear
- `--seed`: Ejecuta el seeder para llenar con datos de ejemplo

---

## 8. Comandos Útiles

### Configurar el proyecto
```bash
# Instalar dependencias
composer install

# Configurar base de datos SQLite (ya está configurado por defecto)
# El archivo database.sqlite ya existe

# Ejecutar migraciones
php artisan migrate

# Ejecutar migraciones Y seeders (con datos de ejemplo)
php artisan migrate:fresh --seed

# Levantar servidor
php artisan serve
```

### Limpiar caché
```bash
php artisan route:clear
php artisan config:clear
php artisan view:clear
```

---

## 9. Resumen de Conceptos Clave

### Relación Muchos a Muchos
- **Necesita una tabla pivote** (intermedia)
- Ejemplo: `autor_periodo` conecta autores con periodos
- La tabla pivote tiene claves foráneas hacia ambas tablas

### `belongsToMany()`
- Define la relación muchos a muchos en el modelo
- Parámetros: modelo relacionado, nombre de tabla pivote

### `attach()`
- **Añade** relaciones sin borrar las existentes
- Usar al crear nuevos registros

### `sync()`
- **Reemplaza completamente** las relaciones
- Usar al editar registros existentes

### `with()` (Eager Loading)
- Carga las relaciones de una vez
- Evita consultas múltiples a la base de datos
- Mejora el rendimiento

### Checkboxes en formularios
- `name="periodos[]"` crea un array
- `value="{{ $periodo->nombre }}"` define qué se envía
- `old()` mantiene valores tras errores de validación

---

## 10. Diferencias con CRUD Básico

| Aspecto | CRUD Básico | CRUD Avanzado |
|---------|-------------|---------------|
| Periodos/Tipos | Enum (un solo valor) | Tabla + pivote (múltiples valores) |
| Relación | Simple columna | belongsToMany() |
| Formulario | Select simple | Checkboxes múltiples |
| Guardar | Columna directa | attach() o sync() |
| Mostrar | String simple | Loop sobre relación |
| Base de datos | 2 tablas | 6 tablas (incluye pivotes) |

---

## 11. Estructura Final del Proyecto

```
crud-musica-avanzado/
├── app/
│   ├── Models/
│   │   ├── Autor.php         (hasMany Obra, belongsToMany Periodo)
│   │   ├── Periodo.php       (belongsToMany Autor)
│   │   ├── Obra.php          (belongsTo Autor, belongsToMany Tipo)
│   │   └── Tipo.php          (belongsToMany Obra)
│   └── Http/Controllers/
│       ├── AutorControlador.php   (attach, sync)
│       └── ObraControlador.php    (attach, sync)
├── database/
│   ├── migrations/
│   │   ├── 2025_12_13_000001_create_autores_table.php
│   │   ├── 2025_12_13_000002_create_periodos_table.php
│   │   ├── 2025_12_13_000003_create_tipos_table.php
│   │   ├── 2025_12_13_000004_create_obras_table.php
│   │   ├── 2025_12_13_000005_create_autor_periodo_table.php  (PIVOTE)
│   │   └── 2025_12_13_000006_create_obra_tipo_table.php      (PIVOTE)
│   └── seeders/
│       └── DatabaseSeeder.php
├── resources/views/
│   ├── layouts/app.blade.php
│   ├── home.blade.php
│   ├── detallesAutor.blade.php
│   ├── crearAutor.blade.php      (checkboxes de periodos)
│   ├── editarAutor.blade.php     (checkboxes de periodos)
│   └── crearObra.blade.php       (checkboxes de tipos)
└── routes/
    └── web.php                   (con eager loading)
```

---

¡Proyecto completo con relaciones muchos a muchos! 🎵
