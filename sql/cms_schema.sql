-- MySQL dump 10.13  Distrib 5.1.32, for Win32 (ia32)
--
-- Host: 192.168.0.100    Database: 4b2cms
-- ------------------------------------------------------
-- Server version	5.1.31-community

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
-- Table structure for table `articleattachments`
--

DROP TABLE IF EXISTS `articleattachments`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `articleattachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `mime` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_token` int(10) unsigned NOT NULL DEFAULT '0',
  `id_language` int(10) unsigned NOT NULL DEFAULT '0',
  `id_author` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `content` mediumtext,
  `moment` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IXU_token_language` (`id_token`,`id_language`),
  FULLTEXT KEY `IXF_content` (`title`,`content`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `articlescomments`
--

DROP TABLE IF EXISTS `articlescomments`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `articlescomments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_content` int(10) unsigned NOT NULL DEFAULT '0',
  `author` varchar(255) DEFAULT NULL,
  `commenttext` text,
  `ismuted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `moment` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `articlestokens`
--

DROP TABLE IF EXISTS `articlestokens`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `articlestokens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_fuseaction` int(10) unsigned NOT NULL DEFAULT '0',
  `token` varchar(70) NOT NULL DEFAULT '',
  `id_author` int(10) unsigned NOT NULL DEFAULT '0',
  `description` varchar(255) DEFAULT NULL,
  `moment` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IXU_fuseaction_token` (`id_fuseaction`,`token`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `articlestree`
--

DROP TABLE IF EXISTS `articlestree`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `articlestree` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `data_id` int(10) unsigned NOT NULL DEFAULT '0',
  `left` int(10) unsigned DEFAULT NULL,
  `right` int(10) unsigned DEFAULT NULL,
  `level` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `content`
--

DROP TABLE IF EXISTS `content`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_token` int(10) unsigned NOT NULL DEFAULT '0',
  `id_language` int(10) unsigned NOT NULL DEFAULT '0',
  `id_author` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `content` mediumtext,
  `moment` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IXU_token_language` (`id_token`,`id_language`),
  FULLTEXT KEY `IXF_content` (`title`,`content`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `contentcomments`
--

DROP TABLE IF EXISTS `contentcomments`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `contentcomments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_content` int(10) unsigned NOT NULL DEFAULT '0',
  `author` varchar(255) DEFAULT NULL,
  `commenttext` text,
  `ismuted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `moment` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `contenttokens`
--

DROP TABLE IF EXISTS `contenttokens`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `contenttokens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_fuseaction` int(10) unsigned NOT NULL DEFAULT '0',
  `token` varchar(70) NOT NULL DEFAULT '',
  `id_author` int(10) unsigned NOT NULL DEFAULT '0',
  `description` varchar(255) DEFAULT NULL,
  `moment` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IXU_fuseaction_token` (`id_fuseaction`,`token`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `dictionary`
--

DROP TABLE IF EXISTS `dictionary`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `dictionary` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_property` int(10) unsigned NOT NULL DEFAULT '0',
  `xcode` varchar(70) DEFAULT NULL,
  `code` varchar(70) NOT NULL DEFAULT '',
  `name` varchar(255) DEFAULT NULL,
  `pos` int(10) unsigned NOT NULL DEFAULT '9999999',
  PRIMARY KEY (`id`),
  UNIQUE KEY `IXU_prop_code` (`id_property`,`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `galleries`
--

DROP TABLE IF EXISTS `galleries`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `galleries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_token` int(10) unsigned NOT NULL DEFAULT '0',
  `id_language` int(10) unsigned NOT NULL DEFAULT '0',
  `id_author` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `content` mediumtext,
  `moment` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IXU_token_language` (`id_token`,`id_language`),
  FULLTEXT KEY `IXF_content` (`title`,`content`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `galleriescomments`
--

DROP TABLE IF EXISTS `galleriescomments`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `galleriescomments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_content` int(10) unsigned NOT NULL DEFAULT '0',
  `author` varchar(255) DEFAULT NULL,
  `commenttext` text,
  `ismuted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `moment` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `galleriestokens`
--

DROP TABLE IF EXISTS `galleriestokens`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `galleriestokens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_fuseaction` int(10) unsigned NOT NULL DEFAULT '0',
  `token` varchar(70) NOT NULL DEFAULT '',
  `id_author` int(10) unsigned NOT NULL DEFAULT '0',
  `description` varchar(255) DEFAULT NULL,
  `moment` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IXU_fuseaction_token` (`id_fuseaction`,`token`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `graphics`
--

DROP TABLE IF EXISTS `graphics`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `graphics` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_token` int(10) unsigned NOT NULL DEFAULT '0',
  `id_language` int(10) unsigned NOT NULL DEFAULT '0',
  `id_author` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `content` mediumtext,
  `moment` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IXU_token_language` (`id_token`,`id_language`),
  FULLTEXT KEY `IXF_content` (`title`,`content`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `graphicscomments`
--

DROP TABLE IF EXISTS `graphicscomments`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `graphicscomments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_content` int(10) unsigned NOT NULL DEFAULT '0',
  `author` varchar(255) DEFAULT NULL,
  `commenttext` text,
  `ismuted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `moment` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `graphicstokens`
--

DROP TABLE IF EXISTS `graphicstokens`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `graphicstokens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_fuseaction` int(10) unsigned NOT NULL DEFAULT '0',
  `token` varchar(70) NOT NULL DEFAULT '',
  `id_author` int(10) unsigned NOT NULL DEFAULT '0',
  `description` varchar(255) DEFAULT NULL,
  `moment` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IXU_fuseaction_token` (`id_fuseaction`,`token`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `homepage` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `IXU_code` (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_token` int(10) unsigned NOT NULL DEFAULT '0',
  `id_language` int(10) unsigned NOT NULL DEFAULT '0',
  `id_author` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `content` mediumtext,
  `moment` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IXU_token_language` (`id_token`,`id_language`),
  FULLTEXT KEY `IXF_content` (`title`,`content`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `imagescomments`
--

DROP TABLE IF EXISTS `imagescomments`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `imagescomments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_content` int(10) unsigned NOT NULL DEFAULT '0',
  `author` varchar(255) DEFAULT NULL,
  `commenttext` text,
  `ismuted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `moment` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `imagestokens`
--

DROP TABLE IF EXISTS `imagestokens`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `imagestokens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_fuseaction` int(10) unsigned NOT NULL DEFAULT '0',
  `token` varchar(70) NOT NULL DEFAULT '',
  `id_author` int(10) unsigned NOT NULL DEFAULT '0',
  `description` varchar(255) DEFAULT NULL,
  `moment` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IXU_fuseaction_token` (`id_fuseaction`,`token`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `languages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(4) NOT NULL DEFAULT '',
  `name` varchar(255) DEFAULT NULL,
  `encoding` varchar(255) DEFAULT NULL,
  `contentlanguage` varchar(255) DEFAULT NULL,
  `direction` enum('ltr','rtl') NOT NULL DEFAULT 'ltr',
  PRIMARY KEY (`id`),
  UNIQUE KEY `IXU_code` (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mailtemplates`
--

DROP TABLE IF EXISTS `mailtemplates`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mailtemplates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_token` int(10) unsigned NOT NULL DEFAULT '0',
  `id_language` int(10) unsigned NOT NULL DEFAULT '0',
  `id_author` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `content` mediumtext,
  `moment` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IXU_token_language` (`id_token`,`id_language`),
  FULLTEXT KEY `IXF_content` (`title`,`content`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mailtemplatescomments`
--

DROP TABLE IF EXISTS `mailtemplatescomments`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mailtemplatescomments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_content` int(10) unsigned NOT NULL DEFAULT '0',
  `author` varchar(255) DEFAULT NULL,
  `commenttext` text,
  `ismuted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `moment` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mailtemplatestokens`
--

DROP TABLE IF EXISTS `mailtemplatestokens`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mailtemplatestokens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_fuseaction` int(10) unsigned NOT NULL DEFAULT '0',
  `token` varchar(70) NOT NULL DEFAULT '',
  `id_author` int(10) unsigned NOT NULL DEFAULT '0',
  `description` varchar(255) DEFAULT NULL,
  `moment` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IXU_fuseaction_token` (`id_fuseaction`,`token`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(70) NOT NULL DEFAULT '',
  `description` varchar(255) DEFAULT NULL,
  `responsibility` text,
  `sticky_attributes` text,
  `is_devonly` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `IXU_Name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `properties`
--

DROP TABLE IF EXISTS `properties`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `properties` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(70) NOT NULL DEFAULT '',
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IXU_code` (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `security`
--

DROP TABLE IF EXISTS `security`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `security` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_fuseaction` int(10) unsigned DEFAULT NULL,
  `id_group` int(10) unsigned DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `access` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `IXU_security` (`id_fuseaction`,`id_group`,`token`,`access`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `seocontent`
--

DROP TABLE IF EXISTS `seocontent`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `seocontent` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_token` int(10) unsigned NOT NULL DEFAULT '0',
  `id_language` int(10) unsigned NOT NULL DEFAULT '0',
  `id_author` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `content` mediumtext,
  `moment` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IXU_token_language` (`id_token`,`id_language`),
  FULLTEXT KEY `IXF_content` (`title`,`content`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `seocontentcomments`
--

DROP TABLE IF EXISTS `seocontentcomments`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `seocontentcomments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_content` int(10) unsigned NOT NULL DEFAULT '0',
  `author` varchar(255) DEFAULT NULL,
  `commenttext` text,
  `ismuted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `moment` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `seocontenttokens`
--

DROP TABLE IF EXISTS `seocontenttokens`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `seocontenttokens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_fuseaction` int(10) unsigned NOT NULL DEFAULT '0',
  `token` varchar(70) NOT NULL DEFAULT '',
  `id_author` int(10) unsigned NOT NULL DEFAULT '0',
  `description` varchar(255) DEFAULT NULL,
  `moment` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IXU_fuseaction_token` (`id_fuseaction`,`token`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `datatype` enum('STRING','INT','FLOAT','BOOL') NOT NULL DEFAULT 'STRING',
  `value` varchar(255) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IXU_name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `syslog`
--

DROP TABLE IF EXISTS `syslog`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `syslog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_fuseaction` int(10) unsigned DEFAULT NULL,
  `id_user` int(10) unsigned DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `logtype` char(1) DEFAULT NULL,
  `logcode` varchar(70) DEFAULT NULL,
  `logmsg` varchar(255) DEFAULT NULL,
  `extmsg` text,
  `ip` bigint(20) DEFAULT NULL,
  `moment` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL DEFAULT '',
  `pwd` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `birthdate` datetime DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `postalcode` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `registeredmoment` datetime DEFAULT NULL,
  `previousvisitmoment` datetime DEFAULT NULL,
  `previousvisitip` int(10) unsigned DEFAULT NULL,
  `currentvisitmoment` datetime DEFAULT NULL,
  `currentvisitip` int(10) unsigned DEFAULT NULL,
  `recoversignature` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `IXU_login` (`login`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `users_groups`
--

DROP TABLE IF EXISTS `users_groups`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `users_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned DEFAULT NULL,
  `id_group` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `IXU_usersgroups` (`id_user`,`id_group`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2009-07-06 13:11:39

CREATE TABLE sitemap (
	id INT (10) UNSIGNED NOT NULL AUTO_INCREMENT, 
	url VARCHAR (1000) NOT NULL, 
	last_modified DATE, 
	change_freq ENUM ('always','hourly','daily','weekly','monthly','yearly','never') DEFAULT 'always' NOT NULL, 
	priority FLOAT DEFAULT 0.5 NOT NULL, 
	PRIMARY KEY(id), UNIQUE(url)
)  TYPE = MyISAM