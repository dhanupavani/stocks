-- MySQL dump 10.13  Distrib 8.0.39, for Linux (x86_64)
--
-- Host: localhost    Database: stock_monitoring
-- ------------------------------------------------------
-- Server version	8.0.39

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Portfolios`
--

DROP TABLE IF EXISTS `Portfolios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Portfolios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `stock_id` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `purchase_price` decimal(10,2) DEFAULT NULL,
  `purchase_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `stock_id` (`stock_id`),
  CONSTRAINT `Portfolios_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Portfolios`
--

LOCK TABLES `Portfolios` WRITE;
/*!40000 ALTER TABLE `Portfolios` DISABLE KEYS */;
/*!40000 ALTER TABLE `Portfolios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Sold_Stocks`
--

DROP TABLE IF EXISTS `Sold_Stocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Sold_Stocks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `released_money` decimal(10,2) NOT NULL,
  `profit_amount` decimal(10,2) NOT NULL,
  `sale_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Sold_Stocks`
--

LOCK TABLES `Sold_Stocks` WRITE;
/*!40000 ALTER TABLE `Sold_Stocks` DISABLE KEYS */;
INSERT INTO `Sold_Stocks` VALUES (1,'Test Stock',1000.00,200.00,'2024-07-24 18:30:00'),(2,'TATA STEEL',97110.00,93987.54,'2024-07-24 22:02:16'),(3,'TATA STEEL',80.00,69.55,'2024-07-25 09:11:20'),(4,'TATA STEEL',30408.00,29273.13,'2024-07-25 16:02:56'),(5,'TATA STEEL',336.00,218.96,'2024-07-25 16:24:46'),(6,'TATA STEEL',15.00,4.55,'2024-07-25 11:58:52'),(7,'AWS',1250.00,-248.75,'2024-07-25 11:58:52'),(8,'AWS',400.00,-4396.00,'2024-07-25 11:58:52'),(9,'AWS',6000.00,5.00,'2024-07-25 12:00:50'),(10,'TATA STEEL',195.00,188.73,'2024-07-25 12:03:38'),(11,'Stock A',120.00,34.00,'2024-07-25 12:11:17'),(12,'Stock A',6.00,-37.00,'2024-07-25 12:14:32'),(13,'Stock A',5650.00,791.00,'2024-07-25 12:35:32'),(14,'Stock C',8.00,4.00,'2024-07-26 02:03:18'),(15,'Stock C',120.00,90.00,'2024-07-27 01:50:28'),(16,'TATA STEEL',1664.00,1229.28,'2024-07-27 01:55:51'),(17,'Stock C',1872.00,1456.00,'2024-07-27 01:56:50'),(18,'TATA STEEL',53778.50,34728.15,'2024-07-27 02:02:48'),(19,'AWS',179.00,79.00,'2024-07-27 02:07:13'),(20,'AWS',1136.00,568.00,'2024-07-27 02:18:40'),(21,'Stock C',9.00,4.00,'2024-07-27 02:19:42'),(22,'Stock C',7.90,2.90,'2024-07-27 02:24:02'),(23,'TATA STEEL',87.00,85.00,'2024-07-27 08:03:25'),(24,'TATA STEEL',58.00,56.00,'2024-07-27 08:03:53'),(25,'TATA STEEL',8.00,6.00,'2024-07-27 08:27:01'),(26,'AWS',12.00,7.00,'2024-07-27 08:29:24'),(27,'AWS',96.00,56.00,'2024-07-27 09:19:45'),(28,'TATA STEEL',60.00,36.00,'2024-07-27 09:20:35'),(29,'Stock B',2000.00,1000.00,'2024-07-27 10:05:17'),(30,'ZOMATO',10.00,5.00,'2024-07-27 10:37:33'),(31,'Stock B',10.00,5.00,'2024-07-27 10:44:30'),(32,'AWS',1.00,5.00,'2024-07-27 12:07:41'),(33,'AWS',3.00,12.00,'2024-07-27 12:17:53'),(34,'Stock A',5.00,20.00,'2024-07-27 12:46:06'),(35,'Stock D',0.00,0.00,'2024-07-28 00:57:45');
/*!40000 ALTER TABLE `Sold_Stocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Stocks`
--

DROP TABLE IF EXISTS `Stocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Stocks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `Bought_At` decimal(10,2) DEFAULT NULL,
  `investment_amount` decimal(10,2) DEFAULT NULL,
  `total_shares` int DEFAULT NULL,
  `average_share_price` decimal(10,2) DEFAULT NULL,
  `target_price` decimal(10,2) DEFAULT NULL,
  `Sold_At` decimal(10,2) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Stocks`
--

LOCK TABLES `Stocks` WRITE;
/*!40000 ALTER TABLE `Stocks` DISABLE KEYS */;
INSERT INTO `Stocks` VALUES (21,'AWS',1.00,47.00,46,1.00,5.00,NULL,'2024-07-27'),(22,'Stock A',1.00,15.00,15,1.00,5.00,NULL,'2024-07-27'),(23,'Stock B',1.00,54.00,40,1.35,6.00,NULL,'2024-07-27'),(24,'Stock D',5.00,65.50,13,5.00,8.00,NULL,'2024-07-28');
/*!40000 ALTER TABLE `Stocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Total_Investment`
--

DROP TABLE IF EXISTS `Total_Investment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Total_Investment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `total_invested` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_profit_loss` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Total_Investment`
--

LOCK TABLES `Total_Investment` WRITE;
/*!40000 ALTER TABLE `Total_Investment` DISABLE KEYS */;
INSERT INTO `Total_Investment` VALUES (1,164.00,NULL);
/*!40000 ALTER TABLE `Total_Investment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Transactions`
--

DROP TABLE IF EXISTS `Transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `stock_id` int DEFAULT NULL,
  `transaction_type` enum('buy','sell') DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `transaction_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `stock_id` (`stock_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Transactions`
--

LOCK TABLES `Transactions` WRITE;
/*!40000 ALTER TABLE `Transactions` DISABLE KEYS */;
INSERT INTO `Transactions` VALUES (10,5,'sell',NULL,NULL,'2024-07-25 22:58:44'),(11,5,'sell',2,34.00,'2024-07-25 22:58:44'),(12,3,'sell',23,3.00,'2024-07-25 22:58:45'),(13,5,'sell',12,6.00,'2024-07-25 22:58:45'),(14,5,'sell',4,23.00,'2024-07-25 22:58:48'),(15,5,'sell',3,46.00,'2024-07-25 22:58:50'),(16,3,'sell',34,60.00,'2024-07-25 23:24:50'),(17,7,'sell',20,8.00,'2024-07-25 23:32:16'),(18,5,'sell',424,87.00,'2024-07-25 23:37:19'),(19,8,'sell',1,8.00,'2024-07-26 12:56:35'),(20,24,'buy',20,5.00,'2024-07-28 00:00:00'),(21,24,'sell',7,9.00,'2024-07-28 00:00:00');
/*!40000 ALTER TABLE `Transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `all_stocks`
--

DROP TABLE IF EXISTS `all_stocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `all_stocks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `all_stocks`
--

LOCK TABLES `all_stocks` WRITE;
/*!40000 ALTER TABLE `all_stocks` DISABLE KEYS */;
INSERT INTO `all_stocks` VALUES (6,'AWS'),(1,'Stock A'),(2,'Stock B'),(3,'Stock C'),(4,'Stock D'),(5,'TATA STEEL'),(7,'ZOMATO');
/*!40000 ALTER TABLE `all_stocks` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-07-28  6:31:49
