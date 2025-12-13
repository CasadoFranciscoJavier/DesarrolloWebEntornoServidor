# CRUD Música

Vas a desarrollar una **aplicación web en Laravel** (sin API separada y sin autenticación) para gestionar **música**.

La aplicación deberá implementar:

* **CRUD completo de Autores**

  * Crear.
  * Listar.
  * Ver detalle (incluidas las obras del autor).
  * Editar.
  * Borrar.
* Para **Obras**:

  * **Añadir nueva obra** a un autor.
  * **Borrar obra** de un autor.
  * *(Opcional)* Ver detalle de obra y editar obra.

Toda la lógica estará en **modelos, controladores, validaciones, migraciones, vistas Blade y rutas en `web.php`** (no se usará `api.php`, lo puedes usar opcionalmente si quieres).

---

## Entidades

### Autor

Campos mínimos:

* `id` (autoincremental).
* `nombre` (string, obligatorio).
* `pais` (string, opcional).
* `periodo` (string, opcional, pero si se rellena debe ser uno de esta lista):

  * `Renacimiento`
  * `Renacimiento tardío`
  * `Barroco temprano`
  * `Barroco`
  * `Clasicismo`
  * `Romanticismo`
* `foto_url` (string, opcional, URL de la foto/avatar del autor).
* `created_at`, `updated_at`.

Relación:

* Un **Autor** tiene muchas **Obras**.

---

### Obra

Campos mínimos:

* `id` (autoincremental).
* `titulo` (string, obligatorio).
* `tipo` (string, opcional, pero si se rellena debe ser uno de esta lista):

  * `Misa`, `Motete`, `Pasión`, `Magnificat`,
  * `Oficio de difuntos`, `Responsorios`, `Anthem`,
  * `Lamentaciones`, `Madrigal espiritual`, `Vísperas`,
  * `Colección sacra`, `Salmo`, `Oratorio`,
  * `Gloria`, `Stabat Mater`, `Requiem`, `Himno`
* `anio` (integer, opcional).
* `autor_id` (foreign key hacia autores).
* `created_at`, `updated_at`.

Relación:

* Una **Obra** pertenece a un **Autor**.

---

## Modelos de Eloquent

Debes crear al menos:

* `app/Models/Autor.php`
* `app/Models/Obra.php`

---

## Migraciones

Crea migraciones para:

1. Tabla `autores`
2. Tabla `obras`