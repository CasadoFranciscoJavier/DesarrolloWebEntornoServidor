### Gestión de Películas con Sistema de Usuarios y Administradores

**Descripción**: 
Desarrolla una aplicación web de gestión de películas donde haya dos tipos de usuarios: administradores y usuarios regulares. Los administradores pueden gestionar el catálogo de películas (añadir, editar y eliminar), mientras que los usuarios regulares pueden valorar las películas y dejar comentarios. La aplicación debe seguir el patrón MVC para garantizar una buena separación de responsabilidades y un diseño escalable.

**Requisitos de Funcionalidad**:

1. **Inicio de sesión y roles**:
   - Implementa un sistema de autenticación donde los usuarios puedan registrarse e iniciar sesión.
   - Distingue entre dos roles de usuario: "administrador" y "usuario regular".
   - Al iniciar sesión, los usuarios se redirigen a una página principal según su rol:
     - **Usuarios**: Redirigidos a una página de exploración de películas.
     - **Administradores**: Redirigidos a una página de administración de películas.

2. **Funcionalidades de Administrador**:
   - **Añadir Película**: Los administradores pueden agregar una nueva película al catálogo, proporcionando información como título, sinopsis, año de lanzamiento y género.
   - **Editar Película**: Los administradores pueden editar los detalles de cualquier película existente.
   - **Eliminar Película**: Los administradores pueden eliminar películas del catálogo.

3. **Funcionalidades de Usuario Regular**:
   - **Ver Catálogo de Películas**: Los usuarios pueden ver una lista de todas las películas disponibles.
   - **Valorar Película**: Los usuarios pueden dar una valoración (de 1 a 10) a cada película.
   - **Comentar Película**: Los usuarios pueden dejar comentarios en cada película.

4. **Funcionalidades Generales**:
   - **Vistas de Detalle**: Cada película debe tener una página de detalles que muestre sus características, valoraciones promedio y comentarios.
   - **Seguridad**: Usa sesiones para autenticar y autorizar a los usuarios y administradores. Las acciones de edición, eliminación y adición de películas deben estar restringidas solo a administradores.

---

### Estructura de Archivos del Proyecto

Para organizar el proyecto con el patrón MVC, se recomienda la siguiente estructura de archivos y carpetas:

```plaintext
project/
│
├── index.php                # Archivo de entrada principal
│
├── models/
│   ├── User.php
│   ├── Movie.php
│   ├── Rating.php
│   ├── Comment.php
│   ├── UserModel.php         # Modelo para usuarios (login, registro, roles)
│   ├── MovieModel.php        # Modelo para películas (CRUD de películas)
│   ├── RatingModel.php       # Modelo para valoraciones (valorar una película)
│   └── CommentModel.php      # Modelo para comentarios (añadir comentarios)
│
└── views/
    ├── auth/
    │   ├── login.php         # Vista para el inicio de sesión
    │   ├── register.php      # Vista para el registro de usuarios
    │   └── logout.php        # Script para cerrar la sesión del usuario
    │
    └── movies/
        ├── list.php          # Vista para mostrar el catálogo de películas
        ├── detail.php        # Vista de detalle de una película
        ├── add.php           # Vista para añadir una nueva película (solo admin)
        ├── edit.php          # Vista para editar una película (solo admin)
        ├── delete.php        # Script para borrar películas (solo admin)
        ├── addComment.php    # Script para añadir comentario
        ├── addRating.php     # Script para añadir rating
        └── navbar.php        # "Barra" de navegación (se importará en todas las otras páginas)
```

-- 

## Modifica la aplicación con las siguientes funcionalidades:
   - Los administradores pueden borrar comentarios (Aparece un botón al lado del comentario)
   - Los administradores pueden resetear las votaciones de una película (Botón en detalle de película)
   - Los administradores pueden ver el detalle de un usuario haciendo click en su nombre (por ejemplo en un comentario) y banearlo.
     - Banear implica cambiar el nombre por "usuario eliminado" y poner una contraseña aleatoria