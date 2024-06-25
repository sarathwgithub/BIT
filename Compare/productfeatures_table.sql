/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.4.32-MariaDB : Database - bittest_2
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bittest_2` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `bittest_2`;

/*Table structure for table `productfeatures` */

DROP TABLE IF EXISTS `productfeatures`;

CREATE TABLE `productfeatures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `feature_name` varchar(100) DEFAULT NULL,
  `feature_value` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `productfeatures_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `productfeatures` */

insert  into `productfeatures`(`id`,`product_id`,`feature_name`,`feature_value`) values 
(1,1,'RAM','8GB'),
(2,1,'Size','1080 x 2408 pixels, 6.6 inches'),
(3,1,'Camera','50MP + 2MP + 2MP + 8MP Selfie'),
(4,2,'RAM','6GB'),
(5,2,'Size','720 x 1600 pixels'),
(6,2,'Camera','50 MP + 2 MP + 8 MP Selfie'),
(7,3,'RAM','8GB'),
(8,3,'Size','FHD + 2388 × 1080 pixels; 387 PPI'),
(9,3,'Camera','108 MP High-Res Photography');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
