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
                    <label className="form-label">Año</label>
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
