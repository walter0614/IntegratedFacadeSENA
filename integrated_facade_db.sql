-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-02-2020 a las 21:28:35
-- Versión del servidor: 10.3.16-MariaDB
-- Versión de PHP: 7.1.30

SET SQL_MODE
= "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT
= 0;
START TRANSACTION;
SET time_zone
= "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: integrated_facade_db
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla category
--

CREATE TABLE category
(
  id_category int(100) DEFAULT NULL,
  id int(100) DEFAULT NULL,
  name text DEFAULT NULL,
  description text DEFAULT NULL,
  parent int(100) DEFAULT NULL,
  visible int(100) DEFAULT NULL,
  timemodified date DEFAULT NULL
)
ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla category
--

INSERT INTO category
  (id_category, id, name, description, parent, visible, timemodified)
VALUES
  (1, 1, 'Robotica', 'Test', 0, 1, '2020-02-12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla user
--

CREATE TABLE user
(
  Id int(100) DEFAULT NULL,
  Name varchar(100) DEFAULT NULL,
  Pass varchar(100) DEFAULT NULL
)
ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla user
--

INSERT INTO user
  (Id, Name, Pass)
VALUES
  (1, 'admin', 'MTIzNA==');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

drop table category;
CREATE TABLE category
(
  id_category int(100) DEFAULT NULL,
  id int(100) DEFAULT NULL,
  name text DEFAULT NULL,
  description text DEFAULT NULL,
  parent int(100) DEFAULT NULL,
  visible int(100) DEFAULT NULL,
  timemodified text DEFAULT NULL
)
ENGINE=InnoDB DEFAULT CHARSET=latin1

CREATE TABLE course
(
  id_course int(100) NOT NULL,
  id int(100) NOT NULL,
  fullname text NOT NULL,
  categoryid int(100) NOT NULL,
  startdate text NOT NULL,
  enddate text NOT NULL,
  timecreated text NOT NULL,
  timemodified text NOT NULL
)
ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla course
--

INSERT INTO course
  (id_course, id, fullname, categoryid, startdate, enddate, timecreated, timemodified)
VALUES
  (1, 2, 'Prueba 1', 2, '1581462000', '1612998000', '1581461766', '1581461766');
COMMIT;