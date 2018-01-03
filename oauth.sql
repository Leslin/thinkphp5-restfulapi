SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS  `cfg_oauth`;
CREATE TABLE `cfg_oauth` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `app_key` varchar(50) NOT NULL DEFAULT '' COMMENT 'Key',
  `expires_in` int(11) NOT NULL COMMENT '有效期',
  `app_secret` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `un-appkey` (`app_key`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;

