-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-02-2020 a las 21:00:24
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `integrated_facade_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

CREATE TABLE `category` (
  `id_category` int(100) NOT NULL AUTO_INCREMENT,
  `id` int(100) DEFAULT NULL,
  `name` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `parent` int(100) DEFAULT NULL,
  `visible` int(100) DEFAULT NULL,
  `timemodified` text DEFAULT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `category`
--

INSERT INTO `category` (`id_category`, `id`, `name`, `description`, `parent`, `visible`, `timemodified`) VALUES
(1, 1, 'Robotica', 'Test', 0, 1, '2020-02-12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `course`
--

CREATE TABLE `course` (
  `id_course` int(100) NOT NULL AUTO_INCREMENT,
  `id` int(100) NOT NULL,
  `fullname` text NOT NULL,
  `categoryid` int(100) NOT NULL,
  `startdate` text NOT NULL,
  `enddate` text NOT NULL,
  `timecreated` text NOT NULL,
  `timemodified` text NOT NULL,
  PRIMARY KEY (`id_course`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `course`
--

INSERT INTO `course` (`id_course`, `id`, `fullname`, `categoryid`, `startdate`, `enddate`, `timecreated`, `timemodified`) VALUES
(1, 2, 'Prueba 1', 2, '1581462000', '1612998000', '1581461766', '1581461766');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `module`
--

CREATE TABLE `module` (
  `id_module_table` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `summary` text NOT NULL,
  `section` int(11) NOT NULL,
  `id_module` int(11) NOT NULL,
  `id_section` int(11) NOT NULL,
  `id_course` int(11) NOT NULL,
  PRIMARY KEY (`id_module_table`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `module`
--

INSERT INTO `module` (`id_module_table`, `id`, `name`, `summary`, `section`, `id_module`, `id_section`, `id_course`) VALUES
(1, 2, 'Modulo 1', 'Prueba', 1, 0, 0, 2),
(0, 7, 'Modulo 2', '', 0, 0, 0, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `Id` int(100) DEFAULT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Pass` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`Id`, `Name`, `Pass`) VALUES
(1, 'admin', 'MTIzNA==');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- DROP TABLE activity;
CREATE TABLE activity
(
  id_activity int(100) NOT NULL AUTO_INCREMENT,
  id int(100) NOT NULL,
  name text NOT NULL,
  courseid int(100) NOT NULL,
  moduleid int(100) NOT NULL,
  CONSTRAINT activity_pk PRIMARY KEY (id_activity)
)
ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE delivery
(
    id_delivery int PRIMARY key AUTO_INCREMENT,
    id int,
    itemmodule text,
    cmid int,
    grademin int,
    grademax int,
    graderaw int,
    gradedategraded text,
    feedback text,
    userid int
)
