CREATE TABLE IF NOT EXISTS `token` (
  `sina_uid` bigint(13) unsigned NOT NULL COMMENT '新狼用户ID',
  `oauth_token` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '授权信息',
  `remind_in` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `expires_in` int(13) NOT NULL COMMENT '过期时间',
  `creation_date` int(11) NOT NULL,
  PRIMARY KEY (`sina_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户TOKEN表';

CREATE TABLE IF NOT EXISTS `user` (
  `sina_uid` bigint(10) unsigned NOT NULL COMMENT '新浪uid',
  `idstr` varchar(15) NOT NULL COMMENT '新浪uid 字符串型',
  `screen_name` varchar(50) DEFAULT NULL COMMENT '新浪昵称',
  `name` varchar(50) DEFAULT NULL COMMENT '友好显示名称',
  `province` int(10) NOT NULL COMMENT '用户所在省级ID',
  `city` int(10) NOT NULL COMMENT '用户所在城市ID',
  `location` varchar(50) DEFAULT '' COMMENT '用户所在地',
  `description` varchar(150) DEFAULT NULL COMMENT '用户个人描述',
  `url` varchar(255) DEFAULT NULL COMMENT '用户博客地址',
  `profile_image_url` varchar(255) DEFAULT NULL COMMENT '用户头像地址，50×50像素',
  `cover_image` varchar(255) DEFAULT 'NULL' COMMENT '背景图',
  `profile_url` varchar(255) DEFAULT NULL COMMENT '用户的微博统一URL地址',
  `domain` varchar(255) DEFAULT NULL COMMENT '用户的个性化域名',
  `weihao` bigint(10) DEFAULT NULL COMMENT '用户的微号',
  `gender` char(1) DEFAULT NULL COMMENT '性别，m：男、f：女、n：未知',
  `followers_count` int(10) unsigned DEFAULT NULL COMMENT '粉丝数量',
  `friends_count` int(10) unsigned DEFAULT NULL COMMENT '关注数量',
  `statuses_count` int(10) unsigned DEFAULT NULL COMMENT '微博数量',
  `favourites_count` int(10) unsigned DEFAULT NULL COMMENT '收藏数量',
  `created_at` varchar(30) DEFAULT NULL COMMENT '用户创建（注册）时间',
  `following` enum('true','false') DEFAULT 'false' COMMENT '暂未支持',
  `allow_all_act_msg` enum('true','false') DEFAULT NULL COMMENT '是否允许所有人给我发私信，true：是，false：否',
  `geo_enabled` enum('true','false') DEFAULT NULL COMMENT '是否允许标识用户的地理位置，true：是，false：否',
  `verified` enum('true','false') DEFAULT NULL COMMENT '是否是微博认证用户，即加V用户，true：是，false：否',
  `verified_type` char(4) DEFAULT NULL COMMENT '认证类型',
  `remark` varchar(50) DEFAULT NULL COMMENT '用户备注信息，只有在查询用户关系时才返回此字段',
  `status` longtext COMMENT '用户的最近一条微博信息字段 详细',
  `allow_all_comment` enum('true','false') DEFAULT NULL COMMENT '是否允许所有人对我的微博进行评论，true：是，false：否',
  `avatar_large` varchar(255) DEFAULT NULL COMMENT '用户大头像地址',
  `verified_reason` varchar(255) DEFAULT NULL COMMENT '认证原因',
  `follow_me` enum('true','false') DEFAULT NULL COMMENT '该用户是否关注当前登录用户，true：是，false：否',
  `online_status` tinyint(1) DEFAULT NULL COMMENT '用户的在线状态，0：不在线、1：在线',
  `bi_followers_count` int(10) DEFAULT NULL COMMENT '用户的互粉数',
  `lang` varchar(5) DEFAULT NULL COMMENT '用户当前的语言版本，zh-cn：简体中文，zh-tw：繁体中文，en：英语',
  `star` int(10) DEFAULT '0' COMMENT '是否明星',
  `mbtype` int(10) DEFAULT '0' COMMENT '暂无支持',
  `mbrank` int(10) DEFAULT '0' COMMENT '暂无支持',
  `block_word` int(10) DEFAULT '0' COMMENT '暂无支持',
  `is_del` enum('N','Y') DEFAULT 'N' COMMENT '是否删除 Y:删除 N:未删除',
  `creation_date` int(10) NOT NULL,
  `verified_my` tinyint(1) DEFAULT NULL COMMENT '自定义用户类型：1=普通用户，2=达人用户，3=认证名人，4=企业用户',
  `regions` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`sina_uid`),
  KEY `is_del` (`is_del`),
  KEY `creation_date` (`creation_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';

CREATE TABLE `user_map` (
  `sina_uid` bigint(13) unsigned NOT NULL COMMENT '新狼用户ID',
  `ot_uid` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '其他用户ID',
  `type` tinyint(1) DEFAULT NULL COMMENT '类型 1 微博 - 微信',
  `is_del` enum('Y','N') COLLATE utf8_unicode_ci DEFAULT 'N',
  `creation_date` int(11) NOT NULL,
  PRIMARY KEY (`sina_uid`),
  KEY `is_del` (`is_del`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户对应表';


CREATE TABLE IF NOT EXISTS `ajax_weibo_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键自增',
  `weibo_id` varchar(20) DEFAULT NULL COMMENT '微博ID',
  `mid` varchar(20) DEFAULT NULL COMMENT '微博mid',
  `user_id` bigint(13) unsigned NOT NULL COMMENT '用户uid',
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '分享类型',
  `match_id` int(10) DEFAULT NULL COMMENT '特殊id PS答题题目id，投票选项id等',
  `status` longtext COMMENT '博文内容',
  `is_del` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT '是否删除',
  `creation_date` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `is_del` (`is_del`),
  KEY `type` (`type`),
  KEY `creation_date` (`creation_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分享日志表' AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `link_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键自增',
  `user_id` varchar(50) DEFAULT NULL COMMENT '点击的用户ID',
  `link_id` int(10) NOT NULL COMMENT '点击的链接ID（公共配置表ID）',
  `other_id` int(10) NOT NULL DEFAULT 0 COMMENT '备用ID',
  `is_del` enum('N','Y') NOT NULL COMMENT '是否删除',
  `creation_date` int(10) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `is_del` (`is_del`),
  KEY `link_id` (`link_id`),
  KEY `creation_date` (`creation_date`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='展示点击次数表' AUTO_INCREMENT=1;

--
-- 表的结构 `province`
--

CREATE TABLE IF NOT EXISTS `province` (
  `id` int(10) unsigned NOT NULL COMMENT '省份代码',
  `province_name` varchar(10) NOT NULL COMMENT '省份名称',
  `longitude` varchar(10) NOT NULL COMMENT '经度坐标',
  `latitude` varchar(10) NOT NULL COMMENT '纬度坐标',
  `topic_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '话题总数',
  `false_count` int(10) unsigned NOT NULL DEFAULT '0',
  `is_del` enum('N','Y') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N' COMMENT 'Y是已经删除，默认N,未删除',
  `creation_date` int(10) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `is_del` (`is_del`),
  KEY `topic_count` (`topic_count`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='省份列表';

--
-- 转存表中的数据 `wc_user`
--
CREATE TABLE `wc_user` (
  `openid` varchar(50) NOT NULL COMMENT '微信用户openid',
  `nickname` varchar(80) DEFAULT NULL COMMENT '用户昵称',
  `sex` tinyint(1) DEFAULT '0' COMMENT '用户的性别，值为1时是男性，值为2时是女性，值为0时是未知',
  `province` varchar(20) DEFAULT 'NULL' COMMENT '省份',
  `city` varchar(20) DEFAULT 'NULL' COMMENT '城市',
  `country` varchar(50) DEFAULT 'NULL' COMMENT '国家',
  `headimgurl` varchar(255) DEFAULT 'NULL' COMMENT '头像图',
  `language` varchar(15) DEFAULT NULL COMMENT '语言',
  `privilege` text COMMENT '用户特权信息，json 数组，如微信沃卡用户为（chinaunicom）',
  `is_del` enum('N','Y') DEFAULT 'N' COMMENT '是否删除 Y:删除 N:未删除',
  `creation_date` int(11) NOT NULL,
  PRIMARY KEY (`openid`),
  KEY `is_del` (`is_del`),
  KEY `creation_date` (`creation_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';

--
-- 转存表中的数据 `wc_token`
--
CREATE TABLE `wc_token` (
  `openid` varchar(50) NOT NULL COMMENT '微信用户openid',
  `access_token` varchar(255) NOT NULL COMMENT '授权token',
  `refresh_token` varchar(255) NOT NULL COMMENT '授权refresh token',
  `expires_in` bigint(15) NOT NULL COMMENT '过期时间',
  `scope` varchar(32) NOT NULL COMMENT '用户授权的作用域，使用逗号（,）分隔',
  `is_del` enum('N','Y') DEFAULT 'N' COMMENT '是否删除 Y:删除 N:未删除',
  `creation_date` int(11) NOT NULL,
  PRIMARY KEY (`openid`),
  KEY `is_del` (`is_del`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信用户TOKEN表';

--
-- 转存表中的数据 `province`
--

INSERT INTO `province` (`id`, `province_name`, `longitude`, `latitude`, `topic_count`, `false_count`, `is_del`, `creation_date`) VALUES
(11, '北京', '39.902', '116.422', 23, 0, 'N', 1362554903),
(12, '天津', '39.113', '117.197', 4, 0, 'N', 1362554903),
(13, '河北', '38.049', '114.518', 2, 0, 'N', 1362554903),
(14, '山西', '37.876', '112.558', 1, 0, 'N', 1362554903),
(15, '内蒙古', '40.830', '111.703', 0, 0, 'N', 1362554903),
(21, '辽宁', '41.810', '123.439', 6, 0, 'N', 1362554903),
(22, '吉林', '43.862', '125.330', 1, 0, 'N', 1362554903),
(23, '黑龙江', '45.750', '126.649', 2, 0, 'N', 1362554903),
(31, '上海', '31.235', '121.480', 47, 0, 'N', 1362554903),
(32, '江苏', '32.063', '118.804', 11, 0, 'N', 1362554903),
(33, '浙江', '30.277', '120.161', 5, 0, 'N', 1362554903),
(34, '安徽', '31.866', '117.293', 0, 0, 'N', 1362554903),
(35, '福建', '26.079', '119.303', 2, 0, 'N', 1362554903),
(36, '江西', '28.677', '115.927', 2, 0, 'N', 1362554903),
(37, '山东', '36.670', '117.001', 4, 0, 'N', 1362554903),
(41, '河南', '34.752', '113.631', 2, 0, 'N', 1362554903),
(42, '湖北', '30.597', '114.311', 0, 0, 'N', 1362554903),
(43, '湖南', '28.233', '112.946', 0, 0, 'N', 1362554903),
(44, '广东', '23.134', '113.270', 15, 0, 'N', 1362554903),
(45, '广西', '22.820', '108.334', 4, 0, 'N', 1362554903),
(46, '海南', '20.025', '110.341', 1, 0, 'N', 1362554903),
(50, '重庆', '29.570', '106.558', 4, 0, 'N', 1362554903),
(51, '四川', '30.661', '104.071', 5, 0, 'N', 1362554903),
(52, '贵州', '26.602', '106.674', 0, 0, 'N', 1362554903),
(53, '云南', '25.042', '102.711', 1, 0, 'N', 1362554903),
(54, '西藏', '29.657', '91.124', 0, 0, 'N', 1362554903),
(61, '陕西', '34.263', '108.949', 1, 0, 'N', 1362554903),
(62, '甘肃', '36.066', '103.841', 0, 0, 'N', 1362554903),
(63, '青海', '36.621', '101.786', 0, 0, 'N', 1362554903),
(64, '宁夏', '38.492', '106.238', 0, 0, 'N', 1362554903),
(65, '新疆', '43.832', '87.623', 0, 0, 'N', 1362554903),
(71, '台湾', '25.050', '121.517', 0, 0, 'N', 1362554903),
(81, '香港', '22.304', '114.185', 0, 0, 'N', 1362554903),
(82, '澳门', '22.143', '113.568', 0, 0, 'N', 1362554903);