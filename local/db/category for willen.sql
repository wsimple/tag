-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-11-2013 a las 17:09:03
-- Versión del servidor: 5.5.32
-- Versión de PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `store_category`
--

DROP TABLE IF EXISTS `store_category`;
CREATE TABLE IF NOT EXISTS `store_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_status` int(11) DEFAULT NULL,
  `id_template` int(11) DEFAULT NULL,
  `name` mediumtext,
  `photo` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `store_category`
--

INSERT INTO `store_category` (`id`, `id_status`, `id_template`, `name`, `photo`) VALUES
(1, 1, 1068, 'STORE_CATEGORY_BACKGROUNS', ''),
(2, 1, 1070, 'STORE_CATEGORY_39fd62ca9ee5b676761bfdaf2860ea2b', ''),
(3, 1, 1075, 'STORE_CATEGORY_e4e4d02f84300d12be765e265f8fa284', '3/b4197c94979ba6088535ccb6b27e4c68.png'),
(7, 1, 1219, 'STORE_CATEGORY_696baa28ebdf671edd516b6d0914dc9a', '7/9b821601571ccbf4169b8612d466b394.png'),
(6, 1, 1218, 'STORE_CATEGORY_732aad380172d701261309c30a7b7914', '6/f6559ed6092fa28ad9c5b8f5ce3157ac.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `store_sub_category`
--

DROP TABLE IF EXISTS `store_sub_category`;
CREATE TABLE IF NOT EXISTS `store_sub_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_status` int(11) DEFAULT NULL,
  `id_category` int(11) DEFAULT NULL,
  `id_template` int(11) DEFAULT NULL,
  `name` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `store_sub_category`
--

INSERT INTO `store_sub_category` (`id`, `id_status`, `id_category`, `id_template`, `name`) VALUES
(1, 1, 1, 1069, 'STORE_SUBCATEGORY_ALLBG'),
(2, 1, 2, 1071, 'STORE_SUBCATEGORY_5800134073561c8e532819e8560ceaac'),
(3, 1, 2, 1072, 'STORE_SUBCATEGORY_83bbfeae54992e2d3007416f5bfc71c4'),
(4, 1, 2, 1073, 'STORE_SUBCATEGORY_c100b787ba4f88f5d30db810d570f26c'),
(5, 1, 2, 1074, 'STORE_SUBCATEGORY_e377adc4b19d77849a13797bb19547c4'),
(6, 1, 3, 1076, 'STORE_SUBCATEGORY_09630a5ab42b1748c6a8b11564289c68'),
(7, 1, 3, 1077, 'STORE_SUBCATEGORY_413909c349aab6743a9364cd0b8f57d2'),
(8, 1, 3, 1078, 'STORE_SUBCATEGORY_25bb7e884e6bfafffaeb251ea48e12d8'),
(9, 1, 7, 1220, 'STORE_SUBCATEGORY_636e97bacec6c15678be9f96023cad73'),
(10, 1, 6, 1221, 'STORE_SUBCATEGORY_33978272229a60ce8187be06bd821f8d'),
(11, 1, 7, 1222, 'STORE_SUBCATEGORY_4b4ffb60a7ab3094a7f370b6c284f6fc');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
