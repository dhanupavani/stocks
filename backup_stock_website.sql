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
-- Table structure for table `Investment_Track`
--

DROP TABLE IF EXISTS `Investment_Track`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Investment_Track` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Investment` decimal(10,2) DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Investment_Track`
--

LOCK TABLES `Investment_Track` WRITE;
/*!40000 ALTER TABLE `Investment_Track` DISABLE KEYS */;
INSERT INTO `Investment_Track` VALUES (1,5.00,'2024-08-02'),(2,1250.00,'2024-08-02');
/*!40000 ALTER TABLE `Investment_Track` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Sold_Stocks`
--

LOCK TABLES `Sold_Stocks` WRITE;
/*!40000 ALTER TABLE `Sold_Stocks` DISABLE KEYS */;
INSERT INTO `Sold_Stocks` VALUES (1,'Test Stock',1000.00,200.00,'2024-07-24 18:30:00'),(2,'TATA STEEL',97110.00,93987.54,'2024-07-24 22:02:16'),(3,'TATA STEEL',80.00,69.55,'2024-07-25 09:11:20'),(4,'TATA STEEL',30408.00,29273.13,'2024-07-25 16:02:56'),(5,'TATA STEEL',336.00,218.96,'2024-07-25 16:24:46'),(6,'TATA STEEL',15.00,4.55,'2024-07-25 11:58:52'),(7,'AWS',1250.00,-248.75,'2024-07-25 11:58:52'),(8,'AWS',400.00,-4396.00,'2024-07-25 11:58:52'),(9,'AWS',6000.00,5.00,'2024-07-25 12:00:50'),(10,'TATA STEEL',195.00,188.73,'2024-07-25 12:03:38'),(11,'Stock A',120.00,34.00,'2024-07-25 12:11:17'),(12,'Stock A',6.00,-37.00,'2024-07-25 12:14:32'),(13,'Stock A',5650.00,791.00,'2024-07-25 12:35:32'),(14,'Stock C',8.00,4.00,'2024-07-26 02:03:18'),(15,'Stock C',120.00,90.00,'2024-07-27 01:50:28'),(16,'TATA STEEL',1664.00,1229.28,'2024-07-27 01:55:51'),(17,'Stock C',1872.00,1456.00,'2024-07-27 01:56:50'),(18,'TATA STEEL',53778.50,34728.15,'2024-07-27 02:02:48'),(19,'AWS',179.00,79.00,'2024-07-27 02:07:13'),(20,'AWS',1136.00,568.00,'2024-07-27 02:18:40'),(21,'Stock C',9.00,4.00,'2024-07-27 02:19:42'),(22,'Stock C',7.90,2.90,'2024-07-27 02:24:02'),(23,'TATA STEEL',87.00,85.00,'2024-07-27 08:03:25'),(24,'TATA STEEL',58.00,56.00,'2024-07-27 08:03:53'),(25,'TATA STEEL',8.00,6.00,'2024-07-27 08:27:01'),(26,'AWS',12.00,7.00,'2024-07-27 08:29:24'),(27,'AWS',96.00,56.00,'2024-07-27 09:19:45'),(28,'TATA STEEL',60.00,36.00,'2024-07-27 09:20:35'),(29,'Stock B',2000.00,1000.00,'2024-07-27 10:05:17'),(30,'ZOMATO',10.00,5.00,'2024-07-27 10:37:33'),(31,'Stock B',10.00,5.00,'2024-07-27 10:44:30'),(32,'AWS',1.00,5.00,'2024-07-27 12:07:41'),(33,'AWS',3.00,12.00,'2024-07-27 12:17:53'),(34,'Stock A',5.00,20.00,'2024-07-27 12:46:06'),(35,'Stock D',0.00,0.00,'2024-07-28 00:57:45'),(36,'Stock D',0.00,0.00,'2024-07-28 01:06:17'),(37,'Stock D',0.00,0.00,'2024-07-28 01:06:22'),(38,'AWS',1.00,6.00,'2024-07-28 01:06:46'),(39,'Stock D',30.00,18.00,'2024-07-28 01:32:28'),(40,'Stock C',100.00,92.00,'2024-07-28 01:32:29'),(41,'AWS',2.00,8.00,'2024-07-28 01:32:29'),(42,'AWS',6.76,27.24,'2024-07-28 01:35:31'),(43,'AWS',6.33,28.47,'2024-07-28 01:52:49'),(44,'AWS',48.53,112.47,'2024-07-28 02:18:42'),(45,'ZOMATO',200.00,150.40,'2024-07-28 07:54:19'),(46,'TATA STEEL',4.00,46.00,'2024-07-28 07:56:14'),(47,'AWS',126.60,126.60,'2024-07-28 08:14:12'),(48,'AWS',100.00,60.00,'2024-07-28 08:23:06'),(49,'AWS',2.00,24.00,'2024-07-28 09:09:33'),(50,'AWS',2.00,1.00,'2024-07-28 09:10:06'),(51,'Stock B',254.34,530.66,'2024-07-28 11:07:39'),(52,'Stock B',1.00,3.00,'2024-07-28 11:15:38'),(53,'Stock B',1.00,0.50,'2024-07-28 11:16:00'),(54,'Stock B',1.00,0.50,'2024-07-28 11:22:15'),(55,'Stock B',1.00,1.00,'2024-07-28 11:22:33'),(56,'Stock B',1.00,0.80,'2024-07-28 11:36:30'),(57,'Stock B',1.00,1.00,'2024-07-28 11:36:45'),(58,'Stock B',2.00,1.00,'2024-07-28 12:12:21'),(59,'Stock B',2.00,1.00,'2024-07-28 12:12:26'),(60,'Stock B',3.00,2.00,'2024-07-28 12:12:44'),(61,'Stock B',3.00,2.00,'2024-07-28 12:15:35'),(62,'Stock B',2.00,1.00,'2024-07-28 12:22:18'),(63,'Stock B',5.00,4.00,'2024-07-28 12:22:48'),(64,'ZOMATO',2.00,1.00,'2024-07-28 12:29:25'),(65,'ZOMATO',5.00,4.00,'2024-07-28 12:29:44'),(68,'ZOMATO',8.00,7.00,'2024-07-28 12:58:17'),(69,'ZOMATO',2.00,1.00,'2024-07-28 17:46:04'),(70,'ZOMATO',3.00,2.00,'2024-07-28 17:50:49'),(71,'ZOMATO',7.00,6.00,'2024-07-28 17:59:32'),(72,'ZOMATO',4.00,3.00,'2024-07-28 18:00:11'),(73,'ZOMATO',4.00,3.00,'2024-07-28 18:02:17'),(74,'Stock B',2.00,0.00,'2024-07-28 18:14:18'),(75,'ZOMATO',1.00,2.00,'2024-07-28 18:17:21'),(76,'ZOMATO',1.00,44.00,'2024-07-28 18:56:55'),(77,'ZOMATO',1.00,4.00,'2024-07-28 18:57:33'),(78,'ZOMATO',1.00,7.00,'2024-07-28 18:57:58'),(79,'Stock B',50.00,5.00,'2024-07-28 19:02:43'),(80,'Stock B',50.00,10.00,'2024-07-28 19:03:21'),(81,'ZOMATO',5.00,1.00,'2024-07-28 19:13:39'),(82,'ZOMATO',5.00,2.00,'2024-07-28 19:21:04'),(83,'Stock B',1.00,4.00,'2024-07-28 19:28:37'),(84,'Stock B',1.00,7.00,'2024-07-28 19:28:58'),(85,'AWS',1.00,1.00,'2024-07-28 20:01:22'),(86,'AWS',1.00,4.00,'2024-07-28 20:01:49'),(87,'AWS',1.00,4.00,'2024-07-28 20:06:12'),(88,'AWS',1.00,9.00,'2024-07-28 20:06:57'),(89,'AWS',5.00,1.00,'2024-07-28 20:21:17'),(90,'AWS',5.00,5.00,'2024-07-28 20:21:49'),(91,'Stock A',2.00,8.00,'2024-07-28 20:23:45'),(92,'TATA STEEL',1.00,0.50,'2024-07-29 15:25:50'),(93,'TATA STEEL',1.00,0.50,'2024-07-29 15:26:03'),(94,'AWS',1.00,4.00,'2024-07-29 15:29:08'),(95,'AWS',1.00,49.00,'2024-07-29 15:29:55'),(96,'Stock B',1.00,49.00,'2024-07-29 15:44:24'),(97,'Stock B',1.00,14.00,'2024-07-29 15:52:29'),(98,'Stock A',1.00,4.00,'2024-07-29 15:52:31'),(99,'Stock A',1.00,11.00,'2024-07-29 15:52:31'),(100,'TATA STEEL',1.00,4.00,'2024-07-29 15:55:32'),(101,'TATA STEEL',1.00,0.60,'2024-07-29 15:56:49'),(102,'Stock B',25.00,5.00,'2024-07-29 16:07:22'),(103,'Stock B',25.00,20.00,'2024-07-29 16:08:05'),(104,'Stock A',10.00,4.00,'2024-07-31 07:41:45'),(105,'Stock A',30.00,24.00,'2024-08-01 18:07:51'),(106,'AWS',25.00,25.00,'2024-08-02 15:08:24'),(107,'AWS',16.00,384.00,'2024-08-02 17:45:00');
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
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Stocks`
--

LOCK TABLES `Stocks` WRITE;
/*!40000 ALTER TABLE `Stocks` DISABLE KEYS */;
INSERT INTO `Stocks` VALUES (44,'AWS',1.00,64.00,64,1.00,7.00,NULL,'2024-08-02',0),(45,'Stock A',1.00,155.00,31,5.00,6.00,6.00,'2024-07-31',0),(46,'TATA STEEL',1.00,1.00,1,1.00,5.00,NULL,'2024-07-29',1),(47,'Stock B',1.00,25.00,5,5.00,50.00,NULL,'2024-07-29',1),(48,'Stock C',14.00,1250.00,89,14.00,56.00,NULL,'2024-08-02',0);
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
  `total_released_money` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Total_Investment`
--

LOCK TABLES `Total_Investment` WRITE;
/*!40000 ALTER TABLE `Total_Investment` DISABLE KEYS */;
INSERT INTO `Total_Investment` VALUES (1,2880.00,NULL,NULL);
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
  KEY `stock_id` (`stock_id`),
  CONSTRAINT `fk_stock` FOREIGN KEY (`stock_id`) REFERENCES `Stocks` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=150 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Transactions`
--

LOCK TABLES `Transactions` WRITE;
/*!40000 ALTER TABLE `Transactions` DISABLE KEYS */;
INSERT INTO `Transactions` VALUES (114,44,'buy',2,1.00,'2024-07-29 01:35:49'),(115,44,'sell',1,5.00,'2024-07-29 01:36:12'),(116,44,'sell',1,10.00,'2024-07-29 01:36:57'),(117,44,'buy',2,5.00,'2024-07-29 01:50:51'),(118,44,'sell',1,6.00,'2024-07-29 01:51:17'),(119,44,'sell',1,10.00,'2024-07-29 01:51:49'),(120,45,'buy',2,1.00,'2024-07-29 01:53:12'),(121,45,'sell',2,5.00,'2024-07-29 01:53:45'),(122,46,'buy',2,1.00,'2024-07-29 20:54:46'),(123,46,'sell',1,1.50,'2024-07-29 20:55:50'),(124,46,'sell',1,1.50,'2024-07-29 20:56:03'),(125,44,'buy',2,1.00,'2024-07-29 20:58:50'),(126,44,'sell',1,5.00,'2024-07-29 20:59:08'),(127,44,'sell',1,50.00,'2024-07-29 20:59:55'),(128,47,'buy',2,1.00,'2024-07-29 21:13:19'),(129,47,'sell',1,50.00,'2024-07-29 21:14:24'),(130,47,'sell',1,15.00,'2024-07-29 21:22:29'),(131,45,'buy',2,1.00,'2024-07-29 21:22:31'),(132,45,'sell',1,5.00,'2024-07-29 21:22:31'),(133,45,'sell',1,12.00,'2024-07-29 21:22:31'),(134,46,'buy',2,1.00,'2024-07-29 21:22:32'),(135,46,'sell',1,5.00,'2024-07-29 21:25:32'),(136,46,'sell',1,1.60,'2024-07-29 21:26:49'),(137,47,'buy',10,5.00,'2024-07-29 21:37:04'),(138,47,'sell',5,6.00,'2024-07-29 21:37:22'),(139,47,'sell',5,9.00,'2024-07-29 21:38:05'),(140,45,'buy',20,5.00,'2024-07-31 13:09:11'),(141,45,'buy',20,5.00,'2024-07-31 13:09:14'),(142,45,'sell',1,6.00,'2024-07-31 13:09:48'),(143,45,'sell',2,7.00,'2024-07-31 13:11:45'),(144,45,'sell',6,9.00,'2024-08-01 23:37:51'),(145,44,'buy',100,1.00,'2024-08-02 20:37:16'),(146,44,'sell',25,2.00,'2024-08-02 20:38:24'),(147,44,'buy',5,1.00,'2024-08-02 21:26:59'),(148,48,'buy',89,14.00,'2024-08-02 22:50:42'),(149,44,'sell',16,25.00,'2024-08-02 23:15:00');
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

-- Dump completed on 2024-08-03  0:18:25
