/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : game

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-11-19 10:01:39
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `game`
-- ----------------------------
DROP TABLE IF EXISTS `game`;
CREATE TABLE `game` (
  `game_id` int(11) NOT NULL DEFAULT '1',
  `game_uid1` varchar(11) DEFAULT NULL,
  `game_state1` varchar(20) DEFAULT NULL,
  `game_uid2` varchar(11) DEFAULT NULL,
  `game_state2` varchar(255) DEFAULT NULL,
  `game_uid3` varchar(20) DEFAULT NULL,
  `game_state3` varchar(20) DEFAULT NULL,
  `game_uid4` varchar(11) DEFAULT NULL,
  `game_state4` varchar(20) DEFAULT NULL,
  `game_uid5` varchar(11) DEFAULT NULL,
  `game_state5` varchar(20) DEFAULT NULL,
  `game_uid6` varchar(11) DEFAULT NULL,
  `game_state6` varchar(20) DEFAULT NULL,
  `game_uid7` varchar(11) DEFAULT NULL,
  `game_state7` varchar(20) DEFAULT NULL,
  `game_fstate` tinyint(4) DEFAULT NULL COMMENT ' 1-游戏开始   0 - 游戏未开始',
  PRIMARY KEY (`game_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of game
-- ----------------------------
INSERT INTO `game` VALUES ('1', '01', '', '', '', '', '', null, null, null, null, null, null, null, null, '1');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) DEFAULT NULL,
  `user_pwd` varchar(255) DEFAULT NULL,
  `user_jifen` int(11) DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', '123', '123', '0');
INSERT INTO `user` VALUES ('2', 'admin', '123', '3100');

-- ----------------------------
-- Table structure for `xz`
-- ----------------------------
DROP TABLE IF EXISTS `xz`;
CREATE TABLE `xz` (
  `xz_id` int(11) NOT NULL AUTO_INCREMENT,
  `xz_uid` int(11) DEFAULT NULL,
  `xz_xz` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`xz_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xz
-- ----------------------------
INSERT INTO `xz` VALUES ('1', '2', '1');
