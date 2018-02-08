SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `content`
-- ----------------------------
DROP TABLE IF EXISTS `content`;
CREATE TABLE `content` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `author_id` char(8) NOT NULL,
  `course_id` tinyint(1) unsigned NOT NULL,
  `time` int(10) NOT NULL,
  `pic` text NOT NULL,
  `read` tinyint(1) unsigned zerofill NOT NULL,
  `good` tinyint(1) unsigned zerofill NOT NULL,
  `duration` int(11) unsigned zerofill NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of content
-- ----------------------------

-- ----------------------------
-- Table structure for `members`
-- ----------------------------
DROP TABLE IF EXISTS `members`;
CREATE TABLE `members` (
  `id` char(8) NOT NULL,
  `name` char(15) NOT NULL,
  `password` char(32) NOT NULL,
  `salt` char(6) NOT NULL,
  `card` char(10) NOT NULL,
  `char` tinyint(1) unsigned NOT NULL COMMENT '0 for student\r\n1-4 for teacher',
  `grade` char(4) DEFAULT NULL,
  `class` char(2) DEFAULT NULL,
  `course` tinyint(1) unsigned DEFAULT NULL,
  `in` int(10) unsigned DEFAULT NULL,
  `out` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE,
  KEY `name` (`name`) USING HASH,
  KEY `card` (`card`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

