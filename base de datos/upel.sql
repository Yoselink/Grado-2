-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2018 at 03:45 PM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `upel`
--

-- --------------------------------------------------------

--
-- Table structure for table `nivel`
--

CREATE TABLE `nivel` (
  `id_nivel` int(3) NOT NULL,
  `nombre_nivel` varchar(120) NOT NULL,
  `descripcion` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nivel`
--

INSERT INTO `nivel` (`id_nivel`, `nombre_nivel`, `descripcion`) VALUES
(1, 'Administrador', 'Super Usuario Del Sistema'),
(2, 'Prueba 2', 'Prueba'),
(3, 'Prueba 3', 'Encarg'),
(4, 'Prueba 4', 'Ajhsjk'),
(5, 'Prueba 5', 'Prueb'),
(6, 'Usuario', 'Usuario general de dependencias');

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) UNSIGNED NOT NULL,
  `nombre_producto` varchar(50) CHARACTER SET latin1 NOT NULL,
  `tipo` tinyint(1) UNSIGNED NOT NULL COMMENT '1 = Ganchos | 0 = Gomas',
  `descripcion` text CHARACTER SET latin1 NOT NULL,
  `modelo` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `cantidad` mediumint(5) NOT NULL,
  `registrado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre_producto`, `tipo`, `descripcion`, `modelo`, `cantidad`, `registrado`) VALUES
(1, 'Nombre', 0, 'Descripcion', 'Modelo', 7, '2018-02-04 16:36:20'),
(4, 'Gancho', 1, 'Descripcion', 'De ropa', 0, '2018-02-07 14:24:46'),
(5, 'otro gancho', 1, 'Cualquiera', 'De carne', 4, '2018-02-07 14:29:47');

-- --------------------------------------------------------

--
-- Table structure for table `salidas`
--

CREATE TABLE `salidas` (
  `id_salida` int(11) UNSIGNED NOT NULL,
  `id_user` int(11) UNSIGNED NOT NULL,
  `id_producto` int(11) UNSIGNED NOT NULL,
  `tipo` tinyint(1) UNSIGNED NOT NULL COMMENT '1 = Ganchos | 0 = Gomas',
  `contenido` varchar(150) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre, descripcion y modelo del producto',
  `cantidad` mediumint(5) UNSIGNED NOT NULL,
  `registrado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `salidas`
--

INSERT INTO `salidas` (`id_salida`, `id_user`, `id_producto`, `tipo`, `contenido`, `cantidad`, `registrado`) VALUES
(3, 10, 1, 0, '<b>Producto:</b> Nombre2<br><b>Descripcion:</b> Descripcion<br><b>Modelo:</b> Modelo', 3, '2018-02-04 19:49:31'),
(4, 10, 4, 1, '<b>Producto:</b> Gancho<br><b>Descripcion:</b> Descripcion<br><b>Modelo:</b> De ropa', 15, '2018-02-07 14:26:10'),
(5, 10, 5, 1, '<b>Producto:</b> Otro gancho<br><b>Descripcion:</b> Cualquiera<br><b>Modelo:</b> De carne', 1, '2018-02-07 14:29:59');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(120) NOT NULL,
  `cedula` int(11) NOT NULL,
  `nivel` int(11) NOT NULL,
  `password` varchar(75) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha_reg` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `email`, `nombre`, `apellido`, `cedula`, `nivel`, `password`, `fecha_reg`) VALUES
(1, 'User@prueba.com', 'User', 'User', 12345677, 1, '$2y$10$95g4vLAGDbJd8g3DbbOMB.jYxIK0pWqNyTZ7cgPhxSg21o.OrspIG', '2016-12-09 08:00:00'),
(6, 'Yoselin@prueba.com', 'Yoselin', 'Torres', 23791618, 2, '$2y$10$16QyZL0GzXgl4KJzQrXekebOzSMgNl0sXybHJTCZxu8CFHiE.sZlS', '2016-12-12 15:26:12'),
(7, 'Fran@gmail.com', 'Fran', 'Fran', 20990397, 3, '$2y$10$4UtpbuCYtOCLPMWPvrOwY.Sw.HicSdIm1CAcyK2DnBCNQ3COYi.7a', '2017-01-10 21:27:48'),
(8, 'Jefe@jefe.com', 'Jefe', 'Jeje', 1234567, 3, '$2y$10$Ber7/BJSB7EpQ0LazyW/CeEkoZd6mFsSWijkm9ZKQA4V1pl7GrHe6', '2017-01-29 23:35:17'),
(9, 'Prueba@prueba.com', 'Prueba', 'Prueba', 12345678, 1, '$2y$10$WwlzMI8jgpYzcVTvmOeozOB8DOUstftBOCk6ZDR2LWlduNwzUEBpW', '2009-01-01 05:48:37'),
(10, 'Yosi@prueba.com', 'Yoselin', 'Torres', 8689309, 1, '$2y$10$WbltcIXF7bK/mZFGXH1sseDjus0HuE004yGP.CU2.qqxHFAwHu4eS', '2018-01-29 12:27:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `nivel`
--
ALTER TABLE `nivel`
  ADD PRIMARY KEY (`id_nivel`);

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indexes for table `salidas`
--
ALTER TABLE `salidas`
  ADD PRIMARY KEY (`id_salida`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `nivel`
--
ALTER TABLE `nivel`
  MODIFY `id_nivel` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `salidas`
--
ALTER TABLE `salidas`
  MODIFY `id_salida` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
