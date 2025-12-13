-- Seed completo para la base de datos de autores y obras
-- Ejecutar este SQL en MySQL Workbench para tener datos de prueba completos
CREATE DATABASE crud_musica_avanzado;
USE crud_musica_avanzado;

-- Limpiar las tablas antes de insertar (en orden correcto por las foreign keys)
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE obras;
TRUNCATE TABLE autores;
SET FOREIGN_KEY_CHECKS = 1;

-- ============================================
-- AUTORES (10 autores de ejemplo)
-- ============================================
INSERT INTO autores (nombre, pais, periodo, foto_url, created_at, updated_at) VALUES
('Johann Sebastian Bach', 'Alemania', 'Barroco', 'https://upload.wikimedia.org/wikipedia/commons/6/6a/Johann_Sebastian_Bach.jpg', NOW(), NOW()),
('Wolfgang Amadeus Mozart', 'Austria', 'Clasicismo', 'https://upload.wikimedia.org/wikipedia/commons/1/1e/Wolfgang-amadeus-mozart_1.jpg', NOW(), NOW()),
('Ludwig van Beethoven', 'Alemania', 'Clasicismo', 'https://upload.wikimedia.org/wikipedia/commons/6/6f/Beethoven.jpg', NOW(), NOW()),
('Frédéric Chopin', 'Polonia', 'Romanticismo', 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e8/Frederic_Chopin_photo.jpeg/220px-Frederic_Chopin_photo.jpeg', NOW(), NOW()),
('Antonio Vivaldi', 'Italia', 'Barroco', 'https://upload.wikimedia.org/wikipedia/commons/b/bd/Vivaldi.jpg', NOW(), NOW()),
('Giuseppe Verdi', 'Italia', 'Romanticismo', 'https://m.media-amazon.com/images/M/MV5BNzBmOTg0MDAtNzBlMS00ZTZhLWI2NzctZDU3MDlkNTFhMWE0XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg', NOW(), NOW()),
('Claudio Monteverdi', 'Italia', 'Renacimiento tardío', 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/02/Bernardo_Strozzi_-_Claudio_Monteverdi_%28c.1630%29.jpg/960px-Bernardo_Strozzi_-_Claudio_Monteverdi_%28c.1630%29.jpg', NOW(), NOW()),
('George Frideric Handel', 'Alemania', 'Barroco', 'https://m.media-amazon.com/images/M/MV5BYmJlYzdlNjUtYzM4OC00YzA1LTk0NDItYjk3ODk1YWRkNTUyXkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg', NOW(), NOW()),
('Joseph Haydn', 'Austria', 'Clasicismo', 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/05/Joseph_Haydn.jpg/220px-Joseph_Haydn.jpg', NOW(), NOW()),
('Franz Schubert', 'Austria', 'Romanticismo', 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/0d/Franz_Schubert_by_Wilhelm_August_Rieder_1875.jpg/220px-Franz_Schubert_by_Wilhelm_August_Rieder_1875.jpg', NOW(), NOW());

-- ============================================
-- OBRAS (20 obras de ejemplo, vinculadas a autores)
-- ============================================
INSERT INTO obras (titulo, tipo, anio, autor_id, created_at, updated_at) VALUES
('Misa en si menor', 'Misa', 1749, 1, NOW(), NOW()),
('El clave bien temperado', 'Magnificat', 1722, 1, NOW(), NOW()),
('Réquiem', 'Requiem', 1791, 2, NOW(), NOW()),
('Sinfonía n.º 40', 'Oratorio', 1788, 2, NOW(), NOW()),
('Sinfonía n.º 5', 'Oratorio', 1808, 3, NOW(), NOW()),
('Para Elisa', NULL, 1810, 3, NOW(), NOW()),
('Nocturnos', NULL, 1830, 4, NOW(), NOW()),
('Concierto para piano n.º 1', NULL, 1831, 4, NOW(), NOW()),
('Las cuatro estaciones', NULL, 1725, 5, NOW(), NOW()),
('Gloria', 'Gloria', 1715, 5, NOW(), NOW()),
('La Traviata', 'Anthem', 1853, 6, NOW(), NOW()),
('Aida', 'Anthem', 1871, 6, NOW(), NOW()),
('L''Orfeo', 'Motete', 1607, 7, NOW(), NOW()),
('Vespro della Beata Vergine', 'Vísperas', 1610, 7, NOW(), NOW()),
('Messiah', 'Oratorio', 1741, 8, NOW(), NOW()),
('Water Music', NULL, 1717, 8, NOW(), NOW()),
('Sinfonía n.º 94 "Sorpresa"', NULL, 1791, 9, NOW(), NOW()),
('Misa en do mayor', 'Misa', 1796, 9, NOW(), NOW()),
('Ave Maria', 'Himno', 1825, 10, NOW(), NOW()),
('Sinfonía n.º 8 "Incompleta"', NULL, 1822, 10, NOW(), NOW());

-- ============================================
-- VERIFICACIÓN
-- ============================================
SELECT 'Autores creados:' as Info, COUNT(*) as Total FROM autores;
SELECT 'Obras creadas:' as Info, COUNT(*) as Total FROM obras;

-- Mostrar resumen de autores y algunas obras
SELECT id, nombre, pais, periodo FROM autores ORDER BY id;
SELECT id, titulo, tipo, anio, autor_id FROM obras ORDER BY autor_id, id;
