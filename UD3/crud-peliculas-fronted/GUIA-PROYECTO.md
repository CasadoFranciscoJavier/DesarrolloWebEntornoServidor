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
- Esta configuración se usará en todos los servicios de la aplicación

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

## 🗂️ Estructura Inicial del Proyecto

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
│   ├── components/              # Componentes reutilizables
│   │
│   ├── pages/                   # Páginas de la aplicación
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

## 🎯 Implementación Completa del CRUD

### Paso 1: Crear el servicio de películas

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

### Paso 4: Configurar rutas iniciales en App.jsx

**Archivo:** `src/App.jsx`

```jsx
import { BrowserRouter as Router, Routes, Route, Link } from 'react-router-dom';
import ListarPeliculas from './pages/ListarPeliculas';
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
          </div>
        </div>
      </nav>

      {/* Definición de rutas */}
      <Routes>
        <Route path="/" element={<ListarPeliculas />} />
      </Routes>
    </Router>
  );
}

export default App;
```

**Ruta inicial:**
- `/`: Lista de películas

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

const peliculaVacia = {
    poster_url: '',
    title: '',
    release_year: '',
    genres: [],
    synopsis: ''
}

export default function EditarPelicula() {

    const navigate = useNavigate();
    const { id } = useParams();
    const [movie, setMovie] = useState(peliculaVacia);

    const GENEROS = ['Action', 'Comedy', 'Drama', 'Horror', 'Sci-Fi', 'Fantasy', 'Documentary', 'Romance'];

    // useEffect(() => {             Así sería con varios useState
    //     getPeliculaById(id)
    //         .then((response) => {
    //             const pelicula = response.data[0];
    //             setPosterUrl(pelicula.poster_url);
    //             setTitle(pelicula.title);
    //             setReleaseYear(pelicula.release_year);
    //             setGenres(pelicula.genres);
    //             setSynopsis(pelicula.synopsis);
    //         })
    //         .catch((error) => console.error(error));
    // }, [id]);

    useEffect(() => {
        getPeliculaById(id)
            .then((response) => setMovie(response.data[0]))
            .catch((error) => console.error(error));
    }, [id]);

    function handleChange(input) {
        const { name, value } = input.target;
        setMovie({
            ...movie,
            [name]: value
        });
    }

    function handleGenreChange(genero) {
        if (movie.genres.includes(genero)) {
            setMovie({
                ...movie,
                genres: movie.genres.filter(generoActual => generoActual != genero)
            });
        } else {
            setMovie({
                ...movie,
                genres: [...movie.genres, genero]
            });
        }
    }

    function handleSubmit(form) {
        form.preventDefault();
        actualizarPelicula(id, movie)
            .then(() => navigate(`/movies/${id}`))
            .catch((error) => console.error(error));
    }

    return (
        <div className="container mt-4">
            <h2 className="mb-4">Editar Pelicula</h2>

            <form onSubmit={handleSubmit}>
                <div className="mb-3">
                    <label className="form-label"><strong>URL Póster: </strong></label>
                    <input
                        type="url"
                        name="poster_url"
                        className="form-control"
                        value={movie.poster_url}
                        onChange={handleChange}
                        required
                    />
                </div>

                <div className="mb-3">
                    <label className="form-label"><strong>Título: </strong></label>
                    <input
                        type="text"
                        name="title"
                        className="form-control"
                        value={movie.title}
                        onChange={handleChange}
                        required
                    />
                </div>

                <div className="mb-3">
                    <label className="form-label"><strong>Año: </strong></label>
                    <input
                        type="number"
                        name="release_year"
                        className="form-control"
                        value={movie.release_year}
                        onChange={handleChange}
                        required
                    />
                </div>

                <div className="mb-3">
                    <label className="form-label"><strong>Géneros: </strong></label>
                    <div className="row">
                        {GENEROS.map((genero) => (
                            <div key={genero} className="col-6 col-md-3">
                                <div className="form-check">
                                    <input
                                        type="checkbox"
                                        className="form-check-input"
                                        checked={movie.genres.includes(genero)}
                                        onChange={() => handleGenreChange(genero)}
                                    />
                                    <label className="form-check-label">{genero}</label>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>

                <div className="mb-3">
                    <label className="form-label"><strong>Sinopsis: </strong></label>
                    <textarea
                        name="synopsis"
                        className="form-control"
                        rows="5"
                        value={movie.synopsis}
                        onChange={handleChange}
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
- **Enfoque simplificado:** Un solo estado `movie` en lugar de múltiples estados separados
- `peliculaVacia`: Objeto inicial con todos los campos vacíos
- `useEffect()`: Carga los datos actuales de la película (`response.data[0]` porque la API devuelve un array)
- `handleChange()`: Función genérica que actualiza cualquier campo usando el atributo `name` del input
- `handleGenreChange()`: Maneja la selección de géneros con checkboxes
- `handleSubmit()`: Envía el objeto `movie` completo a la API
- Navegación automática al detalle después de guardar

**Ventajas del enfoque simplificado:**
- ✅ **Menos código:** 1 estado en lugar de 5
- ✅ **Más mantenible:** Añadir campos nuevos es muy fácil
- ✅ **Función reutilizable:** `handleChange` funciona para todos los campos
- ✅ **Menos errores:** Todo centralizado en un objeto

**Convenciones de código importantes:**
- NO usar single-letter variables (prohibido `e`, `g`, etc.)
- Usar nombres descriptivos: `input`, `form`, `generoActual`
- Código simple y fácil de entender para estudiantes
- Usar `!=` en lugar de `!==`
- Usar `function` en lugar de arrow functions para mayor claridad

---

### Paso 8: Crear página de crear película

**Archivo:** `src/pages/CrearPelicula.jsx`

```jsx
import { useState } from "react";
import { useNavigate } from "react-router-dom";
import { crearPelicula } from "../services/PeliculaService.js";

const peliculaVacia = {
    poster_url: '',
    title: '',
    release_year: '',
    genres: [],
    synopsis: ''
}

export default function CrearPelicula() {

    const navigate = useNavigate();
    const [movie, setMovie] = useState(peliculaVacia);

    const GENEROS = ['Action', 'Comedy', 'Drama', 'Horror', 'Sci-Fi', 'Fantasy', 'Documentary', 'Romance'];

    function handleChange(input) {
        const { name, value } = input.target;
        setMovie({
            ...movie,
            [name]: value
        });
    }

    function handleGenreChange(genero) {
        if (movie.genres.includes(genero)) {
            setMovie({
                ...movie,
                genres: movie.genres.filter(generoActual => generoActual != genero)
            });
        } else {
            setMovie({
                ...movie,
                genres: [...movie.genres, genero]
            });
        }
    }

    function handleSubmit(form) {
        form.preventDefault();
        crearPelicula(movie)
            .then((response) => navigate(`/movies/${response.data.id}`))
            .catch((error) => console.error(error));
    }

    return (
        <div className="container mt-4">
            <h2 className="mb-4">Registrar Película</h2>

            <form onSubmit={handleSubmit}>
                <div className="mb-3">
                    <label className="form-label"><strong>URL Póster: </strong></label>
                    <input
                        type="url"
                        name="poster_url"
                        className="form-control"
                        value={movie.poster_url}
                        onChange={handleChange}
                        required
                    />
                </div>

                <div className="mb-3">
                    <label className="form-label"><strong>Título: </strong></label>
                    <input
                        type="text"
                        name="title"
                        className="form-control"
                        value={movie.title}
                        onChange={handleChange}
                        required
                    />
                </div>

                <div className="mb-3">
                    <label className="form-label"><strong>Año: </strong></label>
                    <input
                        type="number"
                        name="release_year"
                        className="form-control"
                        value={movie.release_year}
                        onChange={handleChange}
                        required
                    />
                </div>

                <div className="mb-3">
                    <label className="form-label"><strong>Géneros: </strong></label>
                    <div className="row">
                        {GENEROS.map((genero) => (
                            <div key={genero} className="col-6 col-md-3">
                                <div className="form-check">
                                    <input
                                        type="checkbox"
                                        className="form-check-input"
                                        checked={movie.genres.includes(genero)}
                                        onChange={() => handleGenreChange(genero)}
                                    />
                                    <label className="form-check-label">{genero}</label>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>

                <div className="mb-3">
                    <label className="form-label"><strong>Sinopsis: </strong></label>
                    <textarea
                        name="synopsis"
                        className="form-control"
                        rows="5"
                        value={movie.synopsis}
                        onChange={handleChange}
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
                        onClick={() => navigate('/')}
                    >
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    );
}
```

**Explicación:**
- **Mismo enfoque simplificado** que EditarPelicula
- NO necesita `useEffect()` porque no carga datos previos (película nueva)
- NO necesita `useParams()` porque no hay `id` en la URL
- `handleSubmit()`: Usa `response.data.id` para navegar a la película recién creada
- **IMPORTANTE:** `response.data.id` es el id que devuelve el backend después de crear la película

**Diferencias con EditarPelicula:**
- ❌ Sin `useEffect()` (no carga datos)
- ❌ Sin `useParams()` (no hay id)
- ✅ `navigate('/')` en botón Cancelar (vuelve al home)
- ✅ `navigate(\`/movies/${response.data.id}\`)` después de crear (redirige a la nueva película)

---

### Paso 9: Actualizar rutas en App.jsx

**Archivo:** `src/App.jsx` (versión completa)

```jsx
import { BrowserRouter as Router, Routes, Route, Link } from 'react-router-dom';
import ListarPeliculas from './pages/ListarPeliculas';
import CrearPelicula from './pages/CrearPelicula';
import EditarPelicula from './pages/EditarPelicula';
import DetallePelicula from './pages/DetallePelicula';
import './App.css'
import logo from './assets/logo-api-crud-peliculas.png';

function App() {
  return (
    <Router>
      {/* Barra de navegación con Bootstrap */}
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
          <div className="navbar-nav">
            <Link to="/" className="nav-link">Películas</Link>
            <Link to="/movies/create" className="nav-link">Registrar Película</Link>
          </div>
        </div>
      </nav>

      {/* Definición de rutas */}
      <Routes>
        <Route path="/" element={<ListarPeliculas />} />
        <Route path="/movies/create" element={<CrearPelicula />} />
        <Route path="/movies/:id" element={<DetallePelicula />} />
        <Route path="/movies/:id/edit" element={<EditarPelicula />} />
      </Routes>
    </Router>
  );
}

export default App;
```

**Rutas implementadas:**
- ✅ `/`: Lista de películas
- ✅ `/movies/create`: Crear película
- ✅ `/movies/:id`: Detalle de película
- ✅ `/movies/:id/edit`: Editar película

**Características del navbar:**
- Logo personalizado importado desde `assets/`
- Links a las páginas principales
- Clase `navbar-fija` para estilos personalizados

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

### ✅ Funcionalidades Completadas

- [x] Crear componentes de navegación (Navbar con logo)
- [x] Implementar página de lista de películas
- [x] Implementar página de detalle de película
- [x] Implementar componente de tarjeta de detalle
- [x] Implementar formulario de editar película (enfoque simplificado)
- [x] Implementar formulario de crear película (enfoque simplificado)
- [x] Implementar funcionalidad de eliminar película
- [x] Configurar React Router para navegación
- [x] Conectar todas las rutas del CRUD completo
- [x] Usar enfoque simplificado de un solo estado por formulario

### 🎯 Mejoras Futuras (Opcionales)

- [ ] Implementar manejo de errores avanzado (toasts, alertas)
- [ ] Añadir validaciones de formularios adicionales
- [ ] Mejorar estilos personalizados (CSS custom)
- [ ] Añadir paginación en la lista de películas
- [ ] Implementar búsqueda y filtros
- [ ] Añadir animaciones de transición entre páginas

---

## 📚 Conceptos Clave Aprendidos

### 1. **Gestión de Estado Simplificada**
```javascript
// ✅ ENFOQUE RECOMENDADO: Un solo estado objeto
const [movie, setMovie] = useState(peliculaVacia);

// ❌ ENFOQUE COMPLEJO: Múltiples estados separados
const [title, setTitle] = useState('');
const [year, setYear] = useState('');
// ... etc
```

### 2. **Función handleChange Genérica**
```javascript
function handleChange(input) {
    const { name, value } = input.target;
    setMovie({ ...movie, [name]: value });
}
```
- Usa el atributo `name` del input para actualizar dinámicamente
- Reutilizable para todos los campos del formulario

### 3. **Spread Operator (`...`)**
```javascript
setMovie({
    ...movie,           // Copia todas las propiedades
    title: "nuevo"      // Sobrescribe solo una
});
```

### 4. **Respuestas de la API**
```javascript
// EditarPelicula - API devuelve array [pelicula, comentarios]
.then((response) => setMovie(response.data[0]))

// CrearPelicula - API devuelve el objeto creado con id
.then((response) => navigate(`/movies/${response.data.id}`))
```

---

## 🎓 Estructura Final del Proyecto

```
crud-peliculas-fronted/
│
├── public/
│   └── vite.svg
│
├── src/
│   ├── assets/
│   │   ├── react.svg
│   │   └── logo-api-crud-peliculas.png
│   │
│   ├── services/
│   │   ├── api.js                    # Configuración Axios
│   │   └── PeliculaService.js        # Servicios CRUD
│   │
│   ├── components/
│   │   ├── PeliculaCard.jsx          # Tarjeta para lista
│   │   └── PeliculaDetalleCard.jsx   # Tarjeta de detalle
│   │
│   ├── pages/
│   │   ├── ListarPeliculas.jsx       # Página principal (home)
│   │   ├── DetallePelicula.jsx       # Ver película
│   │   ├── CrearPelicula.jsx         # Crear película
│   │   └── EditarPelicula.jsx        # Editar película
│   │
│   ├── App.jsx                        # Router y navegación
│   ├── App.css                        # Estilos de App
│   ├── main.jsx                       # Punto de entrada
│   └── index.css                      # Estilos globales
│
├── .gitignore
├── eslint.config.js
├── index.html
├── package.json
├── package-lock.json
├── vite.config.js
└── GUIA-PROYECTO.md                   # Esta guía
```

---

---

## ✅ Validaciones de Formularios

### Implementación de Validaciones en Tiempo Real

Las validaciones se implementan siguiendo el patrón del ejemplo de registro de usuario, con validaciones en tiempo real usando `useEffect`.

#### Reglas de Validación

| Campo | Validación | Mensaje de Error |
|-------|------------|------------------|
| **URL Póster** | No puede estar vacío | "La URL del póster debe ser válida y no estar vacía" |
| **Título** | Entre 1 y 100 caracteres | "El título debe tener entre 1 y 100 caracteres" |
| **Año** | Entre 1888 y año actual + 5 | "El año debe estar entre 1888 (primera película) y el año actual + 5" |
| **Géneros** | Al menos 1 género seleccionado | "Debes seleccionar al menos un género" |
| **Sinopsis** | Entre 10 y 500 caracteres | "La sinopsis debe tener entre 10 y 500 caracteres" |

#### Ejemplo de Implementación (CrearPelicula.jsx)

```javascript
// Estados para mensajes de error
const [mensajePoster, setMensajePoster] = useState('');
const [mensajeTitulo, setMensajeTitulo] = useState('');
const [mensajeAno, setMensajeAno] = useState('');
const [mensajeGeneros, setMensajeGeneros] = useState('');
const [mensajeSinopsis, setMensajeSinopsis] = useState('');

// useEffect para validar en tiempo real
useEffect(() => {
    setMensajePoster(
        validarPoster() ? '' : 'La URL del póster debe ser válida y no estar vacía'
    );

    setMensajeTitulo(
        validarTitulo() ? '' : 'El título debe tener entre 1 y 100 caracteres'
    );

    setMensajeAno(
        validarAno() ? '' : 'El año debe estar entre 1888 (primera película) y el año actual + 5'
    );

    setMensajeGeneros(
        validarGeneros() ? '' : 'Debes seleccionar al menos un género'
    );

    setMensajeSinopsis(
        validarSinopsis() ? '' : 'La sinopsis debe tener entre 10 y 500 caracteres'
    );
}, [movie]);

// Funciones de validación
function validarPoster() {
    return movie.poster_url.trim().length > 0;
}

function validarTitulo() {
    return movie.title.trim().length >= 1 && movie.title.trim().length <= 100;
}

function validarAno() {
    const anoActual = new Date().getFullYear();
    const ano = parseInt(movie.release_year);
    return ano >= 1888 && ano <= anoActual + 5;
}

function validarGeneros() {
    return movie.genres.length >= 1;
}

function validarSinopsis() {
    return movie.synopsis.trim().length >= 10 && movie.synopsis.trim().length <= 500;
}

// Validar antes de enviar
function handleSubmit(form) {
    form.preventDefault();

    if (validarPoster() && validarTitulo() && validarAno() && validarGeneros() && validarSinopsis()) {
        crearPelicula(movie)
            .then((response) => navigate(`/movies/${response.data.id}`))
            .catch((error) => console.error(error));
    }
}
```

#### Mostrar Mensajes de Error en el Formulario

```jsx
<div className="mb-3">
    <label className="form-label"><strong>Título: </strong></label>
    <input
        type="text"
        name="title"
        className="form-control"
        value={movie.title}
        onChange={handleChange}
        required
    />
    {mensajeTitulo && <small className="text-danger">{mensajeTitulo}</small>}
</div>
```

#### Características de las Validaciones

- ✅ **Validación en tiempo real:** Los mensajes aparecen mientras el usuario escribe
- ✅ **Prevención de envío:** El formulario solo se envía si todos los campos son válidos
- ✅ **Mensajes descriptivos:** Cada error tiene un mensaje claro y específico
- ✅ **Validación de año:** Verifica que el año esté en un rango realista (desde 1888, primera película de la historia)
- ✅ **Validación de géneros:** Asegura que al menos un género esté seleccionado
- ✅ **Validación de longitud:** Título y sinopsis tienen límites mínimos y máximos

---

## 🔐 Autenticación y Control de Acceso (Opcional)

Si deseas implementar un sistema de autenticación con roles (admin/user), consulta la guía completa:

📄 **[GUIA-AUTENTICACION.md](./GUIA-AUTENTICACION.md)**

Esta guía incluye:
- Login/Logout con Laravel Sanctum
- Tokens JWT
- Protección de rutas según rol
- Control de acceso basado en roles (RBAC)
- Implementación paso a paso (backend + frontend)

---

**Última actualización:** 2025-12-08
**Versión React:** 18.3.1
**Versión Vite:** 7.2.6
**Node.js recomendado:** 18.x o superior

**Proyecto completado:** ✅ CRUD funcional completo
