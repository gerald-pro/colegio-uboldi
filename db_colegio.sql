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



CREATE TABLE usuario (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario VARCHAR(50) NOT NULL,
  correo VARCHAR(50) NOT NULL,
  password VARCHAR(300) NOT NULL,
  fecha_registro DATE NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE apoderado (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL,
  apellido VARCHAR(50) NOT NULL,
  direccion VARCHAR(100) NOT NULL,
  telefono VARCHAR(15) NOT NULL,
  id_usuario INT NOT NULL,
  FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE curso (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL,
  paralelo CHAR(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE detalle_cuotas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  codigo VARCHAR(20) NOT NULL,
  gestion INT NOT NULL,
  monto DECIMAL(10, 2) NOT NULL, -- Ajustado a valores típicos de dinero
  n_cuotas INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE detalle_n_cuotas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  gestion VARCHAR(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE estudiante (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL,
  apellidos VARCHAR(100) NOT NULL,
  direccion VARCHAR(100) NOT NULL,
  fecha_nacimiento DATE NOT NULL,
  correo VARCHAR(50) NOT NULL,
  telefono VARCHAR(15) NOT NULL,
  fecha_registro DATE NOT NULL,
  fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  id_curso INT NOT NULL,
  id_apoderado INT NOT NULL,
  FOREIGN KEY (id_curso) REFERENCES curso(id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (id_apoderado) REFERENCES apoderado(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE metodos_pago (
  id INT AUTO_INCREMENT PRIMARY KEY,
  metodo VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE pagos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  hora TIME NOT NULL,
  monto DECIMAL(10, 2) NOT NULL,
  gestion YEAR NOT NULL,
  id_estudiante INT NOT NULL,
  id_apoderado INT NOT NULL,
  id_curso INT NOT NULL,
  id_usuario INT NOT NULL,
  id_metodo_pago INT NOT NULL,
  codigo VARCHAR(20) NOT NULL,  -- Unificado con "codigo" en detalle_cuotas
  FOREIGN KEY (id_estudiante) REFERENCES estudiante(id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (id_apoderado) REFERENCES apoderado(id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (id_curso) REFERENCES curso(id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (id_metodo_pago) REFERENCES metodos_pago(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `usuario` (`id`, `usuario`, `correo`, `password`, `fecha_registro`) VALUES
(2, 'luis', 'luis@gmail.commm', '', '2024-05-17'),
(3, 'jose', 'jose@gmail.com', '12347f', '2024-05-25'),
(4, 'admin', 'admin@gmail.com', '12345', '2024-06-10'),
(5, 'marcos', 'marcos@gmail.com', '75432', '2024-05-27'),
(6, 'angel', 'angel@gmail.com', '123456e', '2024-05-28'),
(7, 'andres', 'andres@gmail.com', '33397', '2024-05-29'),
(8, 'luisa', 'luisa@gmail.com', '54321', '2024-05-30');



INSERT INTO `apoderado` (`id`, `nombre`, `apellido`, `direccion`, `telefono`, `id_usuario`) VALUES
(3, 'daniel', 'sanches', 'plan 3000', '75649857', 3),
(4, 'claudia', 'perez', 'villa 1 de mayo', '77647468', 3),
(5, 'karen', 'saucedo', 'radial 10', '68127026', 2),
(6, 'marcela', 'rivero', 'alto san pedro ', '76807742', 2);


INSERT INTO `curso` (`id`, `nombre`, `paralelo`) VALUES
(8, '3', 'B'),
(9, '4', 'C'),
(13, '5', 'a');


INSERT INTO `detalle_cuotas` (`id`, `codigo`, `gestion`, `monto`, `n_cuotas`) VALUES
(3, '1', 2024, 340, '1'),
(5, '2', 2024, 340, '2'),
(8, '3', 2024, 340, '3'),
(10, '4', 2024, 340, '4'),
(11, '5', 2024, 340, '5'),
(12, '6', 2024, 340, '6');


INSERT INTO `detalle_n_cuotas` (`id`, `gestion`) VALUES
(1, '2015'),
(2, '2016'),
(3, '2017'),
(4, '2018'),
(5, '2019'),
(6, '2020'),
(7, '2021'),
(8, '2022'),
(9, '2023'),
(10, '2024');


INSERT INTO `estudiante` (`id`, `nombre`, `apellidos`, `direccion`, `fecha_nacimiento`, `correo`, `telefono`, `fecha_registro`, `fecha_actualizacion`, `id_curso`, `id_apoderado`) VALUES
(4, 'marcos', 'saucedo', 'el plan3000', '2008-07-16', 'marcos@gmail.com', '78786767', '2024-06-02', '2024-06-04 12:35:57', 13, 5);

INSERT INTO `metodos_pago` (`metodo`) VALUES ('Efectivo'), ('Depósito Bancario'), ('QR');

INSERT INTO `pagos` (`id`, `fecha`, `hora`, `monto`, `id_estudiante`, `id_apoderado`, `id_curso`, `id_usuario`, `codigo`, `gestion`, `id_metodo_pago`) VALUES
(16, '2024-06-10 02:48:18', '2024-06-09 22:48:18', 444, 4, 5, 13, 4, 200454, 2024, 1),
(34, '2024-06-10 02:23:10', '2024-06-09 22:23:10', 300000, 4, 3, 8, 4, 5657769, 2024, 1),
(39, '2024-06-10 02:44:16', '2024-06-09 22:44:16', 456789, 4, 3, 8, 4, 57, 2024, 1),
(40, '2024-06-10 03:26:30', '2024-06-09 22:54:12', 780, 4, 6, 9, 4, 789678, 2024, 1),
(47, '2024-06-10 04:10:57', '2024-06-10 00:10:57', 780, 4, 3, 8, 4, 78967, 2024, 1),
(50, '2024-06-10 05:17:31', '2024-06-10 01:17:31', 1200, 4, 4, 8, 4, 2147483647, 2024, 1),
(54, '2024-06-10 11:51:27', '2024-06-10 07:51:27', 7000, 4, 4, 9, 4, 1010, 2024, 1);




