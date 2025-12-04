## 1. **Relación Uno a Uno (1:1)**

### Definición
Una relación uno a uno implica que un modelo tiene exactamente un registro relacionado en otro modelo. Por ejemplo, un usuario tiene un perfil.

### Configuración en Laravel
1. **Base de datos:**
   - Crear tablas con claves foráneas.
     ```php
     Schema::create('profiles', function (Blueprint $table) {
         $table->id();
         $table->unsignedBigInteger('user_id');
         $table->string('bio');
         $table->timestamps();

         $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
     });
     ```

2. **Modelos:**
   - En el modelo principal (por ejemplo, `User`):
     ```php
     public function profile()
     {
         return $this->hasOne(Profile::class);
     }
     ```
   - En el modelo relacionado (por ejemplo, `Profile`):
     ```php
     public function user()
     {
         return $this->belongsTo(User::class);
     }
     ```

3. **Uso:**
   - Crear o asociar:
     ```php
     $user = User::find(1);
     $profile = new Profile(['bio' => 'Laravel developer']);
     $user->profile()->save($profile);
     ```
   - Obtener datos:
     ```php
     $profile = User::find(1)->profile;
     ```

---

## 2. **Relación Uno a Muchos (1:N)**

### Definición
Una relación uno a muchos implica que un modelo puede tener múltiples registros relacionados. Por ejemplo, un usuario puede tener muchos posts.

### Configuración en Laravel
1. **Base de datos:**
   - Crear tablas con claves foráneas.
     ```php
     Schema::create('posts', function (Blueprint $table) {
         $table->id();
         $table->unsignedBigInteger('user_id');
         $table->string('title');
         $table->timestamps();

         $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
     });
     ```

2. **Modelos:**
   - En el modelo principal (por ejemplo, `User`):
     ```php
     public function posts()
     {
         return $this->hasMany(Post::class);
     }
     ```
   - En el modelo relacionado (por ejemplo, `Post`):
     ```php
     public function user()
     {
         return $this->belongsTo(User::class);
     }
     ```

3. **Uso:**
   - Crear o asociar:
     ```php
     $user = User::find(1);
     $post = new Post(['title' => 'First Post']);
     $user->posts()->save($post);
     ```
   - Obtener datos:
     ```php
     $posts = User::find(1)->posts;
     ```
   - Obtener el propietario de un post:
     ```php
     $user = Post::find(1)->user;
     ```

---

## 3. **Relación Muchos a Muchos (N:M)**

### Definición
Una relación muchos a muchos implica que múltiples modelos pueden estar relacionados entre sí. Por ejemplo, muchos usuarios pueden tener muchos roles.

### Configuración en Laravel
1. **Base de datos:**
   - Crear tablas intermedias (pivot).
     ```php
     Schema::create('role_user', function (Blueprint $table) {
         $table->id();
         $table->unsignedBigInteger('user_id');
         $table->unsignedBigInteger('role_id');
         $table->timestamps();

         $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
         $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
     });
     ```

2. **Modelos:**
   - En ambos modelos principales (por ejemplo, `User` y `Role`):
     ```php
     public function roles()
     {
         return $this->belongsToMany(Role::class);
     }
     ```
     ```php
     public function users()
     {
         return $this->belongsToMany(User::class);
     }
     ```

3. **Uso:**
   - Asociar registros:
     ```php
     $user = User::find(1);
     $role = Role::find(2);
     $user->roles()->attach($role); // También: detach(), sync(), syncWithoutDetaching()
     ```
   - Obtener datos:
     ```php
     $roles = User::find(1)->roles;
     $users = Role::find(1)->users;
     ```

4. **Pivot Table Extras:**
   - Agregar columnas adicionales a la tabla pivot.
     ```php
     Schema::create('role_user', function (Blueprint $table) {
         $table->id();
         $table->unsignedBigInteger('user_id');
         $table->unsignedBigInteger('role_id');
         $table->boolean('is_active')->default(true);
         $table->timestamps();
     });
     ```
   - Acceder a datos pivot:
     ```php
     foreach ($user->roles as $role) {
         echo $role->pivot->is_active;
     }
     ```

---

## Consideraciones Generales

Laravel ofrece herramientas robustas para trabajar con relaciones entre modelos de manera eficiente. Las siguientes prácticas permiten optimizar el acceso a los datos, reducir el número de consultas a la base de datos y aplicar filtros personalizados a las relaciones.

---

### 1. **Carga Eager (Eager Loading)**

La carga **eager** es una técnica que permite cargar relaciones asociadas a los modelos de manera anticipada, evitando el problema conocido como "N+1 Query Problem". Este problema ocurre cuando se generan múltiples consultas adicionales a la base de datos al acceder a las relaciones de los modelos individualmente.

#### ¿Cómo funciona?

Al usar la función `with()`, Laravel genera una única consulta SQL para el modelo principal y otra para la relación especificada. Esto es más eficiente que realizar consultas separadas para cada relación.

#### Ejemplo Básico:
```php
$users = User::with('profile')->get();
```
- **Explicación**:
  - Laravel carga todos los registros de la tabla `users`.
  - Luego, en una consulta separada, carga los datos relacionados de la tabla `profiles`, vinculándolos por las claves foráneas.
- Resultado: Menor número de consultas y mayor rendimiento.

#### Cargar Múltiples Relaciones:
Es posible cargar varias relaciones al mismo tiempo especificándolas como un array:
```php
$users = User::with(['profile', 'posts'])->get();
```

#### Relación Anidada:
Se pueden cargar relaciones dentro de relaciones (anidadas):
```php
$users = User::with('posts.comments')->get();
```
- Aquí, además de los posts del usuario, también se cargan los comentarios asociados a cada post.

---

### 2. **Carga Eager Diferida (Lazy Eager Loading)**

La carga **lazy eager** permite cargar relaciones de un modelo después de haber recuperado los datos del modelo principal. Esto es útil cuando inicialmente no se necesitaban las relaciones, pero surgen requerimientos adicionales después de cargar el modelo.

#### ¿Cómo funciona?

Después de obtener los modelos, se utiliza el método `load()` para cargar las relaciones relacionadas.

#### Ejemplo Básico:
```php
$users = User::all();
$users->load('profile');
```
- **Explicación**:
  - Primero, se obtienen todos los registros de `users`.
  - Luego, se carga la relación `profile` para cada usuario en una consulta separada.

#### Usos Combinados:
Se pueden combinar diferentes relaciones y cargarlas de manera diferida:
```php
$users = User::all();
$users->load(['profile', 'posts']);
```

#### Diferencias con Eager Loading:
- **Eager Loading (`with`)**: Se carga desde el principio.
- **Lazy Eager Loading (`load`)**: Se carga después de obtener los modelos.

---

### 3. **Filtrar Relaciones**

Laravel permite aplicar filtros directamente a las relaciones mediante métodos como `whereHas`, `doesntHave`, y `has`. Esto es útil para restringir los modelos devueltos con base en las relaciones.

#### **Filtrar Relaciones con `whereHas`**:

El método `whereHas` filtra los resultados del modelo principal basándose en condiciones aplicadas a la relación.

#### Ejemplo Básico:
```php
$users = User::whereHas('posts', function ($query) {
    $query->where('title', 'like', '%Laravel%');
})->get();
```
- **Explicación**:
  - Laravel busca usuarios (`User`) que tengan al menos un post cuyo título contenga la palabra "Laravel".
  - Se ejecuta una subconsulta SQL para aplicar el filtro en la relación `posts`.

#### **Exclusión de Relaciones con `doesntHave`**:

El método `doesntHave` excluye los modelos que tienen registros relacionados.
```php
$usersWithoutPosts = User::doesntHave('posts')->get();
```
- Resultado: Devuelve todos los usuarios que no tienen posts.

#### **Validar Existencia con `has`**:

El método `has` verifica si una relación existe sin aplicar condiciones adicionales.
```php
$usersWithPosts = User::has('posts')->get();
```
- Resultado: Devuelve todos los usuarios que tienen al menos un post.

---

### Aplicaciones Avanzadas

#### Cargar Relaciones con Condiciones:
Puedes cargar relaciones de manera condicional usando `with` con un callback.
```php
$users = User::with(['posts' => function ($query) {
    $query->where('title', 'like', '%Laravel%');
}])->get();
```
- Solo se cargan los posts cuyo título contiene "Laravel".

#### Seleccionar Campos Específicos:
Para optimizar las consultas, se pueden seleccionar columnas específicas de las relaciones:
```php
$users = User::with(['profile:id,user_id,bio'])->get();
```
- Solo se seleccionan las columnas `id`, `user_id` y `bio` de la tabla `profiles`.

#### Contar Registros Relacionados:
Usando `withCount`, puedes agregar el conteo de registros relacionados:
```php
$users = User::withCount('posts')->get();
```
- Devuelve una columna adicional `posts_count` con el número de posts por usuario.

---

### Buenas Prácticas

1. **Evita el Overfetching:**
   - No cargues relaciones innecesarias. Es mejor cargar únicamente las relaciones que usarás en la lógica o la vista.

2. **Combina Métodos con Paginación:**
   - Para grandes conjuntos de datos, usa `paginate()` con relaciones:
     ```php
     $users = User::with('posts')->paginate(10);
     ```

3. **Debug de Consultas:**
   - Usa el método `dd()` para verificar las consultas generadas:
     ```php
     $users = User::with('posts')->get();
     dd($users);
     ```