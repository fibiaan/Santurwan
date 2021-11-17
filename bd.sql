-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.18-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para api_santurwan
CREATE DATABASE IF NOT EXISTS `api_santurwan` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `api_santurwan`;

-- Volcando estructura para tabla api_santurwan.sensores
CREATE TABLE IF NOT EXISTS `sensores` (
  `id_sensores` int(11) NOT NULL AUTO_INCREMENT,
  `temperatura` varchar(50) NOT NULL DEFAULT '0',
  `uv` varchar(50) NOT NULL DEFAULT '0',
  `humedad` varchar(50) NOT NULL DEFAULT '0',
  `fecha_creacion` timestamp NULL DEFAULT NULL,
  `fecha_ult_modif` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_sensores`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla api_santurwan.sensores: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `sensores` DISABLE KEYS */;
/*!40000 ALTER TABLE `sensores` ENABLE KEYS */;

-- Volcando estructura para tabla api_santurwan.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(50) NOT NULL DEFAULT '0',
  `clave` varchar(50) NOT NULL DEFAULT '0',
  `nombre_completo` varchar(50) NOT NULL DEFAULT '0',
  `fecha_creacion` timestamp NULL DEFAULT NULL,
  `fecha_ult_modif` timestamp NULL DEFAULT NULL,
  `activo` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla api_santurwan.usuario: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` (`id_usuario`, `nickname`, `clave`, `nombre_completo`, `fecha_creacion`, `fecha_ult_modif`, `activo`) VALUES
	(1, 'fibiaan', '1234', 'fabian mejia', '2021-11-17 09:34:39', '2021-11-17 09:34:39', 1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
