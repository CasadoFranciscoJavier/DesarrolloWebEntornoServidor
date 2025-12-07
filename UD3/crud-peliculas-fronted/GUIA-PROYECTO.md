# 🎬 GUÍA COMPLETA - Frontend React CRUD Películas

## 📋 Índice
1. [Descripción del Proyecto](#descripción-del-proyecto)
2. [Configuración Inicial](#configuración-inicial)
3. [Instalación de Dependencias](#instalación-de-dependencias)
4. [Configuración de Servicios API](#configuración-de-servicios-api)
5. [Configuración de Bootstrap](#configuración-de-bootstrap)
6. [Lista de Comandos Completa](#lista-de-comandos-completa)

---

## 📝 Descripción del Proyecto

Frontend en React + Vite para el sistema CRUD de películas que consume la API REST de Laravel.

**Funcionalidades:**
- ✅ Listar películas
- ✅ Ver detalle de película
- ✅ Crear nuevas películas
- ✅ Editar películas existentes
- ✅ Eliminar películas
- ✅ Interfaz responsive con Bootstrap 5

**Stack Tecnológico:**
- **Framework:** React 18
- **Build Tool:** Vite 7.2.6
- **Router:** React Router DOM
- **HTTP Client:** Axios
- **UI Framework:** Bootstrap 5 + Popper.js

---

## 🚀 Configuración Inicial

### 1. Crear proyecto con Vite

```bash
npm create vite@latest crud-peliculas-fronted
```

**Opciones seleccionadas:**
```
? Select a framework: › React
? Select a variant: › JavaScript
? Use rolldown-vite (Experimental)?: › No
? Install with npm and start now? › Yes
```

**Proceso automático:**
1. Crea la estructura del proyecto en `crud-peliculas-fronted/`
2. Instala dependencias (157 paquetes)
3. Inicia el servidor de desarrollo

**Resultado:**
```
VITE v7.2.6  ready in 2202 ms

➜  Local:   http://localhost:5173/
➜  Network: use --host to expose
➜  press h + enter to show help
```

---

## 📦 Instalación de Dependencias

### Navegar al proyecto

```bash
cd crud-peliculas-fronted
```

### 1. Instalar React Router DOM

```bash
npm install react-router-dom
```

**Uso:** Manejo de rutas y navegación entre páginas.

**Paquetes añadidos:** 4
**Total paquetes:** 162

---

### 2. Instalar Axios

```bash
npm install axios
```

**Uso:** Cliente HTTP para consumir la API REST de Laravel.

**Paquetes añadidos:** 23
**Total paquetes:** 185

---

### 3. Instalar Bootstrap

```bash
npm install bootstrap
```

**Uso:** Framework CSS para diseño responsive.

**Paquetes añadidos:** 2
**Total paquetes:** 187

---

### 4. Instalar Popper.js

```bash
npm install @popperjs/core
```

**Uso:** Librería requerida por Bootstrap para tooltips, popovers y dropdowns.

**Estado:** Ya incluido como dependencia de Bootstrap
**Total paquetes:** 187

---

## ⚙️ Configuración de Servicios API

### Paso 1: Crear carpeta de servicios

Estructura de carpetas:
```
src/
  └── services/
      └── api.js
```

### Paso 2: Configurar Axios

**Crear archivo:** `src/services/api.js`

```javascript
import axios from 'axios';

// Configuración de Axios con una base URL
const API = axios.create({
  baseURL: 'http://127.0.0.1:8000/api', // Base URL de la API Laravel
});

// Función para obtener todas las películas
export const getPosts = () => API.get('/posts');
```

**Explicación:**
- `baseURL`: Apunta al backend Laravel (`http://127.0.0.1:8000/api`)
- `API.create()`: Crea una instancia de Axios con configuración predeterminada
- `getPosts()`: Función de ejemplo (puedes añadir más funciones para el CRUD)

**Funciones que se añadirán posteriormente:**
```javascript
// Obtener todas las películas
export const getMovies = () => API.get('/movies');

// Obtener detalle de una película
export const getMovie = (id) => API.get(`/movies/${id}`);

// Crear nueva película
export const createMovie = (data) => API.post('/movies', data);

// Actualizar película
export const updateMovie = (id, data) => API.put(`/movies/${id}`, data);

// Eliminar película
export const deleteMovie = (id) => API.delete(`/movies/${id}`);
```

---

## 🎨 Configuración de Bootstrap

### Importar Bootstrap en main.jsx

**Editar:** `src/main.jsx`

```javascript
import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import 'bootstrap/dist/css/bootstrap.min.css';        // CSS de Bootstrap
import 'bootstrap/dist/js/bootstrap.bundle.min.js';   // JavaScript de Bootstrap
import './index.css'
import App from './App.jsx'

createRoot(document.getElementById('root')).render(
  <StrictMode>
    <App />
  </StrictMode>,
)
```

**Orden de importación:**
1. ✅ CSS de Bootstrap (antes de `index.css` para poder sobrescribir estilos)
2. ✅ JavaScript de Bootstrap (incluye Popper.js)
3. ✅ CSS personalizado (`index.css`)
4. ✅ Componente principal (`App.jsx`)

**Nota:** `bootstrap.bundle.min.js` ya incluye Popper.js, por eso no hace falta importarlo por separado.

---

## 📦 Lista de Comandos Completa

### Secuencia para crear el proyecto desde cero:

```bash
# 1. Crear proyecto con Vite
npm create vite@latest crud-peliculas-fronted
# Seleccionar: React → JavaScript → No → Yes

# 2. Navegar al proyecto
cd crud-peliculas-fronted

# 3. Instalar dependencias necesarias
npm install react-router-dom    # Navegación
npm install axios               # Cliente HTTP
npm install bootstrap           # Framework CSS
npm install @popperjs/core      # Dependencia de Bootstrap

# 4. Iniciar servidor de desarrollo
npm run dev
```

---

### Comandos útiles durante el desarrollo:

```bash
# Iniciar servidor de desarrollo
npm run dev

# Construir para producción
npm run build

# Previsualizar build de producción
npm run preview

# Ver dependencias instaladas
npm list --depth=0

# Actualizar dependencias
npm update

# Instalar dependencia específica
npm install nombre-paquete

# Desinstalar dependencia
npm uninstall nombre-paquete
```

---

## 🗂️ Estructura del Proyecto

```
crud-peliculas-fronted/
│
├── public/                      # Archivos estáticos
│   └── vite.svg
│
├── src/
│   ├── assets/                  # Recursos (imágenes, fuentes, etc.)
│   │   └── react.svg
│   │
│   ├── services/                # Servicios y configuración API
│   │   └── api.js               # Configuración Axios
│   │
│   ├── components/              # Componentes reutilizables (próximamente)
│   │
│   ├── pages/                   # Páginas de la aplicación (próximamente)
│   │
│   ├── App.jsx                  # Componente principal
│   ├── App.css                  # Estilos del componente App
│   ├── main.jsx                 # Punto de entrada
│   └── index.css                # Estilos globales
│
├── .gitignore                   # Archivos ignorados por Git
├── eslint.config.js             # Configuración ESLint
├── index.html                   # HTML principal
├── package.json                 # Dependencias y scripts
├── package-lock.json            # Lock de dependencias
├── vite.config.js               # Configuración de Vite
└── GUIA-PROYECTO.md            # Esta guía
```

---

## ✅ Resumen de Archivos Modificados/Creados

### Configuración
- `package.json` - Dependencias añadidas: react-router-dom, axios, bootstrap, @popperjs/core

### Servicios
- `src/services/api.js` - Configuración de Axios con baseURL del backend Laravel

### Punto de entrada
- `src/main.jsx` - Importaciones de Bootstrap CSS y JS

### Próximos pasos
- Crear componentes de la aplicación
- Configurar rutas con React Router
- Implementar páginas del CRUD
- Conectar con la API de Laravel

---

## 🎯 Implementación del CRUD

### Paso 1: Completar el servicio de películas

**Archivo:** `src/services/PeliculaService.js`

```javascript
import { API } from "./api.js"

// Obtener todas las películas
export function getPeliculas(){
    return API.get('/movies')
}

// Obtener detalle de una película
export function getPelicula(id){
    return API.get('/movies/' + id)
}

// Crear nueva película
export function crearPelicula(data){
    return API.post('/movies', data)
}

// Actualizar película
export function actualizarPelicula(id, data){
    return API.put('/movies/' + id, data)
}

// Eliminar película
export function eliminarPelicula(id){
    return API.delete('/movies/' + id)
}
```

**IMPORTANTE:** Asegúrate de que `api.js` exporta correctamente la constante `API`:
```javascript
export const API = axios.create({...})
```

---

### Paso 2: Crear componente de tarjeta de película

**Archivo:** `src/components/PeliculaCard.jsx`

```jsx
import { Link } from 'react-router-dom';

export default function PeliculaCard({ movie }) {
    const img = movie.poster_url

    return (
        <div className="col-lg-3 col-md-4 col-12 mb-3">
            <div className="card h-100 shadow-sm">
                <Link
                    to={`/movies/${movie.id}`}
                    className="text-decoration-none text-dark"
                >
                    {img && (
                        <img
                            src={img}
                            alt={movie.title}
                            className="card-img-top"
                            style={{ height: '400px', objectFit: 'cover' }}
                        />
                    )}

                    <div className="card-body">
                        <h5 className="card-title">{movie.title}</h5>
                        <p className="card-text text-muted">{movie.release_year}</p>

                        <div className="d-flex flex-wrap gap-1">
                            {movie.genres && movie.genres.map((genre, index) => (
                                <span key={index} className="badge bg-primary">
                                    {genre}
                                </span>
                            ))}
                        </div>
                    </div>
                </Link>
            </div>
        </div>
    )
}
```

**Características:**
- Card de Bootstrap responsive
- Imagen de póster con altura fija
- Muestra título, año y géneros
- Enlace a la página de detalle

---

### Paso 3: Crear página de lista de películas

**Archivo:** `src/pages/ListarPeliculas.jsx`

```jsx
import { useState, useEffect } from "react";
import { getPeliculas } from "../services/PeliculaService.js"
import PeliculaCard from "../components/PeliculaCard.jsx";

export default function ListarPeliculas() {

    const [movies, setMovies] = useState([])

    useEffect(() => {
        getPeliculas()
            .then((response) => {
                console.log(response.data)
                setMovies(response.data)
            })
            .catch((error) => console.error(error))
    }, [])

    return (
        <div className="container mt-4">
            <h2 className="mb-4">Listado de Películas</h2>

            <div className="row">
                {movies.map((movie) => (
                    <PeliculaCard key={movie.id} movie={movie} />
                ))}
            </div>
        </div>
    );
}
```

**Explicación:**
- `useState([])`: Estado para almacenar las películas
- `useEffect()`: Se ejecuta al montar el componente
- `getPeliculas()`: Llama a la API para obtener las películas
- `map()`: Renderiza una tarjeta por cada película

---

### Paso 4: Configurar rutas en App.jsx

**Archivo:** `src/App.jsx`

```jsx
import { BrowserRouter as Router, Routes, Route, Link } from 'react-router-dom';
import ListarPeliculas from './pages/ListarPeliculas';
// import CrearPelicula from './pages/CrearPelicula';
// import EditarPelicula from './pages/EditarPelicula';
// import DetallePelicula from './pages/DetallePelicula';
import './App.css'

function App() {
  return (
    <Router>
      {/* Barra de navegación con Bootstrap */}
      <nav className="navbar navbar-expand-lg navbar-dark bg-dark">
        <div className="container-fluid">
          <Link to="/" className="navbar-brand">CRUD Películas</Link>
          <div className="navbar-nav">
            <Link to="/" className="nav-link">Películas</Link>
            {/* <Link to="/movies/create" className="nav-link">Crear Película</Link> */}
          </div>
        </div>
      </nav>

      {/* Definición de rutas */}
      <Routes>
        <Route path="/" element={<ListarPeliculas />} />
        {/* <Route path="/movies/create" element={<CrearPelicula />} />
        <Route path="/movies/:id" element={<DetallePelicula />} />
        <Route path="/movies/:id/edit" element={<EditarPelicula />} /> */}
      </Routes>
    </Router>
  );
}

export default App;
```

**Rutas definidas:**
- `/`: Lista de películas (implementada)
- `/movies/create`: Crear película (pendiente)
- `/movies/:id`: Detalle de película (pendiente)
- `/movies/:id/edit`: Editar película (pendiente)

---

### Paso 5: Crear componente de detalle de pelicula

**Archivo:** `src/components/PeliculaDetalleCard.jsx`

```jsx
import { Link, useNavigate } from 'react-router-dom';
import { eliminarPelicula } from '../services/PeliculaService';

export default function PeliculaDetalleCard({ movie }) {
    const navigate = useNavigate();
    const img = movie.poster_url

    return (
        <div className="card shadow">
            <div className="row g-0">
                {/* Columna de la imagen */}
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

                {/* Columna de la informacion */}
                <div className="col-md-8 text-start">
                    <div className="card-body d-flex flex-column h-100">
                        <h2 className="card-title mb-3">{movie.title}</h2>

                        <p className="text-muted mb-3">
                            <strong>Ano:</strong> {movie.release_year}
                        </p>

                        <div className="mb-3">
                            <strong>Generos:</strong>
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

                        {/* Botones de accion */}
                        <div className="d-flex gap-2">
                            <Link to={`/movies/${movie.id}/edit`} className="btn btn-warning">
                                Editar
                            </Link>
                            <button
                                onClick={() => {
                                    if (window.confirm(`¿Eliminar "${movie.title}"?`)) {
                                        eliminarPelicula(movie.id)
                                            .then(() => navigate('/'))
                                            .catch(error => console.error(error));
                                    }
                                }}
                                className="btn btn-danger"
                            >
                                Eliminar
                            </button>
                            <Link to="/" className="btn btn-secondary ms-auto">
                                Volver
                            </Link>
                        </div>

                    </div>

                </div>
            </div>

        </div>


    )
}
```

**Caracteristicas:**
- Layout de dos columnas (imagen y detalles)
- Muestra toda la informacion de la pelicula
- Botones de accion: Editar, Eliminar, Volver
- Confirmacion antes de eliminar
- Navegacion automatica despues de eliminar

---

### Paso 6: Crear pagina de detalle de pelicula

**Archivo:** `src/pages/DetallePelicula.jsx`

```jsx
import { useState, useEffect } from "react";
import { useParams } from "react-router-dom";
import { getPeliculaById } from "../services/PeliculaService.js";
import PeliculaDetalleCard from "../components/PeliculaDetalleCard.jsx";

export default function DetallePelicula() {

    const { id } = useParams();
    const [movie, setMovie] = useState(null);




    useEffect(() => {
        getPeliculaById(id)
            .then((response) => {
                setMovie(response.data[0]);
            })
            .catch((error) => console.error(error));
    }, [id]);

    if (!movie) {
        return <div>Cargando...</div>;
    }

    return (
        <div className="container mt-4">
            <PeliculaDetalleCard movie={movie} />
        </div>
    );
}
```

**Explicacion:**
- `useParams()`: Obtiene el ID de la pelicula desde la URL
- `getPeliculaById(id)`: Llama a la API para obtener los detalles
- `response.data[0]`: La API Laravel devuelve un array donde el primer elemento es la pelicula
- Estado de carga mientras se obtienen los datos

**NOTA IMPORTANTE:** La API de Laravel devuelve `[pelicula, comentarios]`, por eso usamos `response.data[0]` para obtener solo la pelicula.

---

### Paso 7: Crear pagina de editar pelicula

**Archivo:** `src/pages/EditarPelicula.jsx`

```jsx
import { useState, useEffect } from "react";
import { useParams, useNavigate } from "react-router-dom";
import { getPeliculaById, actualizarPelicula } from "../services/PeliculaService.js";

export default function EditarPelicula() {
    const { id } = useParams();
    const navigate = useNavigate();

    const [poster_url, setPosterUrl] = useState('');
    const [title, setTitle] = useState('');
    const [release_year, setReleaseYear] = useState('');
    const [genres, setGenres] = useState([]);
    const [synopsis, setSynopsis] = useState('');

    const GENEROS = ['Action', 'Comedy', 'Drama', 'Horror', 'Sci-Fi', 'Fantasy', 'Documentary', 'Romance'];

    useEffect(() => {
        getPeliculaById(id)
            .then((response) => {
                const pelicula = response.data[0];
                setPosterUrl(pelicula.poster_url);
                setTitle(pelicula.title);
                setReleaseYear(pelicula.release_year);
                setGenres(pelicula.genres);
                setSynopsis(pelicula.synopsis);
            })
            .catch((error) => console.error(error));
    }, [id]);

    const handleGenreChange = (genero) => {
        if (genres.includes(genero)) {
            setGenres(genres.filter(generoActual => generoActual != genero));
        } else {
            setGenres([...genres, genero]);
        }
    };

    const handleSubmit = (evento) => {
        evento.preventDefault();

        const datos = {
            poster_url: poster_url,
            title: title,
            release_year: release_year,
            genres: genres,
            synopsis: synopsis
        };

        actualizarPelicula(id, datos)
            .then(() => {
                navigate(`/movies/${id}`);
            })
            .catch((error) => console.error(error));
    };

    return (
        <div className="container mt-4">
            <h2 className="mb-4">Editar Pelicula</h2>

            <form onSubmit={handleSubmit}>
                <div className="mb-3">
                    <label className="form-label">URL del Poster</label>
                    <input
                        type="url"
                        className="form-control"
                        value={poster_url}
                        onChange={(evento) => setPosterUrl(evento.target.value)}
                        required
                    />
                </div>

                <div className="mb-3">
                    <label className="form-label">Titulo</label>
                    <input
                        type="text"
                        className="form-control"
                        value={title}
                        onChange={(evento) => setTitle(evento.target.value)}
                        required
                    />
                </div>

                <div className="mb-3">
                    <label className="form-label">Ano</label>
                    <input
                        type="number"
                        className="form-control"
                        value={release_year}
                        onChange={(evento) => setReleaseYear(evento.target.value)}
                        required
                    />
                </div>

                <div className="mb-3">
                    <label className="form-label">Generos</label>
                    <div className="row">
                        {GENEROS.map((genero) => (
                            <div key={genero} className="col-6 col-md-3">
                                <div className="form-check">
                                    <input
                                        type="checkbox"
                                        className="form-check-input"
                                        checked={genres.includes(genero)}
                                        onChange={() => handleGenreChange(genero)}
                                    />
                                    <label className="form-check-label">{genero}</label>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>

                <div className="mb-3">
                    <label className="form-label">Sinopsis</label>
                    <textarea
                        className="form-control"
                        rows="5"
                        value={synopsis}
                        onChange={(evento) => setSynopsis(evento.target.value)}
                        required
                    ></textarea>
                </div>

                <div className="d-flex gap-2">
                    <button type="submit" className="btn btn-primary">
                        Guardar
                    </button>
                    <button
                        type="button"
                        className="btn btn-secondary"
                        onClick={() => navigate(`/movies/${id}`)}
                    >
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    );
}
```

**Explicacion:**
- Estados individuales para cada campo del formulario (NO usar objeto formData para mayor simplicidad)
- `useEffect()`: Carga los datos actuales de la pelicula al montar el componente
- `handleGenreChange()`: Maneja la seleccion de generos con checkboxes
- `handleSubmit()`: Envia los datos actualizados a la API
- Navegacion automatica al detalle despues de guardar
- Todas las variables tienen nombres descriptivos (NUNCA letras sueltas)
- Todos los eventos usan la palabra `evento` en lugar de `e`

**Convenciones de codigo importantes:**
- NO usar single-letter variables (prohibido `e`, `g`, etc.)
- Usar nombres descriptivos: `evento`, `generoActual`
- Codigo simple y facil de entender para estudiantes
- Usar `!=` en lugar de `!==`
- Un solo return por funcion

---

### Paso 8: Actualizar rutas en App.jsx

**Archivo:** `src/App.jsx` (version completa)

```jsx
import { BrowserRouter as Router, Routes, Route, Link } from 'react-router-dom';
import ListarPeliculas from './pages/ListarPeliculas';
// import CrearPelicula from './pages/CrearPelicula';
import EditarPelicula from './pages/EditarPelicula';
import DetallePelicula from './pages/DetallePelicula';
import './App.css'

function App() {
  return (
    <Router>
      {/* Barra de navegacion con Bootstrap */}
      <nav className="navbar navbar-expand-lg navbar-dark bg-dark">
        <div className="container-fluid">
          <Link to="/" className="navbar-brand">CRUD Peliculas</Link>
          <div className="navbar-nav">
            <Link to="/" className="nav-link">Peliculas</Link>
            {/* <Link to="/movies/create" className="nav-link">Crear Pelicula</Link> */}
          </div>
        </div>
      </nav>

      {/* Definicion de rutas */}
      <Routes>
        <Route path="/" element={<ListarPeliculas />} />
        {/* <Route path="/movies/create" element={<CrearPelicula />} />   */}
        <Route path="/movies/:id" element={<DetallePelicula />} />
        <Route path="/movies/:id/edit" element={<EditarPelicula />} />
      </Routes>
    </Router>
  );
}

export default App;
```

**Rutas implementadas:**
- `/`: Lista de peliculas
- `/movies/:id`: Detalle de pelicula
- `/movies/:id/edit`: Editar pelicula
- `/movies/create`: Crear pelicula (pendiente)

---

## 🔗 Conexion con el Backend

### Configuración CORS en Laravel

Para que el frontend pueda comunicarse con el backend, Laravel debe tener configurado CORS.

**Comandos en el backend:**
```bash
cd ../CRUD_Peliculas
php artisan config:publish cors
# Editar config/cors.php (usar 'allowed_origins' => ['*'] en desarrollo)
php artisan config:clear
php artisan serve
```

**Verificar que el backend está corriendo:**
```
http://127.0.0.1:8000/api/movies
```

---

## 📝 Notas Importantes

1. **Puerto del frontend:** Vite usa por defecto el puerto `5173`
2. **Puerto del backend:** Laravel usa por defecto el puerto `8000`
3. **CORS:** Asegúrate de tener configurado CORS en Laravel con `allowed_origins => ['*']` en desarrollo
4. **API URL:** La baseURL de Axios apunta a `http://127.0.0.1:8000/api`
5. **Error común:** Si `API` no se exporta correctamente en `api.js`, verás el error: `The requested module does not provide an export named 'API'`

---

## 🚧 Estado del Proyecto

- [x] Crear componentes de navegacion (Navbar)
- [x] Implementar pagina de lista de peliculas
- [x] Implementar pagina de detalle de pelicula
- [x] Implementar componente de tarjeta de detalle
- [x] Implementar formulario de editar pelicula
- [x] Implementar funcionalidad de eliminar pelicula
- [x] Configurar React Router para navegacion
- [ ] Implementar formulario de crear pelicula
- [ ] Implementar manejo de errores avanzado
- [ ] Anadir validaciones de formularios adicionales
- [ ] Mejorar estilos personalizados

---

**Última actualización:** 2025-12-07
**Versión React:** 18.3.1
**Versión Vite:** 7.2.6
**Node.js recomendado:** 18.x o superior
