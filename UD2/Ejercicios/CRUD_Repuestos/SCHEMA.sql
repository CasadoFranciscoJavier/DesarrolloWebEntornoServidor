DROP SCHEMA IF EXISTS taller_repuestos;
CREATE SCHEMA IF NOT EXISTS taller_repuestos;
USE taller_repuestos;

CREATE TABLE USUARIOS(
	ID_USUARIO INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    NOMBRE VARCHAR(50) NOT NULL UNIQUE,
    CONTRASENIA VARCHAR(50) NOT NULL,
    ROL ENUM ('administrador', 'usuario') NOT NULL DEFAULT 'usuario'
);

CREATE TABLE REPUESTOS(
	ID_REPUESTO INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	NOMBRE VARCHAR(255) NOT NULL,
	DESCRIPCION TEXT,
	PRECIO DECIMAL(10,2),
	STOCK INT,
	CATEGORIA VARCHAR(50)
);

CREATE TABLE EMBALAJES(
	ID_EMBALAJE INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	ID_REPUESTO INT UNSIGNED NOT NULL,
	TIPO VARCHAR(50),
	DIMENSIONES VARCHAR(50),
	PESO_MAXIMO DECIMAL(5,2),

    FOREIGN KEY (ID_REPUESTO) REFERENCES REPUESTOS(ID_REPUESTO)
);

CREATE TABLE PEDIDOS(
	ID_PEDIDO INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	ID_USUARIO INT UNSIGNED NOT NULL,
	ID_REPUESTO INT UNSIGNED NOT NULL,
	CANTIDAD INT,
	FECHA DATE,
	ESTADO ENUM('pendiente', 'procesando', 'enviado', 'entregado') DEFAULT 'pendiente',

    FOREIGN KEY (ID_USUARIO) REFERENCES USUARIOS(ID_USUARIO),
    FOREIGN KEY (ID_REPUESTO) REFERENCES REPUESTOS(ID_REPUESTO)
);

INSERT INTO USUARIOS(NOMBRE, CONTRASENIA, ROL) VALUES
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
("usuario10", "1234", "usuario");

INSERT INTO REPUESTOS(NOMBRE, DESCRIPCION, PRECIO, STOCK, CATEGORIA) VALUES
("Filtro de Aceite", "Filtro de aceite para motores diésel y gasolina", 15.50, 50, "Filtros"),
("Pastillas de Freno Delanteras", "Juego de pastillas de freno cerámicas", 45.00, 30, "Frenos"),
("Amortiguador Trasero", "Amortiguador hidráulico para suspensión trasera", 85.00, 20, "Suspensión"),
("Bujías (Pack 4)", "Pack de 4 bujías de platino", 25.00, 40, "Motor"),
("Correa de Distribución", "Correa de distribución reforzada", 55.00, 25, "Motor"),

("Batería 12V 60Ah", "Batería de arranque libre de mantenimiento", 120.00, 15, "Eléctrico"),
("Alternador", "Alternador 14V 90A", 180.00, 10, "Eléctrico"),
("Filtro de Aire", "Filtro de aire de alto rendimiento", 18.00, 60, "Filtros"),
("Discos de Freno Delanteros", "Par de discos de freno ventilados", 95.00, 18, "Frenos"),
("Radiador", "Radiador de aluminio con depósito", 150.00, 12, "Refrigeración"),

("Bomba de Agua", "Bomba de agua con junta incluida", 65.00, 22, "Refrigeración"),
("Termostato", "Termostato de refrigeración 82°C", 22.00, 35, "Refrigeración"),
("Embrague Completo", "Kit de embrague con disco y prensa", 210.00, 8, "Transmisión"),
("Filtro de Combustible", "Filtro de combustible diésel/gasolina", 12.00, 70, "Filtros"),
("Sensor de Oxígeno", "Sonda lambda universal", 75.00, 16, "Motor");

INSERT INTO EMBALAJES(ID_REPUESTO, TIPO, DIMENSIONES, PESO_MAXIMO) VALUES
(1, "Caja Pequeña", "20x15x10 cm", 1.00),
(1, "Blister", "25x18x5 cm", 0.50),
(2, "Caja Mediana", "30x25x15 cm", 3.00),
(3, "Caja Grande", "80x15x15 cm", 5.00),
(4, "Blister", "25x20x8 cm", 0.80),

(5, "Caja Mediana", "40x30x10 cm", 2.50),
(6, "Caja Grande", "35x25x20 cm", 15.00),
(7, "Caja Grande", "40x30x25 cm", 8.00),
(8, "Caja Pequeña", "25x20x8 cm", 0.60),
(9, "Caja Grande", "50x50x10 cm", 12.00),

(10, "Caja Grande", "60x40x30 cm", 10.00),
(11, "Caja Mediana", "25x25x20 cm", 3.50),
(12, "Blister", "15x10x5 cm", 0.30),
(13, "Caja Grande", "50x40x15 cm", 18.00),
(14, "Blister", "20x15x5 cm", 0.40),

(15, "Caja Pequeña", "15x10x10 cm", 0.80),
(2, "Caja Pequeña", "25x20x12 cm", 2.50),
(6, "Caja Mediana", "30x22x18 cm", 14.00);

INSERT INTO PEDIDOS(ID_USUARIO, ID_REPUESTO, CANTIDAD, FECHA, ESTADO) VALUES
(4, 1, 2, "2025-01-10", "entregado"),
(4, 8, 1, "2025-01-10", "entregado"),
(5, 2, 4, "2025-01-12", "entregado"),
(6, 6, 1, "2025-01-15", "enviado"),
(7, 3, 2, "2025-01-18", "procesando"),

(8, 5, 1, "2025-01-20", "procesando"),
(9, 4, 8, "2025-01-22", "pendiente"),
(10, 10, 1, "2025-01-23", "pendiente"),
(4, 14, 5, "2025-01-24", "pendiente"),
(5, 7, 1, "2025-01-25", "pendiente");
