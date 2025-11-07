-- MySQL dump 10.19  Distrib 10.3.29-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: hms
-- ------------------------------------------------------
-- Server version	10.3.29-MariaDB-0ubuntu0.20.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `attendances`
--

DROP TABLE IF EXISTS `attendances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attendances` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timestamp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendances`
--

LOCK TABLES `attendances` WRITE;
/*!40000 ALTER TABLE `attendances` DISABLE KEYS */;
/*!40000 ALTER TABLE `attendances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banks`
--

DROP TABLE IF EXISTS `banks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `wasl_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount_iqd` double(20,8) DEFAULT NULL,
  `amount_usd` double(20,8) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banks`
--

LOCK TABLES `banks` WRITE;
/*!40000 ALTER TABLE `banks` DISABLE KEYS */;
INSERT INTO `banks` VALUES (1,'1','سحب من الخزينة',10000.00000000,20.00000000,'2022-02-20',5,'2022-02-19 23:05:06','2022-02-19 23:05:06'),(2,'5','ي',10000.00000000,NULL,'2022-03-26',22,'2022-03-26 10:13:35','2022-03-26 10:13:35'),(3,'2001','نتسيب',10000.00000000,NULL,'2022-03-26',22,'2022-03-26 10:18:14','2022-03-26 10:18:14'),(4,'555','تا',10000.00000000,NULL,'2022-03-26',22,'2022-03-26 10:25:08','2022-03-26 10:25:08');
/*!40000 ALTER TABLE `banks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `checkups`
--

DROP TABLE IF EXISTS `checkups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `checkups` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doctor_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `checkups`
--

LOCK TABLES `checkups` WRITE;
/*!40000 ALTER TABLE `checkups` DISABLE KEYS */;
/*!40000 ALTER TABLE `checkups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clinics`
--

DROP TABLE IF EXISTS `clinics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clinics` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doctor_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clinics`
--

LOCK TABLES `clinics` WRITE;
/*!40000 ALTER TABLE `clinics` DISABLE KEYS */;
INSERT INTO `clinics` VALUES (2,'عيادة استشارية','21','2021-12-29 13:08:00','2021-12-29 13:08:00');
/*!40000 ALTER TABLE `clinics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employees` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cardno` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `follow_ups`
--

DROP TABLE IF EXISTS `follow_ups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `follow_ups` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `drain` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `itake` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spo2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Temp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `output` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) NOT NULL,
  `pat_id` bigint(20) DEFAULT NULL,
  `treatment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `follow_ups`
--

LOCK TABLES `follow_ups` WRITE;
/*!40000 ALTER TABLE `follow_ups` DISABLE KEYS */;
INSERT INTO `follow_ups` VALUES (1,'10','25','30','45','25','30','12',32,20210441,'شكر زايد','2022-03-29','2022-03-28 23:34:26','2022-03-29 00:06:11'),(2,'5','5','5','5','5','5','5',36,20210446,'5','2022-03-30','2022-03-30 09:44:07','2022-03-30 09:44:07');
/*!40000 ALTER TABLE `follow_ups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lab_categories`
--

DROP TABLE IF EXISTS `lab_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lab_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lab_categories`
--

LOCK TABLES `lab_categories` WRITE;
/*!40000 ALTER TABLE `lab_categories` DISABLE KEYS */;
INSERT INTO `lab_categories` VALUES (1,'قسم 1','2022-03-27 19:54:42','2022-03-27 19:54:42'),(2,'قسم 2','2022-03-27 19:54:45','2022-03-27 19:54:45');
/*!40000 ALTER TABLE `lab_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lab_settings`
--

DROP TABLE IF EXISTS `lab_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lab_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double(24,8) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lab_settings`
--

LOCK TABLES `lab_settings` WRITE;
/*!40000 ALTER TABLE `lab_settings` DISABLE KEYS */;
INSERT INTO `lab_settings` VALUES (1,'فحص دم',8000.00000000,'2022-02-25 14:56:14','2022-02-25 14:56:14');
/*!40000 ALTER TABLE `lab_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lab_tests`
--

DROP TABLE IF EXISTS `lab_tests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lab_tests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double(24,8) NOT NULL DEFAULT 0.00000000,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lab_tests`
--

LOCK TABLES `lab_tests` WRITE;
/*!40000 ALTER TABLE `lab_tests` DISABLE KEYS */;
INSERT INTO `lab_tests` VALUES (9,'β.hCG',8000.00000000,1,'2022-03-27 20:14:45','2022-03-27 20:14:45'),(10,'C-Reactive Protein (C.R.P.)',3000.00000000,2,'2022-03-27 20:18:33','2022-03-27 20:18:33'),(11,'هرمونات',5000.00000000,1,'2022-03-30 09:20:00','2022-03-30 09:20:00');
/*!40000 ALTER TABLE `lab_tests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `labs`
--

DROP TABLE IF EXISTS `labs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `labs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `labs`
--

LOCK TABLES `labs` WRITE;
/*!40000 ALTER TABLE `labs` DISABLE KEYS */;
/*!40000 ALTER TABLE `labs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `log_date` datetime NOT NULL,
  `table_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `log_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
INSERT INTO `logs` VALUES (1,5,'2022-01-27 15:56:46','','login','{\"ip\":\"82.199.221.38\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/97.0.4692.99 Safari\\/537.36\"}'),(2,5,'2022-01-28 11:58:10','','login','{\"ip\":\"82.199.221.38\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/97.0.4692.99 Safari\\/537.36\"}'),(3,5,'2022-01-28 12:04:18','patients','edit','{\"id\":20210390,\"name\":\"\\u0645\\u062d\\u0645\\u062f \\u0645\\u0639\\u062a\\u0632 \\u063a\\u0627\\u0632\\u064a\",\"gender\":\"\\u0627\\u0646\\u062b\\u0649\",\"age\":\"20\",\"image\":null,\"clinic_id\":null,\"phone\":\"07518775861\",\"status\":\"1\",\"notes\":null,\"room_id\":null,\"doctor_id\":null,\"opration_id\":null,\"inter_at\":\"2022-01-28\",\"identity_circule\":null,\"identity_page\":null,\"identity_book\":null,\"relaitve_name\":null,\"relaitve_phone\":null,\"job\":null,\"mother\":null,\"husbandname\":null,\"idSingle\":null,\"iddate\":null,\"idcreatejeha\":null,\"identity_number\":null,\"Nationality\":\"\\u0639\\u0631\\u0627\\u0642\\u064a\",\"adress\":null,\"paid\":0,\"xray\":0,\"sonar\":0,\"clcdoctor\":0,\"hms_nsba\":60,\"redirect_doctor_id\":null,\"created_at\":\"2022-01-28 12:01:56\",\"updated_at\":\"2022-01-28 12:01:56\"}'),(4,5,'2022-01-28 12:04:46','patients','edit','{\"id\":20210390,\"name\":\"\\u0645\\u062d\\u0645\\u062f \\u0645\\u0639\\u062a\\u0632 \\u063a\\u0627\\u0632\\u064a\",\"gender\":\"\\u0627\\u0646\\u062b\\u0649\",\"age\":\"20\",\"image\":null,\"clinic_id\":null,\"phone\":\"07518775861\",\"status\":\"5\",\"notes\":null,\"room_id\":31,\"doctor_id\":26,\"opration_id\":5,\"inter_at\":\"2022-01-28\",\"identity_circule\":\"\\u062d\\u064a \\u0627\\u0644\\u0646\\u0648\\u0631\",\"identity_page\":\"\\u062e\\u062b\",\"identity_book\":\"\\u062b\",\"relaitve_name\":null,\"relaitve_phone\":null,\"job\":\"\\u0645\\u0628\\u0631\\u0645\\u062c\",\"mother\":\"\\u062a\\u064a\\u0633\\u062a\",\"husbandname\":\"\\u062a\\u064a\\u0633\\u062a\",\"idSingle\":null,\"iddate\":null,\"idcreatejeha\":null,\"identity_number\":\"\\u062b\\u0636\",\"Nationality\":\"\\u0639\\u0631\\u0627\\u0642\\u064a\",\"adress\":\"\\u0641\\u0634\\u0633\\u0646\\u064a\",\"paid\":0,\"xray\":0,\"sonar\":0,\"clcdoctor\":0,\"hms_nsba\":60,\"redirect_doctor_id\":null,\"created_at\":\"2022-01-28 12:01:56\",\"updated_at\":\"2022-01-28 12:04:18\"}'),(5,5,'2022-01-28 12:05:53','patients','edit','{\"id\":20210390,\"name\":\"\\u0645\\u062d\\u0645\\u062f \\u0645\\u0639\\u062a\\u0632 \\u063a\\u0627\\u0632\\u064a\",\"gender\":\"\\u0627\\u0646\\u062b\\u0649\",\"age\":\"20\",\"image\":null,\"clinic_id\":null,\"phone\":\"07518775861\",\"status\":\"5\",\"notes\":null,\"room_id\":31,\"doctor_id\":26,\"opration_id\":5,\"inter_at\":\"2022-01-28\",\"identity_circule\":\"\\u062d\\u064a \\u0627\\u0644\\u0646\\u0648\\u0631\",\"identity_page\":\"\\u062e\\u062b\",\"identity_book\":\"\\u062b\",\"relaitve_name\":null,\"relaitve_phone\":null,\"job\":\"\\u0645\\u0628\\u0631\\u0645\\u062c\",\"mother\":\"\\u062a\\u064a\\u0633\\u062a\",\"husbandname\":\"\\u062a\\u064a\\u0633\\u062a\",\"idSingle\":null,\"iddate\":null,\"idcreatejeha\":null,\"identity_number\":\"\\u062b\\u0636\",\"Nationality\":\"\\u0639\\u0631\\u0627\\u0642\\u064a\",\"adress\":\"\\u0641\\u0634\\u0633\\u0646\\u064a\",\"paid\":1,\"xray\":0,\"sonar\":0,\"clcdoctor\":0,\"hms_nsba\":60,\"redirect_doctor_id\":null,\"created_at\":\"2022-01-28 12:01:56\",\"updated_at\":\"2022-01-28 12:04:46\"}'),(6,5,'2022-01-28 12:09:31','patients','edit','{\"id\":20210391,\"name\":\"\\u0645\\u062d\\u0645\\u062f \\u0645\\u0639\\u062a\\u0632 \\u063a\\u0627\\u0632\\u064a\",\"gender\":\"\\u0627\\u0646\\u062b\\u0649\",\"age\":\"23\",\"image\":null,\"clinic_id\":null,\"phone\":\"07518775861\",\"status\":\"5\",\"notes\":null,\"room_id\":17,\"doctor_id\":29,\"opration_id\":7,\"inter_at\":\"2022-01-28\",\"identity_circule\":null,\"identity_page\":null,\"identity_book\":null,\"relaitve_name\":null,\"relaitve_phone\":null,\"job\":\"\\u0645\\u0628\\u0631\\u0645\\u062c\",\"mother\":\"\\u0641\\u0644\\u0642\",\"husbandname\":\"\\u0645\\u062d\\u0633\\u0646\",\"idSingle\":null,\"iddate\":null,\"idcreatejeha\":null,\"identity_number\":null,\"Nationality\":\"\\u0639\\u0631\\u0627\\u0642\\u064a\",\"adress\":null,\"paid\":0,\"xray\":0,\"sonar\":0,\"clcdoctor\":0,\"hms_nsba\":60,\"redirect_doctor_id\":null,\"created_at\":\"2022-01-28 12:09:23\",\"updated_at\":\"2022-01-28 12:09:23\"}'),(7,5,'2022-01-28 23:04:13','','login','{\"ip\":\"82.199.221.30\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/97.0.4692.99 Safari\\/537.36\"}'),(8,30,'2022-01-29 00:16:19','','login','{\"ip\":\"82.199.221.30\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/97.0.4692.99 Safari\\/537.36\"}'),(9,5,'2022-01-29 00:21:11','','login','{\"ip\":\"82.199.221.30\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/97.0.4692.99 Safari\\/537.36\"}'),(10,5,'2022-01-30 14:51:14','','login','{\"ip\":\"82.199.220.127\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/97.0.4692.99 Safari\\/537.36\"}'),(11,22,'2022-01-30 20:28:57','','login','{\"ip\":\"37.236.60.50\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/97.0.4692.99 Safari\\/537.36\"}'),(12,5,'2022-01-30 22:40:07','','login','{\"ip\":\"82.199.220.127\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/97.0.4692.99 Safari\\/537.36\"}'),(13,5,'2022-01-31 23:26:53','','login','{\"ip\":\"82.199.220.127\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/97.0.4692.99 Safari\\/537.36\"}'),(14,5,'2022-02-01 13:15:27','','login','{\"ip\":\"82.199.220.127\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/97.0.4692.99 Safari\\/537.36\"}'),(15,22,'2022-02-02 08:11:47','','login','{\"ip\":\"194.127.108.177\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/97.0.4692.99 Safari\\/537.36\"}'),(16,5,'2022-02-02 11:55:18','','login','{\"ip\":\"37.238.68.36\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/97.0.4692.99 Safari\\/537.36\"}'),(17,5,'2022-02-04 23:50:49','','login','{\"ip\":\"82.199.220.56\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/97.0.4692.99 Safari\\/537.36\"}'),(18,5,'2022-02-05 17:52:33','','login','{\"ip\":\"82.199.220.56\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/97.0.4692.99 Safari\\/537.36\"}'),(19,5,'2022-02-12 11:21:17','','login','{\"ip\":\"185.16.26.110\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/97.0.4692.99 Safari\\/537.36\"}'),(20,5,'2022-02-12 22:07:10','','login','{\"ip\":\"82.199.221.83\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.82 Safari\\/537.36\"}'),(21,22,'2022-02-13 07:23:45','','login','{\"ip\":\"194.127.108.183\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.82 Safari\\/537.36\"}'),(22,5,'2022-02-13 12:05:45','','login','{\"ip\":\"185.16.26.36\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.82 Safari\\/537.36\"}'),(23,18,'2022-02-13 15:18:22','','login','{\"ip\":\"185.16.26.36\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.82 Safari\\/537.36\"}'),(24,5,'2022-02-13 15:20:17','','login','{\"ip\":\"185.16.26.36\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.82 Safari\\/537.36\"}'),(25,25,'2022-02-13 15:20:37','','login','{\"ip\":\"185.16.26.36\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.82 Safari\\/537.36\"}'),(26,5,'2022-02-14 11:20:57','','login','{\"ip\":\"82.199.221.54\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.82 Safari\\/537.36\"}'),(27,5,'2022-02-16 22:23:28','','login','{\"ip\":\"82.199.221.54\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.102 Safari\\/537.36\"}'),(28,5,'2022-02-17 10:57:53','','login','{\"ip\":\"82.199.221.54\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.102 Safari\\/537.36\"}'),(29,5,'2022-02-17 22:46:45','','login','{\"ip\":\"185.16.26.16\",\"user_agent\":\"Mozilla\\/5.0 (Linux; Android 10; Redmi Note 9S) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.101 Mobile Safari\\/537.36\"}'),(30,22,'2022-02-19 10:24:23','','login','{\"ip\":\"194.127.108.184\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.82 Safari\\/537.36\"}'),(31,5,'2022-02-19 22:44:08','','login','{\"ip\":\"82.199.221.99\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.102 Safari\\/537.36\"}'),(32,22,'2022-02-20 10:08:23','','login','{\"ip\":\"194.127.108.184\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.102 Safari\\/537.36\"}'),(33,22,'2022-02-20 12:23:33','','login','{\"ip\":\"194.127.108.184\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.102 Safari\\/537.36\"}'),(34,5,'2022-02-20 22:04:48','','login','{\"ip\":\"82.199.223.31\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.102 Safari\\/537.36\"}'),(35,5,'2022-02-22 23:19:39','','login','{\"ip\":\"82.199.221.84\",\"user_agent\":\"Mozilla\\/5.0 (Linux; Android 10; Redmi Note 9S) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.101 Mobile Safari\\/537.36\"}'),(36,22,'2022-02-23 12:20:49','','login','{\"ip\":\"194.127.108.184\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.102 Safari\\/537.36\"}'),(37,5,'2022-02-23 18:54:44','','login','{\"ip\":\"82.199.221.84\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.102 Safari\\/537.36\"}'),(38,22,'2022-02-23 18:57:42','','login','{\"ip\":\"37.236.185.6\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.102 Safari\\/537.36\"}'),(39,5,'2022-02-23 23:20:14','','login','{\"ip\":\"82.199.221.84\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.102 Safari\\/537.36\"}'),(40,5,'2022-02-24 12:26:05','','login','{\"ip\":\"185.16.26.24\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.102 Safari\\/537.36\"}'),(41,5,'2022-02-24 13:04:52','','login','{\"ip\":\"37.239.106.26\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.102 Safari\\/537.36\"}'),(42,5,'2022-02-24 14:41:10','','login','{\"ip\":\"185.16.26.24\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.102 Safari\\/537.36\"}'),(43,5,'2022-02-25 12:48:17','','login','{\"ip\":\"82.199.221.84\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.102 Safari\\/537.36\"}'),(44,22,'2022-02-25 13:52:48','','login','{\"ip\":\"82.199.221.84\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.102 Safari\\/537.36\"}'),(45,31,'2022-02-25 14:38:44','','login','{\"ip\":\"82.199.221.84\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.102 Safari\\/537.36 Edg\\/98.0.1108.56\"}'),(46,32,'2022-02-25 17:12:45','','login','{\"ip\":\"82.199.221.84\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.102 Safari\\/537.36 Edg\\/98.0.1108.56\"}'),(47,25,'2022-02-25 17:33:35','','login','{\"ip\":\"82.199.221.84\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.102 Safari\\/537.36 Edg\\/98.0.1108.56\"}'),(48,5,'2022-02-26 09:49:41','','login','{\"ip\":\"82.199.221.84\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.102 Safari\\/537.36\"}'),(49,5,'2022-02-26 20:42:18','','login','{\"ip\":\"185.16.26.105\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.102 Safari\\/537.36\"}'),(50,5,'2022-02-27 19:16:56','','login','{\"ip\":\"37.239.106.23\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.102 Safari\\/537.36\"}'),(51,5,'2022-02-28 21:59:57','','login','{\"ip\":\"185.16.26.56\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.102 Safari\\/537.36\"}'),(52,5,'2022-03-01 07:39:36','','login','{\"ip\":\"151.236.162.53\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.102 Safari\\/537.36\"}'),(53,5,'2022-03-08 16:52:09','','login','{\"ip\":\"82.199.221.16\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/98.0.4758.102 Safari\\/537.36\"}'),(54,5,'2022-03-09 10:21:03','','login','{\"ip\":\"151.236.162.162\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.51 Safari\\/537.36\"}'),(55,5,'2022-03-17 17:35:27','','login','{\"ip\":\"82.199.221.65\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.74 Safari\\/537.36\"}'),(56,5,'2022-03-20 17:25:58','','login','{\"ip\":\"82.199.221.49\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.74 Safari\\/537.36\"}'),(57,5,'2022-03-21 14:37:04','','login','{\"ip\":\"82.199.221.49\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.74 Safari\\/537.36\"}'),(58,22,'2022-03-21 17:27:03','','login','{\"ip\":\"37.236.185.6\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.74 Safari\\/537.36\"}'),(59,5,'2022-03-21 19:54:53','','login','{\"ip\":\"82.199.221.49\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.74 Safari\\/537.36\"}'),(60,5,'2022-03-22 14:54:35','','login','{\"ip\":\"82.199.221.49\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.74 Safari\\/537.36\"}'),(61,5,'2022-03-23 14:13:06','','login','{\"ip\":\"185.16.26.19\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.74 Safari\\/537.36\"}'),(62,22,'2022-03-26 10:11:42','','login','{\"ip\":\"194.127.108.181\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.82 Safari\\/537.36\"}'),(63,5,'2022-03-27 18:44:37','','login','{\"ip\":\"82.199.223.28\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.82 Safari\\/537.36\"}'),(64,5,'2022-03-28 22:24:53','','login','{\"ip\":\"185.16.26.93\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.82 Safari\\/537.36\"}'),(65,5,'2022-03-28 22:29:01','','login','{\"ip\":\"185.16.26.93\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.74 Safari\\/537.36 Edg\\/99.0.1150.52\"}'),(66,33,'2022-03-28 22:29:10','','login','{\"ip\":\"185.16.26.93\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.74 Safari\\/537.36 Edg\\/99.0.1150.52\"}'),(67,22,'2022-03-28 23:02:54','','login','{\"ip\":\"37.236.185.8\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.82 Safari\\/537.36\"}'),(68,34,'2022-03-28 23:03:28','','login','{\"ip\":\"37.236.185.8\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.82 Safari\\/537.36\"}'),(69,22,'2022-03-28 23:04:30','','login','{\"ip\":\"37.236.185.8\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.82 Safari\\/537.36\"}'),(70,32,'2022-03-28 23:09:21','','login','{\"ip\":\"185.16.26.93\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.74 Safari\\/537.36 Edg\\/99.0.1150.52\"}'),(71,22,'2022-03-30 06:51:00','','login','{\"ip\":\"45.157.53.146\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.82 Safari\\/537.36\"}'),(72,35,'2022-03-30 08:58:06','','login','{\"ip\":\"45.157.53.146\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.82 Safari\\/537.36\"}'),(73,5,'2022-03-30 09:12:39','','login','{\"ip\":\"185.16.26.93\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.84 Safari\\/537.36\"}'),(74,5,'2022-03-30 09:20:57','','login','{\"ip\":\"185.16.26.93\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.82 Safari\\/537.36\"}'),(75,35,'2022-03-30 09:34:59','','login','{\"ip\":\"45.157.53.146\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.82 Safari\\/537.36\"}'),(76,36,'2022-03-30 09:41:18','','login','{\"ip\":\"45.157.53.146\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.82 Safari\\/537.36\"}'),(77,34,'2022-03-30 09:52:28','','login','{\"ip\":\"45.157.53.146\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.82 Safari\\/537.36\"}'),(78,33,'2022-03-30 09:55:24','','login','{\"ip\":\"185.16.26.93\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.84 Safari\\/537.36\"}'),(79,35,'2022-03-30 12:54:29','','login','{\"ip\":\"45.157.53.146\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.82 Safari\\/537.36\"}'),(80,5,'2022-03-30 13:38:50','','login','{\"ip\":\"185.16.26.93\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.84 Safari\\/537.36\"}'),(81,32,'2022-03-30 14:28:31','','login','{\"ip\":\"185.16.26.93\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.74 Safari\\/537.36 Edg\\/99.0.1150.55\"}'),(82,36,'2022-03-30 16:53:46','','login','{\"ip\":\"185.244.177.63\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.84 Safari\\/537.36\"}'),(83,34,'2022-03-30 16:57:17','','login','{\"ip\":\"185.244.177.63\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.84 Safari\\/537.36\"}'),(84,33,'2022-03-30 16:58:12','','login','{\"ip\":\"185.244.177.63\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.84 Safari\\/537.36\"}'),(85,36,'2022-03-30 17:02:25','','login','{\"ip\":\"185.244.177.63\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.84 Safari\\/537.36\"}'),(86,5,'2022-03-30 18:37:27','','login','{\"ip\":\"185.16.26.111\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.84 Safari\\/537.36\"}'),(87,37,'2022-03-30 19:51:41','','login','{\"ip\":\"185.16.26.111\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.84 Safari\\/537.36\"}'),(88,37,'2022-03-30 20:18:37','','login','{\"ip\":\"37.236.185.11\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.84 Safari\\/537.36\"}'),(89,37,'2022-03-31 05:52:37','','login','{\"ip\":\"65.20.205.232\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.82 Safari\\/537.36\"}'),(90,37,'2022-03-31 13:22:46','','login','{\"ip\":\"185.16.26.111\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/99.0.4844.84 Safari\\/537.36\"}');
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medicine_profiles`
--

DROP TABLE IF EXISTS `medicine_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medicine_profiles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `room_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doctor_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `opration_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inter_at` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identity_circule` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identity_page` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identity_book` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `relaitve_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `relaitve_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Nationality` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adress` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medicine_profiles`
--

LOCK TABLES `medicine_profiles` WRITE;
/*!40000 ALTER TABLE `medicine_profiles` DISABLE KEYS */;
/*!40000 ALTER TABLE `medicine_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2021_08_24_231401_create_clinics_table',2),(6,'2021_08_24_233119_create_patients_table',3),(7,'2021_08_25_004931_create_stages_table',4),(8,'2021_08_25_062035_create_checkups_table',5),(9,'2021_08_25_101252_create_operations_table',6),(10,'2021_08_25_101749_create_stocks_table',7),(11,'2021_08_25_103842_create_stockoperations_table',8),(12,'2021_09_06_155703_create_medicine_profiles_table',9),(13,'2021_09_11_121207_create_rays_table',10),(14,'2021_09_22_134736_create_sonars_table',11),(15,'2021_09_29_063837_create_rooms_table',12),(16,'2021_10_05_092430_create_payments_table',13),(17,'2021_12_01_173209_create_warehouses_table',14),(18,'2021_12_01_173234_create_warehouse_items_table',14),(19,'2021_12_04_135906_create_settings_table',15),(20,'2021_12_04_181330_create_warehouse_exports_table',16),(21,'2021_12_04_181339_create_warehouse_export_items_table',16),(22,'2021_12_14_130427_create_attendances_table',17),(23,'2021_12_14_133953_create_employees_table',18),(24,'2022_01_07_174740_create_operation_holds_table',19),(25,'2020_11_20_100001_create_log_table',20),(27,'2022_02_19_225129_create_banks_table',21),(28,'2022_02_25_125219_create_warehouseproducts_table',22),(29,'2022_02_25_141237_create_labs_table',23),(30,'2022_02_25_144359_create_lab_settings_table',24),(31,'2022_03_20_165601_create_lab_tests_table',25),(32,'2022_03_20_170251_create_testcomponets_table',25),(33,'2022_03_21_145214_create_pat_tests_table',26),(34,'2022_03_21_145238_create_pat_test_componets_table',26),(35,'2022_03_27_191952_create_lab_categories_table',27),(36,'2022_03_28_231228_create_follow_ups_table',28);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `operation_holds`
--

DROP TABLE IF EXISTS `operation_holds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `operation_holds` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `patinet_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `doctor_id` bigint(20) NOT NULL,
  `operation_price` bigint(20) NOT NULL,
  `operation_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doctorexp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doctor_paid` tinyint(1) DEFAULT NULL,
  `helper` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `m5dr` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `helperm5dr` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `operation_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_number` int(11) NOT NULL,
  `helper_paid` tinyint(1) DEFAULT NULL,
  `helperm5dr_paid` tinyint(1) DEFAULT NULL,
  `nsba` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `m5dr_paid` tinyint(1) DEFAULT NULL,
  `m5dr_selected` tinyint(1) DEFAULT NULL,
  `qabla_paid` tinyint(1) DEFAULT NULL,
  `qabla` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supervised` int(11) DEFAULT NULL,
  `mqema_paid` int(11) DEFAULT NULL,
  `mqema_id` int(11) DEFAULT NULL,
  `mqema_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nurse_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nurse_paid` tinyint(1) DEFAULT NULL,
  `ambulance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ambulance_paid` tinyint(1) DEFAULT NULL,
  `ambulance_doctor` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `hide` bigint(20) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `operation_holds`
--

LOCK TABLES `operation_holds` WRITE;
/*!40000 ALTER TABLE `operation_holds` DISABLE KEYS */;
/*!40000 ALTER TABLE `operation_holds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `operations`
--

DROP TABLE IF EXISTS `operations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `operations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `operations`
--

LOCK TABLES `operations` WRITE;
/*!40000 ALTER TABLE `operations` DISABLE KEYS */;
INSERT INTO `operations` VALUES (1,NULL,'فتح بطن','600000','2021-08-25 10:16:43','2022-01-23 16:41:23'),(5,NULL,'طبيعي بطن ثاني','200000','2021-10-05 11:35:29','2022-02-13 12:30:15'),(6,NULL,'ولادة طبيعية','500000','2022-01-07 18:54:50','2022-01-07 18:55:07'),(7,NULL,'ولادة قيصرية','700000','2022-01-23 21:35:03','2022-02-13 12:24:32'),(8,NULL,'كرتاج','300000','2022-02-13 12:31:45','2022-02-13 12:31:45'),(9,NULL,'ربط','350000','2022-02-14 11:24:13','2022-02-14 11:24:13');
/*!40000 ALTER TABLE `operations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pat_test_componets`
--

DROP TABLE IF EXISTS `pat_test_componets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pat_test_componets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pat_test_id` bigint(20) DEFAULT NULL,
  `test_id` bigint(20) DEFAULT NULL,
  `componet_id` bigint(20) DEFAULT NULL,
  `result` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pat_test_componets`
--

LOCK TABLES `pat_test_componets` WRITE;
/*!40000 ALTER TABLE `pat_test_componets` DISABLE KEYS */;
INSERT INTO `pat_test_componets` VALUES (7,7,5,12,'10','2022-03-21 15:10:27','2022-03-21 15:10:27'),(9,8,7,8,'2','2022-03-21 16:25:55','2022-03-21 16:25:55'),(10,8,7,9,'10','2022-03-21 16:25:55','2022-03-21 16:25:55'),(11,9,5,12,'4','2022-03-21 16:25:55','2022-03-21 16:25:55'),(12,9,5,13,'10','2022-03-21 16:25:55','2022-03-21 16:25:55'),(13,10,5,12,'5','2022-03-21 17:35:59','2022-03-21 17:35:59'),(14,10,5,13,'5','2022-03-21 17:35:59','2022-03-21 17:35:59'),(15,11,9,15,'10','2022-03-27 20:41:37','2022-03-27 20:41:37'),(16,12,10,16,'5','2022-03-27 20:41:37','2022-03-27 20:41:37'),(17,13,9,15,'0','2022-03-30 09:03:58','2022-03-30 09:03:58'),(18,14,9,15,'5','2022-03-30 09:15:16','2022-03-30 09:15:16'),(19,15,11,17,'55','2022-03-30 09:20:53','2022-03-30 09:20:53'),(20,16,9,15,'5','2022-03-30 09:22:21','2022-03-30 09:22:21'),(21,17,11,17,'8','2022-03-30 09:22:21','2022-03-30 09:22:21'),(22,18,12,18,'5','2022-03-30 09:29:33','2022-03-30 09:29:33'),(23,18,12,19,'5','2022-03-30 09:29:33','2022-03-30 09:29:33'),(24,18,12,20,'5','2022-03-30 09:29:33','2022-03-30 09:29:33'),(25,19,9,15,'555','2022-03-30 09:29:33','2022-03-30 09:29:33'),(26,20,9,15,'3','2022-03-30 12:57:16','2022-03-30 12:57:16'),(27,21,12,18,'2','2022-03-30 12:57:16','2022-03-30 12:57:16'),(28,21,12,19,'2','2022-03-30 12:57:16','2022-03-30 12:57:16'),(29,21,12,20,'2','2022-03-30 12:57:16','2022-03-30 12:57:16'),(30,22,9,15,'4','2022-03-30 14:22:18','2022-03-30 14:22:18'),(31,23,13,21,'negative','2022-03-30 14:25:54','2022-03-30 14:25:54'),(32,24,9,15,'0','2022-03-30 14:52:37','2022-03-30 14:52:37'),(33,25,9,15,'0','2022-03-30 17:10:09','2022-03-30 17:10:09');
/*!40000 ALTER TABLE `pat_test_componets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pat_tests`
--

DROP TABLE IF EXISTS `pat_tests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pat_tests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `lab_id` bigint(20) DEFAULT NULL,
  `test_id` bigint(20) DEFAULT NULL,
  `amount` double(20,4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pat_tests`
--

LOCK TABLES `pat_tests` WRITE;
/*!40000 ALTER TABLE `pat_tests` DISABLE KEYS */;
INSERT INTO `pat_tests` VALUES (7,14,5,8000.0000,'2022-03-21 15:10:27','2022-03-21 15:10:27'),(8,15,7,1600.0000,'2022-03-21 16:25:55','2022-03-21 16:25:55'),(9,15,5,8000.0000,'2022-03-21 16:25:55','2022-03-21 16:25:55'),(10,16,5,8000.0000,'2022-03-21 17:35:59','2022-03-21 17:35:59'),(11,17,9,8000.0000,'2022-03-27 20:41:37','2022-03-27 20:41:37'),(12,17,10,3000.0000,'2022-03-27 20:41:37','2022-03-27 20:41:37'),(13,18,9,8000.0000,'2022-03-30 09:03:58','2022-03-30 09:03:58'),(14,19,9,8000.0000,'2022-03-30 09:15:16','2022-03-30 09:15:16'),(15,20,11,5000.0000,'2022-03-30 09:20:53','2022-03-30 09:20:53'),(16,21,9,8000.0000,'2022-03-30 09:22:21','2022-03-30 09:22:21'),(17,21,11,5000.0000,'2022-03-30 09:22:21','2022-03-30 09:22:21'),(18,22,12,10000.0000,'2022-03-30 09:29:33','2022-03-30 09:29:33'),(19,22,9,8000.0000,'2022-03-30 09:29:33','2022-03-30 09:29:33'),(20,23,9,8000.0000,'2022-03-30 12:57:16','2022-03-30 12:57:16'),(21,23,12,10000.0000,'2022-03-30 12:57:16','2022-03-30 12:57:16'),(22,24,9,8000.0000,'2022-03-30 14:22:18','2022-03-30 14:22:18'),(23,25,13,2.0000,'2022-03-30 14:25:54','2022-03-30 14:25:54'),(24,26,9,8000.0000,'2022-03-30 14:52:37','2022-03-30 14:52:37'),(25,27,9,8000.0000,'2022-03-30 17:10:09','2022-03-30 17:10:09');
/*!40000 ALTER TABLE `pat_tests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patients`
--

DROP TABLE IF EXISTS `patients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `age` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `clinic_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `opration_id` int(11) DEFAULT NULL,
  `inter_at` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identity_circule` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identity_page` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identity_book` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `relaitve_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `relaitve_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `husbandname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idSingle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iddate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idcreatejeha` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identity_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Nationality` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adress` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid` tinyint(1) DEFAULT 0,
  `xray` int(10) unsigned NOT NULL DEFAULT 0,
  `sonar` int(10) unsigned NOT NULL DEFAULT 0,
  `clcdoctor` int(10) unsigned NOT NULL DEFAULT 0,
  `hms_nsba` int(11) DEFAULT NULL,
  `redirect_doctor_id` int(11) DEFAULT NULL,
  `lab` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_lab` decimal(24,8) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20210456 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patients`
--

LOCK TABLES `patients` WRITE;
/*!40000 ALTER TABLE `patients` DISABLE KEYS */;
/*!40000 ALTER TABLE `patients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `payment_number` int(11) DEFAULT NULL,
  `wasl_number` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `patinet_id` bigint(20) unsigned DEFAULT NULL,
  `doctor_id` bigint(20) unsigned NOT NULL,
  `account_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_type` int(11) NOT NULL,
  `payment_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'expense',
  `amount_iqd` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `amount_usd` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `return_iqd` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `return_usd` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `operation_id` int(11) DEFAULT NULL,
  `operation_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `operation_nsba` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `operation_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `operation_profile` double(25,8) DEFAULT NULL,
  `operation_doctor` bigint(20) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` int(11) DEFAULT NULL,
  `redirect_done` int(20) DEFAULT NULL,
  `redirect_doctor_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect_doctor_paid` tinyint(1) DEFAULT NULL,
  `redirect_nurse_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect_nurse_paid` tinyint(1) DEFAULT NULL,
  `redirect_doctor_id` int(11) DEFAULT NULL,
  `is_stage` int(22) DEFAULT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `patinet_id` (`patinet_id`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`patinet_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=394 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rays`
--

DROP TABLE IF EXISTS `rays`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rays` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` bigint(20) unsigned DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `patient_id` (`patient_id`),
  CONSTRAINT `rays_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rays`
--

LOCK TABLES `rays` WRITE;
/*!40000 ALTER TABLE `rays` DISABLE KEYS */;
/*!40000 ALTER TABLE `rays` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rooms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `floor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` VALUES (5,'20210423','غرفة 14','2',NULL,'2022-01-01 07:20:45','2022-02-20 12:24:11'),(6,'20210449','غرفة 13','2',NULL,'2022-01-01 07:20:52','2022-03-30 10:03:51'),(7,'20210437','غرفة 12','2',NULL,'2022-01-01 07:21:05','2022-03-21 20:05:10'),(8,'20210450','غرفة 11','2',NULL,'2022-01-01 07:21:09','2022-03-30 10:07:27'),(9,'20210416','غرفة 10','2',NULL,'2022-01-01 07:21:17','2022-02-13 15:02:18'),(10,NULL,'غرفة 9','2',NULL,'2022-01-01 07:21:26','2022-01-20 14:29:10'),(11,'20210446','غرفة 8','2',NULL,'2022-01-01 07:21:31','2022-03-30 09:25:22'),(12,NULL,'غرفة 7','2',NULL,'2022-01-01 07:21:36','2022-01-30 15:02:18'),(13,'20210439','غرفة 6','2',NULL,'2022-01-01 07:21:48','2022-03-22 15:25:12'),(14,NULL,'غرفة 5','2',NULL,'2022-01-01 07:21:51','2022-01-23 21:58:18'),(15,NULL,'غرفة 4','2',NULL,'2022-01-01 07:22:34','2022-01-19 17:59:59'),(16,'20210431','غرفة 3','2',NULL,'2022-01-01 07:22:39','2022-03-08 16:52:56'),(17,'20210410','غرفة 2','2',NULL,'2022-01-01 07:22:42','2022-02-13 12:21:14'),(18,NULL,'غرفة 1','2',NULL,'2022-01-01 07:22:46','2022-01-11 19:17:10'),(19,NULL,'غرفة 14','3',NULL,'2022-01-01 07:23:01','2022-01-01 07:23:01'),(20,NULL,'غرفة 13','3',NULL,'2022-01-01 07:23:13','2022-01-01 07:23:13'),(21,NULL,'غرفة 12','3',NULL,'2022-01-01 07:23:19','2022-01-01 07:23:19'),(22,'20210429','غرفة 11','3',NULL,'2022-01-01 07:23:32','2022-02-28 22:05:29'),(23,NULL,'غرفة 10','3',NULL,'2022-01-01 07:23:37','2022-02-02 08:21:20'),(24,NULL,'غرفة 9','3',NULL,'2022-01-01 07:23:40','2022-01-01 07:23:40'),(25,NULL,'غرفة 8','3',NULL,'2022-01-01 07:23:44','2022-01-07 19:35:06'),(26,'20210413','غرفة 7','3',NULL,'2022-01-01 07:23:47','2022-02-13 12:33:23'),(27,NULL,'غرفة 6','3',NULL,'2022-01-01 07:23:53','2022-01-07 19:52:45'),(28,'20210419','غرفة 5','3',NULL,'2022-01-01 07:23:58','2022-02-14 11:26:43'),(29,NULL,'غرفة 4','3',NULL,'2022-01-01 07:24:04','2022-01-01 07:24:04'),(30,'20210412','غرفة 3','3',NULL,'2022-01-01 07:24:08','2022-02-13 12:25:03'),(31,NULL,'غرفة 2','3',NULL,'2022-01-01 07:24:12','2022-01-28 12:05:53'),(32,NULL,'غرفة 1','3',NULL,'2022-01-01 07:24:29','2022-01-11 19:17:04');
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `xray` double(20,8) DEFAULT 0.00000000,
  `xray_doctor_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `xray_doctor_id` bigint(20) NOT NULL,
  `sonar` double(20,8) DEFAULT 0.00000000,
  `doctor_sonar_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doctor_sonar_id` bigint(20) NOT NULL,
  `clinic_price` double(20,8) DEFAULT 0.00000000,
  `doctor_price` double(20,8) DEFAULT 0.00000000,
  `doctor_id` bigint(20) NOT NULL,
  `pat_profile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `helper_doctor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `m5dr_doctor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `m5dr_large_doctor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `m5dr_small_doctor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `helper_m5dr_doctor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qabla` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mqema` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `not_supervised` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supervised` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mqema_id` int(11) DEFAULT NULL,
  `nurse_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ambulance` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_op_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `hnsba` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,15000.00000000,'0',21,15000.00000000,'0',21,5000.00000000,10000.00000000,21,'10000','5000','75000','50000','25000','5000','25000','50000','100000','200000',28,'25000','25000','700000','40',NULL,'2022-02-02 09:38:21');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sonars`
--

DROP TABLE IF EXISTS `sonars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sonars` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` bigint(20) unsigned DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `patient_id` (`patient_id`),
  CONSTRAINT `sonars_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sonars`
--

LOCK TABLES `sonars` WRITE;
/*!40000 ALTER TABLE `sonars` DISABLE KEYS */;
/*!40000 ALTER TABLE `sonars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stages`
--

DROP TABLE IF EXISTS `stages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `total_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doctor_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `res_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stages`
--

LOCK TABLES `stages` WRITE;
/*!40000 ALTER TABLE `stages` DISABLE KEYS */;
INSERT INTO `stages` VALUES (1,'العيادة الاستشارية',28,'15000','3500',NULL,'1500',NULL,'2022-01-19 16:57:54'),(2,'المختبر',0,'8000','',NULL,NULL,NULL,'2022-01-11 13:32:12'),(3,'الاشعة',0,'10000','5000',NULL,NULL,NULL,'2022-01-25 13:24:02'),(4,'السونار',0,'10000','5000',NULL,NULL,NULL,'2022-02-05 18:15:39'),(5,'عمليات',0,'','',NULL,NULL,NULL,NULL),(7,'الخدج',0,'200000','',NULL,NULL,NULL,'2022-01-11 13:31:29'),(8,'مصرف الدم',0,'','',NULL,NULL,NULL,NULL),(9,'مبيت',0,'0','',NULL,NULL,NULL,'2022-01-11 13:31:11'),(10,'ECG',0,'7000','',NULL,NULL,NULL,'2022-01-11 13:31:05'),(11,'بيان ولادة',0,'10000','',NULL,NULL,NULL,'2022-01-11 13:30:50'),(12,'اعطاء دم',NULL,'100000','25000','10000',NULL,'2022-01-16 15:30:37','2022-02-20 13:14:45'),(13,'العناية',NULL,'150000','25000','5000',NULL,'2022-01-16 17:42:26','2022-01-16 17:42:26'),(14,'كانيولا',NULL,'3000','0','1000',NULL,'2022-01-17 17:20:22','2022-01-17 17:20:22');
/*!40000 ALTER TABLE `stages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stockoperations`
--

DROP TABLE IF EXISTS `stockoperations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stockoperations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `op_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to_person` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to_department` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stockoperations`
--

LOCK TABLES `stockoperations` WRITE;
/*!40000 ALTER TABLE `stockoperations` DISABLE KEYS */;
/*!40000 ALTER TABLE `stockoperations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stocks`
--

DROP TABLE IF EXISTS `stocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stocks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stocks`
--

LOCK TABLES `stocks` WRITE;
/*!40000 ALTER TABLE `stocks` DISABLE KEYS */;
INSERT INTO `stocks` VALUES (2,NULL,'كمامات','5000','500',NULL,NULL,'2021-11-30 17:45:40','2021-11-30 17:45:40');
/*!40000 ALTER TABLE `stocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `testcomponets`
--

DROP TABLE IF EXISTS `testcomponets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `testcomponets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `test_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `result_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `options` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `normal_range` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `test_id` (`test_id`),
  CONSTRAINT `testcomponets_ibfk_1` FOREIGN KEY (`test_id`) REFERENCES `lab_tests` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testcomponets`
--

LOCK TABLES `testcomponets` WRITE;
/*!40000 ALTER TABLE `testcomponets` DISABLE KEYS */;
INSERT INTO `testcomponets` VALUES (15,9,'β.hCG ','value','[]','mUI/ml','M: <3.0\nF: cyclic women<4.0\nMenopausal women <13.0\nPreg. Women >10days >16.0','2022-03-27 20:14:45','2022-03-27 20:14:45'),(16,10,'C.R.P.','value','[]','','UP to 6','2022-03-27 20:18:33','2022-03-27 20:18:33'),(17,11,'crp','value','[]','ssss','UP to 6','2022-03-30 09:20:00','2022-03-30 09:20:00');
/*!40000 ALTER TABLE `testcomponets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `is_superuser` int(11) DEFAULT 1,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mqema` tinyint(1) DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (34,1,'op','operation',NULL,NULL,'operation',NULL,'$2y$10$1NlPZnDnDtk0vGVy1JwlN.Hup4bCPmCEV.IDIBzuQN73R.mqCiIbi',NULL,'2022-03-28 23:03:17','2022-03-28 23:03:17'),(35,1,'jj','lab',NULL,NULL,'m5tbr',NULL,'$2y$10$pUzjQtItjAIzR0C2hAtNpOlr8jYUYnDPqOmvv2JXt9PSLJSJm8gQa',NULL,'2022-03-30 08:58:04','2022-03-30 08:58:04'),(36,1,'hh','tabq',NULL,NULL,'tabq',NULL,'$2y$10$sZAZB9Lez4xbuK8qKkPUPuKASv9jRZoXVXIrKiDPa9Evx6GjlC6ua',NULL,'2022-03-30 09:41:08','2022-03-30 09:41:08'),(37,1,'admin','superadmin',NULL,NULL,'admin@hms.com',NULL,'$2y$10$vYhYAhPtmnzKnn03no5cFOxRtE1IogjbH.h7Z/uq.g8Uzg.lSAbKW',NULL,'2022-03-30 19:51:41','2022-03-30 19:51:41');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `warehouse_export_items`
--

DROP TABLE IF EXISTS `warehouse_export_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `warehouse_export_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) NOT NULL,
  `qty` double(8,2) DEFAULT 1.00,
  `amount` double(20,8) DEFAULT 0.00000000,
  `total` double(20,8) DEFAULT 0.00000000,
  `export_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `export_id` (`export_id`),
  CONSTRAINT `warehouse_export_items_ibfk_1` FOREIGN KEY (`export_id`) REFERENCES `warehouse_exports` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `warehouse_export_items`
--

LOCK TABLES `warehouse_export_items` WRITE;
/*!40000 ALTER TABLE `warehouse_export_items` DISABLE KEYS */;
INSERT INTO `warehouse_export_items` VALUES (21,4,1.00,0.00000000,0.00000000,8,'2022-03-27 19:04:25','2022-03-27 19:04:25');
/*!40000 ALTER TABLE `warehouse_export_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `warehouse_exports`
--

DROP TABLE IF EXISTS `warehouse_exports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `warehouse_exports` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total` double(20,8) DEFAULT 0.00000000,
  `user_id` bigint(20) NOT NULL,
  `menu_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `warehouse_exports`
--

LOCK TABLES `warehouse_exports` WRITE;
/*!40000 ALTER TABLE `warehouse_exports` DISABLE KEYS */;
INSERT INTO `warehouse_exports` VALUES (8,'2022-03-27','محمد معتز غازي',0.00000000,5,'1','2022-03-27 19:04:25','2022-03-27 19:04:25');
/*!40000 ALTER TABLE `warehouse_exports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `warehouse_items`
--

DROP TABLE IF EXISTS `warehouse_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `warehouse_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `qty` double(8,2) DEFAULT 1.00,
  `amount` double(20,2) DEFAULT 1.00,
  `total` double(20,2) DEFAULT 1.00,
  `warehouses_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `warehouses_id` (`warehouses_id`),
  CONSTRAINT `warehouse_items_ibfk_1` FOREIGN KEY (`warehouses_id`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `warehouse_items`
--

LOCK TABLES `warehouse_items` WRITE;
/*!40000 ALTER TABLE `warehouse_items` DISABLE KEYS */;
INSERT INTO `warehouse_items` VALUES (13,'4',4,1.00,5000.00,5000.00,17,'2022-02-25 13:40:28','2022-02-25 13:40:28'),(14,'5',5,1.00,6000.00,6000.00,17,'2022-02-25 13:40:28','2022-02-25 13:40:28'),(15,'4',4,1.00,1000.00,1000.00,18,'2022-02-25 14:01:11','2022-02-25 14:01:11'),(19,'4',4,5.00,1000.00,5000.00,19,'2022-02-25 15:11:43','2022-02-25 15:11:43');
/*!40000 ALTER TABLE `warehouse_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `warehouseproducts`
--

DROP TABLE IF EXISTS `warehouseproducts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `warehouseproducts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double(24,8) DEFAULT 0.00000000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `warehouseproducts`
--

LOCK TABLES `warehouseproducts` WRITE;
/*!40000 ALTER TABLE `warehouseproducts` DISABLE KEYS */;
INSERT INTO `warehouseproducts` VALUES (4,'قطن',0.00000000,'2022-02-25 13:09:37','2022-02-25 13:09:37'),(5,'كمامة',0.00000000,'2022-02-25 13:09:40','2022-02-25 13:09:40');
/*!40000 ALTER TABLE `warehouseproducts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `warehouses`
--

DROP TABLE IF EXISTS `warehouses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `warehouses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `menu_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total` double(20,2) NOT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `warehouses`
--

LOCK TABLES `warehouses` WRITE;
/*!40000 ALTER TABLE `warehouses` DISABLE KEYS */;
INSERT INTO `warehouses` VALUES (17,'حلول عبقرية','2022-02-25','1','حي السكر شارع النور','07518775861',11000.00,NULL,NULL,5,'2022-02-25 13:40:28','2022-02-25 13:40:28'),(18,'الصلبة','1990-05-05','55','ممم','000',1000.00,NULL,'images/warehouse/Tq7hOHqKp9bBhWIl3lQpvLrNurypWFukk5UfELSh.png',22,'2022-02-25 14:01:11','2022-02-25 14:01:11'),(19,'ييي','2022-02-25','5',NULL,NULL,5000.00,NULL,NULL,5,'2022-02-25 14:06:08','2022-02-25 15:10:32');
/*!40000 ALTER TABLE `warehouses` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-03-31 14:02:48
