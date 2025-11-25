DROP SCHEMA IF EXISTS web_peliculas;
CREATE SCHEMA IF NOT EXISTS web_peliculas;
USE web_peliculas;

CREATE TABLE usuarios(
	id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    contrasenia VARCHAR(50) NOT NULL,
    rol ENUM ('administrador', 'usuario') NOT NULL DEFAULT 'usuario'
);

CREATE TABLE peliculas(
	id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	titulo VARCHAR(255) NOT NULL,
	sinopsis TEXT,
	anio INT,
	genero VARCHAR(50)
);

CREATE TABLE comentarios(
	id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	pelicula_id INT UNSIGNED NOT NULL,
	usuario_id INT UNSIGNED NOT NULL,
	contenido TEXT,

    FOREIGN KEY (pelicula_id) REFERENCES peliculas(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE rating(
	id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	pelicula_id INT UNSIGNED NOT NULL,
	usuario_id INT UNSIGNED NOT NULL,
	puntuacion TINYINT
		CONSTRAINT CHECK (puntuacion BETWEEN 1 AND 10),

    FOREIGN KEY (pelicula_id) REFERENCES peliculas(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),

    CONSTRAINT UNIQUE(pelicula_id, usuario_id)
);

INSERT INTO usuarios(nombre, contrasenia, rol) VALUES
("admin1", "1234", "administrador"),
("admin2", "1234", "administrador"),
("moderador", "1234", "administrador"),

("usuario1", "1234", "usuario"),
("usuario2", "1234", "usuario"),
("usuario3", "1234", "usuario"),
("usuario4", "1234", "usuario"),
("usuario5", "1234", "usuario"),
("usuario6", "1234", "usuario"),
("usuario7", "1234", "usuario"),
("usuario8", "1234", "usuario"),
("usuario9", "1234", "usuario"),
("usuario10", "1234", "usuario"),
("usuario11", "1234", "usuario"),
("usuario12", "1234", "usuario"),
("usuario13", "1234", "usuario");

INSERT INTO peliculas(titulo, sinopsis, anio, genero) VALUES
("Matrix", "Un hacker descubre la verdad sobre su realidad.", 1999, "Ciencia ficción"),
("Titanic", "Historia de amor durante el hundimiento del Titanic.", 1997, "Drama"),
("Toy Story", "Los juguetes cobran vida cuando no los ves.", 1995, "Animación"),
("El Señor de los Anillos", "Un grupo intenta destruir un anillo maligno.", 2001, "Fantasía"),
("Inception", "Un ladrón entra en los sueños.", 2010, "Ciencia ficción"),

("Gladiator", "Un general romano traicionado busca venganza.", 2000, "Acción"),
("Interstellar", "Un equipo viaja a través de un agujero de gusano.", 2014, "Ciencia ficción"),
("Avatar", "Un soldado vive entre los Na''vi en Pandora.", 2009, "Ciencia ficción"),
("Pulp Fiction", "Historias criminales entrelazadas.", 1994, "Crimen"),
("La La Land", "Un pianista y una actriz luchan por sus sueños.", 2016, "Musical"),

("Shrek", "Un ogro emprende un viaje inesperado.", 2001, "Animación"),
("El Rey León", "El destino del heredero al trono felino.", 1994, "Animación"),
("Joker", "Origen del villano más icónico de DC.", 2019, "Drama"),
("John Wick", "Un exasesino vuelve por venganza.", 2014, "Acción"),
("Forrest Gump", "La vida extraordinaria de un hombre común.", 1994, "Drama");

INSERT INTO rating(usuario_id, pelicula_id, puntuacion) VALUES
(1, 1, 3),
(2, 1, 8),
(3, 1, 9),
(1, 2, 8),
(2, 2, 8),
(3, 2, 7),
(4, 2, 6),

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

(10, 13, 10),
(9, 14, 10),
(10, 15, 9),
(8, 6, 8),
(10, 7, 7);

INSERT INTO comentarios(usuario_id, pelicula_id, contenido) VALUES
(1, 1, "UNA OBRA MAESTRA"),
(2, 1, "LA VOLVERÍA A VER MIL VECES"),
(3, 1, "NO ME CONVENCIÓ EL FINAL"),
(3, 1, "GRAN PELÍCULA"),
(1, 2, "EL ROMANCE ESTÁ MUY LOGRADO"),

(8, 1, "Una obra maestra absoluta."),
(9, 1, "La volvería a ver mil veces."),
(10, 1, "No me convenció el final."),

(11, 2, "El romance está muy logrado."),
(12, 2, "Demasiado larga, pero emocionante."),
(13, 2, "La banda sonora es increíble."),

(4, 3, "Pixar no falla."),
(5, 3, "Me recordó a mi infancia."),
(6, 3, "Humor muy bien llevado."),

(7, 4, "Un viaje épico."),
(8, 4, "Debería haber ganado más premios."),
(9, 4, "Increíble ambientación."),

(10, 5, "Me explotó la cabeza."),
(11, 5, "Muy original en su concepto."),
(12, 5, "Me perdí un poco, pero genial."),

(13, 6, "La mejor película histórica."),
(4, 6, "Crowe soberbio."),
(5, 6, "La batalla inicial es brutal."),

(6, 7, "Una obra de arte moderna."),
(7, 7, "Nolan en su mejor momento."),
(8, 7, "La ciencia mezclada con emoción."),

(9, 8, "Pandora es impresionante."),
(10, 8, "Visualmente insuperable."),
(11, 8, "Historia simple pero efectiva."),

(12, 9, "Diálogos brillantes."),
(13, 9, "La estructura es increíble."),
(4, 9, "Muy Tarantino."),

(5, 10, "Fotografía preciosa."),
(6, 10, "Una experiencia emocional."),
(7, 10, "Gran química entre los protagonistas."),

(8, 11, "Shrek es mejor que muchas pelis de adultos."),
(9, 11, "El burro es lo mejor."),
(10, 11, "Muy divertida."),

(11, 12, "Icónica."),
(12, 12, "La banda sonora es top."),
(13, 12, "Simba es un rey de verdad."),

(4, 13, "Muy oscura y profunda."),
(5, 13, "Phoenix lo borda."),
(6, 13, "Una obra maestra del drama."),

(7, 14, "Perfecta si te gusta la acción."),
(8, 14, "Las coreografías son brutales."),
(9, 14, "Keanu es Dios."),

(10, 15, "Un clásico moderno."),
(11, 15, "Historia perfecta."),
(12, 15, "Me hizo reflexionar mucho.");
