# ************************************************************
# Sequel Ace SQL dump
# Versión 20033
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Equipo: 127.0.0.1 (MySQL 5.5.5-10.5.8-MariaDB-1:10.5.8+maria~focal)
# Base de datos: telecoming
# Tiempo de generación: 2022-06-27 01:03:38 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Volcado de tabla collections
# ------------------------------------------------------------

DROP TABLE IF EXISTS `collections`;

CREATE TABLE `collections` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT current_timestamp(),
  `amount` double(9,2) DEFAULT NULL,
  `result` enum('OK','KO') DEFAULT NULL,
  `subscriptor_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `collection_ibfk_1` (`subscriptor_id`),
  CONSTRAINT `collections_ibfk_1` FOREIGN KEY (`subscriptor_id`) REFERENCES `subscriptors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Volcado de tabla subscriptors
# ------------------------------------------------------------

DROP TABLE IF EXISTS `subscriptors`;

CREATE TABLE `subscriptors` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(30) DEFAULT NULL,
  `status` enum('ONLINE','DELETED') DEFAULT 'ONLINE',
  `deleted_at` datetime DEFAULT NULL,
  `total_collected_cumulated` double(9,2) DEFAULT 0.00,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
