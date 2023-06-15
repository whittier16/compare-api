-- MySQL dump 10.13  Distrib 5.5.34, for osx10.6 (i386)
--
-- Host: localhost    Database: comparph_dev
-- ------------------------------------------------------
-- Server version	5.5.34

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
-- Table structure for table `admin_groups`
--

DROP TABLE IF EXISTS `admin_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_groups` (
  `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`alias`,`status`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_groups`
--

LOCK TABLES `admin_groups` WRITE;
/*!40000 ALTER TABLE `admin_groups` DISABLE KEYS */;
INSERT INTO `admin_groups` VALUES ('56c4b6c2-1d54-11e4-b32d-eff91066cccf','Super Admin','Super Admin','super-admin',1,1,'2014-08-06 04:27:59','2014-08-06 18:44:44',NULL,NULL),('574a5eb2-1d59-11e4-b32d-eff91066cccf','Administrator','Administrator','administrator',1,1,'2014-08-06 05:03:48','2014-08-06 17:48:51',NULL,NULL),('d49188a6-1d4e-11e4-b32d-eff91066cccf','User','Basic User','basic-user',1,1,'2014-08-06 03:48:33','2014-08-06 17:49:52',NULL,NULL);
/*!40000 ALTER TABLE `admin_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_users`
--

DROP TABLE IF EXISTS `admin_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_users` (
  `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `group_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `email_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email_address`,`status`,`active`),
  KEY `fk_group_id` (`group_id`),
  CONSTRAINT `fk_group_id` FOREIGN KEY (`group_id`) REFERENCES `admin_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_users`
--

LOCK TABLES `admin_users` WRITE;
/*!40000 ALTER TABLE `admin_users` DISABLE KEYS */;
INSERT INTO `admin_users` VALUES ('a8838d12-1dcc-11e4-b32d-eff91066cccf','56c4b6c2-1d54-11e4-b32d-eff91066cccf','sarah.sampan@novafabrik.com','Sarah','Sampan','97c2c80ec1a7d5566b3b798c44a6ac46b1be14ff','FpF0th68jP0YLUj','sha256:1000:GSyNjlSZBXcn1yR4GVOnItplLEco+eBL:8QqTiewkTIlj8XshnpJ/7q6M2wt7UErI',1,1,'2014-08-06 18:49:16','2014-08-06 18:54:17',NULL,NULL),('c6bcb740-1dcc-11e4-b32d-eff91066cccf','56c4b6c2-1d54-11e4-b32d-eff91066cccf','chi@novafabrik.com','Chi','Calicdan','da9d0558b0edde5e7c90d6642010bba7014c0159','4Y1JcC9VejAD4nEp','sha256:1000:7z8PtiDp++nplt2S3KaJ0/ywn0GyzLMp:vYdDiGrTLudtT6v4Ee4IOX391fIYHGDX',1,1,'2014-08-06 18:50:07','2014-08-06 18:53:46',NULL,NULL);
/*!40000 ALTER TABLE `admin_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `areas`
--

DROP TABLE IF EXISTS `areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `areas` (
  `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `category` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `language` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bounds` text COLLATE utf8_unicode_ci,
  `parent_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lft` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rght` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  `scope` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  `editable` tinyint(1) NOT NULL DEFAULT '0',
  `visibility` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`status`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `areas`
--

LOCK TABLES `areas` WRITE;
/*!40000 ALTER TABLE `areas` DISABLE KEYS */;
INSERT INTO `areas` VALUES ('4b639068-319b-11e4-988c-7d9574853fac','NCR Luzon',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,1,1,'2014-08-31 23:46:18','0000-00-00 00:00:00',NULL,NULL);
/*!40000 ALTER TABLE `areas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brands` (
  `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `company_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `language` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `revenue_value` decimal(10,2) DEFAULT '0.00',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`alias`,`status`,`active`),
  KEY `company_id_idx` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES ('1c28fefa-319b-11e4-988c-7d9574853fac','4c8367bc-319a-11e4-988c-7d9574853fac','Bank of Commerce','bank-of-commerce',NULL,NULL,NULL,NULL,NULL,0,0,'2014-08-31 23:44:59','0000-00-00 00:00:00','','');
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `channels`
--

DROP TABLE IF EXISTS `channels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `channels` (
  `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `vertical_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `revenue_value` decimal(10,2) NOT NULL,
  `per_page` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`status`,`active`,`alias`),
  KEY `fk_channels_vertical_id_idx` (`vertical_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `channels`
--

LOCK TABLES `channels` WRITE;
/*!40000 ALTER TABLE `channels` DISABLE KEYS */;
INSERT INTO `channels` VALUES ('a1d14206-1ea9-11e4-b32d-eff91066cccf','07f44e24-1d43-11e4-b32d-eff91066cccf','Credit Card','Credit Card','credit-card',5.00,10,1,1,'2014-08-07 21:11:04','0000-00-00 00:00:00','',''),('a212fb3c-1eaf-11e4-b32d-eff91066cccf','07f44e24-1d43-11e4-b32d-eff91066cccf','Personal Loan','Personal Loan','personal-loan',5.00,10,1,1,'2014-08-07 21:54:01','2014-08-08 00:08:01','',''),('b094c56e-1eaf-11e4-b32d-eff91066cccf','07f44e24-1d43-11e4-b32d-eff91066cccf','Personal Loan','Personal Loan','personal-loan',5.00,10,0,0,'2014-08-07 21:54:25','0000-00-00 00:00:00','',''),('c6b5edee-1eac-11e4-b32d-eff91066cccf','78d7ca20-1dd0-11e4-b32d-eff91066cccf','Broadband','Broadband','broadband',5.00,10,1,1,'2014-08-07 21:33:34','0000-00-00 00:00:00','',''),('dc7c34e2-1eae-11e4-b32d-eff91066cccf','07f44e24-1d43-11e4-b32d-eff91066cccf','Home Loans','Home Loans','home-loans',5.00,10,1,1,'2014-08-07 21:48:30','0000-00-00 00:00:00','','');
/*!40000 ALTER TABLE `channels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `channels_options`
--

DROP TABLE IF EXISTS `channels_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `channels_options` (
  `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `channel_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `editable` tinyint(1) DEFAULT '0',
  `visibility` tinyint(1) DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`status`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `channels_options`
--

LOCK TABLES `channels_options` WRITE;
/*!40000 ALTER TABLE `channels_options` DISABLE KEYS */;
INSERT INTO `channels_options` VALUES ('f8a145d4-20fe-11e4-b94f-085fc4b84f62','a1d14206-1ea9-11e4-b32d-eff91066cccf','columns','[\"cashback\", \"airmiles\", \"points\", \"annualFee\"]','',1,1,1,1,'2014-08-10 20:26:59','2014-08-10 20:28:45','','');
/*!40000 ALTER TABLE `channels_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `companies` (
  `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `language` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `revenue_value` decimal(10,2) DEFAULT '0.00',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`status`,`active`,`alias`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
INSERT INTO `companies` VALUES ('4c8367bc-319a-11e4-988c-7d9574853fac','Bank of Commerce','bank-of-commerce',NULL,NULL,NULL,NULL,NULL,0,0,'2014-08-31 23:39:10','0000-00-00 00:00:00','','');
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `companies_options`
--

DROP TABLE IF EXISTS `companies_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `companies_options` (
  `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `model_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `editable` tinyint(1) DEFAULT '0',
  `visibility` tinyint(1) DEFAULT '0',
  `active` tinyint(1) DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`status`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies_options`
--

LOCK TABLES `companies_options` WRITE;
/*!40000 ALTER TABLE `companies_options` DISABLE KEYS */;
INSERT INTO `companies_options` VALUES ('6916ee92-2805-11e4-bd33-17609cecca2f','10f0c896-2134-11e4-bb06-0a68ec684316','company','phone','6775467897','',1,0,0,1,'2014-08-19 19:00:43','0000-00-00 00:00:00','',''),('8a048714-2791-11e4-bd33-17609cecca2f','10f0c896-2134-11e4-bb06-0a68ec684316','company','fax','123456789','',1,0,0,1,'2014-08-19 05:11:16','2014-09-02 18:00:41','','');
/*!40000 ALTER TABLE `companies_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `country` (
  `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`status`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `country`
--

LOCK TABLES `country` WRITE;
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
INSERT INTO `country` VALUES ('1535ebcc-22b8-11e4-bd33-17609cecca2f','iso2','',1,1,'2014-08-13 01:04:35','0000-00-00 00:00:00','',''),('4de2ec7a-22b5-11e4-bd33-17609cecca2f','Philippines','',1,1,'2014-08-13 00:44:42','0000-00-00 00:00:00','','');
/*!40000 ALTER TABLE `country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `country_options`
--

DROP TABLE IF EXISTS `country_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `country_options` (
  `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `country_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `editable` tinyint(1) DEFAULT '0',
  `visibility` tinyint(1) DEFAULT '0',
  `active` tinyint(1) DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`status`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `country_options`
--

LOCK TABLES `country_options` WRITE;
/*!40000 ALTER TABLE `country_options` DISABLE KEYS */;
INSERT INTO `country_options` VALUES ('8c1291d6-22b9-11e4-bd33-17609cecca2f','4de2ec7a-22b5-11e4-bd33-17609cecca2f','iso2','PH','',1,1,1,1,'2014-08-13 01:15:04','0000-00-00 00:00:00','','');
/*!40000 ALTER TABLE `country_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `options`
--

DROP TABLE IF EXISTS `options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `options` (
  `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf8_unicode_ci,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `editable` tinyint(1) DEFAULT '0',
  `visibility` tinyint(1) DEFAULT '0',
  `active` tinyint(1) DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`status`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `options`
--

LOCK TABLES `options` WRITE;
/*!40000 ALTER TABLE `options` DISABLE KEYS */;
/*!40000 ALTER TABLE `options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `channel_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `brand_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `icon` tinytext COLLATE utf8_unicode_ci,
  `language` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`alias`,`status`,`active`),
  KEY `idx_channel_id` (`channel_id`),
  KEY `idx_brand_id` (`brand_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES ('b4b42cb2-32fe-11e4-8ce3-5bbea8105782','a1d14206-1ea9-11e4-b32d-eff91066cccf','1c28fefa-319b-11e4-988c-7d9574853fac','Visa Gold',NULL,'visa-gold',0,NULL,'',1,1,'2014-09-02 18:10:26','0000-00-00 00:00:00','',''),('ec7b459e-319c-11e4-988c-7d9574853fac','a1d14206-1ea9-11e4-b32d-eff91066cccf','1c28fefa-319b-11e4-988c-7d9574853fac','Visa Classic',NULL,'visa-classic',0,NULL,'',1,1,'2014-08-31 23:57:58','0000-00-00 00:00:00','','');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products_data`
--

DROP TABLE IF EXISTS `products_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_data` (
  `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `language` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`status`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products_data`
--

LOCK TABLES `products_data` WRITE;
/*!40000 ALTER TABLE `products_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `products_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products_data_options`
--

DROP TABLE IF EXISTS `products_data_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_data_options` (
  `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `products_data_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `area_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `editable` tinyint(1) DEFAULT '0',
  `visibility` tinyint(1) DEFAULT '0',
  `active` tinyint(1) DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`status`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products_data_options`
--

LOCK TABLES `products_data_options` WRITE;
/*!40000 ALTER TABLE `products_data_options` DISABLE KEYS */;
/*!40000 ALTER TABLE `products_data_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products_options`
--

DROP TABLE IF EXISTS `products_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_options` (
  `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `product_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `area_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `editable` tinyint(1) DEFAULT '0',
  `visibility` tinyint(1) DEFAULT '0',
  `active` tinyint(1) DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`status`,`active`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products_options`
--

LOCK TABLES `products_options` WRITE;
/*!40000 ALTER TABLE `products_options` DISABLE KEYS */;
INSERT INTO `products_options` VALUES ('2b428388-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','airpoartLounge','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:44','0000-00-00 00:00:00','',''),('2bc3cc40-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','language','en',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2bcacf40-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','annualFee','1500',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2bd07a4e-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','annualFeeAfterFirst','1500',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2bd1a0d6-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','annualFeePromo','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2bd29590-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','annualFeeSupplementary','P750',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2bd37438-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','annualFeeSupplementaryCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2bd6bfa8-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','annualFeeWaiver','Request for a reversal by calling Customer Care and spend P5,000 within the specified period',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2bd7ac56-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','balanceTransferAware','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2bd897ec-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','balanceTransferHighlight','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2bdd5476-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','balanceTransferLongest','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2bde619a-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','balanceTransferLowest','0.88',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2bdf591a-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','balanceTransferMonth','18',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2be035b0-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','bewareThat1','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2be116ec-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','bewareThat2','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2be1fa08-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','bewareThat3','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2be2fa48-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','businessCard','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2be40cbc-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cardReplacementFee','P300',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2be50fc2-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cashAdvanceApr','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2be5facc-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cashAdvanceFee','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2be6e3ba-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cashAdvanceInterest','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2be7bf74-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cashbackDining','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2be8a5c4-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cashbackDiningCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2bea1b66-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cashbackEntertainment','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2beb06d4-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cashbackEntertainmentCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2bebeb30-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cashbackGeneral','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2becf8f4-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cashbackGeneralCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2bedd878-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cashbackGroceries','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2beeb7ac-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cashbackGroceriesCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2befbb84-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cashbackLocalRetail','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2bf0a080-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cashbackLocalRetailCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2bf18522-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cashbackMetaCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2bf28184-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cashbackOther','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2bf3887c-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cashbackOtherCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2bf4a7d4-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cashbackOverseasCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2bf5853c-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cashbackOverseasSpending','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2bf68f7c-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cashbackPetrol','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2bf76cb2-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cashbackPetrolCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2bf865c2-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cashbackShopping','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2bf947c6-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cashbackShoppingCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2bfa2e48-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cbeAutomaticTransaction','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2bfb0cdc-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cbeAutomaticTransactionCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2bfbf82c-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cbeInstalment','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2bfe80e2-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cbeInstalmentConditi','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2bff7560-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cbeLocalDining','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c006b64-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cbeLocalDiningCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c01476e-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cbeLocalRetails','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c0275ee-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cbeLocalRetailsCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c03700c-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cbeOctopusAavs','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c0459c2-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cbeOctopusAavsCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c056a4c-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cbeOnlineBillPayment','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c065556-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cbeOnlineBillPaymentCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c072f80-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cbeOnlineShopping','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c081756-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cbeOnlineShoppingCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c09012a-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cbeOverseasTransaction','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c09e518-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cbeOverseasTransactionCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c0acdfc-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cbeSpecialCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c0bb6ea-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cbsAllNewTransactions','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c0c91aa-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cbsAutopusAavs','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c0d72d2-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cbsCashCoupons','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c0e513e-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cbsDining','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c0f3c8e-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cbsEntertainment','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c1025d6-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cbsPetrol','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c1168ce-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cbsShopping','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c126ad0-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cbsSpecialCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c135dc8-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','cbsTravel','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c144260-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','coBranded','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c1ab37a-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','creditLimit','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c1c1e86-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','creditOverLimit','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c1d1da4-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','delinquencyCashAdvanceApr','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c1e3748-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','delinquencyRetailPurchaseApr','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c1f252c-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','discountsDining','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c200c9e-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','discountsDiningCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c214744-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','discountsEntertainment','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c224aa4-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','discountsEntertainmentCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c236754-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','discountsGroceries','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c244c50-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','discountsGroceriesCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c253cdc-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','discountsMetaCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c261f94-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','discountsOther','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c2703e6-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','discountsOtherCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c27e162-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','discountsPetrol','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c28e49a-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','discountsPetrolCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c29c1ee-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','discountsShopping','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c2ab4e6-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','discountsShoppingCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c2b95fa-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','earningPointsAutomaticTransaction','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c2c759c-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','earningPointsInstallment','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c2d530e-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','earningPointsOctopus','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c2e3580-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','earningPointsOnlineBillPayments','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c2f2df0-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','earningPointsOnlineShopping','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c3224d8-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','existingCardHolder','1',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c3369b0-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','featured','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c347c6a-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','foreignTransactionFee','2% of the converted amount',NULL,1,NULL,NULL,1,'2014-09-03 22:51:45','0000-00-00 00:00:00','',''),('2c3858c6-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','fraudProtection','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c399c2c-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','greatFor1','Get a separate credit limit for your local and foreign transactions',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c3a8d3a-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','greatFor2','Get up to 30% of your credit limit as cash advance',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c3b7218-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','greatFor3','Purchase new appliances, gadgets or other high-ticket items by installment',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c3eccf6-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','hasApplyButton','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c3fcdae-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','installmentPlan','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c40be62-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','insurance','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c41ad72-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','interestFreePeriod','21',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c450576-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','islamicCard','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c464b5c-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','latePayment','2% of the overdue amount',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c476f0a-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','latePayment2','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c486964-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','linkApplication','http://www.bankcom.com.ph/img/ccaf.pdf',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c49b8b4-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','linkInformation','http://www.bankcom.com.ph/percc.php#vc',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c4a97ac-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','maxAge','65',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c4b8c7a-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','milesConversionConditionLocal','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c4c6b72-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','milesConversionConditionOverseas','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c4d5726-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','milesConversionLocal','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c4e53d8-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','milesConversionOverseas','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c4f73d0-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','milesPogram','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c50615a-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','minimumAge','21',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c514cdc-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','minimumAgeSupplementary','18',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c522d64-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','minimumAnnualIncome','10000',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c530b62-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','minimumEmploymentSalaried','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c53e9a6-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','minimumEmploymentSelfEmployed','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c54c6be-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','minimumRepayment','5% of the amount due',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c55cbd6-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','minimumRepayment2','P500, whichever is higher',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c56b316-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','monthlyIncomeForeigners','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c57983a-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','monthlyIncomeLocals','10000',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c589b4a-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','nationality','1',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c597d12-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','octopusCard','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c5a5c00-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','onlineShoppingCard','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c5b3f62-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','other1','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c5c6db0-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','other2','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c5d5fd6-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','overlayOrClickthrough','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c5e6a84-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','parking','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c5f578c-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','partlyWaivedCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c6044c6-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','personalAssistant','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c611edc-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','phoneNumber','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c621a4e-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','premiumCard','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c651d52-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','productImage','bank-of-commerce-visa-classic.jpg',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c667224-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','productName','Visa Classic',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c678a92-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','promoApplyContent','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c687f7e-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','promoApplyPicture','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c696718-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','promoPicture','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c6a8030-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','promoTitle','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c6b7b02-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','providerCard','1',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c6c6bc0-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','purchaseApr','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c6db8a4-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','purchaseInterest','3.5',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c6ebd30-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','residence','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c6fb96a-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','rewardConversion','P50 spent = 1 point',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c70972c-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','rewardConversionCondition','Only principal cardholders can redeem reward points',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c718560-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','rewardMultiplier','No points multiplier',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c7262f0-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','rewardMultiplierCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c734116-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','rewardSpendingDining','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c742ce8-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','rewardSpendingEntertainment','SM Cinema Tickets for Two (3,149 points)',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c7522ba-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','rewardSpendingOther','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c762214-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','rewardSpendingShopping','SM P500 Gift Card (3,711 points)',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c770e68-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','ribbonBest','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c77f1f2-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','shoppingCard','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c78d414-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','specialtyCard','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c79b1ae-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','status','1',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c7a8eee-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','studentCard','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c7b92b2-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','travelCard','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c7c8942-33ef-11e4-8ce3-5bbea8105782','ec7b459e-319c-11e4-988c-7d9574853fac','4b639068-319b-11e4-988c-7d9574853fac','travelOther','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c7dec9c-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','airportLounge','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c7ee35e-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','annualFee','3000',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c7fbf9a-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','annualFeeAfterFirst','3000',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c809e60-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','annualFeePromo','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c8183de-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','annualFeeSupplementary','P1500',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c82d6a8-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','annualFeeSupplementaryCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c83ca04-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','annualFeeWaiver','Request for a reversal by calling Customer Care and spend P5,000 within the specified period',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c84bec8-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','balanceTransferAware','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c859bea-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','balanceTransferHighlight','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c8681d6-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','balanceTransferLongest','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c87712c-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','balanceTransferLowest','0.88',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c8867d0-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','balanceTransferMonth','18',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c89591a-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','bewareThat1','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c8a5c66-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','bewareThat2','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c8b560c-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','bewareThat3','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c8c40da-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','businessCard','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c8d2810-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cardReplacementFee','P300',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c8e2152-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cashAdvanceApr','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c8f0c3e-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cashAdvanceFee','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c8febea-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cashAdvanceInterest','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c90d190-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cashbackDining','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c91c5aa-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cashbackDiningCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c92b67c-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cashbackEntertainment','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c939812-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cashbackEntertainmentCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c9487c2-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cashbackGeneral','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c958794-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cashbackGeneralCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c988f70-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cashbackGroceries','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c9973fe-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cashbackGroceriesCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2c9aa2ba-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cashbackLocalRetail','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2ca77f26-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cashbackLocalRetailCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2cadb60c-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cashbackMetaCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2caf0b60-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cashbackOther','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2cb053d0-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cashbackOtherCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2cb142b8-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cashbackOverseasCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2cb270c0-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cashbackOverseasSpending','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2cb35e0e-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cashbackPetrol','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2cb58f26-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cashbackPetrolCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2cb68f66-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cashbackShopping','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2cb7947e-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cashbackShoppingCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2cb87394-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cbeAutomaticTransaction','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2cb98b1c-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cbeAutomaticTransactionCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2cba8eae-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cbeInstalment','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2cbb88d6-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cbeInstalmentConditi','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2cbc6b98-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cbeLocalDining','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2cbd6eda-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cbeLocalDiningCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2cbe4f80-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cbeLocalRetails','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2cbf2eb4-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cbeLocalRetailsCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2cc01aa4-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cbeOctopusAavs','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2cc0fe6a-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cbeOctopusAavsCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2cc1eb18-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cbeOnlineBillPayment','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2cc2dcb2-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cbeOnlineBillPaymentCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2cc3bbe6-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cbeOnlineShopping','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2cc49dae-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cbeOnlineShoppingCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2cc58ade-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cbeOverseasTransaction','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2cc67016-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cbeOverseasTransactionCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2cc7567a-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cbeSpecialCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2cc8a67e-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cbsAllNewTransactions','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2cc9b708-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cbsAutopusAavs','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2ccc6b92-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cbsCashCoupons','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2ccdccd0-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cbsDining','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2ccecec8-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cbsEntertainment','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2ccfb022-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cbsPetrol','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:46','0000-00-00 00:00:00','',''),('2cd0c250-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cbsShopping','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2cd19d56-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cbsSpecialCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2cd660c0-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','cbsTravel','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2cd79b7a-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','coBranded','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2cd8aeac-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','creditLimit','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2cd996fa-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','creditOverLimit','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2cda9b9a-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','delinquencyCashAdvanceApr','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2cdb84f6-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','delinquencyRetailPurchaseApr','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2cdc7014-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','discountsDining','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2cdd6e56-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','discountsDiningCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2cde5262-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','discountsEntertainment','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2cdf2fc0-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','discountsEntertainmentCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2ce013c2-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','discountsGroceries','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2ce101ec-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','discountsGroceriesCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2ce1ebfc-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','discountsMetaCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2ce2ca5e-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','discountsOther','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2ce3c71a-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','discountsOtherCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2ce4a982-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','discountsPetrol','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2ce5a7f6-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','discountsPetrolCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2ce69530-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','discountsShopping','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2ce79f34-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','discountsShoppingCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2ce890ce-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','earningPointsAutomaticTransaction','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2ce98326-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','earningPointsInstallment','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2cea6a7a-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','earningPointsOctopus','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2ceb5174-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','earningPointsOnlineBillPayments','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2cec3044-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','earningPointsOnlineShopping','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2ced13c4-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','existingCardHolder','1',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2cee1440-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','featured','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2cef2826-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','foreignTransactionFee','2% of the converted amount',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2cf007c8-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','fraudProtection','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2cf100ec-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','greatFor1','Get a separate credit limit for your local and foreign transactions',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2cf1e20a-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','greatFor2','Get up to 30% of your credit limit as cash advance',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2cf2c62a-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','greatFor3','Purchase new appliances, gadgets or other high-ticket items by installment',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2cf3b332-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','hasApplyButton','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2cf4a8aa-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','installmentPlan','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2cf58bc6-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','insurance','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2cfb6f96-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','interestFreePeriod','21',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2cfcb69e-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','islamicCard','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d000024-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','latePayment','2% of the overdue amount',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d016d42-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','latePayment2','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d026b48-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','linkApplication','http://www.bankcom.com.ph/img/ccaf.pdf',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d038780-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','linkInformation','http://www.bankcom.com.ph/percc.php#vc',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d0476f4-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','maxAge','65',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d057e78-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','milesConversionConditionLocal','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d0683b8-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','milesConversionConditionOverseas','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d077d68-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','milesConversionLocal','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d086480-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','milesConversionOverseas','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d09526e-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','milesPogram','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d0a36f2-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','minimumAge','21',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d0b1888-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','minimumAgeSupplementary','18',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d0bf7b2-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','minimumAnnualIncome','40000',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d0cd826-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','minimumEmploymentSalaried','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d0dcbfa-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','minimumEmploymentSelfEmployed','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d0ec06e-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','minimumRepayment','5% of the amount due',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d0fc144-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','minimumRepayment2','P500, whichever is higher',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d10c206-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','monthlyIncomeForeigners','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d11a5d6-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','monthlyIncomeLocals','40000',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d128866-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','nationality','1',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d137a3c-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','octopusCard','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d147cac-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','onlineShoppingCard','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d15794a-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','other1','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d166b98-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','other2','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d1756f2-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','overlayOrClickthrough','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d1843be-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','parking','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d1f440c-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','partlyWaivedCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d20d0ba-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','personalAssistant','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d22d4d2-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','phoneNumber','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d23f1b4-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','premiumCard','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d24f172-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','productImage','bank-of-commerce-visa-gold.jpg',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d2621be-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','productName','Visa Gold',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d271f10-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','promoApplyContent','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d280d62-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','promoApplyPicture','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d28f70e-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','promoPicture','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d29edc6-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','promoTitle','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d2ae294-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','providerCard','1',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d2bca9c-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','purchaseApr','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d2ca976-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','purchaseInterest','3.5',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d2d9674-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','residence','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d2e7896-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','rewardConversion','P50 spent = 1 point',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d2f7a8e-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','rewardConversionCondition','Only principal cardholders can redeem reward points',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d3282ce-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','rewardMultiplier','No points multiplier',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d358ed8-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','rewardMultiplierCondition','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d3682b6-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','rewardSpendingDining','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d37892c-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','rewardSpendingEntertainment','SM Cinema Tickets for Two (3,149 points)',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d3867f2-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','rewardSpendingOther','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d394a96-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','rewardSpendingShopping','SM P500 Gift Card (3,711 points)',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d3a4f72-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','ribbonBest','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d3b375c-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','shoppingCard','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d3c345e-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','specialtyCard','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d3d1a9a-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','status','1',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d3e08ce-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','studentCard','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d3f1660-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','travelCard','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d3ff170-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','travelOther','0',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','',''),('2d40f73c-33ef-11e4-8ce3-5bbea8105782','b4b42cb2-32fe-11e4-8ce3-5bbea8105782','4b639068-319b-11e4-988c-7d9574853fac','language','en',NULL,1,NULL,NULL,1,'2014-09-03 22:51:47','0000-00-00 00:00:00','','');
/*!40000 ALTER TABLE `products_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `translations`
--

DROP TABLE IF EXISTS `translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `translations` (
  `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'UUID',
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `module` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci DEFAULT 'en',
  `description` text COLLATE utf8_unicode_ci,
  `status` tinyint(1) DEFAULT '0',
  `active` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `language` (`language`),
  KEY `name` (`name`),
  KEY `module` (`module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `translations`
--

LOCK TABLES `translations` WRITE;
/*!40000 ALTER TABLE `translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `verticals`
--

DROP TABLE IF EXISTS `verticals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `verticals` (
  `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`status`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `verticals`
--

LOCK TABLES `verticals` WRITE;
/*!40000 ALTER TABLE `verticals` DISABLE KEYS */;
INSERT INTO `verticals` VALUES ('07f44e24-1d43-11e4-b32d-eff91066cccf','Money','Money',1,1,'2014-08-06 02:24:06','2014-08-06 19:06:37',NULL,NULL),('3140c21c-1d43-11e4-b32d-eff91066cccf','Insurance','Insurance',1,1,'2014-08-06 02:25:15','2014-08-06 19:07:03',NULL,NULL),('78d7ca20-1dd0-11e4-b32d-eff91066cccf','Telco','Telco',1,1,'2014-08-06 19:16:34','2014-08-07 19:30:38',NULL,NULL);
/*!40000 ALTER TABLE `verticals` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-09-09 18:11:30
