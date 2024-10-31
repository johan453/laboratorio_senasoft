-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-10-2024 a las 21:36:59
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `laboratorio_senasoft`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `nombre`, `email`) VALUES
(1, 'admin', 'password123', 'Administrador', 'admin@example.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fac_m_tarjetero`
--

CREATE TABLE `fac_m_tarjetero` (
  `id` int(11) NOT NULL,
  `id_persona` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `fac_m_tarjetero`
--

INSERT INTO `fac_m_tarjetero` (`id`, `id_persona`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 10),
(10, 11),
(11, 12),
(12, 13),
(13, 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gen_m_persona`
--

CREATE TABLE `gen_m_persona` (
  `id` int(11) NOT NULL,
  `tipo_identificacion` varchar(50) DEFAULT NULL,
  `numero_identificacion` varchar(20) DEFAULT NULL,
  `nombre1` varchar(50) DEFAULT NULL,
  `nombre2` varchar(50) DEFAULT NULL,
  `apellido1` varchar(50) DEFAULT NULL,
  `apellido2` varchar(50) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `sexo_biologico` varchar(10) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `telefono_movil` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `rol` enum('usuario','admin') NOT NULL DEFAULT 'usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `gen_m_persona`
--

INSERT INTO `gen_m_persona` (`id`, `tipo_identificacion`, `numero_identificacion`, `nombre1`, `nombre2`, `apellido1`, `apellido2`, `fecha_nacimiento`, `sexo_biologico`, `direccion`, `telefono_movil`, `email`, `rol`) VALUES
(1, 'CC', '1234567890', 'Juan', 'Carlos', 'Pérez', 'Gómez', '1990-01-01', 'Masculino', 'Calle 123 #45-67', '3001234567', 'juan.perez@gmail.com', 'admin'),
(2, 'TI', '0987654321', 'María', 'Fernanda', 'López', 'Rodríguez', '2000-05-15', 'Femenino', 'Carrera 78 #90-12', '3109876543', 'maria.lopez@gmail.com', 'usuario'),
(3, 'CE', '1122334455', 'John', 'Michael', 'Smith', 'Johnson', '1985-12-31', 'Masculino', 'Avenida 56 #78-90', '3201234567', 'john.smith@gmail.com', 'usuario'),
(4, 'CC', '1001234567', 'Laura', 'Isabel', 'Rodríguez', 'Gómez', '1990-05-15', 'Femenino', 'Calle 23 #45-67', '3101234567', 'laura.rodriguez@email.com', 'usuario'),
(5, 'TI', '991234567', 'Andrés', 'Felipe', 'Martínez', 'López', '2005-08-20', 'Masculino', 'Carrera 56 #78-90', '3202345678', 'andres.martinez@email.com', 'usuario'),
(6, 'CE', '2001234567', 'Sophie', 'Marie', 'Smith', 'Johnson', '1985-12-10', 'Femenino', 'Avenida 7 #12-34', '3303456789', 'sophie.smith@email.com', 'usuario'),
(7, 'CC', '1002345678', 'Carlos', 'Eduardo', 'Pérez', 'Sánchez', '1978-03-25', 'Masculino', 'Calle 89 #01-23', '3404567890', 'carlos.perez@email.com', 'usuario'),
(8, 'CC', '1003456789', 'María', 'Fernandaa', 'González', 'Torres', '1995-07-30', 'Femenino', 'Carrera 34 #56-79', '3505678901', 'maria.gonzalez@email.com', 'usuario'),
(9, 'CC', '09876543210', 'Juan', 'Carlos', 'Perez', '', '2024-10-22', 'Masculino', 'cra 43d', '30484737333', 'carlos@gmail.com', 'usuario'),
(10, 'CC', '1001001001', 'Juan', NULL, 'Pérez', NULL, '1990-01-01', 'Masculino', NULL, NULL, NULL, 'usuario'),
(11, 'CC', '1002002002', 'María', NULL, 'González', NULL, '1985-05-15', 'Femenino', NULL, NULL, NULL, 'usuario'),
(12, 'CC', '1003003003', 'Carlos', NULL, 'Rodríguez', NULL, '1978-11-30', 'Masculino', NULL, NULL, NULL, 'usuario'),
(13, 'CC', '1004004004', 'Ana', NULL, 'Martínez', NULL, '1995-08-22', 'Femenino', NULL, NULL, NULL, 'usuario'),
(14, 'CC', '1005005005', 'Luis', NULL, 'Sánchez', NULL, '1982-03-10', 'Masculino', NULL, NULL, NULL, 'usuario'),
(15, 'CE', '1122334455', 'Rene', '', 'pipi', '', '2024-10-23', 'Masculino', 'cra23 q23', '33332222', 'dweidjewoi@djwdwd.com', 'usuario'),
(16, 'CC', '10957757474', 'Jhon', '', 'Marin', '', '2004-05-10', 'Masculino', 'cra 30 sur ', '3190684579', 'jhon@gmail.com', 'usuario'),
(17, 'CC', '122333232', 'STIVEN', '', 'MORA', '', '2024-10-16', 'Masculino', 'CRA 34', '31455544444', 'STIVEN@GMAIL.COM', 'usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gen_p_documento`
--

CREATE TABLE `gen_p_documento` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `gen_p_documento`
--

INSERT INTO `gen_p_documento` (`id`, `nombre`) VALUES
(1, 'Orden de laboratorio'),
(2, 'Resultado de exámenes'),
(3, 'Historia clínica'),
(4, 'Consentimiento informado'),
(5, 'Informe de laboratorio detallado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gen_p_lista_opcion`
--

CREATE TABLE `gen_p_lista_opcion` (
  `id` int(11) NOT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `gen_p_lista_opcion`
--

INSERT INTO `gen_p_lista_opcion` (`id`, `categoria`, `nombre`) VALUES
(1, 'TipoIdentificacion', 'CC'),
(2, 'TipoIdentificacion', 'TI'),
(3, 'TipoIdentificacion', 'CE'),
(4, 'TipoIdentificacion', 'Pasaporte'),
(5, 'TipoIdentificacion', 'Registro Civil'),
(6, 'TipoIdentificacion', 'Permiso Especial de Permanencia'),
(7, 'SexoBiologico', 'Masculino'),
(8, 'SexoBiologico', 'Femenino'),
(9, 'SexoBiologico', 'Intersexual'),
(10, 'EstadoCivil', 'Soltero/a'),
(11, 'EstadoCivil', 'Casado/a'),
(12, 'EstadoCivil', 'Divorciado/a'),
(13, 'EstadoCivil', 'Viudo/a'),
(14, 'EstadoCivil', 'Unión Libre');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lab_m_orden`
--

CREATE TABLE `lab_m_orden` (
  `id` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `id_documento` int(11) DEFAULT NULL,
  `orden` varchar(20) DEFAULT NULL,
  `id_historia` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lab_m_orden`
--

INSERT INTO `lab_m_orden` (`id`, `fecha`, `id_documento`, `orden`, `id_historia`) VALUES
(1, '2023-01-01', 1, 'ORD001', 1),
(2, '2023-02-15', 1, 'ORD002', 2),
(3, '2023-03-30', 1, 'ORD003', 3),
(4, '2023-10-01', 1, 'ORD010', 4),
(5, '2023-10-02', 1, 'ORD011', 4),
(6, '2023-10-03', 1, 'ORD012', 4),
(7, '2023-10-04', 1, 'ORD013', 5),
(8, '2023-10-05', 1, 'ORD014', 5),
(9, '2023-10-06', 1, 'ORD015', 5),
(10, '2023-10-07', 1, 'ORD016', 6),
(11, '2023-10-08', 1, 'ORD017', 6),
(12, '2023-10-09', 1, 'ORD018', 6),
(13, '2023-10-10', 1, 'ORD019', 7),
(14, '2023-10-11', 1, 'ORD020', 7),
(15, '2023-10-12', 1, 'ORD021', 7),
(16, '2023-10-13', 1, 'ORD022', 8),
(17, '2023-10-14', 1, 'ORD023', 8),
(18, '2023-10-15', 1, 'ORD024', 8),
(24, '2024-10-22', 1, 'ORD001', 1),
(25, '2024-10-22', 1, 'ORD002', 2),
(26, '2024-10-15', 1, 'ORD001', 1),
(27, '2024-10-13', 1, 'ORD002', 1),
(28, '2024-09-28', 1, 'ORD003', 1),
(29, '2024-10-16', 1, 'ORD004', 2),
(30, '2024-10-05', 1, 'ORD005', 2),
(31, '2024-10-15', 1, 'ORD006', 2),
(32, '2024-10-08', 1, 'ORD007', 3),
(33, '2024-09-30', 1, 'ORD008', 3),
(34, '2024-10-15', 1, 'ORD009', 3),
(35, '2024-10-07', 1, 'ORD010', 4),
(36, '2024-10-22', 1, 'ORD011', 4),
(37, '2024-10-13', 1, 'ORD012', 4),
(38, '2024-10-01', 1, 'ORD013', 5),
(39, '2024-09-25', 1, 'ORD014', 5),
(40, '2024-10-08', 1, 'ORD015', 5),
(41, '2024-10-02', 1, 'ORD016', 6),
(42, '2024-09-25', 1, 'ORD017', 6),
(43, '2024-10-05', 1, 'ORD018', 6),
(44, '2024-10-15', 1, 'ORD019', 7),
(45, '2024-10-05', 1, 'ORD020', 7),
(46, '2024-10-16', 1, 'ORD021', 7),
(47, '2024-10-15', 1, 'ORD022', 8),
(48, '2024-10-10', 1, 'ORD023', 8),
(49, '2024-10-13', 1, 'ORD024', 8),
(50, '2024-10-10', 1, 'ORD025', 9),
(51, '2024-10-21', 1, 'ORD026', 9),
(52, '2024-10-20', 1, 'ORD027', 9),
(53, '2024-10-16', 1, 'ORD028', 10),
(54, '2024-09-25', 1, 'ORD029', 10),
(55, '2024-09-27', 1, 'ORD030', 10),
(56, '2024-10-06', 1, 'ORD031', 11),
(57, '2024-10-16', 1, 'ORD032', 11),
(58, '2024-10-08', 1, 'ORD033', 11),
(59, '2024-10-06', 1, 'ORD034', 12),
(60, '2024-10-03', 1, 'ORD035', 12),
(61, '2024-09-25', 1, 'ORD036', 12),
(62, '2024-09-24', 1, 'ORD037', 13),
(63, '2024-10-16', 1, 'ORD038', 13),
(64, '2024-10-16', 1, 'ORD039', 13),
(75, '2024-10-30', NULL, '1', 13),
(76, '2024-10-30', NULL, '2', 7),
(77, '2024-10-31', NULL, '3', 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lab_m_orden_detalle`
--

CREATE TABLE `lab_m_orden_detalle` (
  `id` int(11) NOT NULL,
  `id_orden` int(11) NOT NULL,
  `id_prueba` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `lab_m_orden_detalle`
--

INSERT INTO `lab_m_orden_detalle` (`id`, `id_orden`, `id_prueba`) VALUES
(5, 1, 1),
(6, 1, 2),
(7, 2, 3),
(8, 2, 4),
(9, 59, 33),
(10, 56, 33),
(11, 49, 26),
(12, 4, 18),
(13, 61, 3),
(14, 43, 33),
(16, 53, 25),
(17, 48, 5),
(18, 53, 41),
(20, 57, 36),
(21, 38, 41),
(22, 10, 22),
(23, 43, 3),
(24, 46, 7),
(25, 32, 38),
(26, 29, 21),
(27, 30, 37),
(28, 53, 36),
(29, 39, 32),
(30, 40, 18),
(31, 55, 30),
(32, 48, 19),
(33, 8, 18),
(34, 59, 25),
(35, 44, 41),
(36, 35, 36),
(37, 3, 26),
(38, 11, 20),
(39, 13, 40),
(40, 64, 24),
(41, 1, 1),
(42, 43, 18),
(43, 52, 7),
(44, 45, 30),
(45, 54, 5),
(46, 45, 2),
(47, 40, 28),
(48, 42, 23),
(49, 17, 6),
(50, 55, 40),
(51, 37, 25),
(52, 58, 40),
(53, 54, 23),
(54, 27, 29),
(55, 58, 38),
(56, 43, 20),
(57, 40, 40),
(58, 17, 28),
(59, 11, 19),
(60, 37, 30),
(61, 11, 23),
(62, 2, 35),
(63, 27, 18),
(64, 30, 3),
(65, 54, 29),
(66, 4, 38),
(68, 58, 31),
(69, 58, 2),
(70, 15, 24),
(71, 61, 6),
(72, 28, 38),
(73, 10, 30),
(74, 48, 27),
(77, 16, 40),
(78, 50, 39),
(79, 62, 40),
(80, 41, 19),
(81, 54, 1),
(82, 31, 6),
(83, 61, 32),
(85, 30, 30),
(86, 30, 18),
(87, 44, 40),
(89, 13, 7),
(90, 4, 30),
(91, 54, 41),
(92, 29, 1),
(93, 6, 20),
(94, 14, 35),
(95, 37, 21),
(96, 11, 21),
(97, 61, 37),
(98, 57, 25),
(100, 62, 36),
(101, 62, 38),
(102, 57, 40),
(103, 49, 23),
(104, 42, 28),
(105, 9, 24),
(106, 18, 7),
(107, 35, 24),
(108, 62, 1),
(151, 25, 1),
(152, 25, 3),
(153, 25, 37),
(156, 36, 38),
(157, 36, 18),
(158, 75, 30),
(159, 75, 38),
(160, 75, 1),
(161, 24, 37),
(162, 24, 22),
(163, 76, 43),
(164, 76, 5),
(165, 77, 25),
(166, 77, 27);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lab_m_orden_resultados`
--

CREATE TABLE `lab_m_orden_resultados` (
  `id` int(11) NOT NULL,
  `id_orden` int(11) DEFAULT NULL,
  `id_prueba` int(11) DEFAULT NULL,
  `id_procedimiento` int(11) DEFAULT NULL,
  `res_opcion` varchar(50) DEFAULT NULL,
  `res_numerico` decimal(10,2) DEFAULT NULL,
  `res_texto` text DEFAULT NULL,
  `res_memo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lab_m_orden_resultados`
--

INSERT INTO `lab_m_orden_resultados` (`id`, `id_orden`, `id_prueba`, `id_procedimiento`, `res_opcion`, `res_numerico`, `res_texto`, `res_memo`) VALUES
(1, 1, 1, 1, NULL, 180.50, NULL, NULL),
(2, 1, 2, 1, NULL, 150.00, NULL, NULL),
(3, 2, 3, 2, NULL, 14.50, NULL, NULL),
(4, 3, 4, 3, NULL, 2.50, NULL, NULL),
(5, 4, 1, 1, NULL, 185.50, NULL, NULL),
(6, 4, 2, 1, NULL, 130.00, NULL, NULL),
(7, 4, 3, 2, NULL, 13.20, NULL, NULL),
(8, 5, 4, 3, NULL, 2.80, NULL, NULL),
(9, 5, 1, 1, NULL, 190.00, NULL, NULL),
(10, 5, 2, 1, NULL, 135.00, NULL, NULL),
(11, 6, 3, 2, NULL, 13.50, NULL, NULL),
(12, 6, 4, 3, NULL, 3.00, NULL, NULL),
(13, 6, 1, 1, NULL, 188.00, NULL, NULL),
(14, 7, 2, 1, NULL, 95.00, NULL, NULL),
(15, 7, 3, 2, NULL, 14.80, NULL, NULL),
(16, 7, 4, 3, NULL, 3.50, NULL, NULL),
(17, 8, 1, 1, NULL, 160.00, NULL, NULL),
(18, 8, 2, 1, NULL, 100.00, NULL, NULL),
(19, 8, 3, 2, NULL, 15.00, NULL, NULL),
(20, 9, 4, 3, NULL, 3.20, NULL, NULL),
(21, 9, 1, 1, NULL, 165.00, NULL, NULL),
(22, 9, 2, 1, NULL, 98.00, NULL, NULL),
(23, 10, 3, 2, NULL, 12.80, NULL, NULL),
(24, 10, 4, 3, NULL, 2.50, NULL, NULL),
(25, 10, 1, 1, NULL, 210.00, NULL, NULL),
(26, 11, 2, 1, NULL, 150.00, NULL, NULL),
(27, 11, 3, 2, NULL, 13.00, NULL, NULL),
(28, 11, 4, 3, NULL, 2.70, NULL, NULL),
(29, 12, 1, 1, NULL, 205.00, NULL, NULL),
(30, 12, 2, 1, NULL, 145.00, NULL, NULL),
(31, 12, 3, 2, NULL, 13.20, NULL, NULL),
(32, 13, 4, 3, NULL, 3.80, NULL, NULL),
(33, 13, 1, 1, NULL, 195.00, NULL, NULL),
(34, 13, 2, 1, NULL, 140.00, NULL, NULL),
(35, 14, 3, 2, NULL, 15.50, NULL, NULL),
(36, 14, 4, 3, NULL, 3.60, NULL, NULL),
(37, 14, 1, 1, NULL, 200.00, NULL, NULL),
(38, 15, 2, 1, NULL, 145.00, NULL, NULL),
(39, 15, 3, 2, NULL, 15.80, NULL, NULL),
(40, 15, 4, 3, NULL, 3.70, NULL, NULL),
(41, 16, 1, 1, NULL, 178.00, NULL, NULL),
(42, 16, 2, 1, NULL, 120.00, NULL, NULL),
(43, 16, 3, 2, NULL, 13.80, NULL, NULL),
(44, 17, 4, 3, NULL, 2.90, NULL, NULL),
(45, 17, 1, 1, NULL, 180.00, NULL, NULL),
(46, 17, 2, 1, NULL, 125.00, NULL, NULL),
(47, 18, 3, 2, NULL, 14.00, NULL, NULL),
(48, 18, 4, 3, NULL, 3.10, NULL, NULL),
(49, 18, 1, 1, NULL, 182.00, NULL, NULL),
(51, 2, 3, NULL, NULL, 85.37, NULL, NULL),
(52, 2, 4, NULL, NULL, 71.67, NULL, NULL),
(53, 59, 33, NULL, NULL, 93.43, NULL, NULL),
(54, 56, 33, NULL, NULL, 30.15, NULL, NULL),
(56, 4, 18, NULL, NULL, 36.45, NULL, NULL),
(57, 61, 3, NULL, NULL, 4.65, NULL, NULL),
(58, 43, 33, NULL, NULL, 60.30, NULL, NULL),
(59, 53, 25, NULL, NULL, 48.64, NULL, NULL),
(60, 48, 5, NULL, NULL, 11.51, NULL, NULL),
(61, 57, 36, NULL, NULL, 33.09, NULL, NULL),
(62, 38, 41, NULL, NULL, 0.90, NULL, NULL),
(63, 10, 22, NULL, NULL, 19.19, NULL, NULL),
(64, 29, 21, NULL, NULL, 29.69, NULL, NULL),
(65, 30, 37, NULL, NULL, 13.67, NULL, NULL),
(66, 53, 36, NULL, '', 92.54, '', ''),
(67, 39, 32, NULL, NULL, 35.36, NULL, NULL),
(68, 40, 18, NULL, NULL, 38.97, NULL, NULL),
(69, 48, 19, NULL, NULL, 7.17, NULL, NULL),
(70, 59, 25, NULL, NULL, 21.43, NULL, NULL),
(71, 44, 41, NULL, NULL, 81.61, NULL, NULL),
(72, 35, 36, NULL, NULL, 57.67, NULL, NULL),
(73, 3, 26, NULL, NULL, 61.21, NULL, NULL),
(74, 11, 20, NULL, NULL, 43.97, NULL, NULL),
(75, 13, 40, NULL, NULL, 84.53, NULL, NULL),
(77, 43, 18, NULL, NULL, 64.14, NULL, NULL),
(78, 52, 7, NULL, NULL, 55.77, NULL, NULL),
(79, 45, 30, NULL, NULL, 82.39, NULL, NULL),
(80, 40, 28, NULL, NULL, 65.85, NULL, NULL),
(81, 42, 23, NULL, NULL, 79.23, NULL, NULL),
(82, 55, 40, NULL, NULL, 93.17, NULL, NULL),
(83, 37, 25, NULL, NULL, 59.65, NULL, NULL),
(85, 54, 23, NULL, NULL, 65.45, NULL, NULL),
(86, 27, 29, NULL, NULL, 89.79, NULL, NULL),
(87, 58, 38, NULL, NULL, 16.99, NULL, NULL),
(88, 40, 40, NULL, NULL, 54.20, NULL, NULL),
(89, 17, 28, NULL, NULL, 71.61, NULL, NULL),
(90, 11, 23, NULL, NULL, 37.16, NULL, NULL),
(91, 54, 29, NULL, NULL, 80.72, NULL, NULL),
(92, 25, 3, NULL, NULL, 67.21, NULL, NULL),
(93, 58, 2, NULL, NULL, 97.33, NULL, NULL),
(94, 10, 30, NULL, NULL, 28.62, NULL, NULL),
(96, 62, 40, NULL, NULL, 45.03, NULL, NULL),
(97, 30, 30, NULL, NULL, 77.50, NULL, NULL),
(98, 30, 18, NULL, NULL, 86.62, NULL, NULL),
(99, 44, 40, NULL, NULL, 48.28, NULL, NULL),
(113, 4, 30, NULL, NULL, 12.00, NULL, NULL),
(114, 75, 30, NULL, NULL, NULL, NULL, 'nose que decir ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lab_m_prueba`
--

CREATE TABLE `lab_m_prueba` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `tipo_resultado` enum('opcion','numerico','texto','memo') NOT NULL,
  `valores_referencia` text DEFAULT NULL,
  `unidad_medida` varchar(50) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lab_m_prueba`
--

INSERT INTO `lab_m_prueba` (`id`, `nombre`, `codigo`, `descripcion`, `tipo_resultado`, `valores_referencia`, `unidad_medida`, `estado`, `created_at`) VALUES
(1, 'Hemoglobina', 'HGB', 'Medición de hemoglobina en sangre', 'numerico', 'Hombres: 13.5-17.5 g/dL\nMujeres: 12.0-15.5 g/dL', 'g/dL', 1, '2024-10-22 17:46:14'),
(2, 'Hematocrito', 'HCT', 'Porcentaje de glóbulos rojos en sangre', 'numerico', 'Hombres: 41-50%\nMujeres: 36-44%', '%', 1, '2024-10-22 17:46:14'),
(3, 'Recuento de Glóbulos Blancos', 'WBC', 'Conteo total de leucocitos', 'numerico', '4.5-11.0', '10^3/μL', 1, '2024-10-22 17:46:14'),
(4, 'Plaquetas', 'PLT', 'Conteo de plaquetas', 'numerico', '150-450', '10^3/μL', 1, '2024-10-22 17:46:14'),
(5, 'Glucosa en Ayunas', 'GLU', 'Nivel de glucosa en sangre', 'numerico', '70-100', 'mg/dL', 1, '2024-10-22 17:46:14'),
(6, 'Creatinina', 'CREA', 'Medición de creatinina sérica', 'numerico', '0.7-1.3', 'mg/dL', 1, '2024-10-22 17:46:14'),
(7, 'Colesterol Total', 'CHOL', 'Nivel de colesterol total', 'numerico', '<200', 'mg/dL', 1, '2024-10-22 17:46:14'),
(8, 'Triglicéridos', 'TRIG', 'Nivel de triglicéridos', 'numerico', '<150', 'mg/dL', 1, '2024-10-22 17:46:14'),
(9, 'Color de Orina', 'U-COL', 'Color de la muestra de orina', 'texto', 'Amarillo claro a ámbar', NULL, 1, '2024-10-22 17:46:14'),
(10, 'Aspecto de Orina', 'U-ASP', 'Aspecto de la muestra de orina', 'opcion', 'Transparente,Ligeramente turbio,Turbio', NULL, 1, '2024-10-22 17:46:14'),
(11, 'pH Urinario', 'U-PH', 'Nivel de pH en orina', 'numerico', '4.5-8.0', NULL, 1, '2024-10-22 17:46:14'),
(12, 'VIH Prueba Rápida', 'HIV', 'Prueba rápida para detección de VIH', 'opcion', 'Reactivo,No Reactivo', NULL, 1, '2024-10-22 17:46:14'),
(13, 'Prueba de Embarazo', 'BHCG', 'Detección de hormona HCG', 'opcion', 'Positivo,Negativo', NULL, 1, '2024-10-22 17:46:14'),
(14, 'Cultivo de Orina', 'UC', 'Cultivo microbiológico de orina', 'memo', 'Se reportará organismo aislado y sensibilidad antibiótica', NULL, 1, '2024-10-22 17:46:14'),
(15, 'Gram de Secreción', 'GRAM', 'Tinción de Gram', 'memo', 'Se reportará descripción microscópica', NULL, 1, '2024-10-22 17:46:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lab_p_equipos`
--

CREATE TABLE `lab_p_equipos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `modelo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lab_p_equipos`
--

INSERT INTO `lab_p_equipos` (`id`, `nombre`, `marca`, `modelo`) VALUES
(1, 'Analizador de química', 'Roche', 'Cobas c311'),
(2, 'Analizador hematológico', 'Sysmex', 'XN-1000'),
(3, 'Analizador de inmunoensayo', 'Abbott', 'Architect i2000'),
(4, 'Analizador de gases en sangre', 'Radiometer', 'ABL90 FLEX'),
(5, 'Contador de células', 'Beckman Coulter', 'UniCel DxH 800'),
(6, 'Analizador de electrolitos', 'Nova Biomedical', 'StatProfile Prime Plus');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lab_p_grupos`
--

CREATE TABLE `lab_p_grupos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lab_p_grupos`
--

INSERT INTO `lab_p_grupos` (`id`, `nombre`) VALUES
(1, 'Química sanguínea'),
(2, 'Hematología'),
(3, 'Inmunología'),
(4, 'Gasometría'),
(5, 'Coagulación'),
(6, 'Electrolitos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lab_p_metodos`
--

CREATE TABLE `lab_p_metodos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lab_p_metodos`
--

INSERT INTO `lab_p_metodos` (`id`, `nombre`) VALUES
(1, 'Espectrofotometría'),
(2, 'Citometría de flujo'),
(3, 'Inmunoensayo'),
(4, 'Electroquímica'),
(5, 'Impedancia eléctrica'),
(6, 'Potenciometría');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lab_p_procedimientos`
--

CREATE TABLE `lab_p_procedimientos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `id_grupo_laboratorio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lab_p_procedimientos`
--

INSERT INTO `lab_p_procedimientos` (`id`, `nombre`, `id_grupo_laboratorio`) VALUES
(1, 'Perfil lipídico completo', 1),
(2, 'Hemograma completo automatizado', 2),
(3, 'Perfil tiroideo completo', 3),
(4, 'Análisis de gases en sangre', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lab_p_pruebas`
--

CREATE TABLE `lab_p_pruebas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `id_procedimiento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lab_p_pruebas`
--

INSERT INTO `lab_p_pruebas` (`id`, `nombre`, `descripcion`, `id_procedimiento`) VALUES
(1, 'Colesterol total', NULL, 1),
(2, 'Triglicéridos', NULL, 1),
(3, 'Hemoglobina', NULL, 2),
(4, 'TSH', NULL, 3),
(5, 'pH en sangre', NULL, 1),
(6, 'Recuento de plaquetas', NULL, 2),
(7, 'Sodio sérico', NULL, 1),
(18, 'Hemograma completo', 'Análisis completo de células sanguíneas', NULL),
(19, 'Glucosa en sangre', 'Medición de los niveles de azúcar en sangre', NULL),
(20, 'Perfil lipídico', 'Análisis de colesterol y triglicéridos', NULL),
(21, 'Prueba de función hepática', 'Evaluación de la salud del hígado', NULL),
(22, 'Prueba de función renal', 'Evaluación de la salud de los riñones', NULL),
(23, 'TSH', 'Prueba de función tiroidea', NULL),
(24, 'Examen general de orina', 'Análisis de orina para detectar problemas de salud', NULL),
(25, 'Prueba de embarazo', 'Detección de la hormona hCG en sangre u orina', NULL),
(26, 'Prueba de COVID-19', 'Detección del virus SARS-CoV-2', NULL),
(27, 'Prueba de VIH', 'Detección de anticuerpos contra el VIH', NULL),
(28, 'Hemograma', 'Análisis completo de células sanguíneas', NULL),
(29, 'Glucosa', 'Medición de niveles de azúcar en sangre', NULL),
(30, 'Colesterol', 'Medición de niveles de colesterol', NULL),
(31, 'Triglicéridos', 'Medición de niveles de triglicéridos', NULL),
(32, 'Hemograma', 'Análisis completo de células sanguíneas', NULL),
(33, 'Glucosa', 'Medición de niveles de azúcar en sangre', NULL),
(35, 'Triglicéridos', 'Medición de niveles de triglicéridos', NULL),
(36, 'TSH', 'Prueba de función tiroidea', NULL),
(37, 'Creatinina', 'Evaluación de la función renal', NULL),
(38, 'Ácido Úrico', 'Medición de niveles de ácido úrico', NULL),
(39, 'Transaminasas', 'Evaluación de la función hepática', NULL),
(40, 'Urocultivo', 'Cultivo de orina para detectar infecciones', NULL),
(41, 'Prueba de embarazo', 'Detección de la hormona hCG', NULL),
(42, 'coresterol', 'medico veterinario', NULL),
(43, 'coresterol', 'medico veterinario', NULL),
(44, 'coresterol', 'medico veterinario', NULL),
(45, 'coresterol', 'medico veterinario', NULL),
(46, 'coresterol', 'medico veterinario', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lab_p_unidades`
--

CREATE TABLE `lab_p_unidades` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `abreviatura` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lab_p_unidades`
--

INSERT INTO `lab_p_unidades` (`id`, `nombre`, `abreviatura`) VALUES
(1, 'Miligramos por decilitro', 'mg/dL'),
(2, 'Gramos por decilitro', 'g/dL'),
(3, 'Miliunidades internacionales por litro', 'mUI/L'),
(4, 'Unidades de pH', 'pH'),
(5, 'Plaquetas por microlitro', 'plaquetas/'),
(6, 'Miliequivalentes por litro', 'mEq/L');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lab_p_valores_referencia`
--

CREATE TABLE `lab_p_valores_referencia` (
  `id` int(11) NOT NULL,
  `id_prueba` int(11) DEFAULT NULL,
  `sexo` varchar(10) DEFAULT NULL,
  `edad_min` int(11) DEFAULT NULL,
  `edad_max` int(11) DEFAULT NULL,
  `valor_min` decimal(10,2) DEFAULT NULL,
  `valor_max` decimal(10,2) DEFAULT NULL,
  `unidad` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lab_p_valores_referencia`
--

INSERT INTO `lab_p_valores_referencia` (`id`, `id_prueba`, `sexo`, `edad_min`, `edad_max`, `valor_min`, `valor_max`, `unidad`) VALUES
(1, 1, 'Ambos', 18, 99, 0.00, 200.00, 'mg/dL'),
(2, 2, 'Ambos', 18, 99, 0.00, 150.00, 'mg/dL'),
(3, 3, 'Masculino', 18, 99, 13.50, 17.50, 'g/dL'),
(4, 3, 'Femenino', 18, 99, 12.00, 15.50, 'g/dL'),
(5, 4, 'Ambos', 18, 99, 0.40, 4.00, 'mUI/L'),
(6, 5, 'Ambos', 18, 99, 7.35, 7.45, 'pH'),
(7, 6, 'Ambos', 18, 99, 150000.00, 450000.00, 'plaquetas/µL'),
(8, 7, 'Ambos', 18, 99, 135.00, 145.00, 'mEq/L');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lab_r_prueba_metodo_equipo`
--

CREATE TABLE `lab_r_prueba_metodo_equipo` (
  `id` int(11) NOT NULL,
  `id_prueba` int(11) DEFAULT NULL,
  `id_metodo` int(11) DEFAULT NULL,
  `id_equipo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lab_r_prueba_metodo_equipo`
--

INSERT INTO `lab_r_prueba_metodo_equipo` (`id`, `id_prueba`, `id_metodo`, `id_equipo`) VALUES
(1, 1, 1, 1),
(2, 2, 1, 1),
(3, 3, 2, 2),
(4, 4, 3, 3),
(5, 5, 4, 4),
(6, 6, 5, 5),
(7, 7, 6, 6);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `fac_m_tarjetero`
--
ALTER TABLE `fac_m_tarjetero`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_persona` (`id_persona`);

--
-- Indices de la tabla `gen_m_persona`
--
ALTER TABLE `gen_m_persona`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `gen_p_documento`
--
ALTER TABLE `gen_p_documento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `gen_p_lista_opcion`
--
ALTER TABLE `gen_p_lista_opcion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lab_m_orden`
--
ALTER TABLE `lab_m_orden`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_documento` (`id_documento`),
  ADD KEY `id_historia` (`id_historia`);

--
-- Indices de la tabla `lab_m_orden_detalle`
--
ALTER TABLE `lab_m_orden_detalle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_orden` (`id_orden`),
  ADD KEY `id_prueba` (`id_prueba`);

--
-- Indices de la tabla `lab_m_orden_resultados`
--
ALTER TABLE `lab_m_orden_resultados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_orden` (`id_orden`),
  ADD KEY `id_prueba` (`id_prueba`),
  ADD KEY `id_procedimiento` (`id_procedimiento`);

--
-- Indices de la tabla `lab_m_prueba`
--
ALTER TABLE `lab_m_prueba`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lab_p_equipos`
--
ALTER TABLE `lab_p_equipos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lab_p_grupos`
--
ALTER TABLE `lab_p_grupos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lab_p_metodos`
--
ALTER TABLE `lab_p_metodos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lab_p_procedimientos`
--
ALTER TABLE `lab_p_procedimientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_grupo_laboratorio` (`id_grupo_laboratorio`);

--
-- Indices de la tabla `lab_p_pruebas`
--
ALTER TABLE `lab_p_pruebas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_procedimiento` (`id_procedimiento`);

--
-- Indices de la tabla `lab_p_unidades`
--
ALTER TABLE `lab_p_unidades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lab_p_valores_referencia`
--
ALTER TABLE `lab_p_valores_referencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_prueba` (`id_prueba`);

--
-- Indices de la tabla `lab_r_prueba_metodo_equipo`
--
ALTER TABLE `lab_r_prueba_metodo_equipo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_prueba` (`id_prueba`),
  ADD KEY `id_metodo` (`id_metodo`),
  ADD KEY `id_equipo` (`id_equipo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `fac_m_tarjetero`
--
ALTER TABLE `fac_m_tarjetero`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `gen_m_persona`
--
ALTER TABLE `gen_m_persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `gen_p_documento`
--
ALTER TABLE `gen_p_documento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `gen_p_lista_opcion`
--
ALTER TABLE `gen_p_lista_opcion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `lab_m_orden`
--
ALTER TABLE `lab_m_orden`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT de la tabla `lab_m_orden_detalle`
--
ALTER TABLE `lab_m_orden_detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- AUTO_INCREMENT de la tabla `lab_m_orden_resultados`
--
ALTER TABLE `lab_m_orden_resultados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT de la tabla `lab_m_prueba`
--
ALTER TABLE `lab_m_prueba`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `lab_p_equipos`
--
ALTER TABLE `lab_p_equipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `lab_p_grupos`
--
ALTER TABLE `lab_p_grupos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `lab_p_metodos`
--
ALTER TABLE `lab_p_metodos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `lab_p_procedimientos`
--
ALTER TABLE `lab_p_procedimientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `lab_p_pruebas`
--
ALTER TABLE `lab_p_pruebas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `lab_p_unidades`
--
ALTER TABLE `lab_p_unidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `lab_p_valores_referencia`
--
ALTER TABLE `lab_p_valores_referencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `lab_r_prueba_metodo_equipo`
--
ALTER TABLE `lab_r_prueba_metodo_equipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `fac_m_tarjetero`
--
ALTER TABLE `fac_m_tarjetero`
  ADD CONSTRAINT `fac_m_tarjetero_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `gen_m_persona` (`id`);

--
-- Filtros para la tabla `lab_m_orden`
--
ALTER TABLE `lab_m_orden`
  ADD CONSTRAINT `lab_m_orden_ibfk_1` FOREIGN KEY (`id_documento`) REFERENCES `gen_p_documento` (`id`),
  ADD CONSTRAINT `lab_m_orden_ibfk_2` FOREIGN KEY (`id_historia`) REFERENCES `fac_m_tarjetero` (`id`);

--
-- Filtros para la tabla `lab_m_orden_detalle`
--
ALTER TABLE `lab_m_orden_detalle`
  ADD CONSTRAINT `lab_m_orden_detalle_ibfk_1` FOREIGN KEY (`id_orden`) REFERENCES `lab_m_orden` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lab_m_orden_detalle_ibfk_2` FOREIGN KEY (`id_prueba`) REFERENCES `lab_p_pruebas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `lab_m_orden_resultados`
--
ALTER TABLE `lab_m_orden_resultados`
  ADD CONSTRAINT `lab_m_orden_resultados_ibfk_1` FOREIGN KEY (`id_orden`) REFERENCES `lab_m_orden` (`id`),
  ADD CONSTRAINT `lab_m_orden_resultados_ibfk_2` FOREIGN KEY (`id_prueba`) REFERENCES `lab_p_pruebas` (`id`),
  ADD CONSTRAINT `lab_m_orden_resultados_ibfk_3` FOREIGN KEY (`id_procedimiento`) REFERENCES `lab_p_procedimientos` (`id`);

--
-- Filtros para la tabla `lab_p_procedimientos`
--
ALTER TABLE `lab_p_procedimientos`
  ADD CONSTRAINT `lab_p_procedimientos_ibfk_1` FOREIGN KEY (`id_grupo_laboratorio`) REFERENCES `lab_p_grupos` (`id`);

--
-- Filtros para la tabla `lab_p_pruebas`
--
ALTER TABLE `lab_p_pruebas`
  ADD CONSTRAINT `lab_p_pruebas_ibfk_1` FOREIGN KEY (`id_procedimiento`) REFERENCES `lab_p_procedimientos` (`id`);

--
-- Filtros para la tabla `lab_p_valores_referencia`
--
ALTER TABLE `lab_p_valores_referencia`
  ADD CONSTRAINT `lab_p_valores_referencia_ibfk_1` FOREIGN KEY (`id_prueba`) REFERENCES `lab_p_pruebas` (`id`);

--
-- Filtros para la tabla `lab_r_prueba_metodo_equipo`
--
ALTER TABLE `lab_r_prueba_metodo_equipo`
  ADD CONSTRAINT `lab_r_prueba_metodo_equipo_ibfk_1` FOREIGN KEY (`id_prueba`) REFERENCES `lab_p_pruebas` (`id`),
  ADD CONSTRAINT `lab_r_prueba_metodo_equipo_ibfk_2` FOREIGN KEY (`id_metodo`) REFERENCES `lab_p_metodos` (`id`),
  ADD CONSTRAINT `lab_r_prueba_metodo_equipo_ibfk_3` FOREIGN KEY (`id_equipo`) REFERENCES `lab_p_equipos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
