-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Servidor: localhost
-- Tiempo de generación: 09-10-2013 a las 21:22:34
-- Versión del servidor: 5.0.51
-- Versión de PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Base de datos: `odontosoft`
-- 

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `cita`
-- 

CREATE TABLE `cita` (
  `id` int(11) NOT NULL auto_increment,
  `nombre_paciente` varchar(150) NOT NULL,
  `nombre_tratamientos` varchar(1500) NOT NULL,
  `tiempo` time NOT NULL,
  `fecha` datetime NOT NULL,
  `costo_final` double NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

-- 
-- Volcar la base de datos para la tabla `cita`
-- 

INSERT INTO `cita` VALUES (12, 'Edith Trujillo', 'Endodoncia Normal|', '00:30:00', '2013-07-02 05:00:00', 50);
INSERT INTO `cita` VALUES (14, 'Leyla Díaz', 'Prótesis Fijas|', '01:30:00', '2013-07-02 06:30:00', 200);
INSERT INTO `cita` VALUES (18, 'Edith Trujillo', 'Prótesis dental|', '01:00:00', '2013-08-31 04:30:00', 200);
INSERT INTO `cita` VALUES (19, 'Shaila', 'Endodoncia Fuerte|Endodoncia Fuerte|', '01:00:00', '2013-09-21 06:30:00', 148);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `historial`
-- 

CREATE TABLE `historial` (
  `id` int(11) NOT NULL auto_increment,
  `id_paciente` int(11) NOT NULL,
  `p1` varchar(500) NOT NULL,
  `p2` varchar(500) NOT NULL,
  `p3` varchar(500) NOT NULL,
  `p4` varchar(500) NOT NULL,
  `p5` varchar(500) NOT NULL,
  `p6` varchar(500) NOT NULL,
  `p7` varchar(500) NOT NULL,
  `p8` varchar(500) NOT NULL,
  `p9` varchar(500) NOT NULL,
  `p10` varchar(500) NOT NULL,
  `p11` varchar(500) NOT NULL,
  `p12` varchar(500) NOT NULL,
  `p13` varchar(500) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

-- 
-- Volcar la base de datos para la tabla `historial`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `opc_preg_hist`
-- 

CREATE TABLE `opc_preg_hist` (
  `id_preg` int(11) NOT NULL,
  `opcion` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Volcar la base de datos para la tabla `opc_preg_hist`
-- 

INSERT INTO `opc_preg_hist` VALUES (31, 'L');
INSERT INTO `opc_preg_hist` VALUES (31, 'N');
INSERT INTO `opc_preg_hist` VALUES (31, 'A');
INSERT INTO `opc_preg_hist` VALUES (32, 'A');
INSERT INTO `opc_preg_hist` VALUES (32, 'B');
INSERT INTO `opc_preg_hist` VALUES (32, 'C');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `paciente`
-- 

CREATE TABLE `paciente` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(150) NOT NULL,
  `appat` varchar(50) NOT NULL,
  `apmat` varchar(50) NOT NULL,
  `dni` varchar(8) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

-- 
-- Volcar la base de datos para la tabla `paciente`
-- 

INSERT INTO `paciente` VALUES (24, 'Shaila', 'Mondragón', 'Montiel', '71776804', '976543212', 'Jr. Contamana 266');
INSERT INTO `paciente` VALUES (25, 'Juan', 'Sánchez', 'Figueroa', '12345678', '987654323', 'Jr. Puno 180');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `preg_hist`
-- 

CREATE TABLE `preg_hist` (
  `id` int(11) NOT NULL auto_increment,
  `pregunta` varchar(500) NOT NULL,
  `isMultiple` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

-- 
-- Volcar la base de datos para la tabla `preg_hist`
-- 

INSERT INTO `preg_hist` VALUES (31, 'Segunda pregunta con opciones', 0);
INSERT INTO `preg_hist` VALUES (32, 'Sin opciones nuevamente hola!', 0);
INSERT INTO `preg_hist` VALUES (29, 'Pregunta sin opciones', 0);
INSERT INTO `preg_hist` VALUES (34, 'Pregunta X', 0);
INSERT INTO `preg_hist` VALUES (35, 'Nueva', 0);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `tratamiento`
-- 

CREATE TABLE `tratamiento` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(150) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `tiempo` time NOT NULL,
  `costo` double NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

-- 
-- Volcar la base de datos para la tabla `tratamiento`
-- 

INSERT INTO `tratamiento` VALUES (20, 'Colocacion de Brackets', 'Se colocal las ligas y brakets correspondientes al paciente.', '01:30:00', 250);
INSERT INTO `tratamiento` VALUES (19, 'Exodoncia dental', 'Practicar la avulsión o extracción de un diente o porción del mismo, del lecho óseo que lo alberga.', '01:00:00', 30);
INSERT INTO `tratamiento` VALUES (16, 'Prótesis dental', 'Las prótesis fijas, son prótesis completamente dentosoportadas, que toman apoyo únicamente en los dientes.', '02:00:00', 200);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `usuario`
-- 

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(50) NOT NULL,
  `appat` varchar(20) NOT NULL,
  `apmat` varchar(20) NOT NULL,
  `nick` varchar(6) NOT NULL,
  `password` varchar(250) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cargo` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

-- 
-- Volcar la base de datos para la tabla `usuario`
-- 

INSERT INTO `usuario` VALUES (10, 'Dany', 'Nureña', 'Trujillo', 'nuda87', 'aa47f8215c6f30a0dcdb2a36a9f4168e', 'email@email.com', 1);
INSERT INTO `usuario` VALUES (15, 'Leyla', 'Díaz', 'Mondragón', 'ledi01', 'e10adc3949ba59abbe56e057f20f883e', 'leyla@hotmail.com', 1);
INSERT INTO `usuario` VALUES (13, 'Junior', 'Mondragón', 'Hernández', 'moju21', 'e10adc3949ba59abbe56e057f20f883e', 'w@hotmail.com', 20);
INSERT INTO `usuario` VALUES (14, 'Shaila', 'Mondragon', 'Montiel', 'mosh64', 'e10adc3949ba59abbe56e057f20f883e', 'shaila@hotmail.com', 3);
INSERT INTO `usuario` VALUES (16, 'Juan', 'Figueroa', 'Vargas', 'fiju23', 'e10adc3949ba59abbe56e057f20f883e', 'juan@hotmail.com', 2);
INSERT INTO `usuario` VALUES (17, 'Juan', 'Guerra', 'Vasquez', 'guju46', 'e10adc3949ba59abbe56e057f20f883e', 'guju@hotmail.com', 1);
