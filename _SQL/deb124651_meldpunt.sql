-- MySQL dump 10.16  Distrib 10.1.44-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: deb124651_meldpunt
-- ------------------------------------------------------
-- Server version	10.1.44-MariaDB-cll-lve

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `gebruiker`
--

DROP TABLE IF EXISTS `gebruiker`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gebruiker` (
  `ID` smallint(6) NOT NULL AUTO_INCREMENT,
  `naam` varchar(45) NOT NULL,
  `postcode` varchar(7) NOT NULL,
  `geslacht` varchar(20) NOT NULL,
  `geboortedatum` date NOT NULL,
  `email` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gebruiker`
--

LOCK TABLES `gebruiker` WRITE;
/*!40000 ALTER TABLE `gebruiker` DISABLE KEYS */;
INSERT INTO `gebruiker` VALUES (1,'John van den Berg','1098 LV','M','1984-10-07','jvdb@live.nl'),(2,'Celia Hayna','1999 BB','V','1986-05-24','ch@gnail.com'),(3,'Justin Boom','2000 AA','M','1991-05-03','jv@live.nl'),(4,'Roemer Gallo','1999 BB','M','1085-05-31','rg@hotmail.com'),(5,'Johan Jansen','1099 TT','M','1960-03-14','johan@gmail.com'),(6,'Test Gebruiker1','1098 LV','M','1945-03-01','test@gebruiker.nl'),(7,'Test Gebruiker2','1099 TT','V','1987-03-28','test2@gebruiker.nl'),(8,'Test Gebruiker3','1099 TT','M','1975-06-20','test@gebruiker3.nl'),(9,'Daan','1099 TT','V','0792-07-31','31jc2020320@student.zonne.college'),(10,'Yeet','1999 BB','V','2019-09-27','daanrosendal18@outlook.com'),(11,'Test','1999 BB','M','2020-02-15','yeezyyeety@outlook.com');
/*!40000 ALTER TABLE `gebruiker` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `klacht`
--

DROP TABLE IF EXISTS `klacht`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `klacht` (
  `ID` smallint(6) NOT NULL AUTO_INCREMENT,
  `ID_gebruiker` smallint(6) NOT NULL,
  `ID_klachtsoort` smallint(6) NOT NULL,
  `postcode` varchar(7) NOT NULL,
  `datum` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `prioriteit` int(5) DEFAULT NULL,
  `afgehandeld` int(11) DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `ID_klachtsoort` (`ID_klachtsoort`),
  CONSTRAINT `klacht_ibfk_1` FOREIGN KEY (`ID_klachtsoort`) REFERENCES `klachtsoort` (`ID`),
  CONSTRAINT `klacht_ibfk_2` FOREIGN KEY (`ID_klachtsoort`) REFERENCES `klachtsoort` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `klacht`
--

LOCK TABLES `klacht` WRITE;
/*!40000 ALTER TABLE `klacht` DISABLE KEYS */;
INSERT INTO `klacht` VALUES (1,1,1,'1098 LV','2016-05-01 18:00:00',0,1),(2,2,2,'1999 BB','2016-05-11 19:30:00',2,0),(3,3,3,'2000 AA','2016-05-10 09:30:00',3,0),(4,3,3,'1999 BB','2016-05-10 11:45:00',1,0),(5,2,1,'1099 TT','2016-04-10 12:30:00',4,0),(6,6,2,'1098 LV','2019-03-14 21:05:38',1,0),(7,7,2,'1099 TT','2019-03-14 21:18:48',2,0),(8,8,3,'1099 TT','2019-03-14 21:27:19',1,0),(9,1,1,'1098 LV','2019-03-14 21:34:07',1,0),(10,9,3,'1099 TT','2019-07-31 12:36:03',1,0),(11,10,3,'1999 BB','2019-09-12 09:12:00',1,0),(12,11,3,'1999 BB','2020-02-07 16:21:23',2,0);
/*!40000 ALTER TABLE `klacht` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`deb124651_deb124651`@`localhost`*/ /*!50003 TRIGGER `trig_afgehandeld` BEFORE UPDATE ON `klacht` FOR EACH ROW BEGIN
IF NEW.afgehandeld = 1 THEN SET NEW.prioriteit = 0;
END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `klachtsoort`
--

DROP TABLE IF EXISTS `klachtsoort`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `klachtsoort` (
  `ID` smallint(6) NOT NULL AUTO_INCREMENT,
  `klachtsoort` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `klachtsoort`
--

LOCK TABLES `klachtsoort` WRITE;
/*!40000 ALTER TABLE `klachtsoort` DISABLE KEYS */;
INSERT INTO `klachtsoort` VALUES (1,'milieu'),(2,'veiligheid'),(3,'geluid');
/*!40000 ALTER TABLE `klachtsoort` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `postcode`
--

DROP TABLE IF EXISTS `postcode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `postcode` (
  `postcode` varchar(7) NOT NULL,
  `ID` mediumint(9) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `postcode`
--

LOCK TABLES `postcode` WRITE;
/*!40000 ALTER TABLE `postcode` DISABLE KEYS */;
INSERT INTO `postcode` VALUES ('1098 LV',1),('1098 XX',2),('1098 LX',3),('1099 TT',4),('1999 BB',5),('2000 AA',6);
/*!40000 ALTER TABLE `postcode` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'deb124651_meldpunt'
--

--
-- Dumping routines for database 'deb124651_meldpunt'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-05-21 13:59:43
