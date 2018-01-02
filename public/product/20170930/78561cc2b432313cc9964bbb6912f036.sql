# Host: 211.159.177.229  (Version: 5.5.56-log)
# Date: 2017-09-29 19:02:44
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "oa_app_sales"
#

DROP TABLE IF EXISTS `oa_app_sales`;
CREATE TABLE `oa_app_sales` (
  `sales_id` int(11) NOT NULL AUTO_INCREMENT,
  `sales_name` varchar(100) DEFAULT NULL COMMENT '日报标题',
  `sales_time` int(11) DEFAULT NULL COMMENT '时间',
  `sales_url` varchar(64) DEFAULT NULL COMMENT '地址',
  `sales_category` tinyint(1) DEFAULT NULL COMMENT '1日报整理 2月报汇总',
  `sales_content` text COMMENT '备注',
  PRIMARY KEY (`sales_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='销售日报';
