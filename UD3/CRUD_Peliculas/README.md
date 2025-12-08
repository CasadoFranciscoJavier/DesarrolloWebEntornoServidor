# 🎬 CRUD Películas - Backend Laravel

Backend API REST en Laravel para sistema CRUD de gestión de películas con autenticación, roles y comentarios.

![Laravel](https://img.shields.io/badge/Laravel-12.41.1-red)
![PHP](https://img.shields.io/badge/PHP-8.2.12-blue)
![MySQL](https://img.shields.io/badge/MySQL-8.0-orange)
![License](https://img.shields.io/badge/License-MIT-green)

## 📋 Características

- ✅ API REST completa (GET, POST, PUT, DELETE)
- ✅ Sistema de autenticación Laravel UI
- ✅ Control de acceso por roles (admin/user)
- ✅ CRUD completo de películas
- ✅ Sistema de comentarios
- ✅ Validaciones robustas
- ✅ Paginación de resultados
- ✅ Configuración CORS para frontend React
- ✅ Relaciones Eloquent ORM

## 🛠️ Stack Tecnológico

| Tecnología | Versión | Uso |
|------------|---------|-----|
| Laravel | 12.41.1 | Framework PHP |
| PHP | 8.2.12 | Lenguaje backend |
| MySQL | 8.0+ | Base de datos |
| Laravel UI | - | Sistema de autenticación |
| Bootstrap 5 | - | Framework CSS (vistas web) |

## 🚀 Inicio Rápido

### Requisitos Previos

- PHP 8.2 o superior
- Composer
- MySQL 8.0+
- Node.js y npm (para compilar assets)

### Instalación

```bash
# Clonar el repositorio
git clone <url-del-repositorio>

# Navegar al directorio
cd CRUD_Peliculas

# Instalar dependencias PHP
composer install

# Instalar dependencias Node
npm install

# Copiar archivo de entorno (si no existe)
cp .env.example .env

# Configurar base de datos en .env
# DB_DATABASE=mi_crud_peliculas
# DB_USERNAME=root
# DB_PASSWORD=1234

# Generar clave de aplicación
php artisan key:generate

# Ejecutar migraciones
php artisan migrate

# Compilar assets
npm run build

# Iniciar servidor
php artisan serve
```

El backend estará disponible en: `http://127.0.0.1:8000`

## 📦 Comandos Disponibles

```bash
# Desarrollo
php artisan serve                    # Inicia servidor en http://127.0.0.1:8000
php artisan route:list               # Lista todas las rutas
php artisan migrate:status           # Estado de migraciones

# Base de datos
php artisan migrate                  # Ejecuta migraciones pendientes
php artisan migrate:rollback         # Revierte última migración
php artisan migrate:fresh            # Borra y recrea DB (CUIDADO)

# Caché
php artisan config:clear            # Limpia caché de configuración
php artisan cache:clear             # Limpia caché de aplicación
php artisan view:clear              # Limpia caché de vistas

# Utilidades
php artisan tinker                  # Consola interactiva
php artisan make:controller NombreControlador
php artisan make:model NombreModelo
php artisan make:migration nombre_migracion
```

## 📁 Estructura del Proyecto

```
CRUD_Peliculas/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── HomeController.php
│   │   │   ├── peliculaControlador.php
│   │   │   └── ComentarioControlador.php
│   │   └── Middleware/
│   │       └── RoleMiddleware.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Pelicula.php
│   │   └── Comentario.php
│   └── Providers/
│       └── AppServiceProvider.php
├── database/
│   ├── migrations/
│   │   ├── *_add_rol_to_users_table.php
│   │   ├── *_create_peliculas_table.php
│   │   └── *_create_comentarios_table.php
│   └── seed_completo.sql
├── routes/
│   ├── web.php          # Rutas web (vistas Laravel)
│   └── api.php          # Rutas API REST
├── resources/
│   └── views/           # Vistas Blade
├── config/
│   └── cors.php         # Configuración CORS
├── .env
├── server.php
├── GUIA-PROYECTO.md     # Guía completa de implementación
└── README.md            # Este archivo
```

## 🔌 API Endpoints

### Películas

| Método | Endpoint | Descripción | Auth |
|--------|----------|-------------|------|
| GET | `/api/movies` | Listar todas las películas | No |
| GET | `/api/movies/{id}` | Obtener película con comentarios | No |
| POST | `/api/movies` | Crear nueva película | No* |
| PUT | `/api/movies/{id}` | Actualizar película | No* |
| DELETE | `/api/movies/{id}` | Eliminar película | No* |

*Nota: En producción deberías proteger estas rutas con autenticación

### Swagger UI - Documentación Interactiva

Accede a la documentación interactiva de Swagger UI:

```
http://127.0.0.1:8000/api/documentation
```

Swagger UI proporciona:
- ✅ Interfaz visual para explorar todos los endpoints
- ✅ Probador integrado ("Try it out") para ejecutar peticiones
- ✅ Ejemplos de request y response para cada endpoint
- ✅ Esquemas de validación documentados
- ✅ Generación automática desde anotaciones OpenAPI

### Ejemplo de Request

**POST /api/movies**
```json
{
    "poster_url": "https://image.tmdb.org/t/p/w500/poster.jpg",
    "title": "Inception",
    "release_year": 2010,
    "genres": ["Sci-Fi", "Action"],
    "synopsis": "Un ladrón que roba secretos corporativos..."
}
```

**PUT /api/movies/2**
```json
{
    "poster_url": "https://image.tmdb.org/t/p/w500/poster.jpg",
    "title": "Inception",
    "release_year": 2010,
    "genres": ["Sci-Fi", "Action", "Drama"],
    "synopsis": "Sinopsis actualizada..."
}
```

## 🗄️ Modelo de Datos

### Tabla: users
- `id` (PK)
- `name`
- `email` (unique)
- `password`
- `role` (default: 'user')
- `timestamps`

### Tabla: peliculas
- `id` (PK)
- `poster_url`
- `title` (unique)
- `release_year`
- `genres` (JSON)
- `synopsis`
- `timestamps`

### Tabla: comentarios
- `id` (PK)
- `pelicula_id` (FK → peliculas)
- `user_id` (FK → users)
- `content`
- `timestamps`

## 🎯 Rutas Web (Vistas Laravel)

| Ruta | Método | Descripción | Middleware |
|------|--------|-------------|------------|
| `/` | GET | Lista de películas | auth |
| `/home` | GET | Dashboard | auth |
| `/movie/create` | GET | Formulario crear película | auth, role:admin |
| `/movie` | POST | Guardar nueva película | - |
| `/movie/detail/{id}` | GET | Ver detalle de película | auth |
| `/movie/edit/{id}` | GET | Formulario editar película | auth, role:admin |
| `/movie/edit/{id}` | POST | Actualizar película | auth, role:admin |
| `/movie/delete/{id}` | GET | Eliminar película | auth, role:admin |
| `/comments/create` | POST | Crear comentario | auth |
| `/comments/delete/{id}` | GET | Eliminar comentario | auth, role:admin |

## 🔐 Autenticación y Roles

### Usuarios de Prueba

El archivo `database/seed_completo.sql` incluye:

**Administradores:**
- admin1@test.com / 12345678
- admin2@test.com / 12345678

**Usuarios:**
- user1@test.com hasta user8@test.com / 12345678

### Middleware de Roles

```php
// Proteger ruta solo para admins
Route::get('/ruta', function () {
    // ...
})->middleware(['auth', 'role:admin']);
```

## 🌐 Configuración CORS

Para consumir la API desde frontend React:

```bash
# Publicar configuración CORS
php artisan config:publish cors

# Editar config/cors.php
# Configurar allowed_origins, allowed_methods, etc.

# Limpiar caché
php artisan config:clear
```

**Configuración recomendada para desarrollo:**

```php
// config/cors.php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'],
    'allowed_headers' => ['*'],
    'supports_credentials' => false,
];
```

## 📚 Documentación

### Guías Disponibles

- **[GUIA-PROYECTO.md](./GUIA-PROYECTO.md)** - Guía completa paso a paso del backend
  - Configuración inicial de Laravel
  - Creación de migraciones y modelos
  - Implementación de controladores
  - Sistema de autenticación y roles
  - API REST completa
  - Configuración CORS
  - Documentación API con Swagger
  - Lista de comandos completos

- **Swagger UI** - Documentación interactiva de la API
  - URL: `http://127.0.0.1:8000/api/documentation`
  - Interfaz visual para explorar endpoints
  - Probador integrado de peticiones
  - Esquemas de validación

## 🔧 Validaciones

### Películas

```php
'poster_url' => ['required', 'string', 'url', 'max:255']
'title' => ['required', 'string', 'min:3', 'max:100', 'unique:peliculas,title']
'release_year' => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 1)]
'genres' => ['required', 'array', 'min:1', 'distinct']
'genres.*' => ['required', 'string', 'in:Action,Comedy,Drama,Horror,Sci-Fi,Fantasy,Documentary,Romance']
'synopsis' => ['required', 'string', 'min:10', 'max:5000']
```

### Comentarios

```php
'pelicula_id' => ['required', 'integer', 'exists:peliculas,id']
'content' => ['required', 'string', 'min:3', 'max:1000']
```

## 🤝 Integración con Frontend

Este backend está diseñado para ser consumido por el frontend React:

- **Frontend:** [crud-peliculas-fronted](../crud-peliculas-fronted)
- **URL Frontend:** `http://localhost:5173`
- **Comunicación:** API REST con JSON

### Flujo de Integración

1. Frontend hace petición HTTP a `/api/movies`
2. Backend procesa la petición
3. Backend valida datos si es POST/PUT
4. Backend consulta/modifica base de datos
5. Backend retorna JSON al frontend
6. Frontend renderiza los datos

## 🐛 Solución de Problemas

### Error: 419 Page Expired
- Causa: Token CSRF expirado
- Solución: Recargar la página para obtener nuevo token

### Error: Access denied for user
- Verifica credenciales en `.env`
- Asegúrate de que MySQL esté corriendo
- Verifica que la base de datos exista

### Error: CORS policy
```bash
php artisan config:publish cors
# Editar config/cors.php
php artisan config:clear
```

### Error: Class not found
```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

## 📝 Convenciones del Código

1. **Un solo return por función**
2. **Variables descriptivas:** `$pelicula`, `$comentario` (nunca `$p`, `$c`)
3. **Comparaciones:** Usar `==` y `!=` (no `===` ni `!==`)
4. **Sin breaks ni continues**
5. **Flujo lineal:** Usar variables de control

## 🎓 Conceptos Clave

### Eloquent ORM

```php
// Relaciones
public function comentarios() {
    return $this->hasMany(Comentario::class);
}

// Consultas
$peliculas = Pelicula::paginate(10);
$pelicula = Pelicula::find($id);
```

### Validación Unique con Edición

```php
// Creación: título único
Rule::unique('peliculas', 'title')

// Edición: único excepto el actual
Rule::unique('peliculas', 'title')->ignore($id, 'id')
```

## 📄 Licencia

Este proyecto es de código abierto y está disponible bajo la licencia MIT.

## 👤 Autor

Proyecto educativo - CRUD Películas Backend Laravel

---

**Última actualización:** 2025-12-08
**Versión Laravel:** 12.41.1
**Versión PHP:** 8.2.12
