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

                {/* Columna de la información */}
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

                        {/* Botones de acción */}
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
