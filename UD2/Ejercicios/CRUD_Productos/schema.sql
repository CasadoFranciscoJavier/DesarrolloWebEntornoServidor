-- 🗑️ Eliminar la base de datos si existe
DROP DATABASE IF EXISTS tienda;

-- 🏪 Crear base de datos
CREATE DATABASE tienda;

-- Usar la base de datos
USE tienda;

-- 🧱 Crear tabla de productos
CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    precio DECIMAL(10,2) NOT NULL
);

-- 📦 Insertar productos de ejemplo
INSERT INTO productos (nombre, precio) VALUES
('Pan', 1.20),
('Leche', 0.99),
('Huevos', 2.50),
('Arroz', 1.80),
('Azúcar', 1.50),
('Aceite', 3.40),
('Manzanas', 2.10),
('Pasta', 1.30);

-- ✅ Verificar que los productos se insertaron correctamente
SELECT * FROM productos;
