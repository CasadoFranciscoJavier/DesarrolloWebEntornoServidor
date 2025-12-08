# 🎬 CRUD Películas - Frontend React

Frontend en React + Vite para sistema CRUD de gestión de películas que consume una API REST de Laravel.

![React](https://img.shields.io/badge/React-18.3.1-blue)
![Vite](https://img.shields.io/badge/Vite-7.2.6-purple)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-blueviolet)
![License](https://img.shields.io/badge/License-MIT-green)

## 📋 Características

- ✅ Listar películas con tarjetas visuales
- ✅ Ver detalles completos de cada película
- ✅ Crear nuevas películas
- ✅ Editar películas existentes
- ✅ Eliminar películas con confirmación
- ✅ Interfaz responsive con Bootstrap 5
- ✅ Navegación SPA con React Router
- ✅ Consumo de API REST con Axios

## 🛠️ Stack Tecnológico

| Tecnología | Versión | Uso |
|------------|---------|-----|
| React | 18.3.1 | Framework principal |
| Vite | 7.2.6 | Build tool y dev server |
| React Router DOM | - | Navegación y rutas |
| Axios | - | Cliente HTTP |
| Bootstrap 5 | - | Framework CSS |
| Popper.js | - | Tooltips y popovers |

## 🚀 Inicio Rápido

### Requisitos Previos

- Node.js 18.x o superior
- npm o yarn
- Backend Laravel corriendo en `http://127.0.0.1:8000`

### Instalación

```bash
# Clonar el repositorio
git clone <url-del-repositorio>

# Navegar al directorio
cd crud-peliculas-fronted

# Instalar dependencias
npm install

# Iniciar servidor de desarrollo
npm run dev
```

El proyecto estará disponible en: `http://localhost:5173`

## 📦 Comandos Disponibles

```bash
# Desarrollo
npm run dev          # Inicia servidor de desarrollo
npm run build        # Construye para producción
npm run preview      # Previsualiza build de producción
npm run lint         # Ejecuta linter

# Gestión de dependencias
npm install <paquete>      # Instala nueva dependencia
npm uninstall <paquete>    # Desinstala dependencia
npm list --depth=0         # Lista dependencias instaladas
```

## 📁 Estructura del Proyecto

```
crud-peliculas-fronted/
├── public/
│   └── vite.svg
├── src/
│   ├── assets/
│   │   ├── react.svg
│   │   └── logo-api-crud-peliculas.png
│   ├── services/
│   │   ├── api.js                    # Configuración Axios
│   │   └── PeliculaService.js        # Servicios CRUD
│   ├── components/
│   │   ├── PeliculaCard.jsx          # Tarjeta lista
│   │   └── PeliculaDetalleCard.jsx   # Tarjeta detalle
│   ├── pages/
│   │   ├── ListarPeliculas.jsx       # Página principal
│   │   ├── DetallePelicula.jsx       # Ver película
│   │   ├── CrearPelicula.jsx         # Crear película
│   │   └── EditarPelicula.jsx        # Editar película
│   ├── App.jsx                        # Router principal
│   ├── App.css
│   ├── main.jsx                       # Punto de entrada
│   └── index.css
├── .gitignore
├── index.html
├── package.json
├── vite.config.js
├── GUIA-PROYECTO.md                   # Guía completa de implementación
├── GUIA-AUTENTICACION.md              # Guía de autenticación (opcional)
└── README.md                          # Este archivo
```

## 🎯 Rutas de la Aplicación

| Ruta | Componente | Descripción |
|------|-----------|-------------|
| `/` | ListarPeliculas | Lista todas las películas |
| `/movies/create` | CrearPelicula | Formulario para crear película |
| `/movies/:id` | DetallePelicula | Detalles de una película |
| `/movies/:id/edit` | EditarPelicula | Formulario de edición |

## 🔌 API Endpoints Utilizados

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/api/movies` | Obtener todas las películas |
| GET | `/api/movies/{id}` | Obtener una película |
| POST | `/api/movies` | Crear nueva película |
| PUT | `/api/movies/{id}` | Actualizar película |
| DELETE | `/api/movies/{id}` | Eliminar película |

## 📚 Documentación

### Guías Disponibles

- **[GUIA-PROYECTO.md](./GUIA-PROYECTO.md)** - Guía completa paso a paso del proyecto
  - Configuración inicial
  - Instalación de dependencias
  - Implementación completa del CRUD
  - Conceptos clave de React

- **[GUIA-AUTENTICACION.md](./GUIA-AUTENTICACION.md)** - Sistema de autenticación (opcional)
  - Login/Logout
  - Roles (admin/user)
  - Protección de rutas
  - Control de acceso basado en roles

## 🔧 Configuración

### Variables de Entorno

La URL base de la API se configura en `src/services/api.js`:

```javascript
const API = axios.create({
  baseURL: 'http://127.0.0.1:8000/api',
});
```

### CORS en Laravel

Asegúrate de tener configurado CORS en tu backend Laravel:

```bash
cd ../CRUD_Peliculas
php artisan config:publish cors
# Editar config/cors.php
php artisan config:clear
php artisan serve
```

## 🎨 Patrones de Código

### Gestión de Estado Simplificada

```javascript
// ✅ Patrón utilizado: Un solo estado objeto
const [movie, setMovie] = useState(peliculaVacia);

// Función genérica reutilizable
function handleChange(input) {
    const { name, value } = input.target;
    setMovie({ ...movie, [name]: value });
}
```

### Convenciones de Código

- ✅ Nombres descriptivos (no variables de una letra)
- ✅ `function` en lugar de arrow functions para mayor claridad
- ✅ Usar `!=` en lugar de `!==`
- ✅ Código simple y fácil de entender

## 🤝 Integración con Backend

Este frontend está diseñado para consumir la API REST del backend Laravel:

- **Backend:** [CRUD_Peliculas](../CRUD_Peliculas)
- **API Base:** `http://127.0.0.1:8000/api`
- **Autenticación:** Laravel Sanctum (opcional)

## 📝 Notas Importantes

1. El backend Laravel debe estar corriendo antes de iniciar el frontend
2. Asegúrate de tener CORS configurado correctamente
3. La API devuelve arrays en algunos endpoints (ver documentación)
4. Bootstrap ya incluye Popper.js en el bundle

## 🐛 Solución de Problemas

### Error: Cannot find module 'axios'
```bash
npm install axios
```

### Error: API no responde
- Verifica que Laravel esté corriendo: `php artisan serve`
- Verifica la URL en `src/services/api.js`
- Revisa la configuración CORS en Laravel

### Error: CORS policy
```bash
# En el backend Laravel
php artisan config:publish cors
# Editar config/cors.php
# Reiniciar servidor
```

## 📄 Licencia

Este proyecto es de código abierto y está disponible bajo la licencia MIT.

## 👤 Autor

Proyecto educativo - CRUD Películas Frontend React

---

**Última actualización:** 2025-12-08
