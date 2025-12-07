import { BrowserRouter as Router, Routes, Route, Link } from 'react-router-dom';
import ListarPeliculas from './pages/ListarPeliculas';
// import CrearPelicula from './pages/CrearPelicula';
import EditarPelicula from './pages/EditarPelicula';
import DetallePelicula from './pages/DetallePelicula';
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
        {/* <Route path="/movies/create" element={<CrearPelicula />} />   */}
        <Route path="/movies/:id" element={<DetallePelicula />} />
        <Route path="/movies/:id/edit" element={<EditarPelicula />} />
      </Routes>
    </Router>
  );
}

export default App;