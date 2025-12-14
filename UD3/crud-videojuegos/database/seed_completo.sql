-- ============================================
-- SEED COMPLETO - CRUD VIDEOJUEGOS
-- Base de datos: crud_videojuegos
-- ============================================

-- Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS crud_videojuegos;

-- Usar la base de datos
USE crud_videojuegos;

-- Eliminar tablas si existen (en orden correcto para evitar errores de FK)
DROP TABLE IF EXISTS juegos;
DROP TABLE IF EXISTS companias;

-- ============================================
-- TABLA: companias
-- ============================================
CREATE TABLE companias (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    pais VARCHAR(255) NOT NULL,
    tipo ENUM('Indie', 'Pequeña', 'Mediana', 'Grande') NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLA: juegos
-- ============================================
CREATE TABLE juegos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    anio INT NOT NULL,
    genero ENUM('Acción', 'Aventura', 'RPG', 'Estrategia', 'Sandbox', 'Música', 'Pary', 'Arcade') NOT NULL,
    cover_url VARCHAR(255) NOT NULL,
    compania_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT fk_juegos_compania
        FOREIGN KEY (compania_id)
        REFERENCES companias(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- DATOS DE PRUEBA: companias
-- ============================================
INSERT INTO companias (id, nombre, pais, tipo, created_at, updated_at) VALUES
(1, 'Nintendo', 'Japón', 'Grande', NOW(), NOW()),
(2, 'Sony Interactive Entertainment', 'Japón', 'Grande', NOW(), NOW()),
(3, 'Microsoft Game Studios', 'Estados Unidos', 'Grande', NOW(), NOW()),
(4, 'CD Projekt', 'Polonia', 'Mediana', NOW(), NOW()),
(5, 'Ubisoft', 'Francia', 'Grande', NOW(), NOW()),
(6, 'Rockstar Games', 'Estados Unidos', 'Grande', NOW(), NOW()),
(7, 'FromSoftware', 'Japón', 'Mediana', NOW(), NOW()),
(8, 'Supergiant Games', 'Estados Unidos', 'Indie', NOW(), NOW()),
(9, 'Team Cherry', 'Australia', 'Indie', NOW(), NOW()),
(10, 'ConcernedApe', 'Estados Unidos', 'Indie', NOW(), NOW()),
(11, 'Mojang Studios', 'Suecia', 'Mediana', NOW(), NOW()),
(12, 'Epic Games', 'Estados Unidos', 'Grande', NOW(), NOW()),
(13, 'Valve Corporation', 'Estados Unidos', 'Grande', NOW(), NOW()),
(14, 'Square Enix', 'Japón', 'Grande', NOW(), NOW()),
(15, 'Capcom', 'Japón', 'Grande', NOW(), NOW()),
(16, 'Riot Games', 'Estados Unidos', 'Grande', NOW(), NOW()),
(17, 'Blizzard Entertainment', 'Estados Unidos', 'Grande', NOW(), NOW()),
(18, 'Devolver Digital', 'Estados Unidos', 'Pequeña', NOW(), NOW()),
(19, 'Annapurna Interactive', 'Estados Unidos', 'Pequeña', NOW(), NOW()),
(20, 'Re-Logic', 'Estados Unidos', 'Indie', NOW(), NOW());

-- ============================================
-- DATOS DE PRUEBA: juegos
-- ============================================
INSERT INTO juegos (id, titulo, anio, genero, cover_url, compania_id, created_at, updated_at) VALUES
-- Nintendo
(1, 'The Legend of Zelda: Breath of the Wild', 2017, 'Aventura', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co3p2d.jpg', 1, NOW(), NOW()),
(2, 'Super Mario Odyssey', 2017, 'Aventura', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co3p3t.jpg', 1, NOW(), NOW()),
(3, 'Animal Crossing: New Horizons', 2020, 'Sandbox', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1rdu.jpg', 1, NOW(), NOW()),
(4, 'Splatoon 3', 2022, 'Acción', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co4pd1.jpg', 1, NOW(), NOW()),

-- Sony
(5, 'God of War', 2018, 'Acción', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1tmu.jpg', 2, NOW(), NOW()),
(6, 'The Last of Us Part II', 2020, 'Aventura', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co2z1x.jpg', 2, NOW(), NOW()),
(7, 'Spider-Man', 2018, 'Acción', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1wyy.jpg', 2, NOW(), NOW()),

-- Microsoft
(8, 'Halo Infinite', 2021, 'Acción', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co2fxp.jpg', 3, NOW(), NOW()),
(9, 'Forza Horizon 5', 2021, 'Arcade', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co2nzu.jpg', 3, NOW(), NOW()),

-- CD Projekt
(10, 'The Witcher 3: Wild Hunt', 2015, 'RPG', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1wyy.jpg', 4, NOW(), NOW()),
(11, 'Cyberpunk 2077', 2020, 'RPG', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co2nzu.jpg', 4, NOW(), NOW()),

-- Ubisoft
(12, 'Assassins Creed Valhalla', 2020, 'Aventura', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1wyy.jpg', 5, NOW(), NOW()),
(13, 'Far Cry 6', 2021, 'Acción', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co2nzu.jpg', 5, NOW(), NOW()),

-- Rockstar
(14, 'Grand Theft Auto V', 2013, 'Acción', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co2lbd.jpg', 6, NOW(), NOW()),
(15, 'Red Dead Redemption 2', 2018, 'Aventura', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1q1f.jpg', 6, NOW(), NOW()),

-- FromSoftware
(16, 'Elden Ring', 2022, 'RPG', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co4jni.jpg', 7, NOW(), NOW()),
(17, 'Dark Souls III', 2016, 'RPG', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1wyy.jpg', 7, NOW(), NOW()),
(18, 'Sekiro: Shadows Die Twice', 2019, 'Acción', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1irx.jpg', 7, NOW(), NOW()),

-- Supergiant Games
(19, 'Hades', 2020, 'RPG', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co2d1y.jpg', 8, NOW(), NOW()),
(20, 'Bastion', 2011, 'Aventura', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co2gkv.jpg', 8, NOW(), NOW()),

-- Team Cherry
(21, 'Hollow Knight', 2017, 'Aventura', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1rgi.jpg', 9, NOW(), NOW()),

-- ConcernedApe
(22, 'Stardew Valley', 2016, 'Sandbox', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1x7m.jpg', 10, NOW(), NOW()),

-- Mojang
(23, 'Minecraft', 2011, 'Sandbox', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co3qxj.jpg', 11, NOW(), NOW()),

-- Epic Games
(24, 'Fortnite', 2017, 'Acción', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co2ekt.jpg', 12, NOW(), NOW()),

-- Valve
(25, 'Half-Life: Alyx', 2020, 'Acción', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1vmg.jpg', 13, NOW(), NOW()),
(26, 'Portal 2', 2011, 'Estrategia', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1rs5.jpg', 13, NOW(), NOW()),

-- Square Enix
(27, 'Final Fantasy VII Remake', 2020, 'RPG', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1wzo.jpg', 14, NOW(), NOW()),
(28, 'Kingdom Hearts III', 2019, 'RPG', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1p7w.jpg', 14, NOW(), NOW()),

-- Capcom
(29, 'Resident Evil Village', 2021, 'Acción', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co2o8n.jpg', 15, NOW(), NOW()),
(30, 'Monster Hunter Rise', 2021, 'RPG', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co2mwk.jpg', 15, NOW(), NOW()),

-- Riot Games
(31, 'League of Legends', 2009, 'Estrategia', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co49wj.jpg', 16, NOW(), NOW()),
(32, 'Valorant', 2020, 'Acción', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co2mvt.jpg', 16, NOW(), NOW()),

-- Blizzard
(33, 'Overwatch 2', 2022, 'Acción', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co5s2x.jpg', 17, NOW(), NOW()),
(34, 'Diablo IV', 2023, 'RPG', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co5q4l.jpg', 17, NOW(), NOW()),

-- Devolver Digital
(35, 'Hotline Miami', 2012, 'Acción', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co24xf.jpg', 18, NOW(), NOW()),

-- Annapurna Interactive
(36, 'Stray', 2022, 'Aventura', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co4lda.jpg', 19, NOW(), NOW()),

-- Re-Logic
(37, 'Terraria', 2011, 'Sandbox', 'https://images.igdb.com/igdb/image/upload/t_cover_big/co3p2s.jpg', 20, NOW(), NOW());

-- ============================================
-- VERIFICACIÓN DE DATOS
-- ============================================
SELECT 'Companias insertadas:' AS Verificacion, COUNT(*) AS Total FROM companias;
SELECT 'Juegos insertados:' AS Verificacion, COUNT(*) AS Total FROM juegos;

-- ============================================
-- CONSULTAS DE PRUEBA
-- ============================================
-- Listar todas las compañías
SELECT * FROM companias ORDER BY nombre;

-- Listar todos los juegos con su compañía
SELECT
    j.id,
    j.titulo,
    j.anio,
    j.genero,
    c.nombre AS compania,
    c.pais,
    c.tipo AS tipo_compania
FROM juegos j
INNER JOIN companias c ON j.compania_id = c.id
ORDER BY j.anio DESC;

-- Juegos por género
SELECT genero, COUNT(*) AS cantidad
FROM juegos
GROUP BY genero
ORDER BY cantidad DESC;

-- Compañías por tipo
SELECT tipo, COUNT(*) AS cantidad
FROM companias
GROUP BY tipo
ORDER BY cantidad DESC;

-- Compañías con más juegos
SELECT
    c.nombre,
    c.tipo,
    COUNT(j.id) AS total_juegos
FROM companias c
LEFT JOIN juegos j ON c.id = j.compania_id
GROUP BY c.id, c.nombre, c.tipo
ORDER BY total_juegos DESC;
