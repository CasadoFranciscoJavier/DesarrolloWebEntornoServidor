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
