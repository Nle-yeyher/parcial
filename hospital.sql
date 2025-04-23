-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 23-04-2025 a las 22:29:43
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
-- Base de datos: `hospital`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cedes`
--

CREATE TABLE `cedes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `latitud` decimal(9,6) DEFAULT NULL,
  `longitud` decimal(9,6) DEFAULT NULL,
  `foto` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `ID_Cita` int(11) NOT NULL,
  `ID_Paciente` int(11) DEFAULT NULL,
  `ID_Medico` int(11) DEFAULT NULL,
  `Fecha_Cita` date DEFAULT NULL,
  `Hora_Cita` time DEFAULT NULL,
  `Motivo_Cita` text DEFAULT NULL,
  `Estado_Cita` enum('Pendiente','Confirmada','Cancelada') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturacion`
--

CREATE TABLE `facturacion` (
  `ID_Factura` int(11) NOT NULL,
  `ID_Paciente` int(11) DEFAULT NULL,
  `ID_Medico` int(11) DEFAULT NULL,
  `ID_Cita` int(11) DEFAULT NULL,
  `Fecha_Factura` date DEFAULT NULL,
  `pago_Total` decimal(10,2) DEFAULT NULL,
  `Descripción` text DEFAULT NULL,
  `Metodo_Pago` enum('Efectivo','Tarjeta','Transferencia') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formulas_medicas`
--

CREATE TABLE `formulas_medicas` (
  `ID_Formula` int(11) NOT NULL,
  `ID_Paciente` int(11) DEFAULT NULL,
  `ID_Medico` int(11) DEFAULT NULL,
  `ID_Medicamento` int(11) DEFAULT NULL,
  `Fecha_Formula` date DEFAULT NULL,
  `Indicaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones`
--

CREATE TABLE `habitaciones` (
  `ID_Habitacion` int(11) NOT NULL,
  `ID_Paciente` int(11) DEFAULT NULL,
  `Numero_Habitacion` varchar(10) DEFAULT NULL,
  `Tipo_Habitacion` enum('Individual','Doble','Suite') DEFAULT NULL,
  `Estado_Habitacion` enum('Disponible','Ocupada','Mantenimiento') DEFAULT NULL,
  `Costo_Habitacion` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_clinico`
--

CREATE TABLE `historial_clinico` (
  `ID_Historial` int(11) NOT NULL,
  `ID_Paciente` int(11) DEFAULT NULL,
  `Fecha_Historial` date DEFAULT NULL,
  `Descripción_Historial` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios_medicos`
--

CREATE TABLE `horarios_medicos` (
  `ID_Horario` int(11) NOT NULL,
  `ID_Medico` int(11) DEFAULT NULL,
  `Día` enum('Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo') DEFAULT NULL,
  `Hora_Inicio` time DEFAULT NULL,
  `Hora_Fin` time DEFAULT NULL,
  `Disponibilidad` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log`
--

CREATE TABLE `log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `accion` text DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicamentos`
--

CREATE TABLE `medicamentos` (
  `ID_Medicamento` int(11) NOT NULL,
  `Nombre_Medicamento` varchar(100) DEFAULT NULL,
  `Descripción_Medicamento` text DEFAULT NULL,
  `Dosis` varchar(50) DEFAULT NULL,
  `Frecuencia` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicos`
--

CREATE TABLE `medicos` (
  `ID_Medico` int(11) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Apellidos` varchar(50) DEFAULT NULL,
  `Especialidad` varchar(100) DEFAULT NULL,
  `Telefono` varchar(20) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Numero_Licencia` varchar(50) DEFAULT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `ID_Paciente` int(11) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Apellido` varchar(50) DEFAULT NULL,
  `Fecha_Nacimiento` date DEFAULT NULL,
  `barrio` varchar(100) DEFAULT NULL,
  `Ciudad` varchar(50) DEFAULT NULL,
  `Teléfono` varchar(20) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `tipo_sangre` varchar(5) DEFAULT NULL,
  `eps` varchar(100) DEFAULT NULL,
  `Genero` enum('Masculino','Femenino','Otro') DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tratamientos`
--

CREATE TABLE `tratamientos` (
  `ID_Tratamiento` int(11) NOT NULL,
  `ID_Historial` int(11) DEFAULT NULL,
  `Nombre_Tratamiento` varchar(100) DEFAULT NULL,
  `Descripción_Tratamiento` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `correo` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `rol` enum('admin','medico','paciente') DEFAULT NULL,
  `intentos_fallidos` int(11) DEFAULT 0,
  `bloqueado_hasta` datetime DEFAULT NULL,
  `clave` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `correo`, `contraseña`, `rol`, `intentos_fallidos`, `bloqueado_hasta`, `clave`) VALUES
(1, 'Yeyher', 'admin@gmail.com', '', 'admin', 4, '2025-04-23 15:18:41', '$2y$10$7AnD.BLepH81ljU9ZujbDuXNGCsaFNJ6KR26IuWVPqet/RbH/rOYC');

--
-- Disparadores `usuario`
--
DELIMITER $$
CREATE TRIGGER `trg_control_intentos` BEFORE UPDATE ON `usuario` FOR EACH ROW BEGIN
    IF NEW.intentos_fallidos >= 3 THEN
        SET NEW.bloqueado_hasta = NOW() + INTERVAL 2 MINUTE;
    END IF;
END
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cedes`
--
ALTER TABLE `cedes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`ID_Cita`),
  ADD KEY `citas_ibfk_1` (`ID_Paciente`),
  ADD KEY `citas_ibfk_2` (`ID_Medico`);

--
-- Indices de la tabla `facturacion`
--
ALTER TABLE `facturacion`
  ADD PRIMARY KEY (`ID_Factura`),
  ADD KEY `facturacion_ibfk_1` (`ID_Paciente`),
  ADD KEY `facturacion_ibfk_2` (`ID_Medico`),
  ADD KEY `facturacion_ibfk_3` (`ID_Cita`);

--
-- Indices de la tabla `formulas_medicas`
--
ALTER TABLE `formulas_medicas`
  ADD PRIMARY KEY (`ID_Formula`),
  ADD KEY `formulas_medicas_ibfk_1` (`ID_Paciente`),
  ADD KEY `formulas_medicas_ibfk_2` (`ID_Medico`),
  ADD KEY `formulas_medicas_ibfk_3` (`ID_Medicamento`);

--
-- Indices de la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  ADD PRIMARY KEY (`ID_Habitacion`),
  ADD KEY `habitaciones_ibfk_1` (`ID_Paciente`);

--
-- Indices de la tabla `historial_clinico`
--
ALTER TABLE `historial_clinico`
  ADD PRIMARY KEY (`ID_Historial`),
  ADD KEY `historial_clinico_ibfk_1` (`ID_Paciente`);

--
-- Indices de la tabla `horarios_medicos`
--
ALTER TABLE `horarios_medicos`
  ADD PRIMARY KEY (`ID_Horario`),
  ADD KEY `horarios_medicos_ibfk_1` (`ID_Medico`);

--
-- Indices de la tabla `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `medicamentos`
--
ALTER TABLE `medicamentos`
  ADD PRIMARY KEY (`ID_Medicamento`);

--
-- Indices de la tabla `medicos`
--
ALTER TABLE `medicos`
  ADD PRIMARY KEY (`ID_Medico`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`ID_Paciente`);

--
-- Indices de la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  ADD PRIMARY KEY (`ID_Tratamiento`),
  ADD KEY `tratamientos_ibfk_1` (`ID_Historial`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cedes`
--
ALTER TABLE `cedes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `log`
--
ALTER TABLE `log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cedes`
--
ALTER TABLE `cedes`
  ADD CONSTRAINT `cedes_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`ID_Paciente`) REFERENCES `pacientes` (`ID_Paciente`),
  ADD CONSTRAINT `citas_ibfk_2` FOREIGN KEY (`ID_Medico`) REFERENCES `medicos` (`ID_Medico`);

--
-- Filtros para la tabla `facturacion`
--
ALTER TABLE `facturacion`
  ADD CONSTRAINT `facturacion_ibfk_1` FOREIGN KEY (`ID_Paciente`) REFERENCES `pacientes` (`ID_Paciente`),
  ADD CONSTRAINT `facturacion_ibfk_2` FOREIGN KEY (`ID_Medico`) REFERENCES `medicos` (`ID_Medico`),
  ADD CONSTRAINT `facturacion_ibfk_3` FOREIGN KEY (`ID_Cita`) REFERENCES `citas` (`ID_Cita`);

--
-- Filtros para la tabla `formulas_medicas`
--
ALTER TABLE `formulas_medicas`
  ADD CONSTRAINT `formulas_medicas_ibfk_1` FOREIGN KEY (`ID_Paciente`) REFERENCES `pacientes` (`ID_Paciente`),
  ADD CONSTRAINT `formulas_medicas_ibfk_2` FOREIGN KEY (`ID_Medico`) REFERENCES `medicos` (`ID_Medico`),
  ADD CONSTRAINT `formulas_medicas_ibfk_3` FOREIGN KEY (`ID_Medicamento`) REFERENCES `medicamentos` (`ID_Medicamento`);

--
-- Filtros para la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  ADD CONSTRAINT `habitaciones_ibfk_1` FOREIGN KEY (`ID_Paciente`) REFERENCES `pacientes` (`ID_Paciente`) ON DELETE SET NULL;

--
-- Filtros para la tabla `historial_clinico`
--
ALTER TABLE `historial_clinico`
  ADD CONSTRAINT `historial_clinico_ibfk_1` FOREIGN KEY (`ID_Paciente`) REFERENCES `pacientes` (`ID_Paciente`);

--
-- Filtros para la tabla `horarios_medicos`
--
ALTER TABLE `horarios_medicos`
  ADD CONSTRAINT `horarios_medicos_ibfk_1` FOREIGN KEY (`ID_Medico`) REFERENCES `medicos` (`ID_Medico`);

--
-- Filtros para la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  ADD CONSTRAINT `tratamientos_ibfk_1` FOREIGN KEY (`ID_Historial`) REFERENCES `historial_clinico` (`ID_Historial`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
