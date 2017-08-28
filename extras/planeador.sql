-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-08-2017 a las 22:28:28
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `planeador`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detail_group`
--

CREATE TABLE `detail_group` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `start_time` time NOT NULL,
  `final_hour` time NOT NULL,
  `day` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `detail_group`
--

INSERT INTO `detail_group` (`id`, `group_id`, `start_time`, `final_hour`, `day`) VALUES
(1, 1, '06:00:00', '07:59:00', 1),
(2, 1, '06:00:00', '07:59:00', 3),
(3, 2, '06:00:00', '07:59:00', 2),
(4, 2, '06:00:00', '07:59:00', 4),
(5, 3, '18:00:00', '19:59:00', 1),
(6, 3, '18:00:00', '19:59:00', 3),
(7, 4, '18:00:00', '19:59:00', 2),
(8, 4, '18:00:00', '19:59:00', 4),
(9, 5, '06:00:00', '23:00:00', 7),
(10, 6, '12:00:00', '13:59:00', 3),
(11, 6, '12:00:00', '13:59:00', 5),
(12, 7, '12:00:00', '13:59:00', 1),
(13, 7, '12:00:00', '13:59:00', 2),
(14, 8, '18:00:00', '19:59:00', 1),
(15, 8, '18:00:00', '19:59:00', 2),
(16, 9, '06:00:00', '07:59:00', 1),
(17, 9, '06:00:00', '07:59:00', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `faculties`
--

CREATE TABLE `faculties` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `faculties`
--

INSERT INTO `faculties` (`id`, `name`) VALUES
(1, 'Administrativas, Contables y Económicas'),
(2, 'Derecho, Ciencias Políticas y Sociales'),
(3, 'Ingenierías Tecnológicas'),
(4, 'Bellas Artes'),
(5, 'Ciencias Básicas y de la Educación'),
(6, 'Ciencias de la Salud');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(9) NOT NULL,
  `max_capacity` int(11) NOT NULL COMMENT 'Capacidad maxima de alumnos',
  `current_quota` int(11) NOT NULL COMMENT 'Cantidad de alumnos actualmente',
  `subject_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `groups`
--

INSERT INTO `groups` (`id`, `name`, `max_capacity`, `current_quota`, `subject_id`, `teacher_id`) VALUES
(1, 'G1', 40, 0, 1, 1),
(2, 'G2', 40, 0, 1, 1),
(3, 'G3', 40, 0, 1, 2),
(4, 'G4', 40, 0, 1, 2),
(5, 'G1', 20, 0, 2, 3),
(6, 'G1', 40, 0, 3, 4),
(7, 'G2', 40, 0, 3, 4),
(8, 'G3', 40, 0, 3, 5),
(9, 'G4', 40, 0, 3, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programs`
--

CREATE TABLE `programs` (
  `id` int(11) NOT NULL,
  `faculty_code` int(11) NOT NULL COMMENT 'Foranea a la tabla faculties',
  `snies_code` varchar(15) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `programs`
--

INSERT INTO `programs` (`id`, `faculty_code`, `snies_code`, `name`) VALUES
(1, 1, '13976', 'Administración de Empresas'),
(2, 1, '1708', 'Contaduría Pública'),
(3, 1, '5244', 'Comercio Internacional'),
(4, 1, '7093', 'Economía'),
(5, 2, '7800', 'Derecho'),
(6, 2, '102932', 'Psicología'),
(7, 2, '9480', 'Sociología'),
(8, 3, '3237', 'Ingeniería Agroindustrial'),
(9, 3, '5095', 'Ingeniería de Sistemas'),
(10, 3, '7095', 'Ingeniería Electrónica'),
(11, 3, '7094', 'Ingeniería Ambiental y Sanitaria'),
(12, 4, '91337', 'Lic. En Arte, Folclor y Cultura'),
(13, 5, '11330', 'Lic. Lengua Castellana e Ingles'),
(14, 5, '11734', 'Lic. Ciencias Naturales y Educación Ambiental'),
(15, 5, '1705', 'Lic. Matemáticas y Física'),
(16, 6, '1706', 'Enfermería'),
(17, 6, '6686', 'Instrumentación Quirúrgica'),
(18, 6, '8444', 'Microbiología');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `code` varchar(15) NOT NULL,
  `name` varchar(255) NOT NULL,
  `credits` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `subjects`
--

INSERT INTO `subjects` (`id`, `code`, `name`, `credits`) VALUES
(1, 'FC406', 'INTRODUCCION A LA INGENIERIA DE SISTEMAS', 4),
(2, 'UPC08', 'ACTIVIDAD DEPORTIVA', 2),
(3, 'MT302B', 'CALCULO DIFERENCIAL', 4),
(4, 'UPC01', 'CATEDRA UPECISTA', 2),
(5, 'HM301', 'HUMANIDADES I', 3),
(6, 'UPC04', 'LENGUA EXTRANJERA-GRAMATICA', 2),
(7, 'MT310B', 'LOGICA, CONJUNTOS Y GRAFOS', 3),
(8, 'PG312', 'TECNICAS DE AUTOAPRENDIZAJE', 2),
(9, 'UPC09', 'ACTIVIDAD CULTURAL', 2),
(10, 'MT301B', 'ALGEBRA LINEAL', 3),
(11, 'MT303B', 'CALCULO INTEGRAL', 3),
(12, 'HM302', 'HUMANIDADES II ', 3),
(13, 'UPC05', 'LENGUA EXTRANJERA-LECTURA', 2),
(14, 'FS314', 'MECANICA ', 4),
(15, 'SS401', 'PROGRAMACION DE COMPUTADORES I', 4),
(16, 'MT304B', 'CALCULO MULTIVARIABLE', 4),
(17, 'FS311', 'ELECTROMAGNETISMO', 4),
(18, 'MT307B', 'ESTADISTICA DESCRIPTIVA E INFERENCIAL', 4),
(19, 'AE101', 'FUNDAMENTOS DE ADMINISTRACION', 3),
(20, 'SS402', 'PROGRAMACION DE COMPUTADORES II', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subjects_programs`
--

CREATE TABLE `subjects_programs` (
  `id` int(11) NOT NULL,
  `program_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `subjects_programs`
--

INSERT INTO `subjects_programs` (`id`, `program_id`, `subject_id`) VALUES
(201, 9, 1),
(202, 9, 2),
(203, 9, 3),
(204, 9, 4),
(205, 9, 5),
(206, 9, 6),
(207, 9, 7),
(208, 9, 8),
(209, 9, 9),
(210, 9, 10),
(211, 9, 11),
(212, 9, 12),
(213, 9, 13),
(214, 9, 14),
(215, 9, 15),
(216, 9, 16),
(217, 9, 17),
(218, 9, 18),
(219, 9, 19),
(220, 9, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `teachers`
--

INSERT INTO `teachers` (`id`, `name`) VALUES
(1, 'PROFESOR 1'),
(2, 'PROFESOR 2'),
(3, 'PROFESOR 3'),
(4, 'PROFESOR 4'),
(5, 'PROFESOR 5'),
(6, 'PROFESOR 6'),
(7, 'PROFESOR 7'),
(8, 'PROFESOR 8'),
(9, 'PROFESOR 9'),
(10, 'PROFESOR 10');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detail_group`
--
ALTER TABLE `detail_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group` (`group_id`);

--
-- Indices de la tabla `faculties`
--
ALTER TABLE `faculties`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indices de la tabla `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faculty_code` (`faculty_code`);

--
-- Indices de la tabla `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `subjects_programs`
--
ALTER TABLE `subjects_programs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faculty_id` (`program_id`),
  ADD KEY `subjet_id` (`subject_id`);

--
-- Indices de la tabla `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detail_group`
--
ALTER TABLE `detail_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT de la tabla `faculties`
--
ALTER TABLE `faculties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `programs`
--
ALTER TABLE `programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT de la tabla `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT de la tabla `subjects_programs`
--
ALTER TABLE `subjects_programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=221;
--
-- AUTO_INCREMENT de la tabla `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detail_group`
--
ALTER TABLE `detail_group`
  ADD CONSTRAINT `detail_group_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `groups_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `programs`
--
ALTER TABLE `programs`
  ADD CONSTRAINT `programs_ibfk_1` FOREIGN KEY (`faculty_code`) REFERENCES `faculties` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `subjects_programs`
--
ALTER TABLE `subjects_programs`
  ADD CONSTRAINT `subjects_programs_ibfk_1` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `subjects_programs_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
