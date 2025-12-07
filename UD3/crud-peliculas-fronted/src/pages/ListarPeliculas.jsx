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