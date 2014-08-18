CREATE DATABASE IF NOT EXISTS `hfs_detective`;
use `hfs_detective`

DROP TABLE IF EXISTS `hfs_det_season`;
CREATE TABLE IF NOT EXISTS `hfs_det_season` (
  `id` int(11) unsigned NOT NULL auto_increment COMMENT '唯一id',
  `season` varbinary(128) NOT NULL default '' COMMENT '季名',
  `answer` varbinary(128) NOT NULL default '' COMMENT '答案',
  `starttime` varbinary(128) NOT NULL default '0' COMMENT '该季开始时间',
  `endtime` varbinary(128) NOT NULL default '0' COMMENT '该季结束时间',
  `answer_pub_time` varbinary(128) NOT NULL default '0' COMMENT '答案公布时间',
  `uptime` varbinary(128) NOT NULL default '0' COMMENT '更新时间',
  PRIMARY KEY  (`id`),
  UNIQUE KEY (`season`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='季表';

DROP TABLE IF EXISTS `hfs_det_clue`;
CREATE TABLE IF NOT EXISTS `hfs_det_clue` (
  `id` int(11) unsigned NOT NULL auto_increment COMMENT '唯一id',
  `clue_id` int(11) unsigned NOT NULL default '1' COMMENT '线索id',
  `season_id` varbinary(128) NOT NULL default '' COMMENT '季',
  `clue_type` int(11) NOT NULL default '1' COMMENT '类型：1：图片；2：音频',
  `clue_addr` varbinary(256) NOT NULL default '' COMMENT '线索地址',
  `starttime` varbinary(128) NOT NULL default '0' COMMENT '线索开始时间',
  `uptime` varbinary(128) NOT NULL default '0' COMMENT '更新时间',
  PRIMARY KEY  (`id`),
  UNIQUE KEY (`clue_id`,`season_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='线索表';

DROP TABLE IF EXISTS `hfs_det_winner`;
CREATE TABLE IF NOT EXISTS `hfs_det_winner` (
  `id` int(11) unsigned NOT NULL auto_increment COMMENT '唯一id',
  `name` varbinary(128) NOT NULL default '1' COMMENT '微信昵称',
  `phone` varbinary(128) NOT NULL default '' COMMENT '手机号',
  `win_seasonid` varbinary(128) NOT NULL default '' COMMENT '猜中季',
  `win_time` varbinary(128) NOT NULL default '0' COMMENT '猜中时间',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='猜中用户表';

DROP TABLE IF EXISTS `hfs_det_pubwinner`;
CREATE TABLE IF NOT EXISTS `hfs_det_pubwinner` (
  `id` int(11) unsigned NOT NULL auto_increment COMMENT '唯一id',
  `name` varbinary(128) NOT NULL default '1' COMMENT '微信昵称',
  `phone` varbinary(128) NOT NULL default '' COMMENT '手机号',
  `type` varbinary(128) NOT NULL default '' COMMENT '类型',
  `win_seasonid` varbinary(128) NOT NULL default '' COMMENT '猜中季',
  `win_time` varbinary(128) NOT NULL default '0' COMMENT '猜中时间',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='发布的猜中用户表';