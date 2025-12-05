-- Seed completo para la base de datos
-- Ejecutar este SQL en MySQL Workbench para tener datos de prueba completos

USE mi_crud_peliculas;

-- Limpiar las tablas antes de insertar (en orden correcto por las foreign keys)
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE comentarios;
TRUNCATE TABLE peliculas;
TRUNCATE TABLE users;
SET FOREIGN_KEY_CHECKS = 1;

-- ============================================
-- USUARIOS (2 admins + 8 usuarios normales)
-- ============================================
-- Password para todos: 12345678
-- Hash bcrypt de "12345678": $2y$12$.zbRm1JcsQymXdwV4tYJKOJPDDntrfX.wY2xGmyjC7u9WvdkaH4dK

INSERT INTO users (name, email, password, role, created_at, updated_at) VALUES
('Admin1', 'admin1@test.com', '$2y$12$.zbRm1JcsQymXdwV4tYJKOJPDDntrfX.wY2xGmyjC7u9WvdkaH4dK', 'admin', NOW(), NOW()),
('Admin2', 'admin2@test.com', '$2y$12$.zbRm1JcsQymXdwV4tYJKOJPDDntrfX.wY2xGmyjC7u9WvdkaH4dK', 'admin', NOW(), NOW()),
('User1', 'user1@test.com', '$2y$12$.zbRm1JcsQymXdwV4tYJKOJPDDntrfX.wY2xGmyjC7u9WvdkaH4dK', 'user', NOW(), NOW()),
('User2', 'user2@test.com', '$2y$12$.zbRm1JcsQymXdwV4tYJKOJPDDntrfX.wY2xGmyjC7u9WvdkaH4dK', 'user', NOW(), NOW()),
('User3', 'user3@test.com', '$2y$12$.zbRm1JcsQymXdwV4tYJKOJPDDntrfX.wY2xGmyjC7u9WvdkaH4dK', 'user', NOW(), NOW()),
('User4', 'user4@test.com', '$2y$12$.zbRm1JcsQymXdwV4tYJKOJPDDntrfX.wY2xGmyjC7u9WvdkaH4dK', 'user', NOW(), NOW()),
('User5', 'user5@test.com', '$2y$12$.zbRm1JcsQymXdwV4tYJKOJPDDntrfX.wY2xGmyjC7u9WvdkaH4dK', 'user', NOW(), NOW()),
('User6', 'user6@test.com', '$2y$12$.zbRm1JcsQymXdwV4tYJKOJPDDntrfX.wY2xGmyjC7u9WvdkaH4dK', 'user', NOW(), NOW()),
('User7', 'user7@test.com', '$2y$12$.zbRm1JcsQymXdwV4tYJKOJPDDntrfX.wY2xGmyjC7u9WvdkaH4dK', 'user', NOW(), NOW()),
('User8', 'user8@test.com', '$2y$12$.zbRm1JcsQymXdwV4tYJKOJPDDntrfX.wY2xGmyjC7u9WvdkaH4dK', 'user', NOW(), NOW());

-- ============================================
-- PELÍCULAS (20 películas frikis/sci-fi/acción)
-- ============================================
INSERT INTO peliculas (poster_url, title, release_year, genres, synopsis, created_at, updated_at) VALUES
('https://image.tmdb.org/t/p/w500/f89U3ADr1oiB1s9GkdPOEpXUk5H.jpg', 'The Matrix', 1999, '["Action", "Sci-Fi"]', 'Un hacker descubre la verdadera naturaleza de su realidad y su papel en la guerra contra sus controladores.', NOW(), NOW()),

('https://image.tmdb.org/t/p/w500/gajva2L0rPYkEWjzgFlBXCAVBE5.jpg', 'Blade Runner 2049', 2017, '["Sci-Fi", "Drama"]', 'Un nuevo blade runner descubre un secreto enterrado que podría sumir lo que queda de la sociedad en el caos.', NOW(), NOW()),

('https://image.tmdb.org/t/p/w500/ljsZTbVsrQSqZgWeep2B1QiDKuh.jpg', 'Inception', 2010, '["Action", "Sci-Fi"]', 'Un ladrón que roba secretos mediante sueños recibe la tarea inversa de plantar una idea en la mente de alguien.', NOW(), NOW()),

('https://image.tmdb.org/t/p/w500/gEU2QniE6E77NI6lCU6MxlNBvIx.jpg', 'Interstellar', 2014, '["Sci-Fi", "Drama"]', 'Exploradores viajan a través de un agujero de gusano espacial para garantizar la supervivencia de la humanidad.', NOW(), NOW()),

('https://image.tmdb.org/t/p/w500/d5NXSklXo0qyIYkgV94XAgMIckC.jpg', 'Dune', 2021, '["Sci-Fi", "Action"]', 'El hijo de una familia noble trata de vengarse de la muerte de su padre mientras salva un planeta rico en especias.', NOW(), NOW()),

('https://image.tmdb.org/t/p/w500/fZPSd91yGE9fCcCe6OoQr6E3Bev.jpg', 'John Wick', 2014, '["Action"]', 'Un ex asesino a sueldo sale de su retiro para rastrear a los gánsteres que mataron a su perro y le robaron todo.', NOW(), NOW()),

('https://image.tmdb.org/t/p/w500/hXWBc0ioZP3cN4zCu6SN3YHXZVO.jpg', 'John Wick: Chapter 2', 2017, '["Action"]', 'John Wick es obligado a salir del retiro por un ex asociado que planea tomar el control de una oscura organización internacional.', NOW(), NOW()),

('https://image.tmdb.org/t/p/w500/8tZYtuWezp8JbcsvHYO0O46tFbo.jpg', 'Mad Max: Fury Road', 2015, '["Action", "Sci-Fi"]', 'En un futuro post-apocalíptico, Max ayuda a una mujer rebelde y a un grupo de prisioneras a escapar de un tirano.', NOW(), NOW()),

('https://image.tmdb.org/t/p/w500/7WsyChQLEftFiDOVTGkv3hFpyyt.jpg', 'Avengers: Infinity War', 2018, '["Action", "Sci-Fi"]', 'Los Avengers deben detener a Thanos antes de que su reinado de devastación ponga fin al universo.', NOW(), NOW()),

('https://image.tmdb.org/t/p/w500/or06FN3Dka5tukK1e9sl16pB3iy.jpg', 'Avengers: Endgame', 2019, '["Action", "Sci-Fi"]', 'Tras los eventos devastadores, los Avengers se reúnen una vez más para deshacer las acciones de Thanos.', NOW(), NOW()),

('https://image.tmdb.org/t/p/w500/2l05cFWJacyIsTpsqSgH0wQXe4V.jpg', 'Star Wars: The Empire Strikes Back', 1980, '["Action", "Sci-Fi", "Fantasy"]', 'Después de la destrucción de la Estrella de la Muerte, los rebeldes huyen del Imperio.', NOW(), NOW()),

('https://image.tmdb.org/t/p/w500/wqnLdwVXoBjKibFRR5U3y0aDUhs.jpg', 'Star Wars: The Force Awakens', 2015, '["Action", "Sci-Fi", "Fantasy"]', 'Tres décadas después de la derrota del Imperio, surge una nueva amenaza: la Primera Orden.', NOW(), NOW()),

('https://image.tmdb.org/t/p/w500/udDclJoHjfjb8Ekgsd4FDteOkCU.jpg', 'Joker', 2019, '["Drama"]', 'Un comediante fracasado comienza su descenso a la locura mientras inspira un movimiento anárquico en Gotham.', NOW(), NOW()),

('https://image.tmdb.org/t/p/w500/qJ2tW6WMUDux911r6m7haRef0WH.jpg', 'The Dark Knight', 2008, '["Action", "Drama"]', 'Batman enfrenta al Joker, un criminal que quiere sumir Gotham en la anarquía.', NOW(), NOW()),

('https://image.tmdb.org/t/p/w500/6oom5QYQ2yQTMJIbnvbkBL9cHo6.jpg', 'The Lord of the Rings: The Fellowship of the Ring', 2001, '["Action", "Fantasy"]', 'Un hobbit recibe un anillo poderoso que debe ser destruido antes de que caiga en manos del mal.', NOW(), NOW()),

('https://image.tmdb.org/t/p/w500/rCzpDGLbOoPwLjy3OAm5NUPOTrC.jpg', 'The Lord of the Rings: The Return of the King', 2003, '["Action", "Fantasy"]', 'Gandalf y Aragorn lideran a los hombres contra el ejército de Sauron para dar tiempo a Frodo.', NOW(), NOW()),

('https://image.tmdb.org/t/p/w500/fNOH9f1aA7XRTzl1sAOx9iF553Q.jpg', 'Back to the Future', 1985, '["Sci-Fi", "Comedy"]', 'Un adolescente viaja accidentalmente 30 años al pasado en un DeLorean y debe arreglar el futuro.', NOW(), NOW()),

('https://image.tmdb.org/t/p/w500/qvktm0BHcnmDpul4Hz01GIazWPr.jpg', 'The Terminator', 1984, '["Action", "Sci-Fi"]', 'Un cyborg asesino es enviado desde el futuro para matar a la madre del futuro líder de la resistencia.', NOW(), NOW()),

('https://image.tmdb.org/t/p/w500/5M0j0B18abtBI5gi2RhfjjurTqb.jpg', 'Terminator 2: Judgment Day', 1991, '["Action", "Sci-Fi"]', 'Un cyborg protector es enviado para proteger al futuro líder de la resistencia de un terminator más avanzado.', NOW(), NOW()),

('https://image.tmdb.org/t/p/w500/9TGHDvWrqKBzwDxDodHYXEmOE6J.jpg', 'The Matrix Reloaded', 2003, '["Action", "Sci-Fi"]', 'Neo y los rebeldes luchan contra las máquinas mientras buscan al Creador de Llaves.', NOW(), NOW());

-- ============================================
-- COMENTARIOS (30 comentarios variados)
-- ============================================
INSERT INTO comentarios (pelicula_id, user_id, content, created_at, updated_at) VALUES
-- Comentarios para The Shawshank Redemption (id: 1)
(1, 3, '¡Obra maestra absoluta! La mejor película que he visto en mi vida.', NOW(), NOW()),
(1, 5, 'Morgan Freeman es increíble en este papel. Una historia conmovedora.', NOW(), NOW()),
(1, 7, 'La escena final me hizo llorar. 10/10', NOW(), NOW()),

-- Comentarios para The Godfather (id: 2)
(2, 4, 'Un clásico del cine. Marlon Brando en su mejor momento.', NOW(), NOW()),
(2, 6, 'La trilogía completa es espectacular, pero esta primera parte es perfecta.', NOW(), NOW()),

-- Comentarios para The Dark Knight (id: 3)
(3, 3, 'Heath Ledger como el Joker es inolvidable. Descanse en paz.', NOW(), NOW()),
(3, 8, 'La mejor película de superhéroes jamás hecha.', NOW(), NOW()),
(3, 10, 'Christopher Nolan es un genio. Cada escena está perfectamente ejecutada.', NOW(), NOW()),

-- Comentarios para Pulp Fiction (id: 4)
(4, 5, 'Tarantino revolucionó el cine con esta película. Narrativa no lineal magistral.', NOW(), NOW()),
(4, 9, 'Los diálogos son oro puro. Me la he visto 5 veces y siempre descubro algo nuevo.', NOW(), NOW()),

-- Comentarios para Forrest Gump (id: 5)
(5, 4, 'Tom Hanks debería haber ganado todos los premios por este papel.', NOW(), NOW()),
(5, 7, 'Una película que te hace reír y llorar en partes iguales.', NOW(), NOW()),
(5, 6, 'La banda sonora es increíble. "Run Forrest, run!"', NOW(), NOW()),

-- Comentarios para Inception (id: 6)
(6, 3, 'Cada vez que la veo entiendo algo nuevo. Una joya del cine.', NOW(), NOW()),
(6, 8, 'El final me dejó pensando durante días. ¿Sueño o realidad?', NOW(), NOW()),
(6, 10, 'La escena del hotel giratorio es espectacular. Efectos prácticos increíbles.', NOW(), NOW()),

-- Comentarios para The Matrix (id: 7)
(7, 5, 'Revolucionó los efectos especiales. El bullet time es icónico.', NOW(), NOW()),
(7, 9, 'La premisa filosófica es fascinante. ¿Vivimos en una simulación?', NOW(), NOW()),

-- Comentarios para Interstellar (id: 8)
(8, 4, 'La ciencia detrás de la película es impresionante. Lloré con la escena de los mensajes.', NOW(), NOW()),
(8, 6, 'Hans Zimmer creó una de las mejores bandas sonoras de todos los tiempos.', NOW(), NOW()),
(8, 7, 'TARS es el mejor personaje robótico del cine.', NOW(), NOW()),

-- Comentarios para LOTR (id: 9)
(9, 3, 'Peter Jackson creó la mejor adaptación literaria de la historia.', NOW(), NOW()),
(9, 10, 'Las tres horas se pasan volando. Una experiencia épica.', NOW(), NOW()),

-- Comentarios para Fight Club (id: 10)
(10, 5, 'El twist final es uno de los mejores del cine. No lo vi venir.', NOW(), NOW()),
(10, 8, 'Una crítica brutal al consumismo moderno. Muy adelantada a su época.', NOW(), NOW()),

-- Comentarios para Goodfellas (id: 11)
(11, 4, 'Scorsese en su mejor momento. Joe Pesci está brutal.', NOW(), NOW()),
(11, 9, 'La escena del restaurante con la cámara es perfecta.', NOW(), NOW()),

-- Comentarios para The Silence of the Lambs (id: 12)
(12, 6, 'Anthony Hopkins da miedo incluso detrás de un cristal.', NOW(), NOW()),

-- Comentarios para Gladiator (id: 14)
(14, 7, '"Are you not entertained?" - Obra maestra del cine épico.', NOW(), NOW()),

-- Comentarios para The Prestige (id: 16)
(16, 10, 'Nolan de nuevo demostrando su maestría narrativa.', NOW(), NOW());

-- ============================================
-- VERIFICACIÓN
-- ============================================
SELECT 'Usuarios creados:' as Info, COUNT(*) as Total FROM users;
SELECT 'Películas creadas:' as Info, COUNT(*) as Total FROM peliculas;
SELECT 'Comentarios creados:' as Info, COUNT(*) as Total FROM comentarios;

-- Mostrar resumen de usuarios
SELECT id, name, email, role FROM users ORDER BY role DESC, id;
