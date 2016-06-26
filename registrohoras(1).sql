-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-06-2016 a las 17:42:42
-- Versión del servidor: 10.1.10-MariaDB
-- Versión de PHP: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `registrohoras`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacion`
--

CREATE TABLE `asignacion` (
  `id_asignacion` int(11) NOT NULL,
  `id_proyecto` int(2) NOT NULL,
  `id_usuario` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `asignacion`
--

INSERT INTO `asignacion` (`id_asignacion`, `id_proyecto`, `id_usuario`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 1, 2),
(4, 3, 4),
(5, 2, 4),
(6, 4, 1),
(7, 4, 3),
(8, 1, 3),
(9, 1, 4),
(10, 3, 3),
(11, 2, 1),
(12, 3, 1),
(13, 1, 5),
(14, 3, 5),
(15, 12, 2),
(16, 12, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargahoras`
--

CREATE TABLE `cargahoras` (
  `id_cargahoras` int(11) NOT NULL,
  `id_proyecto` int(3) NOT NULL,
  `id_usuario` int(3) NOT NULL,
  `id_semana` int(2) NOT NULL,
  `horas` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cargahoras`
--

INSERT INTO `cargahoras` (`id_cargahoras`, `id_proyecto`, `id_usuario`, `id_semana`, `horas`) VALUES
(3, 1, 1, 18, 10),
(11, 3, 3, 20, 1),
(12, 3, 3, 20, 1),
(21, 2, 1, 18, 12),
(22, 2, 1, 18, 12),
(23, 1, 1, 19, 6),
(26, 1, 1, 19, 2),
(31, 2, 1, 20, 7),
(33, 1, 3, 20, 12),
(35, 1, 1, 20, 10),
(36, 3, 1, 20, 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE `proyectos` (
  `id_proyecto` int(11) NOT NULL,
  `proyecto` varchar(255) NOT NULL,
  `inactivo` tinyint(1) DEFAULT NULL,
  `proyecto_id_tipo` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `proyectos`
--

INSERT INTO `proyectos` (`id_proyecto`, `proyecto`, `inactivo`, `proyecto_id_tipo`) VALUES
(1, 'Atlas', NULL, 4),
(2, 'Hercules', NULL, 5),
(3, 'Renovation VN', NULL, 4),
(4, 'AML 2', 1, 4),
(5, 'ProyectoPrueba', NULL, 5),
(6, 'Proyecto', NULL, 5),
(7, 'pro', NULL, 0),
(8, 'proy', NULL, 0),
(9, 'good', NULL, 0),
(10, 'df', NULL, 0),
(11, 'Mou', NULL, 0),
(12, 'FIJA', NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `semanas`
--

CREATE TABLE `semanas` (
  `id_semana` int(11) NOT NULL,
  `semana` varchar(3) NOT NULL,
  `horas_habiles` int(2) NOT NULL,
  `mes` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `semanas`
--

INSERT INTO `semanas` (`id_semana`, `semana`, `horas_habiles`, `mes`) VALUES
(1, 'S1', 40, 1),
(2, 'S2', 40, 1),
(3, 'S3', 40, 1),
(4, 'S4', 40, 1),
(5, 'S5', 32, 2),
(6, 'S6', 40, 2),
(7, 'S7', 32, 2),
(8, 'S8', 40, 2),
(9, 'S9', 40, 3),
(11, 'S11', 40, 3),
(12, 'S12', 40, 3),
(13, 'S13', 32, 3),
(14, 'S14', 40, 4),
(15, 'S15', 40, 4),
(16, 'S16', 40, 4),
(17, 'S17', 40, 4),
(18, 'S18', 40, 5),
(19, 'S19', 40, 5),
(20, 'S20', 40, 5),
(21, 'S21', 40, 5),
(22, 'S22', 40, 6),
(23, 'S23', 40, 6),
(24, 'S24', 40, 6),
(25, 'S25', 40, 6),
(26, 'S26', 32, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_proyecto`
--

CREATE TABLE `tipo_proyecto` (
  `id_tipo` int(11) NOT NULL,
  `tipo_description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_proyecto`
--

INSERT INTO `tipo_proyecto` (`id_tipo`, `tipo_description`) VALUES
(1, 'Capacitacion Interna'),
(2, 'Ausencias'),
(3, 'Infraestructura'),
(4, 'Desarrollo'),
(5, 'Capacitacion');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `user_rol` int(11) NOT NULL DEFAULT '2',
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL DEFAULT 'root',
  `sueldo` decimal(5,0) NOT NULL,
  `costo` int(5) NOT NULL,
  `costo_semanal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `usuario`, `user_rol`, `email`, `password`, `sueldo`, `costo`, `costo_semanal`) VALUES
(1, 'Pablo', 2, 'pablo@admin.com', 'admin', '1000', 1408, 352),
(2, 'Nahuel', 2, '', '', '1000', 1408, 352),
(3, 'Sebas', 2, '', '', '1200', 1690, 423),
(4, 'admin', 9, 'admin@admin.com', 'root', '1000', 1408, 352),
(5, 'Mou', 2, '', 'root', '10000', 14083, 3521);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignacion`
--
ALTER TABLE `asignacion`
  ADD PRIMARY KEY (`id_asignacion`);

--
-- Indices de la tabla `cargahoras`
--
ALTER TABLE `cargahoras`
  ADD PRIMARY KEY (`id_cargahoras`);

--
-- Indices de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`id_proyecto`);

--
-- Indices de la tabla `semanas`
--
ALTER TABLE `semanas`
  ADD PRIMARY KEY (`id_semana`);

--
-- Indices de la tabla `tipo_proyecto`
--
ALTER TABLE `tipo_proyecto`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignacion`
--
ALTER TABLE `asignacion`
  MODIFY `id_asignacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT de la tabla `cargahoras`
--
ALTER TABLE `cargahoras`
  MODIFY `id_cargahoras` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `id_proyecto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `semanas`
--
ALTER TABLE `semanas`
  MODIFY `id_semana` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT de la tabla `tipo_proyecto`
--
ALTER TABLE `tipo_proyecto`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
