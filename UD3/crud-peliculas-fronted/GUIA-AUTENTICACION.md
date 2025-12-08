# 🔐 GUÍA COMPLETA - Autenticación y Control de Acceso por Roles

## 📋 Índice
1. [Introducción](#introducción)
2. [Configuración del Backend Laravel](#configuración-del-backend-laravel)
3. [Configuración del Frontend React](#configuración-del-frontend-react)
4. [Implementación Paso a Paso](#implementación-paso-a-paso)
5. [Protección de Rutas y Componentes](#protección-de-rutas-y-componentes)
6. [Testing y Verificación](#testing-y-verificación)

---

## 🎯 Introducción

Esta guía implementa un sistema completo de autenticación con control de acceso basado en roles (RBAC) que permite:

- **Login/Logout** de usuarios
- **Roles**: `admin` y `user`
- **Protección de rutas** según autenticación y rol
- **Tokens JWT** con Laravel Sanctum
- **Persistencia de sesión** con localStorage

### Permisos por Rol

| ROL | Ver Películas | Ver Detalle | Crear | Editar | Eliminar |
|-----|--------------|-------------|-------|--------|----------|
| **Invitado** (sin login) | ✅ | ❌ | ❌ | ❌ | ❌ |
| **User** (autenticado) | ✅ | ✅ | ❌ | ❌ | ❌ |
| **Admin** | ✅ | ✅ | ✅ | ✅ | ✅ |

---

## 🔧 Configuración del Backend Laravel

### Paso 1: Instalar Laravel Sanctum

```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

### Paso 2: Configurar Sanctum

**Archivo:** `config/sanctum.php`

```php
'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', 'localhost,127.0.0.1')),
```

**Archivo:** `.env`

```env
SANCTUM_STATEFUL_DOMAINS=localhost:5173,127.0.0.1:5173
SESSION_DRIVER=cookie
```

### Paso 3: Añadir campo `role` a la tabla users

**Crear migración:**

```bash
php artisan make:migration add_role_to_users_table
```

**Archivo:** `database/migrations/xxxx_add_role_to_users_table.php`

```php
public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->enum('role', ['user', 'admin'])->default('user')->after('email');
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('role');
    });
}
```

```bash
php artisan migrate
```

### Paso 4: Actualizar el modelo User

**Archivo:** `app/Models/User.php`

```php
protected $fillable = [
    'name',
    'email',
    'password',
    'role',  // Añadir
];
```

### Paso 5: Crear Seeder para usuarios de prueba

```bash
php artisan make:seeder UserSeeder
```

**Archivo:** `database/seeders/UserSeeder.php`

```php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Usuario Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        // Usuario Normal
        User::create([
            'name' => 'Normal User',
            'email' => 'user@test.com',
            'password' => Hash::make('password'),
            'role' => 'user'
        ]);
    }
}
```

```bash
php artisan db:seed --class=UserSeeder
```

### Paso 6: Crear AuthController

```bash
php artisan make:controller Api/AuthController
```

**Archivo:** `app/Http/Controllers/Api/AuthController.php`

```php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sesión cerrada correctamente'
        ]);
    }

    public function me(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ]);
    }
}
```

### Paso 7: Crear Middleware para verificar rol

```bash
php artisan make:middleware CheckRole
```

**Archivo:** `app/Http/Middleware/CheckRole.php`

```php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!$request->user() || $request->user()->role !== $role) {
            return response()->json([
                'message' => 'No tienes permisos para realizar esta acción'
            ], 403);
        }

        return $next($request);
    }
}
```

**Archivo:** `bootstrap/app.php` (Laravel 11)

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'role' => \App\Http\Middleware\CheckRole::class,
    ]);
})
```

### Paso 8: Configurar rutas de API

**Archivo:** `routes/api.php`

```php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MovieController;

// Rutas públicas
Route::post('/login', [AuthController::class, 'login']);

// Rutas públicas de películas
Route::get('/movies', [MovieController::class, 'index']);

// Rutas protegidas (requieren autenticación)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/movies/{id}', [MovieController::class, 'show']);
});

// Rutas solo para ADMIN
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('/movies', [MovieController::class, 'store']);
    Route::put('/movies/{id}', [MovieController::class, 'update']);
    Route::delete('/movies/{id}', [MovieController::class, 'destroy']);
});
```

---

## ⚛️ Configuración del Frontend React

### Paso 1: Crear contexto de autenticación

**Archivo:** `src/contexts/AuthContext.jsx`

```jsx
import { createContext, useState, useContext, useEffect } from 'react';

const AuthContext = createContext();

export function AuthProvider({ children }) {
    const [user, setUser] = useState(() => {
        const savedUser = localStorage.getItem('user');
        return savedUser ? JSON.parse(savedUser) : null;
    });

    const [token, setToken] = useState(() => {
        return localStorage.getItem('token') || null;
    });

    function login(userData, accessToken) {
        localStorage.setItem('user', JSON.stringify(userData));
        localStorage.setItem('token', accessToken);
        setUser(userData);
        setToken(accessToken);
    }

    function logout() {
        localStorage.removeItem('user');
        localStorage.removeItem('token');
        setUser(null);
        setToken(null);
    }

    function isAdmin() {
        return user?.role === 'admin';
    }

    function isAuthenticated() {
        return user !== null && token !== null;
    }

    return (
        <AuthContext.Provider value={{
            user,
            token,
            login,
            logout,
            isAdmin,
            isAuthenticated
        }}>
            {children}
        </AuthContext.Provider>
    );
}

export function useAuth() {
    const context = useContext(AuthContext);
    if (!context) {
        throw new Error('useAuth debe usarse dentro de AuthProvider');
    }
    return context;
}
```

### Paso 2: Envolver App con AuthProvider

**Archivo:** `src/main.jsx`

```jsx
import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import { AuthProvider } from './contexts/AuthContext'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'
import './index.css'
import App from './App.jsx'

createRoot(document.getElementById('root')).render(
  <StrictMode>
    <AuthProvider>
      <App />
    </AuthProvider>
  </StrictMode>,
)
```

### Paso 3: Actualizar Axios para enviar token

**Archivo:** `src/services/api.js`

```javascript
import axios from 'axios';

export const API = axios.create({
  baseURL: 'http://127.0.0.1:8000/api',
});

// Interceptor: añade el token a todas las peticiones
API.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

// Interceptor: maneja errores 401 (no autenticado)
API.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      // Token expirado o inválido
      localStorage.removeItem('token');
      localStorage.removeItem('user');
      window.location.href = '/login';
    }
    return Promise.reject(error);
  }
);
```

### Paso 4: Crear servicio de autenticación

**Archivo:** `src/services/AuthService.js`

```javascript
import { API } from "./api.js"

export function login(credentials) {
    return API.post('/login', credentials);
}

export function logout() {
    return API.post('/logout');
}

export function getCurrentUser() {
    return API.get('/me');
}
```

### Paso 5: Crear componente ProtectedRoute

**Archivo:** `src/components/ProtectedRoute.jsx`

```jsx
import { Navigate } from 'react-router-dom';
import { useAuth } from '../contexts/AuthContext';

export function ProtectedRoute({ children, requireAdmin = false }) {
    const { isAuthenticated, isAdmin } = useAuth();

    if (!isAuthenticated()) {
        return <Navigate to="/login" replace />;
    }

    if (requireAdmin && !isAdmin()) {
        return <Navigate to="/" replace />;
    }

    return children;
}
```

### Paso 6: Crear página de Login

**Archivo:** `src/pages/Login.jsx`

```jsx
import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { useAuth } from '../contexts/AuthContext';
import { login as loginService } from '../services/AuthService';

export default function Login() {
    const navigate = useNavigate();
    const { login } = useAuth();
    const [credentials, setCredentials] = useState({
        email: '',
        password: ''
    });
    const [error, setError] = useState('');
    const [loading, setLoading] = useState(false);

    function handleChange(input) {
        const { name, value } = input.target;
        setCredentials({
            ...credentials,
            [name]: value
        });
    }

    function handleSubmit(form) {
        form.preventDefault();
        setError('');
        setLoading(true);

        loginService(credentials)
            .then((response) => {
                login(response.data.user, response.data.access_token);
                navigate('/');
            })
            .catch((error) => {
                setError(error.response?.data?.message || 'Error al iniciar sesión');
            })
            .finally(() => {
                setLoading(false);
            });
    }

    return (
        <div className="container mt-5">
            <div className="row justify-content-center">
                <div className="col-md-6">
                    <div className="card shadow">
                        <div className="card-body">
                            <h2 className="card-title text-center mb-4">Iniciar Sesión</h2>

                            {error && (
                                <div className="alert alert-danger" role="alert">
                                    {error}
                                </div>
                            )}

                            <form onSubmit={handleSubmit}>
                                <div className="mb-3">
                                    <label className="form-label">Email</label>
                                    <input
                                        type="email"
                                        name="email"
                                        className="form-control"
                                        value={credentials.email}
                                        onChange={handleChange}
                                        required
                                        autoFocus
                                    />
                                </div>

                                <div className="mb-3">
                                    <label className="form-label">Contraseña</label>
                                    <input
                                        type="password"
                                        name="password"
                                        className="form-control"
                                        value={credentials.password}
                                        onChange={handleChange}
                                        required
                                    />
                                </div>

                                <button
                                    type="submit"
                                    className="btn btn-primary w-100"
                                    disabled={loading}
                                >
                                    {loading ? 'Iniciando sesión...' : 'Iniciar Sesión'}
                                </button>
                            </form>

                            <div className="mt-3 text-center">
                                <small className="text-muted">
                                    <strong>Usuarios de prueba:</strong><br />
                                    Admin: admin@test.com / password<br />
                                    User: user@test.com / password
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
```

### Paso 7: Actualizar App.jsx con rutas protegidas

**Archivo:** `src/App.jsx`

```jsx
import { BrowserRouter as Router, Routes, Route, Link } from 'react-router-dom';
import { useAuth } from './contexts/AuthContext';
import { ProtectedRoute } from './components/ProtectedRoute';
import { logout as logoutService } from './services/AuthService';
import ListarPeliculas from './pages/ListarPeliculas';
import CrearPelicula from './pages/CrearPelicula';
import EditarPelicula from './pages/EditarPelicula';
import DetallePelicula from './pages/DetallePelicula';
import Login from './pages/Login';
import logo from './assets/logo-api-crud-peliculas.png';
import './App.css';

function App() {
  const { user, logout, isAdmin, isAuthenticated } = useAuth();

  function handleLogout() {
    logoutService()
      .then(() => {
        logout();
      })
      .catch((error) => {
        console.error(error);
        logout();
      });
  }

  return (
    <Router>
      <nav className="navbar navbar-expand-lg navbar-dark bg-dark navbar-fija">
        <div className="container-fluid">
          <Link to="/" className="navbar-brand">
            <img
              src={logo}
              alt="Logo API CRUD"
              style={{ maxHeight: 'auto', width: '200px' }}
              className="me-2"
            />
          </Link>
          <div className="navbar-nav ms-auto d-flex flex-row gap-3 align-items-center">
            <Link to="/" className="nav-link">Películas</Link>

            {isAdmin() && (
              <Link to="/movies/create" className="nav-link">Registrar Película</Link>
            )}

            {isAuthenticated() ? (
              <>
                <span className="text-white">
                  Hola, <strong>{user.name}</strong>
                  <span className="badge bg-primary ms-2">{user.role}</span>
                </span>
                <button onClick={handleLogout} className="btn btn-sm btn-outline-light">
                  Cerrar Sesión
                </button>
              </>
            ) : (
              <Link to="/login" className="btn btn-sm btn-primary">
                Iniciar Sesión
              </Link>
            )}
          </div>
        </div>
      </nav>

      <Routes>
        {/* Rutas públicas */}
        <Route path="/" element={<ListarPeliculas />} />
        <Route path="/login" element={<Login />} />

        {/* Rutas para usuarios autenticados */}
        <Route
          path="/movies/:id"
          element={
            <ProtectedRoute>
              <DetallePelicula />
            </ProtectedRoute>
          }
        />

        {/* Rutas solo para ADMINS */}
        <Route
          path="/movies/create"
          element={
            <ProtectedRoute requireAdmin={true}>
              <CrearPelicula />
            </ProtectedRoute>
          }
        />
        <Route
          path="/movies/:id/edit"
          element={
            <ProtectedRoute requireAdmin={true}>
              <EditarPelicula />
            </ProtectedRoute>
          }
        />
      </Routes>
    </Router>
  );
}

export default App;
```

### Paso 8: Actualizar PeliculaDetalleCard para ocultar botones

**Archivo:** `src/components/PeliculaDetalleCard.jsx`

```jsx
import { Link, useNavigate } from 'react-router-dom';
import { useAuth } from '../contexts/AuthContext';
import { eliminarPelicula } from '../services/PeliculaService';

export default function PeliculaDetalleCard({ movie }) {
    const navigate = useNavigate();
    const { isAdmin } = useAuth();
    const img = movie.poster_url;

    function handleDelete() {
        if (window.confirm(`¿Eliminar "${movie.title}"?`)) {
            eliminarPelicula(movie.id)
                .then(() => navigate('/'))
                .catch(error => console.error(error));
        }
    }

    return (
        <div className="card shadow">
            <div className="row g-0">
                <div className="col-md-4">
                    {img && (
                        <img
                            src={img}
                            alt={movie.title}
                            className="img-fluid rounded-start h-100"
                            style={{ objectFit: 'cover' }}
                        />
                    )}
                </div>

                <div className="col-md-8 text-start">
                    <div className="card-body d-flex flex-column h-100">
                        <h2 className="card-title mb-3">{movie.title}</h2>

                        <p className="text-muted mb-3">
                            <strong>Año:</strong> {movie.release_year}
                        </p>

                        <div className="mb-3">
                            <strong>Géneros:</strong>
                            <div className="d-flex flex-wrap gap-2 mt-2">
                                {movie.genres && movie.genres.map((genre, index) => (
                                    <span key={index} className="badge bg-primary">
                                        {genre}
                                    </span>
                                ))}
                            </div>
                        </div>

                        <div className="mb-4">
                            <strong>Sinopsis:</strong>
                            <p className="card-text mt-2">{movie.synopsis}</p>
                        </div>

                        <div className="d-flex gap-2">
                            {isAdmin() && (
                                <>
                                    <Link to={`/movies/${movie.id}/edit`} className="btn btn-warning">
                                        Editar
                                    </Link>
                                    <button onClick={handleDelete} className="btn btn-danger">
                                        Eliminar
                                    </button>
                                </>
                            )}

                            <Link to="/" className="btn btn-secondary ms-auto">
                                Volver
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
```

---

## ✅ Testing y Verificación

### Credenciales de Prueba

```
Admin:
  Email: admin@test.com
  Password: password

User:
  Email: user@test.com
  Password: password
```

### Escenarios de Prueba

#### 1. Usuario No Autenticado (Invitado)
- ✅ Puede ver lista de películas
- ❌ No puede ver detalle (redirige a /login)
- ❌ No puede crear/editar/eliminar

#### 2. Usuario Normal (user@test.com)
- ✅ Puede ver lista de películas
- ✅ Puede ver detalle de película
- ❌ No ve botones de Editar/Eliminar
- ❌ No puede acceder a /movies/create (redirige a /)

#### 3. Usuario Admin (admin@test.com)
- ✅ Puede ver lista de películas
- ✅ Puede ver detalle de película
- ✅ Ve botones de Editar/Eliminar
- ✅ Puede crear/editar/eliminar películas

### Verificar en Backend

```bash
# Probar login
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@test.com","password":"password"}'

# Probar endpoint protegido
curl -X GET http://127.0.0.1:8000/api/movies/1 \
  -H "Authorization: Bearer {TOKEN}"
```

---

## 🔒 Seguridad - Puntos Importantes

### Frontend (React)
```javascript
// NIVEL 1: Ocultar elementos visualmente
{isAdmin() && <button>Editar</button>}

// NIVEL 2: Proteger rutas
<ProtectedRoute requireAdmin={true}>
  <EditarPelicula />
</ProtectedRoute>

// NIVEL 3: Enviar token en peticiones
config.headers.Authorization = `Bearer ${token}`;
```

### Backend (Laravel)
```php
// NIVEL 4: Validar token y rol
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('/movies', [MovieController::class, 'store']);
});
```

### ⚠️ Recordatorio Crítico

**Frontend**: Mejora UX (oculta lo que no debe ver)
**Backend**: VERDADERA SEGURIDAD (valida SIEMPRE)

**NUNCA** confíes solo en el frontend. Un usuario malicioso puede:
- Modificar el localStorage
- Hacer peticiones directas con Postman
- Manipular el código JavaScript

**SIEMPRE** valida en el backend cada petición.

---

## 📊 Resumen de Archivos Creados/Modificados

### Backend
- ✅ Migration: `add_role_to_users_table`
- ✅ Seeder: `UserSeeder`
- ✅ Controller: `Api/AuthController`
- ✅ Middleware: `CheckRole`
- ✅ Routes: `api.php`

### Frontend
- ✅ Context: `src/contexts/AuthContext.jsx`
- ✅ Service: `src/services/AuthService.js`
- ✅ Component: `src/components/ProtectedRoute.jsx`
- ✅ Page: `src/pages/Login.jsx`
- ✅ Updated: `src/main.jsx`
- ✅ Updated: `src/services/api.js`
- ✅ Updated: `src/App.jsx`
- ✅ Updated: `src/components/PeliculaDetalleCard.jsx`

---

**Última actualización:** 2025-12-08
**Autor:** Guía de Autenticación CRUD Películas
**Versión:** 1.0
