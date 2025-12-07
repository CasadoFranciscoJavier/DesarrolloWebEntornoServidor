import { API } from "./api.js"

// Obtener todas las películas
export function getPeliculas(){
    return API.get('/movies')
}

// Obtener detalle de una película
export function getPeliculaById(id){
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