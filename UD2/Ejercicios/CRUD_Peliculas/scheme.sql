-- ================================
-- BD + tablas (igual que tienes)
-- ================================

DROP DATABASE IF EXISTS web_peliculas;
CREATE DATABASE web_peliculas;
USE web_peliculas;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    contrasenia VARCHAR(255) NOT NULL,
    rol ENUM('administrador', 'usuario') NOT NULL DEFAULT 'usuario'
);

CREATE TABLE peliculas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    sinopsis TEXT,
    anio INT,
    genero VARCHAR(50)
);

CREATE TABLE comentarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contenido TEXT NOT NULL,
    usuario_id INT,
    pelicula_id INT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (pelicula_id) REFERENCES peliculas(id) ON DELETE CASCADE
);

CREATE TABLE rating (
    id INT AUTO_INCREMENT PRIMARY KEY,
    puntuacion INT CHECK (puntuacion BETWEEN 1 AND 10),
    usuario_id INT,
    pelicula_id INT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (pelicula_id) REFERENCES peliculas(id) ON DELETE CASCADE,
    CONSTRAINT UNIQUE (pelicula_id, usuario_id)
);

-- ================================
-- INSERTAR USUARIOS (ampliado)
-- ================================

INSERT INTO usuarios (nombre, contrasenia, rol) VALUES
('admin1', '1234', 'administrador'),
('admin2', '1234', 'administrador'),
('moderador', '1234', 'administrador'),

('usuario1', '1234', 'usuario'),
('usuario2', '1234', 'usuario'),
('usuario3', '1234', 'usuario'),
('usuario4', '1234', 'usuario'),
('usuario5', '1234', 'usuario'),
('usuario6', '1234', 'usuario'),
('usuario7', '1234', 'usuario'),
('usuario8', '1234', 'usuario'),
('usuario9', '1234', 'usuario'),
('usuario10', '1234', 'usuario'),
('usuario11', '1234', 'usuario'),
('usuario12', '1234', 'usuario'),
('usuario13', '1234', 'usuario');

-- ================================
-- INSERTAR PELICULAS (ampliado)
-- ================================

INSERT INTO peliculas (titulo, sinopsis, anio, genero) VALUES
('Matrix', 'Un hacker descubre la verdad sobre su realidad.', 1999, 'Ciencia ficción'),
('Titanic', 'Historia de amor durante el hundimiento del Titanic.', 1997, 'Drama'),
('Toy Story', 'Los juguetes cobran vida cuando no los ves.', 1995, 'Animación'),
('El Señor de los Anillos', 'Un grupo intenta destruir un anillo maligno.', 2001, 'Fantasía'),
('Inception', 'Un ladrón entra en los sueños.', 2010, 'Ciencia ficción'),

('Gladiator', 'Un general romano traicionado busca venganza.', 2000, 'Acción'),
('Interstellar', 'Un equipo viaja a través de un agujero de gusano.', 2014, 'Ciencia ficción'),
('Avatar', 'Un soldado vive entre los Na\'vi en Pandora.', 2009, 'Ciencia ficción'),
('Pulp Fiction', 'Historias criminales entrelazadas.', 1994, 'Crimen'),
('La La Land', 'Un pianista y una actriz luchan por sus sueños.', 2016, 'Musical'),

('Shrek', 'Un ogro emprende un viaje inesperado.', 2001, 'Animación'),
('El Rey León', 'El destino del heredero al trono felino.', 1994, 'Animación'),
('Joker', 'Origen del villano más icónico de DC.', 2019, 'Drama'),
('John Wick', 'Un exasesino vuelve por venganza.', 2014, 'Acción'),
('Forrest Gump', 'La vida extraordinaria de un hombre común.', 1994, 'Drama');

-- ================================
-- INSERTAR COMENTARIOS (ampliado)
-- ================================

INSERT INTO comentarios (contenido, usuario_id, pelicula_id) VALUES
('Una obra maestra absoluta.', 8, 1),
('La volvería a ver mil veces.', 9, 1),
('No me convenció el final.', 10, 1),

('El romance está muy logrado.', 11, 2),
('Demasiado larga, pero emocionante.', 12, 2),
('La banda sonora es increíble.', 13, 2),

('Pixar no falla.', 3, 3),
('Me recordó a mi infancia.', 4, 3),
('Humor muy bien llevado.', 5, 3),

('Un viaje épico.', 6, 4),
('Debería haber ganado más premios.', 7, 4),
('Increíble ambientación.', 8, 4),

('Me explotó la cabeza.', 9, 5),
('Muy original en su concepto.', 10, 5),
('Me perdí un poco, pero genial.', 11, 5),

('La mejor película histórica.', 12, 6),
('Crowe soberbio.', 13, 6),
('La batalla inicial es brutal.', 4, 6),

('Una obra de arte moderna.', 5, 7),
('Nolan en su mejor momento.', 6, 7),
('La ciencia mezclada con emoción.', 7, 7),

('Pandora es impresionante.', 8, 8),
('Visualmente insuperable.', 9, 8),
('Historia simple pero efectiva.', 10, 8),

('Diálogos brillantes.', 11, 9),
('La estructura es increíble.', 12, 9),
('Muy Tarantino.', 13, 9),

('Fotografía preciosa.', 3, 10),
('Una experiencia emocional.', 4, 10),
('Gran química entre los protagonistas.', 5, 10),

('Shrek es mejor que muchas pelis de adultos.', 6, 11),
('El burro es lo mejor.', 7, 11),
('Muy divertida.', 8, 11),

('Icónica.', 9, 12),
('La banda sonora es top.', 10, 12),
('Simba es un rey de verdad.', 11, 12),

('Muy oscura y profunda.', 12, 13),
('Phoenix lo borda.', 13, 13),
('Una obra maestra del drama.', 4, 13),

('Perfecta si te gusta la acción.', 5, 14),
('Las coreografías son brutales.', 6, 14),
('Keanu es Dios.', 7, 14),

('Un clásico moderno.', 8, 15),
('Historia perfecta.', 9, 15),
('Me hizo reflexionar mucho.', 10, 15);


-- ================================
-- INSERTAR RATINGS (ampliado)
-- ================================

INSERT INTO rating (puntuacion, usuario_id, pelicula_id) VALUES
(10, 3, 1),
(9, 4, 1),
(8, 5, 2),
(7, 6, 2),
(9, 7, 3),

(10, 8, 6),
(9, 9, 8),
(7, 10, 7),
(9, 11, 9),
(8, 12, 10),

(10, 13, 11),
(9, 4, 12),
(10, 5, 13),
(8, 6, 14),
(10, 7, 15),

(6, 3, 6),
(5, 9, 4),
(9, 12, 5),
(7, 11, 3),
(8, 10, 1);
