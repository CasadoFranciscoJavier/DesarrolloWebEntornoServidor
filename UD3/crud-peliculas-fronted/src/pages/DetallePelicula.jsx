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
