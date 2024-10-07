-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               11.4.2-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for undangan
DROP DATABASE IF EXISTS `undangan`;
CREATE DATABASE IF NOT EXISTS `undangan` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `undangan`;

-- Dumping structure for table undangan.ucapan
DROP TABLE IF EXISTS `ucapan`;
CREATE TABLE IF NOT EXISTS `ucapan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `komentar` varchar(500) NOT NULL,
  `attendance` enum('hadir','tidak_hadir') DEFAULT NULL,
  `tanggal` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table undangan.ucapan: ~6 rows (approximately)
DELETE FROM `ucapan`;
INSERT INTO `ucapan` (`id`, `nama`, `komentar`, `attendance`, `tanggal`) VALUES
	(9, 'sdf', 'sdg', 'hadir', '2024-10-06 22:57:38'),
	(10, 'sdfg', 'ds', 'tidak_hadir', '2024-10-06 23:05:49'),
	(11, 'asdasf', 'asfasfasfaf', 'hadir', '2024-10-06 23:45:54'),
	(12, 'wedx', 'asdasfa ', 'hadir', '2024-10-06 23:47:12'),
	(13, 'sdfg', 'dsaa', 'tidak_hadir', '2024-10-07 00:14:10'),
	(14, 'hanafi', 'test', NULL, '2024-10-07 00:14:24');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
