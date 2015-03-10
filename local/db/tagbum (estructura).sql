/*
Navicat MySQL Data Transfer

Source Server         : aws
Source Server Version : 50619
Source Host           : tagbumdb-east.c8ncui6mei6z.us-east-1.rds.amazonaws.com:3306
Source Database       : tagbumdb

Target Server Type    : MYSQL
Target Server Version : 50619
File Encoding         : 65001

Date: 2015-03-10 08:47:20
*/

CREATE DATABASE tagbum_prod CHARACTER SET utf8 COLLATE utf8_general_ci;

USE tagbum_prod;

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for action_points
-- ----------------------------
DROP TABLE IF EXISTS `action_points`;
CREATE TABLE `action_points` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_type` smallint(5) unsigned NOT NULL DEFAULT '0',
  `points_owner` int(11) NOT NULL DEFAULT '0',
  `points_user` int(11) NOT NULL DEFAULT '0',
  `status` smallint(5) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for activity_users
-- ----------------------------
DROP TABLE IF EXISTS `activity_users`;
CREATE TABLE `activity_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL,
  `code` char(32) CHARACTER SET utf8 NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `REMOTE_ADDR` varchar(25) CHARACTER SET utf8 NOT NULL,
  `HTTP_USER_AGENT` varchar(200) CHARACTER SET utf8 NOT NULL,
  `session_id` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for album
-- ----------------------------
DROP TABLE IF EXISTS `album`;
CREATE TABLE `album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `leyend` mediumtext,
  `id_image_cover` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for banners
-- ----------------------------
DROP TABLE IF EXISTS `banners`;
CREATE TABLE `banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_type` int(11) NOT NULL,
  `title` varchar(30) DEFAULT NULL,
  `link` mediumtext,
  `id_publi` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for banners_picture
-- ----------------------------
DROP TABLE IF EXISTS `banners_picture`;
CREATE TABLE `banners_picture` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_banner` int(11) NOT NULL,
  `picture` varchar(100) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `text` text,
  `class` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for business_card
-- ----------------------------
DROP TABLE IF EXISTS `business_card`;
CREATE TABLE `business_card` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` bigint(20) NOT NULL,
  `type` varchar(1) NOT NULL DEFAULT '1',
  `address` varchar(100) DEFAULT NULL,
  `company` varchar(35) DEFAULT NULL,
  `specialty` varchar(20) DEFAULT NULL,
  `email` varchar(70) DEFAULT NULL,
  `middle_text` varchar(25) DEFAULT NULL,
  `home_phone` varchar(15) DEFAULT NULL,
  `work_phone` varchar(15) DEFAULT NULL,
  `mobile_phone` varchar(15) DEFAULT NULL,
  `company_logo_url` varchar(100) DEFAULT NULL,
  `background_url` varchar(100) DEFAULT NULL,
  `text_color` varchar(7) NOT NULL DEFAULT '#000000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cities
-- ----------------------------
DROP TABLE IF EXISTS `cities`;
CREATE TABLE `cities` (
  `id` int(10) NOT NULL,
  `name` varchar(200) CHARACTER SET utf8 NOT NULL,
  `country` varchar(3) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `district` varchar(20) NOT NULL,
  `population` bigint(20) NOT NULL,
  `elevation` int(10) NOT NULL,
  `timezone` int(10) NOT NULL,
  `lat` varchar(100) CHARACTER SET utf8 NOT NULL,
  `log` varchar(100) CHARACTER SET utf8 NOT NULL,
  `last_modification` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cometchat
-- ----------------------------
-- DROP TABLE IF EXISTS `cometchat`;
-- CREATE TABLE `cometchat` (
--   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
--   `from` int(10) unsigned NOT NULL,
--   `to` int(10) unsigned NOT NULL,
--   `message` text NOT NULL,
--   `sent` int(10) unsigned NOT NULL DEFAULT '0',
--   `read` tinyint(1) unsigned NOT NULL DEFAULT '0',
--   `direction` tinyint(1) unsigned NOT NULL DEFAULT '0',
--   PRIMARY KEY (`id`),
--   KEY `to` (`to`),
--   KEY `from` (`from`),
--   KEY `direction` (`direction`),
--   KEY `read` (`read`),
--   KEY `sent` (`sent`)
-- ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cometchat_announcements
-- ----------------------------
-- DROP TABLE IF EXISTS `cometchat_announcements`;
-- CREATE TABLE `cometchat_announcements` (
--   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
--   `announcement` text NOT NULL,
--   `time` int(10) unsigned NOT NULL,
--   `to` int(10) NOT NULL,
--   `recd` int(1) NOT NULL DEFAULT '0',
--   `integer` int(1) NOT NULL DEFAULT '0',
--   PRIMARY KEY (`id`),
--   KEY `to` (`to`),
--   KEY `time` (`time`),
--   KEY `to_id` (`to`,`id`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cometchat_apehistory
-- ----------------------------
-- DROP TABLE IF EXISTS `cometchat_apehistory`;
-- CREATE TABLE `cometchat_apehistory` (
--   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
--   `channel` varchar(255) NOT NULL,
--   `message` text NOT NULL,
--   `sent` int(10) unsigned NOT NULL,
--   PRIMARY KEY (`id`),
--   KEY `channel` (`channel`),
--   KEY `sent` (`sent`),
--   KEY `channel_sent` (`channel`,`sent`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cometchat_block
-- ----------------------------
-- DROP TABLE IF EXISTS `cometchat_block`;
-- CREATE TABLE `cometchat_block` (
--   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
--   `fromid` int(10) unsigned NOT NULL,
--   `toid` int(10) unsigned NOT NULL,
--   PRIMARY KEY (`id`),
--   KEY `fromid` (`fromid`),
--   KEY `toid` (`toid`),
--   KEY `fromid_toid` (`fromid`,`toid`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cometchat_chatroommessages
-- ----------------------------
-- DROP TABLE IF EXISTS `cometchat_chatroommessages`;
-- CREATE TABLE `cometchat_chatroommessages` (
--   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
--   `userid` int(10) unsigned NOT NULL,
--   `chatroomid` int(10) unsigned NOT NULL,
--   `message` text NOT NULL,
--   `sent` int(10) unsigned NOT NULL,
--   PRIMARY KEY (`id`),
--   KEY `userid` (`userid`),
--   KEY `chatroomid` (`chatroomid`),
--   KEY `sent` (`sent`)
-- ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cometchat_chatrooms
-- ----------------------------
-- DROP TABLE IF EXISTS `cometchat_chatrooms`;
-- CREATE TABLE `cometchat_chatrooms` (
--   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
--   `name` varchar(255) NOT NULL,
--   `lastactivity` int(10) unsigned NOT NULL,
--   `createdby` int(10) unsigned NOT NULL,
--   `password` varchar(255) NOT NULL,
--   `type` tinyint(1) unsigned NOT NULL,
--   `vidsession` varchar(512) DEFAULT NULL,
--   PRIMARY KEY (`id`),
--   KEY `lastactivity` (`lastactivity`),
--   KEY `createdby` (`createdby`),
--   KEY `type` (`type`)
-- ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cometchat_chatrooms_users
-- ----------------------------
-- DROP TABLE IF EXISTS `cometchat_chatrooms_users`;
-- CREATE TABLE `cometchat_chatrooms_users` (
--   `userid` int(10) unsigned NOT NULL,
--   `chatroomid` int(10) unsigned NOT NULL,
--   `lastactivity` int(10) unsigned NOT NULL,
--   `isbanned` int(1) DEFAULT '0',
--   PRIMARY KEY (`userid`,`chatroomid`) USING BTREE,
--   KEY `chatroomid` (`chatroomid`),
--   KEY `lastactivity` (`lastactivity`),
--   KEY `userid` (`userid`),
--   KEY `userid_chatroomid` (`chatroomid`,`userid`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cometchat_comethistory
-- ----------------------------
-- DROP TABLE IF EXISTS `cometchat_comethistory`;
-- CREATE TABLE `cometchat_comethistory` (
--   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
--   `channel` varchar(255) NOT NULL,
--   `message` text NOT NULL,
--   `sent` int(10) unsigned NOT NULL,
--   PRIMARY KEY (`id`),
--   KEY `channel` (`channel`),
--   KEY `sent` (`sent`),
--   KEY `channel_sent` (`channel`,`sent`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cometchat_guests
-- ----------------------------
-- DROP TABLE IF EXISTS `cometchat_guests`;
-- CREATE TABLE `cometchat_guests` (
--   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
--   `name` varchar(255) NOT NULL,
--   `lastactivity` int(10) unsigned NOT NULL,
--   PRIMARY KEY (`id`),
--   KEY `lastactivity` (`lastactivity`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cometchat_messages_old
-- ----------------------------
-- DROP TABLE IF EXISTS `cometchat_messages_old`;
-- CREATE TABLE `cometchat_messages_old` (
--   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
--   `from` int(10) unsigned NOT NULL,
--   `to` int(10) unsigned NOT NULL,
--   `message` text NOT NULL,
--   `sent` int(10) unsigned NOT NULL DEFAULT '0',
--   `read` tinyint(1) unsigned NOT NULL DEFAULT '0',
--   `direction` tinyint(1) unsigned NOT NULL DEFAULT '0',
--   PRIMARY KEY (`id`),
--   KEY `to` (`to`),
--   KEY `from` (`from`),
--   KEY `direction` (`direction`),
--   KEY `read` (`read`),
--   KEY `sent` (`sent`)
-- ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cometchat_status
-- ----------------------------
-- DROP TABLE IF EXISTS `cometchat_status`;
-- CREATE TABLE `cometchat_status` (
--   `userid` int(10) unsigned NOT NULL,
--   `message` text,
--   `status` enum('available','away','busy','invisible','offline') DEFAULT NULL,
--   `typingto` int(10) unsigned DEFAULT NULL,
--   `typingtime` int(10) unsigned DEFAULT NULL,
--   `isdevice` int(1) unsigned NOT NULL DEFAULT '0',
--   `lastactivity` int(10) unsigned NOT NULL DEFAULT '0',
--   PRIMARY KEY (`userid`),
--   KEY `typingto` (`typingto`),
--   KEY `typingtime` (`typingtime`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cometchat_videochatsessions
-- ----------------------------
-- DROP TABLE IF EXISTS `cometchat_videochatsessions`;
-- CREATE TABLE `cometchat_videochatsessions` (
--   `username` varchar(255) NOT NULL,
--   `identity` varchar(255) NOT NULL,
--   `timestamp` int(10) unsigned DEFAULT '0',
--   PRIMARY KEY (`username`),
--   KEY `username` (`username`),
--   KEY `identity` (`identity`),
--   KEY `timestamp` (`timestamp`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for comments
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_type` int(11) DEFAULT NULL,
  `id_source` int(11) NOT NULL,
  `id_user_from` int(11) NOT NULL,
  `id_user_to` int(11) NOT NULL,
  `comment` mediumtext CHARACTER SET utf8 NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for config_system
-- ----------------------------
DROP TABLE IF EXISTS `config_system`;
CREATE TABLE `config_system` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `days_block` int(11) NOT NULL,
  `cost_account_individual` decimal(10,2) NOT NULL,
  `cost_account_company` decimal(10,2) NOT NULL,
  `cost_individual_personal_tag` decimal(10,2) NOT NULL,
  `cost_company_personal_tag` decimal(10,2) NOT NULL,
  `cost_business_card` decimal(10,2) NOT NULL,
  `cost_account_individual_old` decimal(10,2) NOT NULL,
  `cost_account_company_old` decimal(10,2) NOT NULL,
  `cost_individual_personal_tag_old` decimal(10,2) NOT NULL,
  `cost_company_personal_tag_old` decimal(10,2) NOT NULL,
  `cost_personal_bc` decimal(10,2) DEFAULT NULL,
  `cost_personal_bc_old` decimal(10,2) DEFAULT NULL,
  `cost_company_bc` decimal(10,2) DEFAULT NULL,
  `cost_company_bc_old` decimal(10,2) DEFAULT NULL,
  `creating_tag_points` decimal(10,2) DEFAULT NULL,
  `creating_tag_points_old` decimal(10,2) DEFAULT NULL,
  `redistributing_tag_points` decimal(10,2) DEFAULT NULL,
  `redistributing_tag_points_old` decimal(10,2) DEFAULT NULL,
  `sending_tag_points` decimal(10,2) DEFAULT NULL,
  `sending_tag_points_old` decimal(10,2) DEFAULT NULL,
  `redistributing_sponsor_tag_points` decimal(10,2) DEFAULT NULL,
  `redistributing_sponsor_tag_points_old` decimal(10,2) DEFAULT NULL,
  `newsletters_batch` int(11) NOT NULL,
  `time_in_minutes_shopping_cart_active` int(11) NOT NULL DEFAULT '120',
  `time_in_minutes_pending_order_payable` int(11) NOT NULL DEFAULT '120',
  `cost_per_point` decimal(5,3) unsigned NOT NULL DEFAULT '0.100',
  `emails_admin_reports_tags` text,
  `porcen_reporta_tag` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cost_points
-- ----------------------------
DROP TABLE IF EXISTS `cost_points`;
CREATE TABLE `cost_points` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_typecurrency` int(11) NOT NULL,
  `amount_from` decimal(11,0) NOT NULL,
  `amount_to` decimal(11,0) NOT NULL,
  `status` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cost` decimal(6,4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cost_publicity
-- ----------------------------
DROP TABLE IF EXISTS `cost_publicity`;
CREATE TABLE `cost_publicity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_typecurrency` int(11) NOT NULL,
  `id_typepublicity` int(11) NOT NULL,
  `click_from` int(11) NOT NULL,
  `click_to` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cost` decimal(6,4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for countries
-- ----------------------------
DROP TABLE IF EXISTS `countries`;
CREATE TABLE `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(5) DEFAULT NULL,
  `code_area` varchar(10) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for currency
-- ----------------------------
DROP TABLE IF EXISTS `currency`;
CREATE TABLE `currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `status` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dialogs
-- ----------------------------
DROP TABLE IF EXISTS `dialogs`;
CREATE TABLE `dialogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `terms` mediumtext,
  `privacity` mediumtext,
  `developers` mediumtext,
  `help` mediumtext,
  `about` mediumtext,
  `cookies` mediumtext,
  `paypal` mediumtext,
  `blog` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dislikes
-- ----------------------------
DROP TABLE IF EXISTS `dislikes`;
CREATE TABLE `dislikes` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_user` bigint(11) NOT NULL,
  `id_source` bigint(11) NOT NULL,
  `date` datetime NOT NULL,
  `type` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for empresas
-- ----------------------------
DROP TABLE IF EXISTS `empresas`;
CREATE TABLE `empresas` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Table structure for followers
-- ----------------------------
DROP TABLE IF EXISTS `followers`;
CREATE TABLE `followers` (
  `id_user` int(11) NOT NULL,
  `id_follower` int(11) NOT NULL,
  `status` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for geo_ip
-- ----------------------------
DROP TABLE IF EXISTS `geo_ip`;
CREATE TABLE `geo_ip` (
  `start_ip` char(15) NOT NULL,
  `end_ip` char(15) NOT NULL,
  `start` int(10) unsigned NOT NULL,
  `end` int(10) unsigned NOT NULL,
  `cc` char(2) NOT NULL,
  `cn` varchar(50) NOT NULL,
  `idioma` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for groups
-- ----------------------------
DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_creator` int(10) unsigned NOT NULL,
  `id_category` int(10) unsigned DEFAULT NULL,
  `id_oriented` smallint(11) NOT NULL,
  `id_privacy` smallint(11) DEFAULT NULL,
  `code` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` mediumtext,
  `photo` varchar(250) DEFAULT NULL,
  `icon` varchar(50) NOT NULL,
  `status` char(1) NOT NULL DEFAULT '',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for groups_category
-- ----------------------------
DROP TABLE IF EXISTS `groups_category`;
CREATE TABLE `groups_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `summary` mediumtext,
  `id_status` int(11) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `id_template` int(11) DEFAULT NULL,
  `id_template_sum` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for groups_oriented
-- ----------------------------
DROP TABLE IF EXISTS `groups_oriented`;
CREATE TABLE `groups_oriented` (
  `id` smallint(11) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL DEFAULT '',
  `rule` smallint(11) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for groups_privacy
-- ----------------------------
DROP TABLE IF EXISTS `groups_privacy`;
CREATE TABLE `groups_privacy` (
  `id` smallint(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `description` varchar(50) NOT NULL DEFAULT '',
  `status` char(1) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for images
-- ----------------------------
DROP TABLE IF EXISTS `images`;
CREATE TABLE `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL COMMENT 'Usuario a quien pertenece la imagen',
  `id_album` int(11) NOT NULL COMMENT 'Solo se usa al momento del upload de una imagen',
  `image_path` varchar(150) NOT NULL COMMENT 'Direccion fisica de la imagen',
  `leyend` mediumtext COMMENT 'Actualmente no se encuentra en uso en el sitio',
  `id_images_type` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Momento en que fue agregada la imagen',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2091 DEFAULT CHARSET=utf8 COMMENT='Conjunto de imagenes que han sido almacenadas en el server, principalmente desde los usuarios';


-- ----------------------------
-- Table structure for images_type
-- ----------------------------
DROP TABLE IF EXISTS `images_type`;
CREATE TABLE `images_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Actualmente no contiene data, pero el ID parece estar siendo usado como 2 desde los uploads de las imagenes';

-- ----------------------------
-- Table structure for languages
-- ----------------------------
DROP TABLE IF EXISTS `languages`;
CREATE TABLE `languages` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT 'Nombre del idioma',
  `status` char(1) CHARACTER SET utf8 NOT NULL COMMENT 'marca para validar si se usa o no el idioma, pero no esta en uso',
  `cod` char(2) NOT NULL COMMENT 'Codigo ISO 639-1 del idioma, ej. EN english',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Tabla maestro para los idiomas del sitio, contiene el codigo ISO de los idiomas, ej. EN ENGLISH';

-- ----------------------------
-- Table structure for likes
-- ----------------------------
DROP TABLE IF EXISTS `likes`;
CREATE TABLE `likes` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_user` bigint(11) NOT NULL COMMENT 'Usuario que realiza el like',
  `id_source` bigint(11) NOT NULL COMMENT 'Elemento que recibe el like',
  `date` datetime NOT NULL,
  `type` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=205932 DEFAULT CHARSET=utf8 COMMENT='Contiene el registro de los likes hechos por los usuarios';

-- ----------------------------
-- Table structure for log_actions
-- ----------------------------
DROP TABLE IF EXISTS `log_actions`;
CREATE TABLE `log_actions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_type` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Tipo de la accion almacenada proviene de type_actions',
  `id_source` int(10) unsigned NOT NULL DEFAULT '0',
  `id_user` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Usuario que realiza la accion',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=234741 DEFAULT CHARSET=utf8 COMMENT='Bitacora de las acciones que se toman dentro del site, en uso actualmente desde cronjobs';

-- ----------------------------
-- Table structure for newsletters
-- ----------------------------
DROP TABLE IF EXISTS `newsletters`;
CREATE TABLE `newsletters` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `current_sent` int(11) NOT NULL,
  `sending_failed` mediumtext,
  `tittle` varchar(50) NOT NULL,
  `tittle_old` varchar(50) DEFAULT NULL,
  `content` mediumtext NOT NULL,
  `content_old` mediumtext,
  `status` char(1) NOT NULL DEFAULT '1',
  `date_sent` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Tabla de los envios masivos de correo, parece necesitar otra tabla llamada newsletters_batch, por lo cual parece no estar en uso\r\n';

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` bigint(20) NOT NULL,
  `id_user` bigint(20) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `observation` mediumtext NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` char(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Actualmente parece estar reemplazada por store_orders';

-- ----------------------------
-- Table structure for paypal
-- ----------------------------
DROP TABLE IF EXISTS `paypal`;
CREATE TABLE `paypal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_publicity` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` mediumtext NOT NULL,
  `txn_id` varchar(30) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` char(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=203 DEFAULT CHARSET=utf8 COMMENT='Usada desde el pay.controls como formato de pago para paypal';

-- ----------------------------
-- Table structure for points_publicity
-- ----------------------------
DROP TABLE IF EXISTS `points_publicity`;
CREATE TABLE `points_publicity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_typecurrency` int(11) NOT NULL,
  `id_typepublicity` int(11) NOT NULL,
  `min_points` int(11) NOT NULL,
  `max_points` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `factor` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='Usada desde el sellpublicity.control como lectura, no tiene inserts en el site normal';

-- ----------------------------
-- Table structure for preference_details
-- ----------------------------
DROP TABLE IF EXISTS `preference_details`;
CREATE TABLE `preference_details` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_preference` int(5) NOT NULL COMMENT 'Tipo de preferencia a la que se usa',
  `detail` mediumtext NOT NULL COMMENT 'Contenido de la preferencia, puede ser seleccionada por los usuarios',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2317 DEFAULT CHARSET=utf8 COMMENT='contiene los valores ingresados para los distintos tipos de preferencias';

-- ----------------------------
-- Table structure for preferences
-- ----------------------------
DROP TABLE IF EXISTS `preferences`;
CREATE TABLE `preferences` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Contiene los tipos para preference_details 1=like, 2=want, 3=need';

-- ----------------------------
-- Table structure for products_user
-- ----------------------------
DROP TABLE IF EXISTS `products_user`;
CREATE TABLE `products_user` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` mediumtext NOT NULL,
  `brand` varchar(100) NOT NULL,
  `status` char(1) NOT NULL,
  `id_user` bigint(20) NOT NULL,
  `picture` varchar(250) NOT NULL,
  `url` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for sections_page
-- ----------------------------
DROP TABLE IF EXISTS `sections_page`;
CREATE TABLE `sections_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT 'Nombre de la pagina o seccion del sitio',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COMMENT='Usadas desde el wpanel y como complemento de las ayudas';

-- ----------------------------
-- Table structure for sex
-- ----------------------------
DROP TABLE IF EXISTS `sex`;
CREATE TABLE `sex` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Contiene los IDs para los sexos',
  `label` mediumtext COMMENT 'nombre a usar para el sexo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Contiene los IDs para los sexos\r\n';

-- ----------------------------
-- Table structure for status
-- ----------------------------
DROP TABLE IF EXISTS `status`;
CREATE TABLE `status` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for store_category
-- ----------------------------
DROP TABLE IF EXISTS `store_category`;
CREATE TABLE `store_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_status` int(11) DEFAULT NULL,
  `id_template` int(11) DEFAULT NULL COMMENT 'template de la traduccion',
  `name` mediumtext,
  `photo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='Categorias de las tiendas, refiere tambien a las traducciones';

-- ----------------------------
-- Table structure for store_orders
-- ----------------------------
DROP TABLE IF EXISTS `store_orders`;
CREATE TABLE `store_orders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_status` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL COMMENT 'usuario que puso la orden',
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8 COMMENT='contiene los ids de las ordenes que los usuarios han ingresado al store';

-- ----------------------------
-- Table structure for store_orders_detail
-- ----------------------------
DROP TABLE IF EXISTS `store_orders_detail`;
CREATE TABLE `store_orders_detail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_order` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `cant` int(11) NOT NULL COMMENT 'cantidad',
  `price` int(11) DEFAULT NULL COMMENT 'presio al que se metio a la compra el producto',
  `id_status` int(11) DEFAULT NULL,
  `formPayment` char(1) DEFAULT '0' COMMENT 'Si se paga con puntos o con moneda',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=150 DEFAULT CHARSET=utf8 COMMENT='contenido de las ordenes, referencia a los productos y el precio al que fueron/son comprados';

-- ----------------------------
-- Table structure for store_products
-- ----------------------------
DROP TABLE IF EXISTS `store_products`;
CREATE TABLE `store_products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_status` int(11) DEFAULT NULL,
  `id_category` int(11) DEFAULT NULL,
  `id_sub_category` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` mediumtext,
  `stock` int(11) DEFAULT NULL COMMENT 'cantidad disponible',
  `sale_points` int(11) DEFAULT NULL COMMENT 'cuanto cuesta en puntos',
  `photo` varchar(100) DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `update_date` date DEFAULT NULL,
  `place` char(1) DEFAULT NULL,
  `formPayment` char(2) NOT NULL DEFAULT '0',
  `hits` bigint(11) NOT NULL DEFAULT '0',
  `video_url` varchar(200) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='Contiene los productos ofrecidos por los usuarios';

-- ----------------------------
-- Table structure for store_products_picture
-- ----------------------------
DROP TABLE IF EXISTS `store_products_picture`;
CREATE TABLE `store_products_picture` (
  `id` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `picture` varchar(100) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Imagenes almacenadas para los productos';

-- ----------------------------
-- Table structure for store_raffle
-- ----------------------------
DROP TABLE IF EXISTS `store_raffle`;
CREATE TABLE `store_raffle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_product` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `points` int(11) NOT NULL COMMENT 'cuantos puntos cuesta entrar en la rifa',
  `cant_users` int(11) NOT NULL COMMENT 'cantidad de usuarios que se han registrado',
  `start_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_date` date DEFAULT NULL,
  `status` int(11) NOT NULL,
  `winner` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Las rifas de productos creadas desde el site';

-- ----------------------------
-- Table structure for store_raffle_join
-- ----------------------------
DROP TABLE IF EXISTS `store_raffle_join`;
CREATE TABLE `store_raffle_join` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_raffle` int(11) NOT NULL,
  `date_join` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='Tabla para registrar la particcipacion de los usuarios';

-- ----------------------------
-- Table structure for store_raffle_users
-- ----------------------------
DROP TABLE IF EXISTS `store_raffle_users`;
CREATE TABLE `store_raffle_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(250) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='contiene los correos de los usuarios que se registran para una rifa';

-- ----------------------------
-- Table structure for store_sub_category
-- ----------------------------
DROP TABLE IF EXISTS `store_sub_category`;
CREATE TABLE `store_sub_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_status` int(11) DEFAULT NULL,
  `id_category` int(11) DEFAULT NULL,
  `id_template` int(11) DEFAULT NULL,
  `name` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for subscription_plans
-- ----------------------------
DROP TABLE IF EXISTS `subscription_plans`;
CREATE TABLE `subscription_plans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `price` double(5,0) NOT NULL,
  `days` int(3) NOT NULL,
  `description` tinytext CHARACTER SET utf8,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for subscription_plans_detail
-- ----------------------------
DROP TABLE IF EXISTS `subscription_plans_detail`;
CREATE TABLE `subscription_plans_detail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_plan` int(11) NOT NULL,
  `ads` smallint(1) DEFAULT '0',
  `banners` smallint(1) DEFAULT '0',
  `num_ads` smallint(1) DEFAULT '0',
  `num_banners` smallint(1) DEFAULT '0',
  `features` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tags
-- ----------------------------
DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL,
  `id_creator` int(10) unsigned NOT NULL,
  `id_product` int(10) unsigned NOT NULL,
  `background` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `bgmatrix` varchar(50) DEFAULT NULL,
  `code_number` varchar(12) CHARACTER SET utf8 NOT NULL DEFAULT '000000000',
  `color_code` varchar(7) CHARACTER SET utf8 NOT NULL DEFAULT '#FFFFFF',
  `color_code2` varchar(7) CHARACTER SET utf8 NOT NULL DEFAULT '#FFFFFF',
  `color_code3` varchar(7) CHARACTER SET utf8 NOT NULL DEFAULT '#FFFFFF',
  `text` varchar(50) CHARACTER SET utf8 NOT NULL,
  `text2` varchar(200) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `geo_lat` decimal(10,5) NOT NULL,
  `geo_lon` decimal(10,5) NOT NULL,
  `geo_log` decimal(10,5) NOT NULL,
  `profile_img_url` varchar(75) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `video_url` varchar(200) CHARACTER SET utf8 NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` char(2) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `points` int(10) unsigned NOT NULL,
  `source` bigint(20) unsigned NOT NULL,
  `hits` int(11) NOT NULL DEFAULT '0',
  `id_business_card` int(10) unsigned NOT NULL,
  `id_group` int(10) unsigned NOT NULL DEFAULT '0',
  `img` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `redist` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tags_comments
-- ----------------------------
DROP TABLE IF EXISTS `tags_comments`;
CREATE TABLE `tags_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tag` int(11) NOT NULL,
  `id_user_from` int(11) NOT NULL,
  `id_user_to` int(11) NOT NULL,
  `comment` varchar(200) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tags_delete_backgrounds
-- ----------------------------
DROP TABLE IF EXISTS `tags_delete_backgrounds`;
CREATE TABLE `tags_delete_backgrounds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `background` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tags_favorites
-- ----------------------------
DROP TABLE IF EXISTS `tags_favorites`;
CREATE TABLE `tags_favorites` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_user_fav` bigint(11) NOT NULL,
  `id_tag` bigint(11) NOT NULL,
  `id_user` bigint(11) NOT NULL,
  `id_creator` bigint(11) NOT NULL,
  `background` varchar(200) NOT NULL,
  `text` varchar(200) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tags_hits
-- ----------------------------
DROP TABLE IF EXISTS `tags_hits`;
CREATE TABLE `tags_hits` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_tag` int(10) unsigned NOT NULL,
  `date` date NOT NULL,
  `hits` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tags_privates
-- ----------------------------
DROP TABLE IF EXISTS `tags_privates`;
CREATE TABLE `tags_privates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_friend` int(11) NOT NULL,
  `id_tag` int(11) NOT NULL,
  `status_tag` char(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tags_report
-- ----------------------------
DROP TABLE IF EXISTS `tags_report`;
CREATE TABLE `tags_report` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_tag` bigint(11) NOT NULL,
  `id_user_creator` bigint(11) NOT NULL,
  `id_user_report` bigint(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type_report` int(11) NOT NULL,
  `status` char(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tags_share_mails
-- ----------------------------
DROP TABLE IF EXISTS `tags_share_mails`;
CREATE TABLE `tags_share_mails` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_tag` bigint(11) NOT NULL,
  `referee_number` varchar(50) NOT NULL,
  `email_destiny` varchar(250) NOT NULL,
  `view` char(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tags_type
-- ----------------------------
DROP TABLE IF EXISTS `tags_type`;
CREATE TABLE `tags_type` (
  `id` int(5) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` mediumtext NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `status` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tour_comment
-- ----------------------------
DROP TABLE IF EXISTS `tour_comment`;
CREATE TABLE `tour_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_div` varchar(35) NOT NULL,
  `title` varchar(100) NOT NULL,
  `message` varchar(100) NOT NULL,
  `position` varchar(20) NOT NULL,
  `hash_tash` varchar(25) NOT NULL,
  `orderP` tinyint(3) unsigned NOT NULL DEFAULT '250',
  `active` tinyint(2) DEFAULT NULL,
  `sectionActive` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tour_hash
-- ----------------------------
DROP TABLE IF EXISTS `tour_hash`;
CREATE TABLE `tour_hash` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `hash_tash` varchar(34) NOT NULL,
  `ip` varchar(15) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tour_position
-- ----------------------------
DROP TABLE IF EXISTS `tour_position`;
CREATE TABLE `tour_position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tour_section
-- ----------------------------
DROP TABLE IF EXISTS `tour_section`;
CREATE TABLE `tour_section` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sectionTour` varchar(30) NOT NULL,
  `active` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for translations
-- ----------------------------
DROP TABLE IF EXISTS `translations`;
CREATE TABLE `translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_lenguage` int(5) NOT NULL,
  `section` varchar(30) NOT NULL,
  `label` mediumtext NOT NULL,
  `text` mediumtext NOT NULL,
  `text_help` mediumtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cod` char(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for translations_template
-- ----------------------------
DROP TABLE IF EXISTS `translations_template`;
CREATE TABLE `translations_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_lenguage` int(5) NOT NULL,
  `section` int(11) NOT NULL,
  `label` mediumtext NOT NULL,
  `text` mediumtext NOT NULL,
  `text_help` mediumtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for trending_toping
-- ----------------------------
DROP TABLE IF EXISTS `trending_toping`;
CREATE TABLE `trending_toping` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `word` varchar(45) NOT NULL,
  `count` int(10) unsigned DEFAULT '1',
  `day` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for type_actions
-- ----------------------------
DROP TABLE IF EXISTS `type_actions`;
CREATE TABLE `type_actions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_source` varchar(15) DEFAULT NULL,
  `status` smallint(5) unsigned NOT NULL DEFAULT '1',
  `description` varchar(50) NOT NULL,
  `reference` varchar(50) NOT NULL,
  `label_name` varchar(70) DEFAULT NULL,
  `label_desc` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for type_banners
-- ----------------------------
DROP TABLE IF EXISTS `type_banners`;
CREATE TABLE `type_banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for type_notifications
-- ----------------------------
DROP TABLE IF EXISTS `type_notifications`;
CREATE TABLE `type_notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `message_sent` varchar(100) NOT NULL,
  `message_link` varchar(100) NOT NULL,
  `message_description` varchar(100) DEFAULT NULL,
  `status` char(1) NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for type_publicity
-- ----------------------------
DROP TABLE IF EXISTS `type_publicity`;
CREATE TABLE `type_publicity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for type_tag_report
-- ----------------------------
DROP TABLE IF EXISTS `type_tag_report`;
CREATE TABLE `type_tag_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descrip` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(250) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `screen_name` varchar(15) DEFAULT NULL,
  `name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `date_birth` date NOT NULL,
  `profile_image_url` varchar(200) DEFAULT NULL,
  `updatePicture` char(1) NOT NULL,
  `location` varchar(30) DEFAULT NULL,
  `url` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `country` varchar(200) DEFAULT NULL,
  `state` varchar(200) DEFAULT NULL,
  `city` varchar(200) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `zip_code` varchar(10) DEFAULT NULL,
  `referee_number` varchar(10) DEFAULT NULL,
  `referee_user` varchar(10) NOT NULL,
  `password_user` varchar(100) NOT NULL,
  `password_system` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `followers_count` int(10) unsigned NOT NULL DEFAULT '0',
  `friends_count` int(10) unsigned NOT NULL DEFAULT '0',
  `following_count` int(10) unsigned NOT NULL DEFAULT '0',
  `tags_count` int(10) unsigned DEFAULT NULL,
  `references_count` int(7) NOT NULL,
  `time_zone` varchar(5) DEFAULT NULL,
  `last_update` datetime NOT NULL,
  `accumulated_points` bigint(20) NOT NULL,
  `current_points` bigint(20) NOT NULL,
  `status` smallint(5) unsigned NOT NULL DEFAULT '2',
  `language` char(2) NOT NULL DEFAULT '1',
  `type` char(1) NOT NULL DEFAULT '0',
  `show_my_birthday` char(1) NOT NULL DEFAULT '1',
  `home_phone` varchar(15) DEFAULT NULL,
  `mobile_phone` varchar(15) DEFAULT NULL,
  `work_phone` varchar(15) DEFAULT NULL,
  `pay_personal_tag` char(1) DEFAULT '0',
  `pay_bussines_card` int(11) DEFAULT '0',
  `logins_count` int(11) NOT NULL DEFAULT '0',
  `super_user` char(1) NOT NULL DEFAULT '0',
  `chat_last_update` datetime NOT NULL,
  `status_chat` char(1) NOT NULL DEFAULT '1',
  `user_background` varchar(100) DEFAULT NULL,
  `view_creation_tag` char(1) NOT NULL,
  `lastChatActivity` int(11) DEFAULT '0',
  `view_type_timeline` char(1) DEFAULT NULL,
  `sex` char(1) DEFAULT '1',
  `paypal` varchar(100) DEFAULT NULL,
  `taxId` varchar(11) DEFAULT '000-00-0000',
  `fbid` int(10) unsigned DEFAULT NULL,
  `personal_messages` varchar(160) DEFAULT NULL,
  `user_cover` varchar(100) DEFAULT NULL,
  `interest` tinyint(3) unsigned NOT NULL,
  `relationship` tinyint(3) unsigned NOT NULL,
  `wish_to` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- ----------------------------
-- Table structure for users_config_notifications
-- ----------------------------
DROP TABLE IF EXISTS `users_config_notifications`;
CREATE TABLE `users_config_notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_notification` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for users_device_login
-- ----------------------------
DROP TABLE IF EXISTS `users_device_login`;
CREATE TABLE `users_device_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `agent` mediumtext NOT NULL,
  `remote_addr` varchar(20) NOT NULL,
  `remote_host` varchar(100) NOT NULL,
  `remote_port` varchar(20) NOT NULL,
  `language` varchar(30) NOT NULL,
  `is_mobile` char(1) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for users_groups
-- ----------------------------
DROP TABLE IF EXISTS `users_groups`;
CREATE TABLE `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_group` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `is_admin` char(1) DEFAULT '0',
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_update` datetime DEFAULT NULL,
  `status` char(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for users_links
-- ----------------------------
DROP TABLE IF EXISTS `users_links`;
CREATE TABLE `users_links` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_user` bigint(20) NOT NULL,
  `id_friend` bigint(20) NOT NULL,
  `is_friend` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for users_notifications
-- ----------------------------
DROP TABLE IF EXISTS `users_notifications`;
CREATE TABLE `users_notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_type` int(11) NOT NULL,
  `id_source` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_friend` int(11) NOT NULL,
  `revised` char(1) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for users_panel
-- ----------------------------
DROP TABLE IF EXISTS `users_panel`;
CREATE TABLE `users_panel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` mediumtext CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `apellidos` mediumtext CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `login` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `password` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipo` char(1) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `code` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `modulos` mediumtext CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for users_plan_purchase
-- ----------------------------
DROP TABLE IF EXISTS `users_plan_purchase`;
CREATE TABLE `users_plan_purchase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_plan` int(11) NOT NULL,
  `init_date` date NOT NULL,
  `end_date` date NOT NULL,
  `notes` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for users_points_purchase
-- ----------------------------
DROP TABLE IF EXISTS `users_points_purchase`;
CREATE TABLE `users_points_purchase` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_cost` int(11) NOT NULL,
  `id_user` bigint(11) NOT NULL,
  `id_currency` int(11) NOT NULL,
  `cost_investment` decimal(15,2) NOT NULL,
  `points_bought` int(11) DEFAULT NULL,
  `status` char(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for users_preferences
-- ----------------------------
DROP TABLE IF EXISTS `users_preferences`;
CREATE TABLE `users_preferences` (
  `id_user` bigint(20) NOT NULL,
  `id_preference` bigint(5) NOT NULL,
  `preference` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for users_profile_showbirthday
-- ----------------------------
DROP TABLE IF EXISTS `users_profile_showbirthday`;
CREATE TABLE `users_profile_showbirthday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for users_publicity
-- ----------------------------
DROP TABLE IF EXISTS `users_publicity`;
CREATE TABLE `users_publicity` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_tag` bigint(11) NOT NULL,
  `id_type_publicity` int(11) NOT NULL,
  `id_cost` int(11) NOT NULL,
  `id_user` bigint(11) NOT NULL,
  `id_currency` int(11) NOT NULL,
  `title` varchar(25) NOT NULL,
  `message` varchar(90) DEFAULT NULL,
  `link` mediumtext NOT NULL,
  `picture` varchar(100) NOT NULL,
  `picture_title_tag` varchar(100) NOT NULL,
  `cost_investment` decimal(15,3) NOT NULL,
  `click_max` int(11) NOT NULL,
  `click_current` int(11) NOT NULL,
  `status` char(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for users_publicity_validation
-- ----------------------------
DROP TABLE IF EXISTS `users_publicity_validation`;
CREATE TABLE `users_publicity_validation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_publicity` int(11) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `timep` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for users_relations
-- ----------------------------
DROP TABLE IF EXISTS `users_relations`;
CREATE TABLE `users_relations` (
  `id` tinyint(3) unsigned NOT NULL,
  `label` varchar(20) NOT NULL,
  `description` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for users_search_preferences
-- ----------------------------
DROP TABLE IF EXISTS `users_search_preferences`;
CREATE TABLE `users_search_preferences` (
  `id` int(10) unsigned NOT NULL,
  `sex_preference` tinyint(3) unsigned NOT NULL,
  `wish_to` tinyint(3) unsigned NOT NULL,
  `min_age` tinyint(3) unsigned NOT NULL,
  `max_age` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for users_sex_preferences
-- ----------------------------
DROP TABLE IF EXISTS `users_sex_preferences`;
CREATE TABLE `users_sex_preferences` (
  `id` tinyint(4) unsigned NOT NULL,
  `label` varchar(15) DEFAULT NULL,
  `description` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for users_wish_to
-- ----------------------------
DROP TABLE IF EXISTS `users_wish_to`;
CREATE TABLE `users_wish_to` (
  `id` tinyint(11) unsigned NOT NULL,
  `label` varchar(10) NOT NULL,
  `descripcion` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for zip_codes
-- ----------------------------
DROP TABLE IF EXISTS `zip_codes`;
CREATE TABLE `zip_codes` (
  `ZIP_CODE` varchar(255) DEFAULT NULL,
  `CITY` varchar(255) DEFAULT NULL,
  `STATE` varchar(255) DEFAULT NULL,
  `AREA_CODE` varchar(255) DEFAULT NULL,
  `CITY_ALIAS_NAME` varchar(255) DEFAULT NULL,
  `CITY_ALIAS_ABBR` varchar(255) DEFAULT NULL,
  `CITY_TYPE` varchar(255) DEFAULT NULL,
  `COUNTY_NAME` varchar(255) DEFAULT NULL,
  `STATE_FIPS` varchar(255) DEFAULT NULL,
  `COUNTY_FIPS` varchar(255) DEFAULT NULL,
  `TIME_ZONE` varchar(255) DEFAULT NULL,
  `DAY_LIGHT_SAVING` varchar(255) DEFAULT NULL,
  `LATITUDE` varchar(255) DEFAULT NULL,
  `LONGITUDE` varchar(255) DEFAULT NULL,
  `ELEVATION` varchar(255) DEFAULT NULL,
  `MSA2000` varchar(255) DEFAULT NULL,
  `PMSA` varchar(255) DEFAULT NULL,
  `CBSA` varchar(255) DEFAULT NULL,
  `CBSA_DIV` varchar(255) DEFAULT NULL,
  `CBSA_TITLE` varchar(255) DEFAULT NULL,
  `PERSONS_PER_HOUSEHOLD` varchar(255) DEFAULT NULL,
  `ZIPCODE_POPULATION` varchar(255) DEFAULT NULL,
  `COUNTIES_AREA` varchar(255) DEFAULT NULL,
  `HOUSEHOLDS_PER_ZIPCODE` varchar(255) DEFAULT NULL,
  `WHITE_POPULATION` varchar(255) DEFAULT NULL,
  `BLACK_POPULATION` varchar(255) DEFAULT NULL,
  `HISPANIC_POPULATION` varchar(255) DEFAULT NULL,
  `INCOME_PER_HOUSEHOLD` varchar(255) DEFAULT NULL,
  `AVERAGE_HOUSE_VALUE` varchar(255) DEFAULT NULL,
  KEY `AREA_CODE` (`AREA_CODE`),
  KEY `HOUSEHOLDS_PER_ZIPCODE` (`HOUSEHOLDS_PER_ZIPCODE`),
  KEY `ZIP_CODE` (`ZIP_CODE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
