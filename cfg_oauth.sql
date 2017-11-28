SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS  `cfg_oauth`;
CREATE TABLE `cfg_oauth` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'PK_授权ID',
  `origin` tinyint(3) NOT NULL DEFAULT '0' COMMENT '来源类型ID',
  `app_key` varchar(50) NOT NULL DEFAULT '' COMMENT '应用Key',
  `expires_in` int(11) NOT NULL COMMENT '有效期（单位：秒）',
  `allow_anonymous` bit(1) NOT NULL DEFAULT b'0' COMMENT '是否允许匿名授权',
  `allow_all_scope` bit(1) NOT NULL DEFAULT b'0' COMMENT '是否允许全部访问',
  `package` blob,
  `remark` varchar(255) NOT NULL COMMENT '备注',
  `app_secret` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `un-appkey` (`app_key`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;

