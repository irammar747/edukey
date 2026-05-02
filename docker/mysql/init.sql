-- MySQL dump 10.13  Distrib 8.0.44, for Linux (x86_64)
--
-- Host: localhost    Database: edukey_db
-- ------------------------------------------------------
-- Server version	8.0.44

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
-- Table structure for table `abre`
--

USE `edukey_db`;

DROP TABLE IF EXISTS `abre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `abre` (
  `llave_id` int NOT NULL,
  `recurso_id` int NOT NULL,
  PRIMARY KEY (`llave_id`,`recurso_id`),
  KEY `IDX_C95CDE978EB29E8F` (`llave_id`),
  KEY `IDX_C95CDE97E52B6C4E` (`recurso_id`),
  CONSTRAINT `FK_C95CDE978EB29E8F` FOREIGN KEY (`llave_id`) REFERENCES `llave` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_C95CDE97E52B6C4E` FOREIGN KEY (`recurso_id`) REFERENCES `recurso` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `abre`
--

LOCK TABLES `abre` WRITE;
/*!40000 ALTER TABLE `abre` DISABLE KEYS */;
INSERT INTO `abre` VALUES (9,13),(10,14),(10,15);
/*!40000 ALTER TABLE `abre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alerta`
--

DROP TABLE IF EXISTS `alerta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alerta` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `estado` varchar(50) NOT NULL DEFAULT 'pendiente',
  `prestamo_id` int NOT NULL,
  `tipo_alerta_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4C3B123135A846E` (`prestamo_id`),
  KEY `IDX_4C3B12341978E30` (`tipo_alerta_id`),
  CONSTRAINT `FK_4C3B123135A846E` FOREIGN KEY (`prestamo_id`) REFERENCES `prestamo` (`id`),
  CONSTRAINT `FK_4C3B12341978E30` FOREIGN KEY (`tipo_alerta_id`) REFERENCES `tipo_alerta` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alerta`
--

LOCK TABLES `alerta` WRITE;
/*!40000 ALTER TABLE `alerta` DISABLE KEYS */;
INSERT INTO `alerta` VALUES (2,'2026-05-01 10:44:00','pendiente',11,4),(3,'2026-05-01 10:44:00','pendiente',11,4),(4,'2026-05-01 10:46:00','pendiente',11,4),(5,'2026-05-01 11:00:06','pendiente',11,7),(6,'2026-05-01 11:02:28','pendiente',11,4),(7,'2026-05-01 11:02:42','pendiente',11,4),(8,'2026-05-01 11:03:10','pendiente',11,4);
/*!40000 ALTER TABLE `alerta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departamento`
--

DROP TABLE IF EXISTS `departamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `departamento` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `observaciones` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_40E497EB3A909126` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departamento`
--

LOCK TABLES `departamento` WRITE;
/*!40000 ALTER TABLE `departamento` DISABLE KEYS */;
INSERT INTO `departamento` VALUES (30,'Matemáticas','Profesores del departamento de matemáticas'),(31,'Informática','Profesores del departamento de informática');
/*!40000 ALTER TABLE `departamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20260217203446','2026-02-17 20:34:55',1781),('DoctrineMigrations\\Version20260218205603','2026-02-18 20:56:07',154),('DoctrineMigrations\\Version20260224204021','2026-02-24 20:40:31',205),('DoctrineMigrations\\Version20260225200007','2026-02-25 20:00:20',128),('DoctrineMigrations\\Version20260304182606','2026-03-04 18:26:18',52);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `llave`
--

DROP TABLE IF EXISTS `llave`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `llave` (
  `id` int NOT NULL AUTO_INCREMENT,
  `codigo` varchar(25) NOT NULL,
  `descripcion` varchar(250) DEFAULT NULL,
  `ubicacion` varchar(100) DEFAULT NULL,
  `disponible` tinyint NOT NULL DEFAULT '1',
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_E6B8CF5A20332D99` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `llave`
--

LOCK TABLES `llave` WRITE;
/*!40000 ALTER TABLE `llave` DISABLE KEYS */;
INSERT INTO `llave` VALUES (9,'dinf','Llave del departamento de informática','Armario 4',1,NULL),(10,'m123','llave maestra de las aulas de ESO','Armario 1',1,NULL);
/*!40000 ALTER TABLE `llave` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750` (`queue_name`,`available_at`,`delivered_at`,`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messenger_messages`
--

LOCK TABLES `messenger_messages` WRITE;
/*!40000 ALTER TABLE `messenger_messages` DISABLE KEYS */;
INSERT INTO `messenger_messages` VALUES (1,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:51:\\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\\":2:{s:60:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\\";O:39:\\\"Symfony\\\\Bridge\\\\Twig\\\\Mime\\\\TemplatedEmail\\\":5:{i:0;s:35:\\\"emails/welcome_invitation.html.twig\\\";i:1;N;i:2;a:3:{s:7:\\\"usuario\\\";O:18:\\\"App\\\\Entity\\\\Usuario\\\":13:{s:22:\\\"\\0App\\\\Entity\\\\Usuario\\0id\\\";i:8;s:28:\\\"\\0App\\\\Entity\\\\Usuario\\0username\\\";s:7:\\\"irammar\\\";s:25:\\\"\\0App\\\\Entity\\\\Usuario\\0roles\\\";a:0:{}s:28:\\\"\\0App\\\\Entity\\\\Usuario\\0password\\\";s:8:\\\"760e8c38\\\";s:26:\\\"\\0App\\\\Entity\\\\Usuario\\0nombre\\\";s:4:\\\"Inma\\\";s:29:\\\"\\0App\\\\Entity\\\\Usuario\\0apellido1\\\";s:6:\\\"Pérez\\\";s:29:\\\"\\0App\\\\Entity\\\\Usuario\\0apellido2\\\";s:2:\\\"RM\\\";s:25:\\\"\\0App\\\\Entity\\\\Usuario\\0email\\\";s:18:\\\"inmarm82@gmail.com\\\";s:28:\\\"\\0App\\\\Entity\\\\Usuario\\0telefono\\\";s:9:\\\"615695957\\\";s:30:\\\"\\0App\\\\Entity\\\\Usuario\\0deleted_at\\\";N;s:32:\\\"\\0App\\\\Entity\\\\Usuario\\0departamento\\\";O:23:\\\"App\\\\Entity\\\\Departamento\\\":4:{s:27:\\\"\\0App\\\\Entity\\\\Departamento\\0id\\\";i:16;s:31:\\\"\\0App\\\\Entity\\\\Departamento\\0nombre\\\";s:12:\\\"Matemáticas\\\";s:38:\\\"\\0App\\\\Entity\\\\Departamento\\0observaciones\\\";s:28:\\\"Departamento de matemáticas\\\";s:33:\\\"\\0App\\\\Entity\\\\Departamento\\0usuarios\\\";O:33:\\\"Doctrine\\\\ORM\\\\PersistentCollection\\\":2:{s:13:\\\"\\0*\\0collection\\\";O:43:\\\"Doctrine\\\\Common\\\\Collections\\\\ArrayCollection\\\":1:{s:53:\\\"\\0Doctrine\\\\Common\\\\Collections\\\\ArrayCollection\\0elements\\\";a:0:{}}s:14:\\\"\\0*\\0initialized\\\";b:0;}}s:40:\\\"\\0App\\\\Entity\\\\Usuario\\0prestamosSolicitados\\\";O:33:\\\"Doctrine\\\\ORM\\\\PersistentCollection\\\":2:{s:13:\\\"\\0*\\0collection\\\";O:43:\\\"Doctrine\\\\Common\\\\Collections\\\\ArrayCollection\\\":1:{s:53:\\\"\\0Doctrine\\\\Common\\\\Collections\\\\ArrayCollection\\0elements\\\";a:0:{}}s:14:\\\"\\0*\\0initialized\\\";b:1;}s:40:\\\"\\0App\\\\Entity\\\\Usuario\\0prestamosRegistrados\\\";O:33:\\\"Doctrine\\\\ORM\\\\PersistentCollection\\\":2:{s:13:\\\"\\0*\\0collection\\\";O:43:\\\"Doctrine\\\\Common\\\\Collections\\\\ArrayCollection\\\":1:{s:53:\\\"\\0Doctrine\\\\Common\\\\Collections\\\\ArrayCollection\\0elements\\\";a:0:{}}s:14:\\\"\\0*\\0initialized\\\";b:1;}}s:8:\\\"resetUrl\\\";s:83:\\\"http://127.0.0.1:8000/reset-password/reset/nTzfXEWAR2LXGzINN696hN8JkmJOmP0CjyFXPHOV\\\";s:9:\\\"expiresAt\\\";O:8:\\\"DateTime\\\":3:{s:4:\\\"date\\\";s:26:\\\"2026-02-26 20:59:23.666013\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}i:3;a:6:{i:0;N;i:1;N;i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\\":2:{s:46:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\\";a:3:{s:4:\\\"from\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:4:\\\"From\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:19:\\\"no-reply@edukey.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:13:\\\"EduKey System\\\";}}}}s:2:\\\"to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:2:\\\"To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:18:\\\"inmarm82@gmail.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:7:\\\"subject\\\";a:1:{i:0;O:48:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:7:\\\"Subject\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:55:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\\";s:41:\\\"Bienvenido a EduKey - Crea tu contraseña\\\";}}}s:49:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\\";i:76;}i:1;N;}}i:4;N;}s:61:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\\";N;}}','[]','default','2026-02-24 20:59:23','2026-02-24 20:59:23',NULL),(2,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:51:\\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\\":2:{s:60:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\\";O:39:\\\"Symfony\\\\Bridge\\\\Twig\\\\Mime\\\\TemplatedEmail\\\":5:{i:0;s:35:\\\"emails/welcome_invitation.html.twig\\\";i:1;N;i:2;a:3:{s:7:\\\"usuario\\\";O:18:\\\"App\\\\Entity\\\\Usuario\\\":13:{s:22:\\\"\\0App\\\\Entity\\\\Usuario\\0id\\\";i:9;s:28:\\\"\\0App\\\\Entity\\\\Usuario\\0username\\\";s:5:\\\"user4\\\";s:25:\\\"\\0App\\\\Entity\\\\Usuario\\0roles\\\";a:0:{}s:28:\\\"\\0App\\\\Entity\\\\Usuario\\0password\\\";s:8:\\\"06af1c68\\\";s:26:\\\"\\0App\\\\Entity\\\\Usuario\\0nombre\\\";s:1:\\\"4\\\";s:29:\\\"\\0App\\\\Entity\\\\Usuario\\0apellido1\\\";s:1:\\\"4\\\";s:29:\\\"\\0App\\\\Entity\\\\Usuario\\0apellido2\\\";s:1:\\\"4\\\";s:25:\\\"\\0App\\\\Entity\\\\Usuario\\0email\\\";s:14:\\\"admin@admin.es\\\";s:28:\\\"\\0App\\\\Entity\\\\Usuario\\0telefono\\\";s:9:\\\"444444444\\\";s:30:\\\"\\0App\\\\Entity\\\\Usuario\\0deleted_at\\\";N;s:32:\\\"\\0App\\\\Entity\\\\Usuario\\0departamento\\\";O:23:\\\"App\\\\Entity\\\\Departamento\\\":4:{s:27:\\\"\\0App\\\\Entity\\\\Departamento\\0id\\\";i:16;s:31:\\\"\\0App\\\\Entity\\\\Departamento\\0nombre\\\";s:12:\\\"Matemáticas\\\";s:38:\\\"\\0App\\\\Entity\\\\Departamento\\0observaciones\\\";s:28:\\\"Departamento de matemáticas\\\";s:33:\\\"\\0App\\\\Entity\\\\Departamento\\0usuarios\\\";O:33:\\\"Doctrine\\\\ORM\\\\PersistentCollection\\\":2:{s:13:\\\"\\0*\\0collection\\\";O:43:\\\"Doctrine\\\\Common\\\\Collections\\\\ArrayCollection\\\":1:{s:53:\\\"\\0Doctrine\\\\Common\\\\Collections\\\\ArrayCollection\\0elements\\\";a:0:{}}s:14:\\\"\\0*\\0initialized\\\";b:0;}}s:40:\\\"\\0App\\\\Entity\\\\Usuario\\0prestamosSolicitados\\\";O:33:\\\"Doctrine\\\\ORM\\\\PersistentCollection\\\":2:{s:13:\\\"\\0*\\0collection\\\";O:43:\\\"Doctrine\\\\Common\\\\Collections\\\\ArrayCollection\\\":1:{s:53:\\\"\\0Doctrine\\\\Common\\\\Collections\\\\ArrayCollection\\0elements\\\";a:0:{}}s:14:\\\"\\0*\\0initialized\\\";b:1;}s:40:\\\"\\0App\\\\Entity\\\\Usuario\\0prestamosRegistrados\\\";O:33:\\\"Doctrine\\\\ORM\\\\PersistentCollection\\\":2:{s:13:\\\"\\0*\\0collection\\\";O:43:\\\"Doctrine\\\\Common\\\\Collections\\\\ArrayCollection\\\":1:{s:53:\\\"\\0Doctrine\\\\Common\\\\Collections\\\\ArrayCollection\\0elements\\\";a:0:{}}s:14:\\\"\\0*\\0initialized\\\";b:1;}}s:8:\\\"resetUrl\\\";s:83:\\\"http://127.0.0.1:8000/reset-password/reset/PII9zs29E0Qw3iKWKuWFBFMVYTqnLQyypfo8HYPO\\\";s:9:\\\"expiresAt\\\";O:8:\\\"DateTime\\\":3:{s:4:\\\"date\\\";s:26:\\\"2026-02-26 21:03:27.304379\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}i:3;a:6:{i:0;N;i:1;N;i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\\":2:{s:46:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\\";a:3:{s:4:\\\"from\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:4:\\\"From\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:19:\\\"no-reply@edukey.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:13:\\\"EduKey System\\\";}}}}s:2:\\\"to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:2:\\\"To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:14:\\\"admin@admin.es\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:7:\\\"subject\\\";a:1:{i:0;O:48:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:7:\\\"Subject\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:55:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\\";s:41:\\\"Bienvenido a EduKey - Crea tu contraseña\\\";}}}s:49:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\\";i:76;}i:1;N;}}i:4;N;}s:61:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\\";N;}}','[]','default','2026-02-24 21:03:27','2026-02-24 21:03:27',NULL),(3,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:51:\\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\\":2:{s:60:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\\";O:39:\\\"Symfony\\\\Bridge\\\\Twig\\\\Mime\\\\TemplatedEmail\\\":5:{i:0;s:35:\\\"emails/welcome_invitation.html.twig\\\";i:1;N;i:2;a:3:{s:7:\\\"usuario\\\";O:18:\\\"App\\\\Entity\\\\Usuario\\\":13:{s:22:\\\"\\0App\\\\Entity\\\\Usuario\\0id\\\";i:11;s:28:\\\"\\0App\\\\Entity\\\\Usuario\\0username\\\";s:7:\\\"eryerty\\\";s:25:\\\"\\0App\\\\Entity\\\\Usuario\\0roles\\\";a:0:{}s:28:\\\"\\0App\\\\Entity\\\\Usuario\\0password\\\";s:8:\\\"22fb4799\\\";s:26:\\\"\\0App\\\\Entity\\\\Usuario\\0nombre\\\";s:4:\\\"erty\\\";s:29:\\\"\\0App\\\\Entity\\\\Usuario\\0apellido1\\\";s:4:\\\"erty\\\";s:29:\\\"\\0App\\\\Entity\\\\Usuario\\0apellido2\\\";s:4:\\\"erty\\\";s:25:\\\"\\0App\\\\Entity\\\\Usuario\\0email\\\";s:18:\\\"inmarm82@gmail.com\\\";s:28:\\\"\\0App\\\\Entity\\\\Usuario\\0telefono\\\";s:9:\\\"615695957\\\";s:30:\\\"\\0App\\\\Entity\\\\Usuario\\0deleted_at\\\";N;s:32:\\\"\\0App\\\\Entity\\\\Usuario\\0departamento\\\";O:23:\\\"App\\\\Entity\\\\Departamento\\\":4:{s:27:\\\"\\0App\\\\Entity\\\\Departamento\\0id\\\";i:16;s:31:\\\"\\0App\\\\Entity\\\\Departamento\\0nombre\\\";s:12:\\\"Matemáticas\\\";s:38:\\\"\\0App\\\\Entity\\\\Departamento\\0observaciones\\\";s:28:\\\"Departamento de matemáticas\\\";s:33:\\\"\\0App\\\\Entity\\\\Departamento\\0usuarios\\\";O:33:\\\"Doctrine\\\\ORM\\\\PersistentCollection\\\":2:{s:13:\\\"\\0*\\0collection\\\";O:43:\\\"Doctrine\\\\Common\\\\Collections\\\\ArrayCollection\\\":1:{s:53:\\\"\\0Doctrine\\\\Common\\\\Collections\\\\ArrayCollection\\0elements\\\";a:0:{}}s:14:\\\"\\0*\\0initialized\\\";b:0;}}s:40:\\\"\\0App\\\\Entity\\\\Usuario\\0prestamosSolicitados\\\";O:33:\\\"Doctrine\\\\ORM\\\\PersistentCollection\\\":2:{s:13:\\\"\\0*\\0collection\\\";O:43:\\\"Doctrine\\\\Common\\\\Collections\\\\ArrayCollection\\\":1:{s:53:\\\"\\0Doctrine\\\\Common\\\\Collections\\\\ArrayCollection\\0elements\\\";a:0:{}}s:14:\\\"\\0*\\0initialized\\\";b:1;}s:40:\\\"\\0App\\\\Entity\\\\Usuario\\0prestamosRegistrados\\\";O:33:\\\"Doctrine\\\\ORM\\\\PersistentCollection\\\":2:{s:13:\\\"\\0*\\0collection\\\";O:43:\\\"Doctrine\\\\Common\\\\Collections\\\\ArrayCollection\\\":1:{s:53:\\\"\\0Doctrine\\\\Common\\\\Collections\\\\ArrayCollection\\0elements\\\";a:0:{}}s:14:\\\"\\0*\\0initialized\\\";b:1;}}s:8:\\\"resetUrl\\\";s:83:\\\"http://127.0.0.1:8000/reset-password/reset/wgNxYfxPuiTUhqgB5ryXsetmwvvQUCwXClSBk9fe\\\";s:9:\\\"expiresAt\\\";O:8:\\\"DateTime\\\":3:{s:4:\\\"date\\\";s:26:\\\"2026-02-26 21:06:58.212665\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}i:3;a:6:{i:0;N;i:1;N;i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\\":2:{s:46:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\\";a:3:{s:4:\\\"from\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:4:\\\"From\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:19:\\\"no-reply@edukey.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:13:\\\"EduKey System\\\";}}}}s:2:\\\"to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:2:\\\"To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:18:\\\"inmarm82@gmail.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:7:\\\"subject\\\";a:1:{i:0;O:48:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:7:\\\"Subject\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:55:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\\";s:41:\\\"Bienvenido a EduKey - Crea tu contraseña\\\";}}}s:49:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\\";i:76;}i:1;N;}}i:4;N;}s:61:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\\";N;}}','[]','default','2026-02-24 21:06:58','2026-02-24 21:06:58',NULL);
/*!40000 ALTER TABLE `messenger_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prestamo`
--

DROP TABLE IF EXISTS `prestamo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prestamo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `f_prest` datetime NOT NULL,
  `f_devo` datetime DEFAULT NULL,
  `tiempo_lim` datetime DEFAULT NULL,
  `observaciones` varchar(250) DEFAULT NULL,
  `llave_id` int NOT NULL,
  `docente_id` int NOT NULL,
  `personal_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F4D874F28EB29E8F` (`llave_id`),
  KEY `IDX_F4D874F294E27525` (`docente_id`),
  KEY `IDX_F4D874F25D430949` (`personal_id`),
  CONSTRAINT `FK_F4D874F25D430949` FOREIGN KEY (`personal_id`) REFERENCES `usuario` (`id`),
  CONSTRAINT `FK_F4D874F28EB29E8F` FOREIGN KEY (`llave_id`) REFERENCES `llave` (`id`),
  CONSTRAINT `FK_F4D874F294E27525` FOREIGN KEY (`docente_id`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prestamo`
--

LOCK TABLES `prestamo` WRITE;
/*!40000 ALTER TABLE `prestamo` DISABLE KEYS */;
INSERT INTO `prestamo` VALUES (11,'2026-04-21 17:33:00','2026-05-01 11:06:55',NULL,'Personal sustituto',9,20,4),(12,'2026-04-23 08:30:00','2026-05-01 10:29:49','2026-05-25 08:30:00','La tiene que devolver dentro de un mes',10,19,4);
/*!40000 ALTER TABLE `prestamo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recurso`
--

DROP TABLE IF EXISTS `recurso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recurso` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(250) DEFAULT NULL,
  `tipo` varchar(50) NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B2BB37643A909126` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recurso`
--

LOCK TABLES `recurso` WRITE;
/*!40000 ALTER TABLE `recurso` DISABLE KEYS */;
INSERT INTO `recurso` VALUES (9,'Laboratorio ciencias 1','Laboratorio del edificio nuevo del departamento de ciencias','Laboratorio',NULL),(13,'Departamento de Informática','Departamento de los profesores de informática','Departamento',NULL),(14,'Aula 1','Aulas del pasillo de abajo','Aula',NULL),(15,'Aula 2','Aula destinada a las clases de ESO','Aula',NULL);
/*!40000 ALTER TABLE `recurso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reset_password_request`
--

DROP TABLE IF EXISTS `reset_password_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reset_password_request` (
  `id` int NOT NULL AUTO_INCREMENT,
  `selector` varchar(20) NOT NULL,
  `hashed_token` varchar(100) NOT NULL,
  `requested_at` datetime NOT NULL,
  `expires_at` datetime NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7CE748AA76ED395` (`user_id`),
  CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reset_password_request`
--

LOCK TABLES `reset_password_request` WRITE;
/*!40000 ALTER TABLE `reset_password_request` DISABLE KEYS */;
/*!40000 ALTER TABLE `reset_password_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_alerta`
--

DROP TABLE IF EXISTS `tipo_alerta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_alerta` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `mensaje` varchar(250) NOT NULL,
  `gravedad` varchar(20) NOT NULL,
  `consecuencia` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_917A473B3A909126` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_alerta`
--

LOCK TABLES `tipo_alerta` WRITE;
/*!40000 ALTER TABLE `tipo_alerta` DISABLE KEYS */;
INSERT INTO `tipo_alerta` VALUES (4,'Llave no devueltaee','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque sed posuere sapien. Suspendisse imperdiet eget magna sed tristique. Quisque arcu lacus, feugiat et rhoncus eget, vulputate ut quam. Curabitur gravida iaculis porta. Fusce pulvinar enim','Crítica','No usar el salon de actos en una semana'),(7,'werwer','werwer','Baja','werweri'),(8,'werwerwer','wegg','Alta','werwer');
/*!40000 ALTER TABLE `tipo_alerta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido1` varchar(50) NOT NULL,
  `apellido2` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `departamento_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_USERNAME` (`username`),
  KEY `IDX_2265B05D5A91C08D` (`departamento_id`),
  CONSTRAINT `FK_2265B05D5A91C08D` FOREIGN KEY (`departamento_id`) REFERENCES `departamento` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (4,'admin','[\"ROLE_ADMIN\"]','$2y$13$wp9YwcCoQ1ilsFrNfsada.TBFQLLxcbet0cu7MJIszhoZJQT0mrZe','Joaquín','Pérez','Reyes','admin@edukey.com','666111222',NULL,31),(14,'personal','[\"ROLE_PERSONAL\"]','$2y$13$/v0I/KF2mNyiilAOL7.qbOgYzKNY57qwz6HA3QC0gaCSbOMsi.lF2','Ángela','Díaz','Marín','personal@edukey.es','666777888',NULL,NULL),(19,'docente1','[\"ROLE_USER\"]','$2y$13$pBS.yPXuvG8el73Gh/eBqOr2PNejosjVLKL0XlcjmhZ08D9LbyOg6','Juan','Pérez','Torres','docente1@edukey.es','666555333',NULL,30),(20,'docente2','[]','$2y$13$0LoxhsSqQfY7gDJChmQrEuELnlXTNs5uIBrZj3/tBxhHoxzX6Nl/q','Ana','López','Fernández','docente2@edukey.es','666111222',NULL,31);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-02  8:20:29
