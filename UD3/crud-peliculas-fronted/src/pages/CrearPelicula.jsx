import { useState, useEffect } from "react";
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

    // Estados para los mensajes de error
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
            validarAno() ? '' : 'El año debe estar entre 1888 (primera película) y el año actual'
        );

        setMensajeGeneros(
            validarGeneros() ? '' : 'Debes seleccionar al menos un género'
        );

        setMensajeSinopsis(
            validarSinopsis() ? '' : 'La sinopsis debe tener entre 10 y 500 caracteres'
        );
    }, [movie]);

    function handleChange(input) {
        const { name, value } = input.target;
        setMovie({
            ...movie,
            [name]: value
        });
    }

    function validarPoster() {
        return movie.poster_url.trim().length > 0;
    }

    function validarTitulo() {
        return movie.title.trim().length >= 1 && movie.title.trim().length <= 100;
    }

    function validarAno() {
        const anoActual = new Date().getFullYear();
        const ano = parseInt(movie.release_year);
        return ano >= 1888 && ano <= anoActual;
    }

    function validarGeneros() {
        return movie.genres.length >= 1;
    }

    function validarSinopsis() {
        return movie.synopsis.trim().length >= 10 && movie.synopsis.trim().length <= 500;
    }

    function handleGenreChange(genero) {
        if (movie.genres.includes(genero)) {
            setMovie({
                ...movie,
                genres: movie.genres.filter(generoActual => generoActual != genero)  
            });
            // El filter recorre la lista elemento por elemento (a cada uno lo llama temporalmente generoActual
            //Nos quedamos solo con los géneros que NO SEAN IGUALES al que acabo de clicar
        } else {
            setMovie({
                ...movie,
                genres: [...movie.genres, genero]
            });
        }
    }

    function handleSubmit(form) {
        form.preventDefault();

        // Validar todos los campos antes de enviar
        if (validarPoster() && validarTitulo() && validarAno() && validarGeneros() && validarSinopsis()) {
            crearPelicula(movie)
                .then((response) => navigate(`/movies/${response.data.id}`))
                .catch((error) => console.error(error));
        }
    }

    return (
        <div className="container mt-4">
            <h2 className="mb-4">Registar Pelicula</h2>

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
                    {mensajePoster && <small className="text-danger">{mensajePoster}</small>}
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
                    {mensajeTitulo && <small className="text-danger">{mensajeTitulo}</small>}
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
                    {mensajeAno && <small className="text-danger">{mensajeAno}</small>}
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
                    {mensajeGeneros && <small className="text-danger">{mensajeGeneros}</small>}
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
                    {mensajeSinopsis && <small className="text-danger">{mensajeSinopsis}</small>}
                </div>

                <div className="d-flex gap-2">
                    <button type="submit" className="btn btn-primary">
                        Guardar
                    </button>
                    <button
                        type="button"
                        className="btn btn-secondary"
                        onClick={() => navigate(`/`)}
                    >
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    );
}
