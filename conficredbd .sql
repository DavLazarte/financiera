-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-09-2017 a las 22:27:22
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `conficredbd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activo`
--

CREATE TABLE `activo` (
  `idcredito` int(11) NOT NULL,
  `zona` varchar(5) NOT NULL,
  `cliente` varchar(45) NOT NULL,
  `saldo` decimal(11,2) NOT NULL,
  `proyeccion` int(11) NOT NULL,
  `vencimiento` datetime NOT NULL,
  `estado` varchar(15) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `activo`
--

INSERT INTO `activo` (`idcredito`, `zona`, `cliente`, `saldo`, `proyeccion`, `vencimiento`, `estado`, `created_at`, `updated_at`) VALUES
(56, 'Z1 ', 'Kermes Blanca ', '200.00', 300, '2017-09-15 00:00:00', 'Refinanciado', '2017-09-05 21:01:40', '2017-09-13 20:22:57'),
(57, 'Z2 ', 'Lara Rafael  ', '360.00', 227, '2017-09-30 00:00:00', 'Activo', '2017-09-14 00:42:38', '2017-09-14 00:43:03');

--
-- Disparadores `activo`
--
DELIMITER $$
CREATE TRIGGER `tr_updEstado` AFTER INSERT ON `activo` FOR EACH ROW BEGIN
	
    UPDATE venta SET estado = 'Activo'
	WHERE venta.idventa= NEW.idcredito;
    
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `idcaja` int(11) NOT NULL,
  `totalingreso` decimal(11,2) NOT NULL,
  `totalsalida` decimal(11,2) NOT NULL,
  `totalsuma` decimal(11,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `estado` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `caja`
--

INSERT INTO `caja` (`idcaja`, `totalingreso`, `totalsalida`, `totalsuma`, `created_at`, `updated_at`, `estado`) VALUES
(1, '0.00', '0.00', '0.00', NULL, NULL, 'Abierta');

--
-- Disparadores `caja`
--
DELIMITER $$
CREATE TRIGGER `caja_AFTER_INSERT` AFTER INSERT ON `caja` FOR EACH ROW BEGIN

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cobranza`
--

CREATE TABLE `cobranza` (
  `idcobranza` int(11) NOT NULL,
  `idventa` int(11) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `zona` varchar(15) NOT NULL,
  `monto` decimal(11,2) NOT NULL,
  `estado` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cobranza`
--

INSERT INTO `cobranza` (`idcobranza`, `idventa`, `fecha_hora`, `zona`, `monto`, `estado`, `created_at`, `updated_at`) VALUES
(102, 56, '2017-09-05 00:00:00', 'Z1', '1600.00', 'Activo', '2017-09-05 21:05:01', '2017-09-05 21:05:01'),
(103, 56, '2017-09-13 00:00:00', 'Z0', '300.00', 'Activo', '2017-09-13 20:23:21', '2017-09-13 20:23:21'),
(104, 57, '2017-09-20 00:00:00', 'Z1', '1000.00', 'Activo', '2017-09-14 01:11:05', '2017-09-14 01:11:05');

--
-- Disparadores `cobranza`
--
DELIMITER $$
CREATE TRIGGER `tr_updSaldo` AFTER INSERT ON `cobranza` FOR EACH ROW BEGIN
	
    UPDATE activo SET saldo= saldo -NEW.monto
	WHERE activo.idcredito= NEW.idventa && estado='Activo';
    
    
    UPDATE refinanciacion SET saldo= saldo-NEW.monto
	WHERE refinanciacion.credito= NEW.idventa&& estado='Activo';
    
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_caja`
--

CREATE TABLE `detalle_caja` (
  `iddetalle_caja` int(11) NOT NULL,
  `caja` int(11) NOT NULL,
  `zonaingreso` varchar(15) DEFAULT NULL,
  `ingreso` int(11) NOT NULL,
  `montoingreso` decimal(11,2) NOT NULL,
  `zonasalida` varchar(15) NOT NULL,
  `salida` int(11) NOT NULL,
  `concepto` varchar(45) NOT NULL,
  `montosalida` decimal(11,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `estado` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Disparadores `detalle_caja`
--
DELIMITER $$
CREATE TRIGGER `tr_updCaja` AFTER INSERT ON `detalle_caja` FOR EACH ROW BEGIN
	UPDATE ingreso SET estado = 'Cerrado'
	WHERE ingreso.idingreso = NEW.ingreso;
    UPDATE salida SET estado = 'Cerrada'
	WHERE salida.idsalida= NEW.salida;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_liquidacion`
--

CREATE TABLE `detalle_liquidacion` (
  `iddetalle_liquidacion` int(11) NOT NULL,
  `idliquidacion` int(11) NOT NULL,
  `zona` varchar(5) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime NOT NULL,
  `cobranza` decimal(11,2) NOT NULL,
  `comision` decimal(11,2) NOT NULL,
  `anticipo` decimal(11,2) NOT NULL,
  `premio` decimal(11,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso`
--

CREATE TABLE `ingreso` (
  `idingreso` int(11) NOT NULL,
  `zona` varchar(10) NOT NULL,
  `empleado` int(11) NOT NULL,
  `monto` decimal(11,2) NOT NULL,
  `concepto` varchar(50) NOT NULL,
  `estado` varchar(12) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ingreso`
--

INSERT INTO `ingreso` (`idingreso`, `zona`, `empleado`, `monto`, `concepto`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Z2', 37, '1000.00', 'cobranza', 'activo', '2017-09-14 00:36:13', '2017-09-14 00:36:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `liquidacion`
--

CREATE TABLE `liquidacion` (
  `idliquidacion` int(11) NOT NULL,
  `empleado` int(11) NOT NULL,
  `periodo` varchar(25) NOT NULL,
  `totalrec` decimal(11,2) NOT NULL,
  `total_comision` decimal(11,2) NOT NULL,
  `total` decimal(11,2) NOT NULL,
  `estado` varchar(15) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `idpersona` int(11) NOT NULL,
  `nombre_apellido` varchar(60) NOT NULL,
  `dni` varchar(15) NOT NULL,
  `domicilio` varchar(45) NOT NULL,
  `telefono` varchar(25) NOT NULL,
  `tipo` varchar(45) NOT NULL,
  `estado` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`idpersona`, `nombre_apellido`, `dni`, `domicilio`, `telefono`, `tipo`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Ferrari Jose Luis', '00000001', 'Terminal de Omnibus-Remisero', '3863503438', 'Cliente', 'Activo', '2017-07-18 02:07:20', '2017-07-18 02:07:20'),
(2, 'Norry Ariel Exequiel', '00000002', 'Barrio 105- Monteros', '3813529939', 'Cliente', 'Activo', '2017-07-18 02:08:33', '2017-07-18 02:08:33'),
(3, 'Isijara David ', '00000003', 'Desconocido', '3863519699', 'Cliente', 'Activo', '2017-07-18 02:09:32', '2017-07-18 02:09:32'),
(4, 'Montero Ariel', '00000004', 'Desconocido', '3863408355', 'Cliente', 'Activo', '2017-07-18 02:10:35', '2017-07-18 02:10:35'),
(5, 'Lara Rafael ', '00000006', 'Desconocido', '3863515438', 'Cliente', 'Activo', '2017-07-18 02:11:54', '2017-07-18 02:11:54'),
(6, 'Gomez Julieta ', '00000007', 'Cerca del Gimnasio', '3863442881', 'Cliente', 'Activo', '2017-07-18 02:14:26', '2017-07-18 02:14:26'),
(7, 'Chirre Walter', '00000008', 'Desconocido', '0000000000', 'Cliente', 'Activo', '2017-07-18 02:15:39', '2017-07-18 02:15:39'),
(8, 'Tula Maria Matilde', '00000009', 'Barrio San Carlos', '3863435004', 'Cliente', 'Activo', '2017-07-18 02:16:44', '2017-07-18 02:16:44'),
(9, 'Paliza Rita del Señor', '00000010', 'Barrio San Carlos', '381518145', 'Cliente', 'Activo', '2017-07-18 02:17:47', '2017-07-18 02:17:47'),
(10, 'Zamorano Soledad', '00000011', 'Santa Lucia', '3863698666', 'Cliente', 'Activo', '2017-07-18 02:18:53', '2017-07-18 02:18:53'),
(11, 'Lopez Jose Emilio', '00000012', 'Barrio 44 viviendas', '3863511095', 'Cliente', 'Activo', '2017-07-18 02:19:38', '2017-07-18 02:19:38'),
(12, 'Herrera Natalia', '00000013', 'Santa Lucia', '000000000', 'Cliente', 'Activo', '2017-07-18 02:20:09', '2017-07-18 02:20:09'),
(13, 'Corroto Romina', '00000013', 'Barrio Belgrano- Monteros', '3863433068', 'Cliente', 'Activo', '2017-07-18 02:21:11', '2017-07-18 02:21:11'),
(14, 'Paez Franco ', '00000014', 'Desconocido', '3863512794', 'Cliente', 'Activo', '2017-07-18 02:22:01', '2017-07-18 02:22:01'),
(15, 'Gomez Jose Gregorio', '0000015', 'Cerca del Gimnasio', '3863403383', 'Cliente', 'Activo', '2017-07-18 02:22:51', '2017-07-18 02:22:51'),
(16, 'Aguilar Madrid Liliana', '00000016', 'Colon n° 60', '3815791504', 'Cliente', 'Activo', '2017-07-18 02:24:42', '2017-07-18 02:24:42'),
(17, 'Pereyra Gustavo', '00000017', 'Gomeria de la san martin', '00000', 'Cliente', 'Activo', '2017-07-18 02:25:22', '2017-07-18 02:25:22'),
(18, 'Quinteros Lina', '00000018', 'Sold. Maldonado', '3863413341', 'Cliente', 'Activo', '2017-07-18 02:31:48', '2017-07-18 02:31:48'),
(19, 'Herrera Noelia ', '00000019', 'Santa Lucia', '3863690149', 'Cliente', 'Activo', '2017-07-18 02:32:36', '2017-07-18 02:32:36'),
(20, 'Ovejero Mauricio', '00000020', 'Barrio Belgrano-Panaderia', '38159597778', 'Cliente', 'Activo', '2017-07-18 02:34:33', '2017-07-18 02:34:33'),
(21, 'Rivero Hector Daniel', '0000021', 'Barrio Belgrano', '', 'Cliente', 'Activo', '2017-07-18 02:35:11', '2017-07-18 02:35:11'),
(22, 'Graneros Ramon Gabriel', '00000022', 'Desconocido', '3863435243', 'Cliente', 'Activo', '2017-07-18 20:02:21', '2017-07-18 20:02:21'),
(23, 'Osorio Alejandro', '00000023', 'Desconocido', '3815096927', 'Cliente', 'Activo', '2017-07-18 20:03:28', '2017-07-18 20:03:28'),
(24, 'Paz Maria Celeste', '00000024', 'Santiago 280- Monteros', '3863505212', 'Cliente', 'Activo', '2017-07-18 20:05:32', '2017-07-18 20:05:32'),
(25, 'Rivera Esteban Emmanuel', '00000025', 'Desconocido', '3816336845', 'Cliente', 'Activo', '2017-07-18 20:06:33', '2017-07-18 20:06:33'),
(26, 'Fernandez Silvia', '00000026', 'Desconocido', '3815453304', 'Cliente', 'Activo', '2017-07-18 20:07:26', '2017-07-18 20:07:26'),
(27, 'Rodriguez Catalina', '00000026', 'Desconocido', '3863430525', 'Cliente', 'Activo', '2017-07-18 20:08:32', '2017-07-18 20:08:32'),
(28, 'Paez Marcela Carolina', '00000027', 'Terminal de Obmnibus', '3815651001', 'Cliente', 'Activo', '2017-07-18 20:10:03', '2017-07-18 20:10:03'),
(29, 'Alderete Cesar', '00000028', 'Maldonado', '00000000', 'Cliente', 'Activo', '2017-07-18 20:10:36', '2017-07-18 20:10:36'),
(30, 'Bravo Silvana', '00000029', 'Barrio 105- al frente de la escuela especial-', '3816310034', 'Cliente', 'Activo', '2017-07-18 20:11:42', '2017-07-18 20:11:42'),
(31, 'Pereyra Silvia  Mabel', '00000030', 'Santa Lucia', '38120208731', 'Cliente', 'Activo', '2017-07-18 20:12:44', '2017-07-18 20:12:44'),
(32, 'Lamm Leonardo ', '00000031', 'Barrio Belgrano', '3863409004', 'Cliente', 'Activo', '2017-07-18 20:14:25', '2017-07-18 20:14:25'),
(33, 'Nuñez Deolinda', '00000032', 'San Carlos', '3863561188', 'Cliente', 'Activo', '2017-07-18 20:15:35', '2017-07-18 20:15:35'),
(34, 'Morales Alicia ', '00000033', 'Desconocido', '3863695672', 'Cliente', 'Activo', '2017-07-18 20:16:55', '2017-07-18 20:16:55'),
(35, 'Jalif Hector', '00000034', 'Desconocido', '000000000', 'Cliente', 'Activo', '2017-07-18 20:17:27', '2017-07-18 20:17:27'),
(36, 'Barrionuevo Elsa', '00000035', 'El Tejar', '3865266418', 'Cliente', 'Activo', '2017-07-18 20:18:17', '2017-07-18 20:18:17'),
(37, 'Lazarte David', '36527542', 'Ruta 344 km 7-Los Sosa- Monteros', '3863515328', 'Empleado', 'Activo', '2017-07-18 20:20:02', '2017-07-18 20:20:02'),
(38, 'Guillemot Ana', '28939922', 'Barrio Belgrano', '333333333', 'Cliente', 'Activo', '2017-07-24 22:29:04', '2017-07-24 22:29:04'),
(40, 'Suarez Analia', '8993003', 'Peluqueria Celeste', '3337848', 'Cliente', 'Activo', '2017-07-24 23:57:43', '2017-07-24 23:57:43'),
(41, 'Robles Octavio', '3456644', 'Taller del Padre', '2992993', 'Cliente', 'Activo', '2017-07-25 18:36:52', '2017-07-25 18:36:52'),
(42, 'Kermes Blanca', '17182889', 'B° Aeroclub casa verde', '2727282', 'Cliente', 'Activo', '2017-08-31 19:05:11', '2017-09-02 16:50:15'),
(43, 'Miranda  Dante', '34241221', 'San Lorenzo n 122', '112314', 'Empleado', 'Activo', '2017-09-03 21:31:04', '2017-09-03 21:31:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `refinanciacion`
--

CREATE TABLE `refinanciacion` (
  `idrefinanciacion` int(11) NOT NULL,
  `credito` int(11) NOT NULL,
  `cliente` varchar(45) NOT NULL,
  `saldo` decimal(11,2) NOT NULL,
  `plan` varchar(15) NOT NULL,
  `vencimiento` datetime NOT NULL,
  `estado` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `refinanciacion`
--

INSERT INTO `refinanciacion` (`idrefinanciacion`, `credito`, `cliente`, `saldo`, `plan`, `vencimiento`, `estado`, `created_at`, `updated_at`) VALUES
(1, 57, 'Lara Rafael   ', '360.00', '0', '0000-00-00 00:00:00', 'Activo', '2017-09-26 19:54:00', '2017-09-26 19:54:00'),
(2, 56, 'Kermes Blanca  ', '200.00', '0', '0000-00-00 00:00:00', 'Activo', '2017-09-26 20:10:51', '2017-09-26 20:10:51');

--
-- Disparadores `refinanciacion`
--
DELIMITER $$
CREATE TRIGGER `ref_estado` AFTER INSERT ON `refinanciacion` FOR EACH ROW BEGIN
	
    UPDATE activo SET estado = 'Refinanciado'
	WHERE activo.idcredito= NEW.credito;
    
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resumen`
--

CREATE TABLE `resumen` (
  `idresumen` int(11) NOT NULL,
  `zona` varchar(5) NOT NULL,
  `ingreso_semana` decimal(11,2) NOT NULL,
  `salida_semana` decimal(11,2) NOT NULL,
  `anticipo` decimal(11,2) NOT NULL,
  `estado` varchar(15) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salida`
--

CREATE TABLE `salida` (
  `idsalida` int(11) NOT NULL,
  `zona` varchar(15) NOT NULL,
  `monto` decimal(11,2) NOT NULL,
  `concepto` varchar(45) NOT NULL,
  `observaciones` varchar(55) NOT NULL,
  `estado` varchar(15) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `salida`
--

INSERT INTO `salida` (`idsalida`, `zona`, `monto`, `concepto`, `observaciones`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Z2', '100.00', 'anticipo', '', 'activo', '2017-09-14 00:36:48', '2017-09-14 00:36:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Z2', 'dav.lazarte@gmail.com', '$2y$10$sQJEuckva6xkvYRIbcMbL.umcCMgfciI3FI0TkMVn5LqCD0iNv1OG', 'ciR7nd7RlGQgamC4sgd2jBTL41YNFT1AGwqrxW7JR1HQa0A9cPrAmWnEWo7U', '2017-06-20 20:45:47', '2017-09-14 19:06:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `idventa` int(11) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `zona` varchar(5) NOT NULL,
  `idpersona` int(11) NOT NULL,
  `monto` decimal(11,2) NOT NULL,
  `plan` varchar(45) NOT NULL,
  `fecha_cancela` datetime NOT NULL,
  `concepto` varchar(45) NOT NULL,
  `empleado` varchar(45) NOT NULL,
  `estado` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`idventa`, `fecha_hora`, `zona`, `idpersona`, `monto`, `plan`, `fecha_cancela`, `concepto`, `empleado`, `estado`, `created_at`, `updated_at`) VALUES
(56, '2017-09-05 00:00:00', 'Z1', 42, '1000.00', '1', '2017-10-05 00:00:00', 'recuperacion', 'leo', 'Pendiente', '2017-09-05 21:01:14', '2017-09-05 21:01:14'),
(57, '2017-09-19 00:00:00', 'Z2', 5, '1000.00', '5', '2017-09-30 00:00:00', 'nuevo', 'dante', 'Activo', '2017-09-14 00:42:28', '2017-09-14 00:42:28');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `activo`
--
ALTER TABLE `activo`
  ADD PRIMARY KEY (`idcredito`);

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`idcaja`);

--
-- Indices de la tabla `cobranza`
--
ALTER TABLE `cobranza`
  ADD PRIMARY KEY (`idcobranza`),
  ADD KEY `idventa_idx` (`idventa`);

--
-- Indices de la tabla `detalle_caja`
--
ALTER TABLE `detalle_caja`
  ADD PRIMARY KEY (`iddetalle_caja`),
  ADD KEY `caja_idx` (`caja`),
  ADD KEY `ingreso_idx` (`ingreso`),
  ADD KEY `salida_idx` (`salida`);

--
-- Indices de la tabla `detalle_liquidacion`
--
ALTER TABLE `detalle_liquidacion`
  ADD PRIMARY KEY (`iddetalle_liquidacion`),
  ADD KEY `liquidacion_idx` (`idliquidacion`);

--
-- Indices de la tabla `ingreso`
--
ALTER TABLE `ingreso`
  ADD PRIMARY KEY (`idingreso`),
  ADD KEY `cobrador_idx` (`empleado`);

--
-- Indices de la tabla `liquidacion`
--
ALTER TABLE `liquidacion`
  ADD PRIMARY KEY (`idliquidacion`),
  ADD KEY `empleado_idx` (`empleado`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`idpersona`);

--
-- Indices de la tabla `refinanciacion`
--
ALTER TABLE `refinanciacion`
  ADD PRIMARY KEY (`idrefinanciacion`),
  ADD KEY `idventa_idx` (`credito`);

--
-- Indices de la tabla `resumen`
--
ALTER TABLE `resumen`
  ADD PRIMARY KEY (`idresumen`);

--
-- Indices de la tabla `salida`
--
ALTER TABLE `salida`
  ADD PRIMARY KEY (`idsalida`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`idventa`),
  ADD KEY `idpersona_idx` (`idpersona`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `idcaja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `cobranza`
--
ALTER TABLE `cobranza`
  MODIFY `idcobranza` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;
--
-- AUTO_INCREMENT de la tabla `detalle_caja`
--
ALTER TABLE `detalle_caja`
  MODIFY `iddetalle_caja` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `detalle_liquidacion`
--
ALTER TABLE `detalle_liquidacion`
  MODIFY `iddetalle_liquidacion` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `ingreso`
--
ALTER TABLE `ingreso`
  MODIFY `idingreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `liquidacion`
--
ALTER TABLE `liquidacion`
  MODIFY `idliquidacion` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `idpersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT de la tabla `refinanciacion`
--
ALTER TABLE `refinanciacion`
  MODIFY `idrefinanciacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `resumen`
--
ALTER TABLE `resumen`
  MODIFY `idresumen` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `salida`
--
ALTER TABLE `salida`
  MODIFY `idsalida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `idventa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `activo`
--
ALTER TABLE `activo`
  ADD CONSTRAINT `credito` FOREIGN KEY (`idcredito`) REFERENCES `venta` (`idventa`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cobranza`
--
ALTER TABLE `cobranza`
  ADD CONSTRAINT `idventa` FOREIGN KEY (`idventa`) REFERENCES `venta` (`idventa`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_caja`
--
ALTER TABLE `detalle_caja`
  ADD CONSTRAINT `caja` FOREIGN KEY (`caja`) REFERENCES `caja` (`idcaja`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ingreso` FOREIGN KEY (`ingreso`) REFERENCES `ingreso` (`idingreso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `salida` FOREIGN KEY (`salida`) REFERENCES `salida` (`idsalida`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_liquidacion`
--
ALTER TABLE `detalle_liquidacion`
  ADD CONSTRAINT `liquidacion` FOREIGN KEY (`idliquidacion`) REFERENCES `liquidacion` (`idliquidacion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ingreso`
--
ALTER TABLE `ingreso`
  ADD CONSTRAINT `cobrador` FOREIGN KEY (`empleado`) REFERENCES `persona` (`idpersona`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `liquidacion`
--
ALTER TABLE `liquidacion`
  ADD CONSTRAINT `empleado` FOREIGN KEY (`empleado`) REFERENCES `persona` (`idpersona`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `idpersona` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`idpersona`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
