-- MySQL dump 10.13  Distrib 5.7.23, for Linux (x86_64)
--
-- Host: localhost    Database: intertech_stackpost
-- ------------------------------------------------------
-- Server version	5.7.23-0ubuntu0.16.04.1

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
-- Table structure for table `facebook_accounts`
--

DROP TABLE IF EXISTS `facebook_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `facebook_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ids` text,
  `uid` int(11) DEFAULT NULL,
  `pid` text,
  `fbapp` text,
  `fullname` text,
  `avatar` text,
  `access_token` text,
  `status` int(1) DEFAULT '1',
  `changed` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facebook_accounts`
--

LOCK TABLES `facebook_accounts` WRITE;
/*!40000 ALTER TABLE `facebook_accounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `facebook_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `facebook_groups`
--

DROP TABLE IF EXISTS `facebook_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `facebook_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ids` text,
  `uid` int(11) DEFAULT NULL,
  `account` int(11) DEFAULT NULL,
  `type` text,
  `category` text,
  `pid` text,
  `name` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facebook_groups`
--

LOCK TABLES `facebook_groups` WRITE;
/*!40000 ALTER TABLE `facebook_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `facebook_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `facebook_posts`
--

DROP TABLE IF EXISTS `facebook_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `facebook_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ids` text,
  `uid` int(11) DEFAULT NULL,
  `account` int(11) DEFAULT NULL,
  `category` text,
  `group` text,
  `type` text,
  `data` longtext,
  `time_post` datetime DEFAULT NULL,
  `delay` int(11) DEFAULT NULL,
  `time_delete` int(11) DEFAULT NULL,
  `result` text,
  `status` int(1) DEFAULT NULL,
  `changed` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facebook_posts`
--

LOCK TABLES `facebook_posts` WRITE;
/*!40000 ALTER TABLE `facebook_posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `facebook_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_caption`
--

DROP TABLE IF EXISTS `general_caption`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_caption` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ids` text,
  `uid` int(11) DEFAULT NULL,
  `content` longtext,
  `status` int(1) DEFAULT '1',
  `changed` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_caption`
--

LOCK TABLES `general_caption` WRITE;
/*!40000 ALTER TABLE `general_caption` DISABLE KEYS */;
/*!40000 ALTER TABLE `general_caption` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_coupons`
--

DROP TABLE IF EXISTS `general_coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_coupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ids` text,
  `name` text,
  `code` text,
  `type` int(1) DEFAULT '1',
  `price` float DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `packages` text,
  `status` int(1) DEFAULT '1',
  `changed` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_coupons`
--

LOCK TABLES `general_coupons` WRITE;
/*!40000 ALTER TABLE `general_coupons` DISABLE KEYS */;
/*!40000 ALTER TABLE `general_coupons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_file_manager`
--

DROP TABLE IF EXISTS `general_file_manager`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_file_manager` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ids` text CHARACTER SET utf8mb4,
  `uid` int(11) DEFAULT NULL,
  `file_name` text CHARACTER SET utf8mb4,
  `image_type` text CHARACTER SET utf8mb4,
  `file_ext` text CHARACTER SET utf8mb4,
  `file_size` text CHARACTER SET utf8mb4,
  `is_image` text CHARACTER SET utf8mb4,
  `image_width` int(11) DEFAULT NULL,
  `image_height` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_file_manager`
--

LOCK TABLES `general_file_manager` WRITE;
/*!40000 ALTER TABLE `general_file_manager` DISABLE KEYS */;
/*!40000 ALTER TABLE `general_file_manager` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_lang`
--

DROP TABLE IF EXISTS `general_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ids` text NOT NULL,
  `code` text NOT NULL,
  `slug` text NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_lang`
--

LOCK TABLES `general_lang` WRITE;
/*!40000 ALTER TABLE `general_lang` DISABLE KEYS */;
/*!40000 ALTER TABLE `general_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_lang_list`
--

DROP TABLE IF EXISTS `general_lang_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_lang_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ids` text,
  `name` text,
  `code` text,
  `icon` text,
  `is_default` int(1) DEFAULT '0',
  `status` int(1) DEFAULT NULL,
  `changed` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_lang_list`
--

LOCK TABLES `general_lang_list` WRITE;
/*!40000 ALTER TABLE `general_lang_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `general_lang_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_options`
--

DROP TABLE IF EXISTS `general_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  `value` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_options`
--

LOCK TABLES `general_options` WRITE;
/*!40000 ALTER TABLE `general_options` DISABLE KEYS */;
INSERT INTO `general_options` VALUES (1,'enable_https','0'),(2,'website_title','Stackposts - Social Marketing Tool'),(3,'website_description','save time, do more, manage multiple social networks at one place'),(4,'website_keyword','social marketing tool, social planner, automation, social schedule'),(5,'website_favicon','https://social.inconsulting.tech/assets/img/favicon.png'),(6,'website_logo_white','https://social.inconsulting.tech/assets/img/logo-white.png'),(7,'website_logo_black','https://social.inconsulting.tech/assets/img/logo-black.png'),(8,'social_page_facebook',''),(9,'social_page_google',''),(10,'social_page_twitter',''),(11,'social_page_instagram',''),(12,'social_page_pinterest',''),(13,'embed_javascript',''),(14,'singup_enable','1'),(15,'facebook_oauth_enable','0'),(16,'google_oauth_enable','0'),(17,'twitter_oauth_enable','0'),(18,'google_drive_api_key',''),(19,'google_drive_client_id',''),(20,'website_logo_mark','https://social.inconsulting.tech/assets/img/logo-mark.png'),(21,'dropbox_api_key',''),(22,'singup_verify_email_enable','1'),(23,'google_oauth_client_id',''),(24,'google_oauth_client_secret',''),(25,'facebook_oauth_app_id',''),(26,'facebook_oauth_app_secret',''),(27,'twitter_oauth_client_id',''),(28,'twitter_oauth_client_secret',''),(29,'user_proxy','1'),(30,'system_proxy','1'),(31,'maximum_upload_file_size','5'),(32,'email_from',''),(33,'email_name',''),(34,'email_protocol_type','mail'),(35,'email_smtp_server',''),(36,'email_smtp_port',''),(37,'email_smtp_encryption',''),(38,'email_smtp_username',''),(39,'email_smtp_password',''),(40,'email_welcome_enable','1'),(41,'email_payment_enable','1'),(42,'email_activation_subject','Hello {full_name}! Activation your account'),(43,'email_activation_content','Welcome to {website_name}! \r\n\r\nHello {full_name},  \r\n\r\nThank you for joining! We\'re glad to have you as community member, and we\'re stocked for you to start exploring our service.  \r\n All you need to do is activate your account: \r\n  {activation_link} \r\n\r\nThanks and Best Regards!'),(44,'email_new_customers_subject','Hi {full_name}! Getting Started with Our Service'),(45,'email_new_customers_content','Hello {full_name}! \r\n\r\nCongratulations! \r\nYou have successfully signed up for our service. \r\nYou have got a trial package, starting today. \r\nWe hope you enjoy this package! We love to hear from you, \r\n\r\nThanks and Best Regards!'),(46,'email_forgot_password_subject','Hi {full_name}! Password Reset'),(47,'email_forgot_password_content','Hi {full_name}! \r\n\r\nSomebody (hopefully you) requested a new password for your account. \r\n\r\nNo changes have been made to your account yet. \r\nYou can reset your password by click this link: \r\n{recovery_password_link}. \r\n\r\nIf you did not request a password reset, no further action is required. \r\n\r\nThanks and Best Regards!'),(48,'email_renewal_reminders_subject','Hi {full_name}, Here\'s a little Reminder your Membership is expiring soon...'),(49,'email_renewal_reminders_content','Dear {full_name}, \r\n\r\nYour membership with your current package will expire in {days_left} days. \r\nWe hope that you will take the time to renew your membership and remain part of our community. It couldn’t be easier - just click here to renew: {website_link} \r\n\r\nThanks and Best Regards!'),(50,'email_payment_subject','Hi {full_name}, Thank you for your payment'),(51,'email_payment_content','Hi {full_name}, \r\n\r\nYou just completed the payment successfully on our service. \r\nThank you for being awesome, we hope you enjoy your package. \r\n\r\nThanks and Best Regards!'),(52,'fb_min_post_interval_seconds','50'),(53,'fb_post_auto_pause_after_post','50'),(54,'fb_post_auto_resume_after_minute_hours','50'),(55,'fb_post_repeat_frequency','50'),(56,'instagram_verify_code_enable','1'),(57,'enable_advance_option','1'),(58,'twitter_app_id',''),(59,'twitter_app_secret',''),(60,'linkedin_app_id',''),(61,'linkedin_app_secret','');
/*!40000 ALTER TABLE `general_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_packages`
--

DROP TABLE IF EXISTS `general_packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_packages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ids` text,
  `type` int(1) DEFAULT '1' COMMENT '1-TRIAL|2-CHARGE',
  `name` text,
  `description` text,
  `price_monthly` float DEFAULT NULL,
  `price_annually` float DEFAULT NULL,
  `number_accounts` int(11) DEFAULT '0',
  `is_default` int(1) DEFAULT '0',
  `trial_day` int(11) DEFAULT NULL,
  `permission` longtext,
  `sort` int(11) DEFAULT '1',
  `status` int(1) DEFAULT '1',
  `changed` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_packages`
--

LOCK TABLES `general_packages` WRITE;
/*!40000 ALTER TABLE `general_packages` DISABLE KEYS */;
INSERT INTO `general_packages` VALUES (1,'c761441297cac88f7cea247f260d1985',1,'Trial mode',NULL,0,0,0,0,3,'{\"0\":\"facebook_enable\",\"1\":\"facebook\\/post\",\"2\":\"instagram_enable\",\"3\":\"instagram\\/post\",\"4\":\"twitter_enable\",\"5\":\"twitter\\/post\",\"6\":\"google_drive\",\"7\":\"dropbox\",\"8\":\"photo_type\",\"9\":\"video_type\",\"max_storage_size\":100,\"max_file_size\":20}',0,1,'2018-06-11 19:21:26','2018-04-02 11:40:23'),(2,'d7394fc22455c18ee2eb177bacb0a082',2,'Basic','Pick great plan for you',30,25,1,0,NULL,'{\"0\":\"facebook_enable\",\"1\":\"facebook\\/post\",\"2\":\"instagram_enable\",\"3\":\"instagram\\/post\",\"4\":\"twitter_enable\",\"5\":\"twitter\\/post\",\"6\":\"google_drive\",\"7\":\"dropbox\",\"8\":\"photo_type\",\"9\":\"video_type\",\"max_storage_size\":250,\"max_file_size\":2}',60,1,'2018-07-26 09:29:34','2018-04-02 11:40:28'),(8,'2c327cb5ab20f86cc0ea9cae47515da1',2,'Standard','Pick great plan for you',60,50,2,0,NULL,'{\"0\":\"facebook_enable\",\"1\":\"facebook\\/post\",\"2\":\"instagram_enable\",\"3\":\"instagram\\/post\",\"4\":\"google_drive\",\"5\":\"dropbox\",\"6\":\"photo_type\",\"7\":\"video_type\",\"max_storage_size\":100,\"max_file_size\":5}',80,1,'2018-07-26 09:29:23','2018-06-09 19:58:16'),(9,'9088ff7e41e726e5e2bf7c1352c22340',2,'Premium','Pick great plan for you',0,0,5,0,NULL,'{\"0\":\"facebook_enable\",\"1\":\"facebook\\/post\",\"2\":\"instagram_enable\",\"3\":\"instagram\\/post\",\"4\":\"twitter_enable\",\"5\":\"twitter\\/post\",\"6\":\"google_drive\",\"7\":\"dropbox\",\"8\":\"photo_type\",\"9\":\"video_type\",\"max_storage_size\":1000,\"max_file_size\":20}',0,1,'2018-09-29 09:24:16','2018-07-26 08:51:38');
/*!40000 ALTER TABLE `general_packages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_payment_history`
--

DROP TABLE IF EXISTS `general_payment_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_payment_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ids` text,
  `uid` int(11) DEFAULT NULL,
  `package` int(11) DEFAULT NULL,
  `type` text,
  `transaction_id` text,
  `plan` int(1) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_payment_history`
--

LOCK TABLES `general_payment_history` WRITE;
/*!40000 ALTER TABLE `general_payment_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `general_payment_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_proxies`
--

DROP TABLE IF EXISTS `general_proxies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_proxies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ids` text,
  `address` text,
  `location` text,
  `status` int(1) DEFAULT NULL,
  `changed` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_proxies`
--

LOCK TABLES `general_proxies` WRITE;
/*!40000 ALTER TABLE `general_proxies` DISABLE KEYS */;
/*!40000 ALTER TABLE `general_proxies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_purchase`
--

DROP TABLE IF EXISTS `general_purchase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_purchase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ids` text,
  `pid` text,
  `purchase_code` text,
  `version` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_purchase`
--

LOCK TABLES `general_purchase` WRITE;
/*!40000 ALTER TABLE `general_purchase` DISABLE KEYS */;
INSERT INTO `general_purchase` VALUES (2,'c915a0fba1edb89d27c2b4f6e68b9504','1','GPLed by g0g0','1.5');
/*!40000 ALTER TABLE `general_purchase` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_sessions`
--

DROP TABLE IF EXISTS `general_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_sessions`
--

LOCK TABLES `general_sessions` WRITE;
/*!40000 ALTER TABLE `general_sessions` DISABLE KEYS */;
INSERT INTO `general_sessions` VALUES ('k36ag14gn04agqmkblpdvnd70tejnfas','46.223.102.154',1538249671,_binary '__ci_last_regenerate|i:1538249638;lang_default|s:4:\"null\";client_timezone|s:13:\"Europe/Berlin\";uid|s:1:\"1\";'),('p7gto3n1c7vb3dkfot2s1uib11pst13t','46.223.102.154',1538252325,_binary '__ci_last_regenerate|i:1538252325;lang_default|s:4:\"null\";client_timezone|s:13:\"Europe/Berlin\";uid|s:1:\"1\";'),('02g6rv98r4pn1nim7h02phnfo83u0k77','46.223.102.154',1538252632,_binary '__ci_last_regenerate|i:1538252632;lang_default|s:4:\"null\";client_timezone|s:13:\"Europe/Berlin\";uid|s:1:\"1\";'),('5v0478roc840vrkdl9hukll85fhlu391','46.223.102.154',1538252964,_binary '__ci_last_regenerate|i:1538252964;lang_default|s:4:\"null\";client_timezone|s:13:\"Europe/Berlin\";uid|s:1:\"1\";'),('bsog10squiu0holn49co08e0vlrt5qfq','46.223.102.154',1538254100,_binary '__ci_last_regenerate|i:1538254100;lang_default|s:4:\"null\";client_timezone|s:13:\"Europe/Berlin\";uid|s:1:\"1\";'),('kk68lb4jcv471f81f4spkan6gk6ub0pc','46.223.102.154',1538254122,_binary '__ci_last_regenerate|i:1538254100;lang_default|s:4:\"null\";client_timezone|s:13:\"Europe/Berlin\";uid|s:1:\"1\";');
/*!40000 ALTER TABLE `general_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_users`
--

DROP TABLE IF EXISTS `general_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ids` text,
  `admin` int(1) DEFAULT NULL,
  `login_type` text,
  `fullname` text,
  `email` text,
  `password` text,
  `package` int(11) DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `timezone` text,
  `permission` text,
  `settings` longtext,
  `activation_key` text,
  `reset_key` text,
  `history_ip` text,
  `status` int(1) DEFAULT NULL,
  `changed` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_users`
--

LOCK TABLES `general_users` WRITE;
/*!40000 ALTER TABLE `general_users` DISABLE KEYS */;
INSERT INTO `general_users` VALUES (1,'c761441297cac88f7cea247f260d1985',1,'direct','Rohit Sharma','rohit@interstellarconsulting.com','1db2cd81f19741d67e4c7aef245a689e',2,'2025-01-01','Pacific/Niue',NULL,'{\"fb_post_media_count\":0,\"fb_post_link_count\":0,\"fb_post_text_count\":0,\"fb_post_success_count\":0,\"fb_post_error_count\":0,\"twitter_app_id\":\"\",\"twitter_app_secret\":\"\",\"linkedin_app_id\":\"\",\"linkedin_app_secret\":\"\",\"linkedin_post_photo_count\":0,\"linkedin_post_link_count\":0,\"linkedin_post_success_count\":0,\"linkedin_post_error_count\":0}','1','b04e3f63724775f74a561648907b70de','[\"46.223.102.154\",\"46.223.102.154\",\"46.223.102.154\"]',1,'2018-07-26 16:28:40','2018-07-26 13:39:32');
/*!40000 ALTER TABLE `general_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instagram_accounts`
--

DROP TABLE IF EXISTS `instagram_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instagram_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ids` text CHARACTER SET utf8,
  `uid` text,
  `pid` text,
  `avatar` text,
  `username` text,
  `password` text,
  `proxy` text,
  `default_proxy` int(11) DEFAULT '0',
  `status` int(1) DEFAULT '1',
  `changed` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instagram_accounts`
--

LOCK TABLES `instagram_accounts` WRITE;
/*!40000 ALTER TABLE `instagram_accounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `instagram_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instagram_posts`
--

DROP TABLE IF EXISTS `instagram_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instagram_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ids` text,
  `uid` int(11) DEFAULT NULL,
  `account` int(11) DEFAULT NULL,
  `type` text,
  `data` longtext,
  `time_post` datetime DEFAULT NULL,
  `delay` int(11) DEFAULT NULL,
  `time_delete` int(11) DEFAULT NULL,
  `result` text,
  `status` int(1) DEFAULT NULL,
  `changed` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instagram_posts`
--

LOCK TABLES `instagram_posts` WRITE;
/*!40000 ALTER TABLE `instagram_posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `instagram_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instagram_sessions`
--

DROP TABLE IF EXISTS `instagram_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instagram_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `settings` mediumblob,
  `cookies` mediumblob,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instagram_sessions`
--

LOCK TABLES `instagram_sessions` WRITE;
/*!40000 ALTER TABLE `instagram_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `instagram_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `linkedin_accounts`
--

DROP TABLE IF EXISTS `linkedin_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `linkedin_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ids` text,
  `uid` int(11) DEFAULT NULL,
  `pid` text,
  `type` text,
  `username` text,
  `url` text,
  `avatar` text,
  `access_token` text,
  `status` int(1) DEFAULT '1',
  `changed` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `linkedin_accounts`
--

LOCK TABLES `linkedin_accounts` WRITE;
/*!40000 ALTER TABLE `linkedin_accounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `linkedin_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `linkedin_posts`
--

DROP TABLE IF EXISTS `linkedin_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `linkedin_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ids` text,
  `uid` int(11) DEFAULT NULL,
  `account` int(11) DEFAULT NULL,
  `type` text,
  `data` longtext,
  `time_post` datetime DEFAULT NULL,
  `delay` int(11) DEFAULT NULL,
  `time_delete` int(11) DEFAULT NULL,
  `result` text,
  `status` int(1) DEFAULT NULL,
  `changed` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `linkedin_posts`
--

LOCK TABLES `linkedin_posts` WRITE;
/*!40000 ALTER TABLE `linkedin_posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `linkedin_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `twitter_accounts`
--

DROP TABLE IF EXISTS `twitter_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twitter_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ids` text,
  `uid` int(11) DEFAULT NULL,
  `pid` text,
  `username` text,
  `avatar` text,
  `access_token` text,
  `status` int(1) DEFAULT '1',
  `changed` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twitter_accounts`
--

LOCK TABLES `twitter_accounts` WRITE;
/*!40000 ALTER TABLE `twitter_accounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `twitter_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `twitter_posts`
--

DROP TABLE IF EXISTS `twitter_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twitter_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ids` text,
  `uid` int(11) DEFAULT NULL,
  `account` int(11) DEFAULT NULL,
  `type` text,
  `data` longtext,
  `time_post` datetime DEFAULT NULL,
  `delay` int(11) DEFAULT NULL,
  `time_delete` int(11) DEFAULT NULL,
  `result` text,
  `status` int(1) DEFAULT NULL,
  `changed` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twitter_posts`
--

LOCK TABLES `twitter_posts` WRITE;
/*!40000 ALTER TABLE `twitter_posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `twitter_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'intertech_stackpost'
--

--
-- Dumping routines for database 'intertech_stackpost'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-09-29 22:51:15
