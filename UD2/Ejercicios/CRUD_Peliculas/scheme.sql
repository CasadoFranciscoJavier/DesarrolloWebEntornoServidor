-- ================================
-- CREACIÓN DE BASE DE DATOS
-- ================================
DROP DATABASE IF EXISTS web_peliculas;
CREATE DATABASE web_peliculas;
USE web_peliculas;

-- ================================
-- TABLA usuarios
-- ================================
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    contrasenia VARCHAR(255) NOT NULL,
    rol ENUM('administrador', 'usuario') NOT NULL
);

-- ================================
-- TABLA peliculas
-- ================================
CREATE TABLE peliculas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    sinopsis TEXT,
    anio INT,
    genero VARCHAR(50)
);

-- ================================
-- TABLA comentarios
-- ================================
CREATE TABLE comentarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contenido TEXT NOT NULL,
    usuario_id INT,
    pelicula_id INT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (pelicula_id) REFERENCES peliculas(id) ON DELETE CASCADE
);

-- ================================
-- TABLA rating
-- ================================
CREATE TABLE rating (
    id INT AUTO_INCREMENT PRIMARY KEY,
    puntuacion INT CHECK (puntuacion BETWEEN 1 AND 10),
    usuario_id INT,
    pelicula_id INT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (pelicula_id) REFERENCES peliculas(id) ON DELETE CASCADE
);

-- ================================
-- INSERTAR USUARIOS
-- ================================
INSERT INTO usuarios (nombre, contrasenia, rol) VALUES
('admin1', '1234', 'administrador'),
('admin2', '1234', 'administrador'),

('usuario1', '1234', 'usuario'),
('usuario2', '1234', 'usuario'),
('usuario3', '1234', 'usuario'),
('usuario4', '1234', 'usuario'),
('usuario5', '1234', 'usuario'),
('usuario6', '1234', 'usuario'),
('usuario7', '1234', 'usuario'),
('usuario8', '1234', 'usuario'),
('usuario9', '1234', 'usuario'),
('usuario10', '1234', 'usuario');

-- ================================
-- INSERTAR PELICULAS DE EJEMPLO
-- ================================
INSERT INTO peliculas (titulo, sinopsis, anio, genero) VALUES
('Matrix', 'Un hacker descubre la verdad sobre su realidad.', 1999, 'Ciencia ficción'),
('Titanic', 'Historia de amor durante el hundimiento del Titanic.', 1997, 'Drama'),
('Toy Story', 'Los juguetes cobran vida cuando no los ves.', 1995, 'Animación'),
('El Señor de los Anillos', 'Un grupo intenta destruir un anillo maligno.', 2001, 'Fantasía'),
('Inception', 'Un ladrón entra en los sueños para robar ideas.', 2010, 'Ciencia ficción');

-- ================================
-- INSERTAR COMENTARIOS DE EJEMPLO
-- ================================
INSERT INTO comentarios (contenido, usuario_id, pelicula_id) VALUES
('Excelente película!', 3, 1),
('Muy profunda y emocionante.', 4, 1),
('Un clásico inolvidable.', 5, 2),
('Me hizo llorar.', 6, 2),
('Muy divertida.', 7, 3);

-- ================================
-- INSERTAR RATINGS DE EJEMPLO
-- ================================
INSERT INTO rating (puntuacion, usuario_id, pelicula_id) VALUES
(10, 3, 1),
(9, 4, 1),
(8, 5, 2),
(7, 6, 2),
(9, 7, 3),
(10, 8, 4),
(8, 9, 5);
