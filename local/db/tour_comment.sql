/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50532
Source Host           : localhost:3306
Source Database       : seemytag

Target Server Type    : MYSQL
Target Server Version : 50532
File Encoding         : 65001

Date: 2013-11-04 10:41:00
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tour_comment`
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
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tour_comment
-- ----------------------------
INSERT INTO `tour_comment` VALUES ('1', '#menu_notifications', 'TOUR_NOTIFICATIONS_TITLE', 'TOUR_NOTIFICATIONS_CONTENT', 'bottom-middle', 'home', '1', '1', '1');
INSERT INTO `tour_comment` VALUES ('2', '#tourProfile', 'TOUR_PROFILE_TITLE', 'TOUR_PROFILE_CONTENT', 'bottom-middle', 'home', '2', '1', '1');
INSERT INTO `tour_comment` VALUES ('3', '#tourFriends', 'TOUR_FRIENDS_TITLE', 'TOUR_FRIENDS_CONTENT', 'bottom-middle', 'home', '3', '1', '1');
INSERT INTO `tour_comment` VALUES ('4', '#tourTimeline', 'TOUR_TAGS_TITLE', 'TOUR_TAGS_CONTENT', 'bottom-middle', 'home', '4', '1', '1');
INSERT INTO `tour_comment` VALUES ('5', '#tourToptag', 'TOUR_TOPTAGS_TITLE', 'TOUR_TOPTAGS_CONTENT', 'bottom-middle', 'home', '5', '1', '1');
INSERT INTO `tour_comment` VALUES ('6', '#tourPublicity', 'TOUR_PUBLICITY_TITLE', 'TOUR_PUBLICITY_CONTENT', 'bottom-middle', 'home', '6', '1', '1');
INSERT INTO `tour_comment` VALUES ('7', '#tourHome', 'TOUR_HOME_TITLE', 'TOUR_HOME_CONTENT', 'bottom-middle', 'home', '7', '1', '1');
INSERT INTO `tour_comment` VALUES ('8', '#cretationTag', 'TOUR_CREATION_TITLE', 'TOUR_CREATION_CONTENT', 'middle-left', 'home', '8', '1', '1');
INSERT INTO `tour_comment` VALUES ('9', '#profile', 'TOUR_ACCOUNT_TITLE', 'TOUR_ACCOUNT_CONTENT', 'middle-left', 'home', '9', '1', '1');
INSERT INTO `tour_comment` VALUES ('10', '#friends', 'TOUR_FRIENDS_TITLE', 'TOUR_FRIENDS_CONTENT', 'middle-left', 'home', '10', '1', '1');
INSERT INTO `tour_comment` VALUES ('11', '#groups', 'TOUR_GROUPS_TITLE', 'TOUR_GROUPS_CONTENT', 'middle-left', 'home', '11', '1', '1');
INSERT INTO `tour_comment` VALUES ('12', '#setting', 'TOUR_SETTING_TITLE', 'TOUR_SETTING_CONTENT', 'middle-left', 'home', '12', '1', '1');
INSERT INTO `tour_comment` VALUES ('13', '#store', 'TOUR_STORE_TITLE', 'TOUR_STORE_CONTENT', 'middle-left', 'home', '13', '1', '1');
INSERT INTO `tour_comment` VALUES ('14', '.imgNewstIndex', 'TOUR_NEWS_TITLE', 'TOUR_NEWS_CONTENT', 'middle-left', 'home', '14', '1', '1');
INSERT INTO `tour_comment` VALUES ('15', '#notifications-box', 'TOUR_NOTIFICATIONS_TITLE', 'TOUR_NOTIFICATIONSDOWN_CONTENT', 'top-left', 'home', '15', '1', '1');
INSERT INTO `tour_comment` VALUES ('16', '#adsListPubliNew', 'TOUR_CREATION_TITLE', 'TOUR_CREATION_CONTENT', 'middle-left', 'home', '16', '1', '1');
INSERT INTO `tour_comment` VALUES ('17', '#imgUsrSuggest', 'TOUR_SUGGEST_TITLE', 'TOUR_SUGGEST_CONTENT', 'middle-left', 'home', '17', '1', '1');
INSERT INTO `tour_comment` VALUES ('18', '.imgPubliIndex', 'TOUR_PUBLICITY_TITLE', 'TOUR_PUBLICITYDOWN_CONTENT', 'middle-left', 'home', '18', '1', '1');
INSERT INTO `tour_comment` VALUES ('19', '#bcard', 'TOUR_BUSINESS_TITLE', 'TOUR_BUSINESS_CONTENT', 'bottom-middle', 'timeline', '19', '1', '1');
INSERT INTO `tour_comment` VALUES ('20', '#like', 'TOUR_LIKE_TITLE', 'TOUR_LIKE_CONTENT', 'bottom-middle', 'timeline', '20', '1', '1');
INSERT INTO `tour_comment` VALUES ('21', '#dislike', 'TOUR_DISLIKE_TITLE', 'TOUR_DISLIKE_CONTENT', 'bottom-middle', 'timeline', '21', '1', '1');
INSERT INTO `tour_comment` VALUES ('22', '#comment', 'TOUR_COMMENT_TITLE', 'TOUR_COMMENT_CONTENT', 'bottom-middle', 'timeline', '22', '1', '1');
INSERT INTO `tour_comment` VALUES ('23', '#redistr', 'TOUR_REDIS_TITLE', 'TOUR_REDIS_CONTENT', 'bottom-middle', 'timeline', '23', '1', '1');
INSERT INTO `tour_comment` VALUES ('24', '#share', 'TOUR_SHARE_TITLE', 'TOUR_SHARE_CONTENT', 'bottom-middle', 'timeline', '24', '1', '1');
INSERT INTO `tour_comment` VALUES ('25', '#sponsors', 'TOUR_SPONSOR_TITLE', 'TOUR_SPONSOR_CONTENT', 'bottom-middle', 'timeline', '25', '1', '1');
INSERT INTO `tour_comment` VALUES ('26', '#trash', 'TOUR_TRASH_TITLE', 'TOUR_TRASH_CONTENT', 'bottom-middle', 'timeline', '26', '1', '1');
INSERT INTO `tour_comment` VALUES ('27', '#edit', 'TOUR_EDIT_TITLE', 'TOUR_EDIT_CONTENT', 'bottom-middle', 'timeline', '27', '1', '1');
INSERT INTO `tour_comment` VALUES ('28', '#report', 'TOUR_REPORT_TITLE', 'TOUR_REPORT_CONTENT', 'bottom-middle', 'timeline', '28', '1', '1');
INSERT INTO `tour_comment` VALUES ('35', '#txtMsg', 'TOUR_TEXTUP_TITLE', 'TOUR_TEXTUP_CONTENT', 'top-left', 'creation', '2', '1', '1');
INSERT INTO `tour_comment` VALUES ('46', '#txtCodeNumber', 'TOUR_TEXTMIDDLE_TITLE', 'TOUR_TEXTMIDDLE_CONTENT', 'top-left', 'creation', '3', '1', '1');
INSERT INTO `tour_comment` VALUES ('47', '#textlarg', 'TOUR_TEXTDOWN_TITLE', 'TOUR_TEXTDOWN_CONTENT', 'middle-left', 'creation', '4', '1', '1');
INSERT INTO `tour_comment` VALUES ('48', '#PublicPrivate', 'TOUR_SHARETAG_TITLE', 'TOUR_SHARETAG_CONTENT', 'bottom-middle', 'creation', '5', '0', '1');
INSERT INTO `tour_comment` VALUES ('49', '#backgroundsTag', 'TOUR_BACKGROUND_TITLE', 'TOUR_BACKGROUND_CONTENT', 'bottom-middle', 'creation', '6', '0', '1');
INSERT INTO `tour_comment` VALUES ('50', '#videosTag', 'TOUR_VIDEOS_TITLE', 'TOUR_VIDEOS_CONTENT', 'bottom-middle', 'creation', '7', '0', '1');
INSERT INTO `tour_comment` VALUES ('51', '#tourRadio', 'TOUR_RADIO_TITLE', 'TOUR_RADIO_CONTENT', 'bottom-left', 'creation', '1', '1', '1');
