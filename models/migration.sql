SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `blog_migration`
-- ----------------------------
DROP TABLE IF EXISTS `{{migration}}`;
CREATE TABLE `{{migration}}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_migration
-- ----------------------------