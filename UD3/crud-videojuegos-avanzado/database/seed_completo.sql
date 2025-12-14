-- ============================================
-- SEED COMPLETO - CRUD VIDEOJUEGOS AVANZADO
-- Base de datos: crud_videojuegos_avanzado
-- Con tabla intermedia genero_juego
-- ============================================

-- Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS crud_videojuego_avanzado;

-- Usar la base de datos
USE crud_videojuego_avanzado;

-- Eliminar tablas si existen (en orden correcto para evitar errores de FK)
DROP TABLE IF EXISTS genero_juego;
DROP TABLE IF EXISTS juegos;
DROP TABLE IF EXISTS generos;
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
-- TABLA: generos
-- ============================================
CREATE TABLE generos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL UNIQUE,
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
-- TABLA INTERMEDIA: genero_juego
-- ============================================
CREATE TABLE genero_juego (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    genero_id BIGINT UNSIGNED NOT NULL,
    juego_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT fk_genero_juego_genero
        FOREIGN KEY (genero_id)
        REFERENCES generos(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_genero_juego_juego
        FOREIGN KEY (juego_id)
        REFERENCES juegos(id)
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
-- DATOS DE PRUEBA: generos
-- ============================================
INSERT INTO generos (id, nombre, created_at, updated_at) VALUES
(1, 'Acción', NOW(), NOW()),
(2, 'Aventura', NOW(), NOW()),
(3, 'RPG', NOW(), NOW()),
(4, 'Estrategia', NOW(), NOW()),
(5, 'Sandbox', NOW(), NOW()),
(6, 'Música', NOW(), NOW()),
(7, 'Party', NOW(), NOW()),
(8, 'Arcade', NOW(), NOW());

-- ============================================
-- DATOS DE PRUEBA: juegos
-- ============================================
INSERT INTO juegos (id, titulo, anio, cover_url, compania_id, created_at, updated_at) VALUES
-- Nintendo
(1, 'The Legend of Zelda: Breath of the Wild', 2017, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co3p2d.jpg', 1, NOW(), NOW()),
(2, 'Super Mario Odyssey', 2017, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co3p3t.jpg', 1, NOW(), NOW()),
(3, 'Animal Crossing: New Horizons', 2020, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1rdu.jpg', 1, NOW(), NOW()),
(4, 'Splatoon 3', 2022, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co4pd1.jpg', 1, NOW(), NOW()),

-- Sony
(5, 'God of War', 2018, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1tmu.jpg', 2, NOW(), NOW()),
(6, 'The Last of Us Part II', 2020, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co2z1x.jpg', 2, NOW(), NOW()),
(7, 'Spider-Man', 2018, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1wyy.jpg', 2, NOW(), NOW()),

-- Microsoft
(8, 'Halo Infinite', 2021, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co2fxp.jpg', 3, NOW(), NOW()),
(9, 'Forza Horizon 5', 2021, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co2nzu.jpg', 3, NOW(), NOW()),

-- CD Projekt
(10, 'The Witcher 3: Wild Hunt', 2015, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1wyy.jpg', 4, NOW(), NOW()),
(11, 'Cyberpunk 2077', 2020, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co2nzu.jpg', 4, NOW(), NOW()),

-- Ubisoft
(12, 'Assassins Creed Valhalla', 2020, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1wyy.jpg', 5, NOW(), NOW()),
(13, 'Far Cry 6', 2021, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co2nzu.jpg', 5, NOW(), NOW()),

-- Rockstar
(14, 'Grand Theft Auto V', 2013, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co2lbd.jpg', 6, NOW(), NOW()),
(15, 'Red Dead Redemption 2', 2018, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1q1f.jpg', 6, NOW(), NOW()),

-- FromSoftware
(16, 'Elden Ring', 2022, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co4jni.jpg', 7, NOW(), NOW()),
(17, 'Dark Souls III', 2016, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1wyy.jpg', 7, NOW(), NOW()),
(18, 'Sekiro: Shadows Die Twice', 2019, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1irx.jpg', 7, NOW(), NOW()),

-- Supergiant Games
(19, 'Hades', 2020, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co2d1y.jpg', 8, NOW(), NOW()),
(20, 'Bastion', 2011, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co2gkv.jpg', 8, NOW(), NOW()),

-- Team Cherry
(21, 'Hollow Knight', 2017, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1rgi.jpg', 9, NOW(), NOW()),

-- ConcernedApe
(22, 'Stardew Valley', 2016, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1x7m.jpg', 10, NOW(), NOW()),

-- Mojang
(23, 'Minecraft', 2011, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co3qxj.jpg', 11, NOW(), NOW()),

-- Epic Games
(24, 'Fortnite', 2017, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co2ekt.jpg', 12, NOW(), NOW()),

-- Valve
(25, 'Half-Life: Alyx', 2020, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1vmg.jpg', 13, NOW(), NOW()),
(26, 'Portal 2', 2011, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1rs5.jpg', 13, NOW(), NOW()),

-- Square Enix
(27, 'Final Fantasy VII Remake', 2020, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1wzo.jpg', 14, NOW(), NOW()),
(28, 'Kingdom Hearts III', 2019, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1p7w.jpg', 14, NOW(), NOW()),

-- Capcom
(29, 'Resident Evil Village', 2021, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co2o8n.jpg', 15, NOW(), NOW()),
(30, 'Monster Hunter Rise', 2021, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co2mwk.jpg', 15, NOW(), NOW()),

-- Riot Games
(31, 'League of Legends', 2009, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co49wj.jpg', 16, NOW(), NOW()),
(32, 'Valorant', 2020, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co2mvt.jpg', 16, NOW(), NOW()),

-- Blizzard
(33, 'Overwatch 2', 2022, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co5s2x.jpg', 17, NOW(), NOW()),
(34, 'Diablo IV', 2023, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co5q4l.jpg', 17, NOW(), NOW()),

-- Devolver Digital
(35, 'Hotline Miami', 2012, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co24xf.jpg', 18, NOW(), NOW()),

-- Annapurna Interactive
(36, 'Stray', 2022, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co4lda.jpg', 19, NOW(), NOW()),

-- Re-Logic
(37, 'Terraria', 2011, 'https://images.igdb.com/igdb/image/upload/t_cover_big/co3p2s.jpg', 20, NOW(), NOW());

-- ============================================
-- DATOS DE PRUEBA: genero_juego (tabla intermedia)
-- Aquí asignamos múltiples géneros a cada juego
-- ============================================
INSERT INTO genero_juego (genero_id, juego_id, created_at, updated_at) VALUES
-- Zelda BOTW: Aventura + Acción
(2, 1, NOW(), NOW()),
(1, 1, NOW(), NOW()),

-- Super Mario Odyssey: Aventura
(2, 2, NOW(), NOW()),

-- Animal Crossing: Sandbox
(5, 3, NOW(), NOW()),

-- Splatoon 3: Acción
(1, 4, NOW(), NOW()),

-- God of War: Acción + Aventura
(1, 5, NOW(), NOW()),
(2, 5, NOW(), NOW()),

-- The Last of Us Part II: Aventura + Acción
(2, 6, NOW(), NOW()),
(1, 6, NOW(), NOW()),

-- Spider-Man: Acción + Aventura
(1, 7, NOW(), NOW()),
(2, 7, NOW(), NOW()),

-- Halo Infinite: Acción
(1, 8, NOW(), NOW()),

-- Forza Horizon 5: Arcade
(8, 9, NOW(), NOW()),

-- The Witcher 3: RPG + Aventura
(3, 10, NOW(), NOW()),
(2, 10, NOW(), NOW()),

-- Cyberpunk 2077: RPG + Acción
(3, 11, NOW(), NOW()),
(1, 11, NOW(), NOW()),

-- Assassins Creed Valhalla: Aventura + RPG + Acción
(2, 12, NOW(), NOW()),
(3, 12, NOW(), NOW()),
(1, 12, NOW(), NOW()),

-- Far Cry 6: Acción + Aventura
(1, 13, NOW(), NOW()),
(2, 13, NOW(), NOW()),

-- GTA V: Acción + Aventura
(1, 14, NOW(), NOW()),
(2, 14, NOW(), NOW()),

-- Red Dead Redemption 2: Aventura + Acción
(2, 15, NOW(), NOW()),
(1, 15, NOW(), NOW()),

-- Elden Ring: RPG + Acción + Aventura
(3, 16, NOW(), NOW()),
(1, 16, NOW(), NOW()),
(2, 16, NOW(), NOW()),

-- Dark Souls III: RPG + Acción
(3, 17, NOW(), NOW()),
(1, 17, NOW(), NOW()),

-- Sekiro: Acción + Aventura
(1, 18, NOW(), NOW()),
(2, 18, NOW(), NOW()),

-- Hades: RPG + Acción
(3, 19, NOW(), NOW()),
(1, 19, NOW(), NOW()),

-- Bastion: Aventura + Acción
(2, 20, NOW(), NOW()),
(1, 20, NOW(), NOW()),

-- Hollow Knight: Aventura
(2, 21, NOW(), NOW()),

-- Stardew Valley: Sandbox + RPG
(5, 22, NOW(), NOW()),
(3, 22, NOW(), NOW()),

-- Minecraft: Sandbox + Aventura
(5, 23, NOW(), NOW()),
(2, 23, NOW(), NOW()),

-- Fortnite: Acción
(1, 24, NOW(), NOW()),

-- Half-Life Alyx: Acción
(1, 25, NOW(), NOW()),

-- Portal 2: Estrategia + Aventura
(4, 26, NOW(), NOW()),
(2, 26, NOW(), NOW()),

-- Final Fantasy VII Remake: RPG + Acción
(3, 27, NOW(), NOW()),
(1, 27, NOW(), NOW()),

-- Kingdom Hearts III: RPG + Acción
(3, 28, NOW(), NOW()),
(1, 28, NOW(), NOW()),

-- Resident Evil Village: Acción + Aventura
(1, 29, NOW(), NOW()),
(2, 29, NOW(), NOW()),

-- Monster Hunter Rise: RPG + Acción
(3, 30, NOW(), NOW()),
(1, 30, NOW(), NOW()),

-- League of Legends: Estrategia
(4, 31, NOW(), NOW()),

-- Valorant: Acción
(1, 32, NOW(), NOW()),

-- Overwatch 2: Acción
(1, 33, NOW(), NOW()),

-- Diablo IV: RPG + Acción
(3, 34, NOW(), NOW()),
(1, 34, NOW(), NOW()),

-- Hotline Miami: Acción
(1, 35, NOW(), NOW()),

-- Stray: Aventura
(2, 36, NOW(), NOW()),

-- Terraria: Sandbox + Aventura
(5, 37, NOW(), NOW()),
(2, 37, NOW(), NOW());

-- ============================================
-- VERIFICACIÓN DE DATOS
-- ============================================
SELECT 'Companias insertadas:' AS Verificacion, COUNT(*) AS Total FROM companias;
SELECT 'Generos insertados:' AS Verificacion, COUNT(*) AS Total FROM generos;
SELECT 'Juegos insertados:' AS Verificacion, COUNT(*) AS Total FROM juegos;
SELECT 'Relaciones genero-juego:' AS Verificacion, COUNT(*) AS Total FROM genero_juego;

-- ============================================
-- CONSULTAS DE PRUEBA
-- ============================================
-- Listar todas las compañías
SELECT * FROM companias ORDER BY nombre;

-- Listar todos los juegos con sus géneros
SELECT
    j.id,
    j.titulo,
    j.anio,
    GROUP_CONCAT(g.nombre ORDER BY g.nombre SEPARATOR ', ') AS generos,
    c.nombre AS compania,
    c.pais,
    c.tipo AS tipo_compania
FROM juegos j
INNER JOIN companias c ON j.compania_id = c.id
LEFT JOIN genero_juego gj ON j.id = gj.juego_id
LEFT JOIN generos g ON gj.genero_id = g.id
GROUP BY j.id, j.titulo, j.anio, c.nombre, c.pais, c.tipo
ORDER BY j.anio DESC;

-- Juegos por género
SELECT
    g.nombre AS genero,
    COUNT(DISTINCT gj.juego_id) AS cantidad_juegos
FROM generos g
LEFT JOIN genero_juego gj ON g.id = gj.genero_id
GROUP BY g.id, g.nombre
ORDER BY cantidad_juegos DESC;

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

-- Juegos con múltiples géneros (más de 1)
SELECT
    j.titulo,
    COUNT(gj.genero_id) AS cantidad_generos,
    GROUP_CONCAT(g.nombre ORDER BY g.nombre SEPARATOR ', ') AS generos
FROM juegos j
INNER JOIN genero_juego gj ON j.id = gj.juego_id
INNER JOIN generos g ON gj.genero_id = g.id
GROUP BY j.id, j.titulo
HAVING COUNT(gj.genero_id) > 1
ORDER BY cantidad_generos DESC, j.titulo;
