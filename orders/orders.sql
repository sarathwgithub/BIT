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

/*Table structure for table `item_stock` */

DROP TABLE IF EXISTS `item_stock`;

CREATE TABLE `item_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `issued_qty` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `item_stock` */

insert  into `item_stock`(`id`,`item_id`,`qty`,`unit_price`,`purchase_date`,`supplier_id`,`issued_qty`) values 
(1,1,5,350000.00,'2024-05-14',1,1),
(2,1,10,85000.00,'2024-05-15',1,1),
(3,3,3,45000.00,'2024-05-14',1,1),
(4,4,5,5000.00,'2024-05-14',1,1),
(5,5,4,65570.00,'2024-05-14',1,1);

/*Table structure for table `items` */

DROP TABLE IF EXISTS `items`;

CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(100) DEFAULT NULL,
  `item_category` int(11) DEFAULT NULL,
  `item_image` varchar(255) NOT NULL,
  `status` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `items` */

insert  into `items`(`id`,`item_name`,`item_category`,`item_image`,`status`) values 
(1,'Laptop',1,'mac-laptop-png-13.png',1),
(2,'Mobile Phone',1,'',1),
(3,'Printer',2,'',1),
(4,'Headphones',3,'',1),
(5,'Tablet',1,'',1);

/*Table structure for table `order_items` */

DROP TABLE IF EXISTS `order_items`;

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `stock_id` int(11) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `order_items` */

insert  into `order_items`(`id`,`order_id`,`item_id`,`stock_id`,`unit_price`,`qty`) values 
(1,1,1,2,85000.00,1),
(2,1,1,1,350000.00,1),
(3,1,3,3,45000.00,1),
(4,1,4,4,5000.00,1),
(5,1,5,5,65570.00,1);

/*Table structure for table `order_items_issue` */

DROP TABLE IF EXISTS `order_items_issue`;

CREATE TABLE `order_items_issue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `stock_id` int(11) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `issued_qty` int(11) DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `order_items_issue` */

insert  into `order_items_issue`(`id`,`order_id`,`item_id`,`stock_id`,`unit_price`,`issued_qty`,`issue_date`) values 
(1,1,1,2,85000.00,1,'2024-05-24'),
(2,1,1,1,350000.00,1,'2024-05-24'),
(3,1,3,3,45000.00,1,'2024-05-24'),
(4,1,4,4,5000.00,1,'2024-05-24'),
(5,1,5,5,65570.00,1,'2024-05-24');

/*Table structure for table `orders` */

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_date` date DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `delivery_name` varchar(255) DEFAULT NULL,
  `delivery_address` text DEFAULT NULL,
  `delivery_phone` varchar(255) DEFAULT NULL,
  `billing_name` varchar(255) DEFAULT NULL,
  `billing_address` text DEFAULT NULL,
  `billing_phone` varchar(255) DEFAULT NULL,
  `order_number` int(11) DEFAULT NULL,
  `new_order_flag` int(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `orders` */

insert  into `orders`(`id`,`order_date`,`customer_id`,`delivery_name`,`delivery_address`,`delivery_phone`,`billing_name`,`billing_address`,`billing_phone`,`order_number`,`new_order_flag`) values 
(1,'2024-05-24',5,'Sarath Wijesinghe','40/172\r\nKamalpitiyawatta, Meepe','0718080409','Sarath Wijesinghe','40/172\r\nKamalpitiyawatta, Meepe','0718080409',202405245,1);

/*Table structure for table `supplier` */

DROP TABLE IF EXISTS `supplier`;

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(100) DEFAULT NULL,
  `register_date` date DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `supplier` */

insert  into `supplier`(`id`,`supplier_name`,`register_date`,`status`) values 
(1,'ABC Electronics','2022-01-10',1),
(2,'XYZ Suppliers','2022-02-15',1),
(3,'PQR Tech','2022-03-20',1),
(4,'LMN Distributors','2022-04-25',1),
(5,'EFG Enterprises','2022-05-30',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
