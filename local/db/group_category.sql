-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-03-2014 a las 16:47:39
-- Versión del servidor: 5.5.32
-- Versión de PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `seemytag`
--
CREATE DATABASE IF NOT EXISTS `seemytag` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `seemytag`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groups_category`
--

CREATE TABLE IF NOT EXISTS `groups_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `summary` mediumtext,
  `id_status` int(11) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `id_template` int(11) DEFAULT NULL,
  `id_template_sum` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;
UPDATE groups SET groups.id_category=1;
--
-- Volcado de datos para la tabla `groups_category`
--
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
