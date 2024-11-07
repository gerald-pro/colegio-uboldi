SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


-- Tabla: usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    correo VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(300) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla: apoderados
CREATE TABLE apoderados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    direccion VARCHAR(100) NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    id_usuario INT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla: cursos
CREATE TABLE cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    paralelo CHAR(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla: estudiantes
CREATE TABLE estudiantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    direccion VARCHAR(100) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    correo VARCHAR(50) NOT NULL UNIQUE UNIQUE,
    telefono VARCHAR(15) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    id_curso INT NOT NULL,
    id_apoderado INT NOT NULL,
    FOREIGN KEY (id_curso) REFERENCES cursos(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_apoderado) REFERENCES apoderados(id) ON DELETE CASCADE ON UPDATE CASCADE
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
  codigo VARCHAR(10) NOT NULL UNIQUE,
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  monto_total DECIMAL(10, 2) NOT NULL,
  id_estudiante INT NOT NULL,         
  id_apoderado INT NOT NULL,
  id_curso INT NOT NULL, 
  id_usuario INT NOT NULL,
  id_metodo_pago INT NOT NULL,
  FOREIGN KEY (id_estudiante) REFERENCES estudiantes(id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (id_apoderado) REFERENCES apoderados(id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (id_curso) REFERENCES cursos(id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (id_metodo_pago) REFERENCES metodos_pago(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE detalle_pago (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_pago INT NOT NULL, 
  id_cuota INT NOT NULL, 
  monto DECIMAL(10, 2) NOT NULL,
  FOREIGN KEY (id_pago) REFERENCES pagos(id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (id_cuota) REFERENCES cuotas(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `usuarios` (`id`, `usuario`, `correo`, `password`) VALUES
(2, 'luis', 'luis@gmail.commm', ''),
(3, 'jose', 'jose@gmail.com', '123'),
(4, 'admin', 'admin@gmail.com', '123'),
(5, 'marcos', 'marcos@gmail.com', '123'),
(6, 'angel', 'angel@gmail.com', '123'),
(7, 'andres', 'andres@gmail.com', '123'),
(8, 'luisa', 'luisa@gmail.com', '123');


INSERT INTO `apoderados` (`id`, `nombre`, `apellido`, `direccion`, `telefono`, `id_usuario`) VALUES
(3, 'daniel', 'sanches', 'plan 3000', '75649857', 3),
(4, 'claudia', 'perez', 'villa 1 de mayo', '77647468', 3),
(5, 'karen', 'saucedo', 'radial 10', '68127026', 2),
(6, 'marcela', 'rivero', 'alto san pedro' , '76807742', 2),
(7, 'tutor', 'trujillo', 'alto san pedro 2', '7000000', 2);

INSERT INTO `cursos` (`id`, `nombre`, `paralelo`) VALUES
(8, '3', 'B'),
(9, '4', 'C'),
(13, '5', 'A');


INSERT INTO `estudiantes` (`id`, `nombre`, `apellidos`, `direccion`, `fecha_nacimiento`, `correo`, `telefono`, `fecha_registro`, `fecha_actualizacion`, `id_curso`, `id_apoderado`) VALUES
(4, 'marcos', 'saucedo', 'el plan3000', '2008-07-16', 'marcos@gmail.com', '78786767', '2024-06-02', '2024-06-04 12:35:57', 13, 5),
(5, 'gerald', 'avalos', 'la guardia', '2001-09-12', 'avaloss.gerald@gmail.com', '70480741', '2024-10-24', '2024-10-25 11:40:50', 13, 3),
(6, 'ana', 'gomez', 'barrio lindo', '2005-03-15', 'ana.gomez@gmail.com', '71234567', '2024-10-01', '2024-10-01 09:00:00', 8, 3),
(7, 'luis', 'fernandez', 'centro', '2006-05-20', 'luis.fernandez@gmail.com', '72345678', '2024-10-02', '2024-10-02 10:00:00', 9, 4),
(8, 'maria', 'lopez', 'zona norte', '2007-07-25', 'maria.lopez@gmail.com', '73456789', '2024-10-03', '2024-10-03 11:00:00', 8, 5),
(9, 'jose', 'martinez', 'zona sur', '2008-09-30', 'jose.martinez@gmail.com', '74567890', '2024-10-04', '2024-10-04 12:00:00', 9, 6),
(10, 'carla', 'rodriguez', 'zona este', '2009-11-05', 'carla.rodriguez@gmail.com', '75678901', '2024-10-05', '2024-10-05 13:00:00', 8, 7),
(11, 'juan', 'perez', 'zona oeste', '2010-01-10', 'juan.perez@gmail.com', '76789012', '2024-10-06', '2024-10-06 14:00:00', 9, 3),
(12, 'sofia', 'sanchez', 'zona central', '2011-03-15', 'sofia.sanchez@gmail.com', '77890123', '2024-10-07', '2024-10-07 15:00:00', 8, 4);

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


INSERT INTO `pagos` (codigo, monto_total, id_estudiante, id_apoderado, id_curso, id_usuario, id_metodo_pago, fecha) VALUES
('123', 340, 4, 5, 8, 4, 1, '2024-01-01 10:50:00'),
('124', 680, 4, 3, 8, 4, 1, '2024-03-01 11:30:00'),
('125', 340, 4, 3, 8, 4, 1, '2024-04-01 08:22:00'),
('126', 340, 4, 6, 8, 4, 1, '2024-05-01 09:21:00'),
('127', 340, 4, 3, 8, 4, 1, '2024-06-01 14:56:00'),
('128', 340, 4, 4, 8, 4, 1, '2024-07-01 13:34:00'),
('129', 340, 4, 4, 8, 4, 1, '2024-08-01 17:38:00');


INSERT INTO detalle_pago (id_pago, id_cuota, monto) VALUES
(1, 1, 340), 
(2, 2, 340), 
(2, 3, 340),
(3, 4, 340),
(4, 5, 340),
(5, 6, 340),
(6, 7, 340),
(7, 8, 340);