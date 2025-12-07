import axios from 'axios';

// Configuración de Axios con una base URL
const API = axios.create({
  baseURL: 'http://127.0.0.1:8000/api', // Base URL de la API
});

// Función para obtener datos
export const getPosts = () => API.get('/posts');