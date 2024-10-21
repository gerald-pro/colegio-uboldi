-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-06-2024 a las 16:27:20
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


-- Tabla: usuario
CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL,
    correo VARCHAR(50) NOT NULL,
    password VARCHAR(300) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla: apoderado
CREATE TABLE apoderado (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    direccion VARCHAR(100) NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    id_usuario INT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla: curso
CREATE TABLE curso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    paralelo CHAR(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla: estudiante
CREATE TABLE estudiante (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    direccion VARCHAR(100) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    correo VARCHAR(50) NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    id_curso INT NOT NULL,
    id_apoderado INT NOT NULL,
    FOREIGN KEY (id_curso) REFERENCES curso(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_apoderado) REFERENCES apoderado(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla: metodos_pago
CREATE TABLE metodos_pago (
    id INT AUTO_INCREMENT PRIMARY KEY,
    metodo VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla: cuotas
CREATE TABLE cuotas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    gestion INT NOT NULL,
    mes INT NOT NULL CHECK (mes BETWEEN 1 AND 12),
    monto DECIMAL(10, 2) NOT NULL,
    fecha_vencimiento DATE NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Tabla: pagos
CREATE TABLE pagos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(10) NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    monto DECIMAL(10, 2) NOT NULL,
    id_estudiante INT NOT NULL,
    id_apoderado INT NOT NULL,
    id_curso INT NOT NULL,
    id_usuario INT NOT NULL,
    id_metodo_pago INT NOT NULL,
    id_cuota INT NOT NULL,
    FOREIGN KEY (id_estudiante) REFERENCES estudiante(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_apoderado) REFERENCES apoderado(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_curso) REFERENCES curso(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_metodo_pago) REFERENCES metodos_pago(id),
    FOREIGN KEY (id_cuota) REFERENCES cuotas(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `usuario` (`id`, `usuario`, `correo`, `password`) VALUES
(2, 'luis', 'luis@gmail.commm', ''),
(3, 'jose', 'jose@gmail.com', '123'),
(4, 'admin', 'admin@gmail.com', '123'),
(5, 'marcos', 'marcos@gmail.com', '123'),
(6, 'angel', 'angel@gmail.com', '123'),
(7, 'andres', 'andres@gmail.com', '123'),
(8, 'luisa', 'luisa@gmail.com', '123');


INSERT INTO `apoderado` (`id`, `nombre`, `apellido`, `direccion`, `telefono`, `id_usuario`) VALUES
(3, 'daniel', 'sanches', 'plan 3000', '75649857', 3),
(4, 'claudia', 'perez', 'villa 1 de mayo', '77647468', 3),
(5, 'karen', 'saucedo', 'radial 10', '68127026', 2),
(6, 'marcela', 'rivero', 'alto san pedro ', '76807742', 2);


INSERT INTO `curso` (`id`, `nombre`, `paralelo`) VALUES
(8, '3', 'B'),
(9, '4', 'C'),
(13, '5', 'A');


INSERT INTO `estudiante` (`id`, `nombre`, `apellidos`, `direccion`, `fecha_nacimiento`, `correo`, `telefono`, `fecha_registro`, `fecha_actualizacion`, `id_curso`, `id_apoderado`) VALUES
(4, 'marcos', 'saucedo', 'el plan3000', '2008-07-16', 'marcos@gmail.com', '78786767', '2024-06-02', '2024-06-04 12:35:57', 13, 5);

INSERT INTO `metodos_pago` (`metodo`) VALUES ('Efectivo'), ('Depósito Bancario'), ('QR');


INSERT INTO `cuotas` (`id`, `gestion`, `mes`, `monto`, `fecha_vencimiento`) VALUES
(1, 2024, 1, 340, '2024-01-31'),
(2, 2024, 2, 340, '2024-02-28'),
(3, 2024, 3, 340, '2024-03-31'),
(4, 2024, 4, 340, '2024-04-30'),
(5, 2024, 5, 340, '2024-05-31'),
(6, 2024, 6, 340, '2024-06-30'),
(7, 2024, 7, 340, '2024-07-31'),
(8, 2024, 8, 340, '2024-08-31'),
(9, 2024, 9, 340, '2024-09-30'),
(10, 2024, 10, 340, '2024-10-31');


INSERT INTO `pagos` (codigo, monto, id_estudiante, id_apoderado, id_curso, id_usuario, id_metodo_pago, id_cuota) VALUES
(123, 340, 4, 5, 13, 4, 1, 1),
(124, 340, 4, 3, 8, 4, 1, 2),
(125, 340, 4, 3, 8, 4, 1, 3),
(126, 340, 4, 6, 9, 4, 1, 4),
(127, 340, 4, 3, 8, 4, 1, 5),
(128, 340, 4, 4, 8, 4, 1, 6),
(129, 340, 4, 4, 9, 4, 1, 7);