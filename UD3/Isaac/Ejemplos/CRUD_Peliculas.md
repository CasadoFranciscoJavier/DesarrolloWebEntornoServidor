# CRUD_Películas

## 1. Estructura de datos

### Películas

Cada película debe tener:

* **Foto / póster**: URL de la imagen
* **Título**
* **Año de lanzamiento**
* **Géneros**: uno o varios entre
  `Action, Comedy, Drama, Horror, Sci-Fi, Fantasy, Documentary, Romance`
* **Sinopsis**

### Comentarios

Cada comentario debe mostrar:

* Nombre del usuario que lo escribió (relación con `users`)
* Fecha del comentario (`created_at` / `updated_at`)
* Texto del comentario

---

## 2. Rutas Web (vistas y autenticación)

| Ruta                    | Descripción                                 | Autenticación    | Notas                                   |
| ----------------------- | ------------------------------------------- | ---------------- | --------------------------------------- |
| `/`                     | Lista de películas paginada (10 por página) | Usuarios logados | Mostrar título, año y póster            |
| `/movie/detail/{id}`    | Detalle de película + comentarios           | Usuarios logados | Permite agregar comentarios             |
| `/movie/create`         | Formulario de creación de película          | Solo admin       | Botón en navbar solo para admin         |
| `/movie/delete/{id}`    | Borrar película                             | Solo admin       | Botón rojo en el detalle de la película |
| `/comments/create`      | Crear comentario                            | Usuarios logados | Procesa comentarios en películas        |
| `/comments/delete/{id}` | Eliminar comentario                         | Solo admin       | El admin puede borrar comentarios       |

---

## 3. Sistema de roles

### Usuario normal

* Ver películas
* Ver comentarios
* Crear comentarios

### Admin (además de lo anterior)

* Crear nuevas películas
* Eliminar películas
* Eliminar comentarios
* Ver botón **"Nueva Película"** en la navbar
* Ver botón **"Eliminar"** (rojo) en el detalle de la película

---

## 4. API REST (sin autenticación)

Endpoints CRUD para películas (no se gestionan comentarios vía API):

| Método | Ruta               | Descripción                        |
| ------ | ------------------ | ---------------------------------- |
| GET    | `/api/movies`      | Listar todas las películas         |
| GET    | `/api/movies/{id}` | Obtener el detalle de una película |
| POST   | `/api/movies`      | Crear una nueva película           |
| PUT    | `/api/movies/{id}` | Actualizar una película            |
| DELETE | `/api/movies/{id}` | Eliminar una película              |

---

## 5. Interfaz de usuario (Laravel)

Navbar con:

* Logo / enlace a inicio
* Botón **"Nueva Película"** (solo visible para admin)
* Nombre del usuario conectado
* Botón **"Cerrar sesión"**

Otras características:

* Autenticación: login y registro
* Bootstrap
* Paginación en la lista de películas

---

## 6. Validaciones en Laravel (películas y comentarios)

La tarea es implementar todas estas validaciones utilizando el sistema de `validate()` de Laravel.

### 6.1. Validaciones para Películas

#### Campos de película

Se asume que la tabla `movies` tiene, al menos, las columnas:

* `poster_url` (string)
* `title` (string)
* `release_year` (integer)
* `genres` (array)
* `synopsis` (text)

#### Validaciones al **crear** una película

Al crear/actualizar una película, se deben aplicar como mínimo las siguientes reglas:

* `poster_url`: obligatorio, cadena de texto, URL válida, longitud máxima.
* `title`: obligatorio, texto, longitud mínima y máxima, único en la tabla.
* `release_year`: obligatorio, entero, dentro de un rango de años válido.
* `genres`: obligatorio, array, con al menos un género.
* `genres.*`: obligatorio, texto, valor dentro de una lista fija, sin duplicados en el array.
* `synopsis`: obligatoria, texto, longitud mínima y máxima definida.

---

### 6.2. Validaciones para Comentarios

Al crear/editar un comentario:

* **user_id**

  * Normalmente se obtiene del usuario autenticado (por ejemplo, a través de `auth()`), pero si se valida, debe ser un entero y existir en la tabla `users`.

* **content**

  * Obligatorio.
  * Debe ser una cadena de texto.
  * Debe tener una longitud mínima (por ejemplo, al menos 3 caracteres).
  * Debe tener una longitud máxima (por ejemplo, hasta 1000 caracteres).

---

## 7. Frontend en React (consumiendo la API SIN autentificación)

Además de las vistas de Laravel, se debe implementar una vista / SPA en **React** que consuma la API REST de Laravel para gestionar películas.

Esta vista debe permitir:

* **Listar películas** usando `GET /api/movies`.
* **Ver detalle** de una película con `GET /api/movies/{id}`.
* **Crear películas** enviando datos a `POST /api/movies`.
* **Editar películas** usando `PUT /api/movies/{id}`.
* **Eliminar películas** con `DELETE /api/movies/{id}`.

Requisitos de la UI en React:

* Formularios para **crear** y **editar** películas con todos los campos requeridos.

---

## 8. CORS (arreglar problema al consumir la API desde React)

Para permitir que React (por ejemplo, en `http://localhost:3000`) consuma la API de Laravel (por ejemplo, `http://localhost:8000`):

1. Publicar la configuración de CORS:

   ```bash
   php artisan config:publish cors
   ```

2. En `config/cors.php`, configurar al menos:

   * `allowed_origins` para incluir la URL del frontend (por ejemplo, `http://localhost:3000`).
   * Ajustar `allowed_methods` y `allowed_headers` si es necesario (por ejemplo, permitir `GET, POST, PUT, DELETE, OPTIONS`).

3. Limpiar la caché de configuración:

   ```bash
   php artisan config:clear
   ```

Con esto se evita el error de CORS al hacer peticiones desde React.