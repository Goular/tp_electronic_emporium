-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-07-29 02:58:25
-- 服务器版本： 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php39`
--

-- --------------------------------------------------------

--
-- 表的结构 `p39_admin`
--

CREATE TABLE `p39_admin` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'Id',
  `username` varchar(30) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员/人员';

--
-- 转存表中的数据 `p39_admin`
--

INSERT INTO `p39_admin` (`id`, `username`, `password`) VALUES
(1, 'root', '96e79218965eb72c92a549dd5a330112'),
(3, 'user1', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- 表的结构 `p39_admin_role`
--

CREATE TABLE `p39_admin_role` (
  `admin_id` mediumint(8) UNSIGNED NOT NULL COMMENT '管理员Id',
  `role_id` mediumint(8) UNSIGNED NOT NULL COMMENT '权限Id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='人员角色';

--
-- 转存表中的数据 `p39_admin_role`
--

INSERT INTO `p39_admin_role` (`admin_id`, `role_id`) VALUES
(3, 3),
(3, 4);

-- --------------------------------------------------------

--
-- 表的结构 `p39_attribute`
--

CREATE TABLE `p39_attribute` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'Id',
  `attr_name` varchar(30) NOT NULL COMMENT '属性名称',
  `attr_type` enum('唯一','可选') NOT NULL COMMENT '属性类型',
  `attr_option_values` varchar(300) NOT NULL DEFAULT '' COMMENT '属性可选值',
  `type_id` mediumint(8) UNSIGNED NOT NULL COMMENT '所属类型Id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='属性表';

--
-- 转存表中的数据 `p39_attribute`
--

INSERT INTO `p39_attribute` (`id`, `attr_name`, `attr_type`, `attr_option_values`, `type_id`) VALUES
(1, '尺码', '可选', 'S,M,X,XL,XXL,XXXL,XXXXL', 3),
(2, '颜色', '可选', '白色,黑色,绿色,蓝色,黄色,红色,紫色,棕色', 3),
(6, '材料', '唯一', '', 3),
(7, '出厂日期', '唯一', '', 3),
(8, '出厂日期', '唯一', '', 4),
(9, '商品毛重', '唯一', '', 4),
(10, '适用人群', '唯一', '', 4),
(11, '功能科技', '唯一', '', 4),
(12, '场合', '唯一', '', 4),
(13, '闭合方式', '唯一', '', 4),
(14, '适合路面', '唯一', '', 4),
(15, '颜色', '可选', '红色,橙色,黄色,绿色,青色,蓝色,紫色', 4),
(16, '尺码', '可选', '36,37,38,39,40,41,42,43,44,45,46', 4);

-- --------------------------------------------------------

--
-- 表的结构 `p39_brand`
--

CREATE TABLE `p39_brand` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'ID',
  `brand_name` varchar(30) NOT NULL COMMENT '品牌名称',
  `site_url` varchar(150) NOT NULL DEFAULT '' COMMENT '官方网站',
  `logo` varchar(150) NOT NULL DEFAULT '' COMMENT '品牌Logo图片'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='品牌';

--
-- 转存表中的数据 `p39_brand`
--

INSERT INTO `p39_brand` (`id`, `brand_name`, `site_url`, `logo`) VALUES
(1, '欧尔登', 'http://www.baidu.com', 'Brand/2017-05-29/592af4e821454.jpg'),
(2, '耐克', 'http://www.qq.com', 'Brand/2017-05-29/592b93e1283bb.jpg'),
(3, '腾讯', 'http://www.ifeng.com', 'Brand/2017-05-29/592b93fa8e1ad.jpg'),
(4, '运动-安踏-1', 'http://www.baidu.com', 'Brand/2017-06-24/594e170dc9c83.jpg'),
(5, '运动-安踏-2', 'http://www.baidu.com', 'Brand/2017-06-24/594e171b6be69.jpg'),
(6, '运动-安踏-3', 'http://www.qq.com', 'Brand/2017-06-24/594e172da5d55.jpg'),
(7, '运动-安踏-4', 'http:/www.baidu.com', 'Brand/2017-06-24/594e174350506.jpg'),
(8, '运动-安踏-5', 'http://www.baidu.com', 'Brand/2017-06-24/594e174f7fb35.jpg'),
(9, '运动-安踏-6', 'http://www.qq.com', 'Brand/2017-06-24/594e17643818d.jpg');

-- --------------------------------------------------------

--
-- 表的结构 `p39_cart`
--

CREATE TABLE `p39_cart` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'Id',
  `goods_id` mediumint(8) UNSIGNED NOT NULL COMMENT '商品ID',
  `goods_attr_id` varchar(150) NOT NULL DEFAULT '' COMMENT '商品属性ID',
  `goods_number` mediumint(8) UNSIGNED NOT NULL COMMENT '购买的数量',
  `member_id` mediumint(8) UNSIGNED NOT NULL COMMENT '会员id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='购物车';

--
-- 转存表中的数据 `p39_cart`
--

INSERT INTO `p39_cart` (`id`, `goods_id`, `goods_attr_id`, `goods_number`, `member_id`) VALUES
(1, 18, '24,36', 2, 2),
(2, 18, '24,34', 3, 2),
(3, 19, '', 2, 2);

-- --------------------------------------------------------

--
-- 表的结构 `p39_category`
--

CREATE TABLE `p39_category` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'Id',
  `cat_name` varchar(30) NOT NULL COMMENT '分类名称',
  `parent_id` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `is_floor` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否推荐楼层'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品分类';

--
-- 转存表中的数据 `p39_category`
--

INSERT INTO `p39_category` (`id`, `cat_name`, `parent_id`, `is_floor`) VALUES
(1, '家用电器', 0, '否'),
(2, '手机、数码、京东通信', 0, '否'),
(3, '电脑、办公', 0, '否'),
(4, '家居、家具、家装、厨具', 0, '否'),
(5, '男装、女装、内衣、珠宝', 0, '否'),
(6, '个护化妆', 0, '否'),
(8, '运动户外', 0, '是'),
(9, '汽车、汽车用品', 0, '否'),
(10, '母婴、玩具乐器', 0, '否'),
(11, '食品、酒类、生鲜、特产', 0, '否'),
(12, '营养保健', 0, '否'),
(13, '图书、音像、电子书', 0, '否'),
(14, '彩票、旅行、充值、票务', 0, '否'),
(16, '大家电', 1, '否'),
(17, '生活电器', 1, '否'),
(18, '厨房电器', 1, '否'),
(19, '个护健康', 1, '否'),
(20, '五金家装', 1, '否'),
(21, 'iphone', 2, '否'),
(22, '冰箱', 16, '否'),
(28, '珠海格力', 1, '否'),
(29, '珠海恒隆', 28, '否'),
(30, 'ABC', 0, '否'),
(31, '运动-推-1', 8, '是'),
(32, '运动-推-2', 8, '是'),
(33, '运动-推-3', 8, '是'),
(34, '运动-推-4', 8, '是'),
(35, '运动-推-5', 8, '是'),
(39, '运动-非-1', 8, '否'),
(40, '运动-非-2', 8, '否'),
(41, '运动-非-3', 8, '否'),
(42, '运动-非-4', 8, '否'),
(43, '户外-非-1', 8, '否'),
(44, '户外-非-2', 8, '否'),
(45, '户外-非-3', 8, '否');

-- --------------------------------------------------------

--
-- 表的结构 `p39_comment`
--

CREATE TABLE `p39_comment` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'Id',
  `goods_id` mediumint(8) UNSIGNED NOT NULL COMMENT '商品ID',
  `member_id` mediumint(8) UNSIGNED NOT NULL COMMENT '用户ID',
  `content` varchar(200) NOT NULL COMMENT '内容',
  `addtime` datetime NOT NULL COMMENT '发表时间',
  `star` tinyint(3) UNSIGNED NOT NULL COMMENT '分值',
  `click_count` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT '有用的数字'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品评论';

--
-- 转存表中的数据 `p39_comment`
--

INSERT INTO `p39_comment` (`id`, `goods_id`, `member_id`, `content`, `addtime`, `star`, `click_count`) VALUES
(1, 18, 2, 'dsfsdfsd', '2017-07-27 15:31:15', 4, 0),
(2, 18, 2, 'gfgsfgsdgdsgd', '2017-07-27 15:32:12', 5, 0),
(3, 18, 2, 'dfgfdsgds', '2017-07-27 15:32:25', 5, 0),
(4, 18, 2, 'dsfdsfsdf', '2017-07-27 15:34:29', 1, 0),
(5, 18, 2, 'NLJLJKJL', '2017-07-27 15:44:07', 4, 0),
(6, 18, 2, 'LKJKLJLKJL', '2017-07-27 15:44:14', 3, 0),
(7, 18, 2, 'HGFSFDGDFGFDSG', '2017-07-27 15:44:26', 5, 0),
(8, 18, 2, '3165156kgkgkhj', '2017-07-27 16:01:53', 5, 0);

-- --------------------------------------------------------

--
-- 表的结构 `p39_comment_reply`
--

CREATE TABLE `p39_comment_reply` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'Id',
  `comment_id` mediumint(8) UNSIGNED NOT NULL COMMENT '评论ID',
  `member_id` mediumint(8) UNSIGNED NOT NULL COMMENT '用户ID',
  `content` varchar(200) NOT NULL COMMENT '内容',
  `addtime` datetime NOT NULL COMMENT '发表时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='评论回复';

--
-- 转存表中的数据 `p39_comment_reply`
--

INSERT INTO `p39_comment_reply` (`id`, `comment_id`, `member_id`, `content`, `addtime`) VALUES
(1, 7, 2, '所发生的方式', '2017-07-27 15:57:20'),
(2, 7, 2, '似懂非懂是规范化4564', '2017-07-27 15:57:30'),
(3, 8, 2, '规划局规划局公积金', '2017-07-27 16:02:08'),
(4, 8, 2, '61456645456', '2017-07-27 16:02:14');

-- --------------------------------------------------------

--
-- 表的结构 `p39_goods`
--

CREATE TABLE `p39_goods` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'Id',
  `goods_name` varchar(150) NOT NULL COMMENT '商品名称',
  `market_price` decimal(10,2) NOT NULL COMMENT '市场价格',
  `shop_price` decimal(10,2) NOT NULL COMMENT '本店价格',
  `goods_desc` longtext COMMENT '商品描述',
  `is_on_sale` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否上架',
  `is_delete` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否放到回收站',
  `addtime` datetime NOT NULL COMMENT '添加时间',
  `logo` varchar(150) NOT NULL DEFAULT '' COMMENT '原图',
  `sm_logo` varchar(150) NOT NULL DEFAULT '' COMMENT '小图',
  `mid_logo` varchar(150) NOT NULL DEFAULT '' COMMENT '中图',
  `big_logo` varchar(150) NOT NULL DEFAULT '' COMMENT '大图',
  `mbig_logo` varchar(150) NOT NULL DEFAULT '' COMMENT '更大图',
  `cat_id` mediumint(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '主分类ID',
  `brand_id` mediumint(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '品牌ID',
  `type_id` mediumint(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '类型ID',
  `promote_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '促销价格',
  `promote_start_date` datetime NOT NULL COMMENT '促销开始时间',
  `promote_end_date` datetime NOT NULL COMMENT '促销结束时间',
  `is_new` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否新品',
  `is_hot` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否热卖',
  `is_best` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否精品',
  `is_floor` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否推荐楼层',
  `sort_num` tinyint(3) UNSIGNED NOT NULL DEFAULT '100' COMMENT '排序的数字',
  `is_updated` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否被修改'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品';

--
-- 转存表中的数据 `p39_goods`
--

INSERT INTO `p39_goods` (`id`, `goods_name`, `market_price`, `shop_price`, `goods_desc`, `is_on_sale`, `is_delete`, `addtime`, `logo`, `sm_logo`, `mid_logo`, `big_logo`, `mbig_logo`, `cat_id`, `brand_id`, `type_id`, `promote_price`, `promote_start_date`, `promote_end_date`, `is_new`, `is_hot`, `is_best`, `is_floor`, `sort_num`, `is_updated`) VALUES
(1, '流行运动鞋', '160.00', '120.00', '<p>创建美图好看</p><p><img src=\"http://www.ee.com/Public/Tools/umeditor1.2.3-utf8-php/php/upload/20170519/14951607082734.jpg\" alt=\"14951607082734.jpg\" /></p>', '是', '否', '2017-05-19 10:25:17', 'Goods/2017-05-19/591e578dc23a5.jpg', 'Goods/2017-05-19/sm_591e578dc23a5.jpg', 'Goods/2017-05-19/mid_591e578dc23a5.jpg', 'Goods/2017-05-19/big_591e578dc23a5.jpg', 'Goods/2017-05-19/mbig_591e578dc23a5.jpg', 1, 1, 0, '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '否', '否', '是', '否', 100, 0),
(2, '运动鞋POP', '361.00', '262.00', '<p><strong><em>创建传你</em></strong></p><p><strong><em><br /></em></strong></p><p><strong><em>是的发生大</em></strong></p><p><strong><em><br /></em></strong></p><p><strong><em><br /></em></strong></p><p><strong><em>太容易太容易</em></strong></p>', '是', '否', '2017-05-19 10:40:50', 'Goods/2017-05-26/5927baebbbe1e.jpg', 'Goods/2017-05-26/thumb_3_5927baebbbe1e.jpg', 'Goods/2017-05-26/thumb_2_5927baebbbe1e.jpg', 'Goods/2017-05-26/thumb_1_5927baebbbe1e.jpg', 'Goods/2017-05-26/thumb_0_5927baebbbe1e.jpg', 0, 2, 0, '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '否', '否', '否', '否', 100, 0),
(5, '韩版潮流运动鞋POI', '899.36', '268.00', '<p><img src=\"http://www.ee.com/Public/Tools/umeditor1.2.3-utf8-php/php/upload/20170526/14957800895316.jpg\" alt=\"14957800895316.jpg\" /></p><p><img src=\"http://www.ee.com/Public/Tools/umeditor1.2.3-utf8-php/php/upload/20170526/1495780092228.jpg\" alt=\"1495780092228.jpg\" /></p><p><img src=\"http://www.ee.com/Public/Tools/umeditor1.2.3-utf8-php/php/upload/20170526/14957801002266.jpg\" alt=\"14957801002266.jpg\" /></p><p>FDSFDSFSDFSDFDSFDSFFDS<br /></p>', '否', '否', '2017-05-26 14:27:26', 'Goods/2017-05-26/5927cacde70ed.jpg', 'Goods/2017-05-26/thumb_3_5927cacde70ed.jpg', 'Goods/2017-05-26/thumb_2_5927cacde70ed.jpg', 'Goods/2017-05-26/thumb_1_5927cacde70ed.jpg', 'Goods/2017-05-26/thumb_0_5927cacde70ed.jpg', 13, 1, 0, '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '是', '否', '否', '否', 100, 0),
(6, '唇膏', '25.01', '16.00', '<p>订单的</p>', '是', '否', '2017-05-30 13:14:47', 'Goods/2017-05-30/592cffc72af5f.jpg', 'Goods/2017-05-30/thumb_3_592cffc72af5f.jpg', 'Goods/2017-05-30/thumb_2_592cffc72af5f.jpg', 'Goods/2017-05-30/thumb_1_592cffc72af5f.jpg', 'Goods/2017-05-30/thumb_0_592cffc72af5f.jpg', 29, 3, 0, '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '否', '否', '否', '否', 100, 0),
(9, 'Nike Air Force 1', '650.00', '500.00', '<p style=\"text-align:left;\">fsdsdfdfsfdsfdsfdfsdfdsfdsfdsfsdfsdfsdfsdfdsfa,</p>', '是', '否', '2017-05-31 16:51:07', 'Goods/2017-05-31/592e83fb368e1.jpg', 'Goods/2017-05-31/thumb_3_592e83fb368e1.jpg', 'Goods/2017-05-31/thumb_2_592e83fb368e1.jpg', 'Goods/2017-05-31/thumb_1_592e83fb368e1.jpg', 'Goods/2017-05-31/thumb_0_592e83fb368e1.jpg', 1, 2, 0, '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '否', '否', '否', '否', 100, 0),
(10, '大幅度', '16.50', '12.00', '<p style=\"text-align:left;\">都是范德萨范德萨</p>', '是', '否', '2017-06-04 11:08:15', 'Goods/2017-06-04/5933799ed6ccd.jpg', 'Goods/2017-06-04/thumb_3_5933799ed6ccd.jpg', 'Goods/2017-06-04/thumb_2_5933799ed6ccd.jpg', 'Goods/2017-06-04/thumb_1_5933799ed6ccd.jpg', 'Goods/2017-06-04/thumb_0_5933799ed6ccd.jpg', 1, 1, 0, '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '否', '否', '否', '否', 100, 0),
(11, 'Nike Air Force 1', '2500.00', '1698.00', '<p style=\"text-align:left;\">渡过难关就能看见彩虹。</p>', '是', '否', '2017-06-05 09:58:48', 'Goods/2017-06-05/5934bad8008dd.jpg', 'Goods/2017-06-05/thumb_3_5934bad8008dd.jpg', 'Goods/2017-06-05/thumb_2_5934bad8008dd.jpg', 'Goods/2017-06-05/thumb_1_5934bad8008dd.jpg', 'Goods/2017-06-05/thumb_0_5934bad8008dd.jpg', 1, 1, 0, '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '否', '否', '否', '否', 100, 0),
(12, 'Nike Air Force 1', '2500.00', '1698.00', '<p style=\"text-align:left;\">渡过难关就能看见彩虹。</p>', '是', '否', '2017-06-05 09:59:53', 'Goods/2017-06-05/5934bb19909d5.jpg', 'Goods/2017-06-05/thumb_3_5934bb19909d5.jpg', 'Goods/2017-06-05/thumb_2_5934bb19909d5.jpg', 'Goods/2017-06-05/thumb_1_5934bb19909d5.jpg', 'Goods/2017-06-05/thumb_0_5934bb19909d5.jpg', 1, 1, 0, '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '否', '否', '否', '否', 100, 0),
(13, 'fdsf', '321321.00', '21312.00', '<p>sdfsd</p>', '是', '否', '2017-06-05 10:01:59', 'Goods/2017-06-05/5934bb9710871.jpg', 'Goods/2017-06-05/thumb_3_5934bb9710871.jpg', 'Goods/2017-06-05/thumb_2_5934bb9710871.jpg', 'Goods/2017-06-05/thumb_1_5934bb9710871.jpg', 'Goods/2017-06-05/thumb_0_5934bb9710871.jpg', 2, 2, 0, '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '否', '是', '否', '否', 100, 0),
(14, '控制', '591.00', '789.00', '<p>水电费的所发生的</p>', '是', '否', '2017-06-05 10:03:20', 'Goods/2017-06-05/5934bbe8494c1.jpg', 'Goods/2017-06-05/thumb_3_5934bbe8494c1.jpg', 'Goods/2017-06-05/thumb_2_5934bbe8494c1.jpg', 'Goods/2017-06-05/thumb_1_5934bbe8494c1.jpg', 'Goods/2017-06-05/thumb_0_5934bbe8494c1.jpg', 1, 1, 0, '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '否', '否', '否', '否', 100, 0),
(15, '控制159', '9877.00', '789.00', '<p>第三方第三方山东师范</p>', '是', '否', '2017-06-05 10:05:05', 'Goods/2017-06-05/5934bc515eaf5.jpg', 'Goods/2017-06-05/thumb_3_5934bc515eaf5.jpg', 'Goods/2017-06-05/thumb_2_5934bc515eaf5.jpg', 'Goods/2017-06-05/thumb_1_5934bc515eaf5.jpg', 'Goods/2017-06-05/thumb_0_5934bc515eaf5.jpg', 1, 1, 0, '1.00', '2017-06-21 00:00:00', '2017-06-30 07:27:00', '否', '是', '否', '否', 100, 0),
(16, 'FSCE123', '1600.00', '1255.00', '<p>创新工场</p>', '是', '否', '2017-06-09 10:15:03', 'Goods/2017-06-09/593a04a7770f7.jpg', 'Goods/2017-06-09/thumb_3_593a04a7770f7.jpg', 'Goods/2017-06-09/thumb_2_593a04a7770f7.jpg', 'Goods/2017-06-09/thumb_1_593a04a7770f7.jpg', 'Goods/2017-06-09/thumb_0_593a04a7770f7.jpg', 1, 1, 3, '80.00', '2017-06-22 14:37:00', '2017-06-23 04:17:00', '是', '是', '是', '否', 100, 0),
(17, 'nike001', '150.00', '120.00', '<p>发鼎折覆餗的范德萨</p>', '是', '否', '2017-06-24 15:43:25', 'Goods/2017-06-24/594e181cdf303.jpg', 'Goods/2017-06-24/thumb_3_594e181cdf303.jpg', 'Goods/2017-06-24/thumb_2_594e181cdf303.jpg', 'Goods/2017-06-24/thumb_1_594e181cdf303.jpg', 'Goods/2017-06-24/thumb_0_594e181cdf303.jpg', 8, 4, 0, '125.00', '2017-06-24 15:42:00', '2017-06-27 10:22:00', '是', '否', '否', '是', 100, 0),
(18, 'Nike-推-2', '1600.00', '1288.35', '<p><img src=\"https://img30.360buyimg.com/popWaterMark/jfs/t5374/289/1105192917/151787/1bf3e341/590bf46bN97fe6300.jpg\" alt=\"590bf46bN97fe6300.jpg\" /></p><p><img src=\"https://img30.360buyimg.com/popWaterMark/jfs/t4570/116/4224386048/127839/d92e207d/590bf46bNb5c580ee.jpg\" alt=\"590bf46bNb5c580ee.jpg\" /><img src=\"https://img30.360buyimg.com/popWaterMark/jfs/t5221/91/1147081908/268406/2425aee1/590c164cNad64d491.jpg\" alt=\"590c164cNad64d491.jpg\" /><img src=\"https://img30.360buyimg.com/popWaterMark/jfs/t5131/79/1165092987/233303/46365b5f/590c164dNe6036cda.jpg\" alt=\"590c164dNe6036cda.jpg\" /></p><p><strong><em><span>欢迎大家选购</span></em></strong></p><p><span><strong><em>左边代码</em></strong></span></p><p><span><strong><em>右边代码</em></strong></span></p>', '是', '否', '2017-06-24 15:51:34', 'Goods/2017-06-24/594e1ba5b1e99.jpg', 'Goods/2017-06-24/thumb_3_594e1ba5b1e99.jpg', 'Goods/2017-06-24/thumb_2_594e1ba5b1e99.jpg', 'Goods/2017-06-24/thumb_1_594e1ba5b1e99.jpg', 'Goods/2017-06-24/thumb_0_594e1ba5b1e99.jpg', 8, 5, 4, '80.00', '2017-07-02 07:00:00', '2017-07-03 00:00:00', '是', '是', '是', '是', 100, 0),
(19, 'Nike-V-102', '160.00', '150.05', '<p>FDSFDSFSDFSDFSFSDFSDFSFSDFSDFSDFSDFSFSD</p>', '是', '否', '2017-06-24 15:56:34', 'Goods/2017-06-24/594e1b9d59450.jpg', 'Goods/2017-06-24/thumb_3_594e1b9d59450.jpg', 'Goods/2017-06-24/thumb_2_594e1b9d59450.jpg', 'Goods/2017-06-24/thumb_1_594e1b9d59450.jpg', 'Goods/2017-06-24/thumb_0_594e1b9d59450.jpg', 33, 6, 4, '80.00', '2017-07-05 00:00:00', '2017-06-30 00:00:00', '是', '是', '是', '是', 101, 0),
(20, 'Nike-p-o-103', '1600.00', '1200.00', '', '是', '否', '2017-06-24 15:57:56', 'Goods/2017-06-24/594e1b949f58a.jpg', 'Goods/2017-06-24/thumb_3_594e1b949f58a.jpg', 'Goods/2017-06-24/thumb_2_594e1b949f58a.jpg', 'Goods/2017-06-24/thumb_1_594e1b949f58a.jpg', 'Goods/2017-06-24/thumb_0_594e1b949f58a.jpg', 8, 7, 0, '80.00', '2017-06-12 00:00:00', '2017-06-14 00:00:00', '否', '否', '是', '是', 109, 0),
(21, 'Nike-UY-98', '3500.00', '1200.00', '', '是', '否', '2017-06-24 15:59:25', 'Goods/2017-06-24/594e1bf6c7a76.jpg', 'Goods/2017-06-24/thumb_3_594e1bf6c7a76.jpg', 'Goods/2017-06-24/thumb_2_594e1bf6c7a76.jpg', 'Goods/2017-06-24/thumb_1_594e1bf6c7a76.jpg', 'Goods/2017-06-24/thumb_0_594e1bf6c7a76.jpg', 8, 8, 0, '79.00', '2017-06-23 00:00:00', '2017-06-29 00:00:00', '否', '否', '是', '是', 108, 0),
(22, '安踏27849', '1600.00', '1200.00', '<p>发士大夫撒地方的是</p>', '是', '否', '2017-07-24 11:58:35', 'Goods/2017-07-24/5975706ad133a.jpg', 'Goods/2017-07-24/thumb_3_5975706ad133a.jpg', 'Goods/2017-07-24/thumb_2_5975706ad133a.jpg', 'Goods/2017-07-24/thumb_1_5975706ad133a.jpg', 'Goods/2017-07-24/thumb_0_5975706ad133a.jpg', 8, 4, 3, '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '是', '否', '是', '否', 100, 0),
(23, '创建8778', '258.25', '1230.00', '', '是', '否', '2017-07-25 16:27:56', 'Goods/2017-07-25/5977010bc1276.jpg', 'Goods/2017-07-25/thumb_3_5977010bc1276.jpg', 'Goods/2017-07-25/thumb_2_5977010bc1276.jpg', 'Goods/2017-07-25/thumb_1_5977010bc1276.jpg', 'Goods/2017-07-25/thumb_0_5977010bc1276.jpg', 1, 1, 0, '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '否', '否', '否', '是', 100, 0),
(24, '海尔冰箱', '4555.00', '4554.00', '', '是', '否', '2017-07-28 11:19:03', '', '', '', '', '', 1, 1, 0, '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '否', '否', '否', '否', 100, 1),
(25, '索爱冰箱', '1200.00', '1326.00', '', '是', '否', '2017-07-28 13:18:14', '', '', '', '', '', 1, 1, 0, '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '否', '否', '否', '否', 100, 1),
(26, '东芝冰箱', '2600.00', '1230.00', '', '是', '否', '2017-07-28 13:20:32', '', '', '', '', '', 1, 2, 0, '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '否', '否', '否', '否', 100, 0);

-- --------------------------------------------------------

--
-- 表的结构 `p39_goods_attr`
--

CREATE TABLE `p39_goods_attr` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'Id',
  `attr_value` varchar(150) NOT NULL DEFAULT '' COMMENT '属性值',
  `attr_id` mediumint(8) UNSIGNED NOT NULL COMMENT '属性Id',
  `goods_id` mediumint(8) UNSIGNED NOT NULL COMMENT '商品Id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品属性';

--
-- 转存表中的数据 `p39_goods_attr`
--

INSERT INTO `p39_goods_attr` (`id`, `attr_value`, `attr_id`, `goods_id`) VALUES
(1, 'S', 1, 16),
(2, 'XXXXL', 1, 16),
(3, 'M', 1, 16),
(4, 'X', 1, 16),
(5, 'XL', 1, 16),
(6, 'XXL', 1, 16),
(7, 'XXXL', 1, 16),
(8, 'XXXXL', 1, 16),
(9, '黑色', 2, 16),
(10, '棕色', 2, 16),
(11, '黄色', 2, 16),
(12, '蓝色', 2, 16),
(13, '红色', 2, 16),
(14, '紫色', 2, 16),
(15, '纯棉', 6, 16),
(16, '2016-12-29', 7, 16),
(17, '2017-07-01', 8, 18),
(18, '255g', 9, 18),
(19, '男士', 10, 18),
(20, '中掌Air', 11, 18),
(21, '任意', 12, 18),
(22, '系带', 13, 18),
(23, '跑道', 14, 18),
(24, '红色', 15, 18),
(25, '橙色', 15, 18),
(26, '黄色', 15, 18),
(27, '绿色', 15, 18),
(28, '青色', 15, 18),
(29, '蓝色', 15, 18),
(30, '紫色', 15, 18),
(31, '36', 16, 18),
(32, '37', 16, 18),
(33, '38', 16, 18),
(34, '39', 16, 18),
(35, '40', 16, 18),
(36, '41', 16, 18),
(37, '42', 16, 18),
(38, '43', 16, 18),
(39, '44', 16, 18),
(40, '45', 16, 18),
(41, '46', 16, 18),
(42, 'M', 1, 22),
(43, '蓝色', 2, 22),
(44, '4666', 6, 22),
(45, '2017-07-01', 7, 22);

-- --------------------------------------------------------

--
-- 表的结构 `p39_goods_cat`
--

CREATE TABLE `p39_goods_cat` (
  `cat_id` mediumint(8) UNSIGNED NOT NULL COMMENT '分类Id',
  `goods_id` mediumint(8) UNSIGNED NOT NULL COMMENT '商品Id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品拓展分类';

--
-- 转存表中的数据 `p39_goods_cat`
--

INSERT INTO `p39_goods_cat` (`cat_id`, `goods_id`) VALUES
(16, 15),
(18, 15),
(16, 16),
(19, 16),
(31, 17),
(34, 21),
(34, 20),
(32, 18),
(33, 19),
(32, 22),
(17, 14),
(21, 13),
(17, 23),
(22, 26),
(16, 25);

-- --------------------------------------------------------

--
-- 表的结构 `p39_goods_number`
--

CREATE TABLE `p39_goods_number` (
  `goods_id` mediumint(8) UNSIGNED NOT NULL COMMENT '商品Id',
  `goods_number` mediumint(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '库存量',
  `goods_attr_id` varchar(150) NOT NULL COMMENT '商品属性表的ID,如果有多个，就用程序拼成字符串存到这个字段中'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='库存量';

--
-- 转存表中的数据 `p39_goods_number`
--

INSERT INTO `p39_goods_number` (`goods_id`, `goods_number`, `goods_attr_id`) VALUES
(18, 200, '24,31'),
(18, 210, '24,32'),
(18, 220, '24,33'),
(18, 167, '24,34'),
(18, 240, '24,35'),
(18, 208, '24,36'),
(18, 251, '24,37'),
(18, 258, '25,37'),
(18, 280, '26,37'),
(18, 290, '27,39'),
(18, 300, '28,40'),
(18, 310, '29,41'),
(18, 320, '30,35'),
(18, 330, '29,37'),
(18, 340, '27,37'),
(18, 350, '28,38'),
(18, 360, '26,37'),
(18, 358, '25,37'),
(18, 380, '29,38'),
(18, 378, '25,37'),
(18, 400, '26,38'),
(19, 945, '');

-- --------------------------------------------------------

--
-- 表的结构 `p39_goods_pic`
--

CREATE TABLE `p39_goods_pic` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'Id',
  `pic` varchar(150) NOT NULL COMMENT '原图',
  `sm_pic` varchar(150) NOT NULL COMMENT '小图',
  `mid_pic` varchar(150) NOT NULL COMMENT '中图',
  `big_pic` varchar(150) NOT NULL COMMENT '大图',
  `goods_id` mediumint(8) UNSIGNED NOT NULL COMMENT '商品Id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品相册';

--
-- 转存表中的数据 `p39_goods_pic`
--

INSERT INTO `p39_goods_pic` (`id`, `pic`, `sm_pic`, `mid_pic`, `big_pic`, `goods_id`) VALUES
(1, 'Goods/2017-06-04/5933799fbd3b2.jpg', 'Goods/2017-06-04/thumb_2_5933799fbd3b2.jpg', 'Goods/2017-06-04/thumb_1_5933799fbd3b2.jpg', 'Goods/2017-06-04/thumb_0_5933799fbd3b2.jpg', 10),
(2, 'Goods/2017-06-04/5933799fdf3c9.jpg', 'Goods/2017-06-04/thumb_2_5933799fdf3c9.jpg', 'Goods/2017-06-04/thumb_1_5933799fdf3c9.jpg', 'Goods/2017-06-04/thumb_0_5933799fdf3c9.jpg', 10),
(3, 'Goods/2017-06-04/593379a0075a0.jpg', 'Goods/2017-06-04/thumb_2_593379a0075a0.jpg', 'Goods/2017-06-04/thumb_1_593379a0075a0.jpg', 'Goods/2017-06-04/thumb_0_593379a0075a0.jpg', 10),
(4, 'Goods/2017-06-05/5934bad8b52fb.jpg', 'Goods/2017-06-05/thumb_2_5934bad8b52fb.jpg', 'Goods/2017-06-05/thumb_1_5934bad8b52fb.jpg', 'Goods/2017-06-05/thumb_0_5934bad8b52fb.jpg', 11),
(5, 'Goods/2017-06-05/5934bad8d53ec.jpg', 'Goods/2017-06-05/thumb_2_5934bad8d53ec.jpg', 'Goods/2017-06-05/thumb_1_5934bad8d53ec.jpg', 'Goods/2017-06-05/thumb_0_5934bad8d53ec.jpg', 11),
(6, 'Goods/2017-06-05/5934bad8f1458.jpg', 'Goods/2017-06-05/thumb_2_5934bad8f1458.jpg', 'Goods/2017-06-05/thumb_1_5934bad8f1458.jpg', 'Goods/2017-06-05/thumb_0_5934bad8f1458.jpg', 11),
(7, 'Goods/2017-06-05/5934bad91bf02.jpg', 'Goods/2017-06-05/thumb_2_5934bad91bf02.jpg', 'Goods/2017-06-05/thumb_1_5934bad91bf02.jpg', 'Goods/2017-06-05/thumb_0_5934bad91bf02.jpg', 11),
(8, 'Goods/2017-06-05/5934bb19eb2e4.jpg', 'Goods/2017-06-05/thumb_2_5934bb19eb2e4.jpg', 'Goods/2017-06-05/thumb_1_5934bb19eb2e4.jpg', 'Goods/2017-06-05/thumb_0_5934bb19eb2e4.jpg', 12),
(9, 'Goods/2017-06-05/5934bb1a142b2.jpg', 'Goods/2017-06-05/thumb_2_5934bb1a142b2.jpg', 'Goods/2017-06-05/thumb_1_5934bb1a142b2.jpg', 'Goods/2017-06-05/thumb_0_5934bb1a142b2.jpg', 12),
(10, 'Goods/2017-06-05/5934bb1a2ed44.jpg', 'Goods/2017-06-05/thumb_2_5934bb1a2ed44.jpg', 'Goods/2017-06-05/thumb_1_5934bb1a2ed44.jpg', 'Goods/2017-06-05/thumb_0_5934bb1a2ed44.jpg', 12),
(19, 'Goods/2017-07-03/5959de00e3c23.jpg', 'Goods/2017-07-03/thumb_2_5959de00e3c23.jpg', 'Goods/2017-07-03/thumb_1_5959de00e3c23.jpg', 'Goods/2017-07-03/thumb_0_5959de00e3c23.jpg', 18),
(20, 'Goods/2017-07-03/5959de0125a2e.jpg', 'Goods/2017-07-03/thumb_2_5959de0125a2e.jpg', 'Goods/2017-07-03/thumb_1_5959de0125a2e.jpg', 'Goods/2017-07-03/thumb_0_5959de0125a2e.jpg', 18),
(21, 'Goods/2017-07-03/5959de014691c.jpg', 'Goods/2017-07-03/thumb_2_5959de014691c.jpg', 'Goods/2017-07-03/thumb_1_5959de014691c.jpg', 'Goods/2017-07-03/thumb_0_5959de014691c.jpg', 18),
(22, 'Goods/2017-07-03/5959de0163ac5.jpg', 'Goods/2017-07-03/thumb_2_5959de0163ac5.jpg', 'Goods/2017-07-03/thumb_1_5959de0163ac5.jpg', 'Goods/2017-07-03/thumb_0_5959de0163ac5.jpg', 18),
(23, 'Goods/2017-07-03/5959de01859bd.jpg', 'Goods/2017-07-03/thumb_2_5959de01859bd.jpg', 'Goods/2017-07-03/thumb_1_5959de01859bd.jpg', 'Goods/2017-07-03/thumb_0_5959de01859bd.jpg', 18),
(24, 'Goods/2017-07-05/595cb195b267d.jpg', 'Goods/2017-07-05/thumb_2_595cb195b267d.jpg', 'Goods/2017-07-05/thumb_1_595cb195b267d.jpg', 'Goods/2017-07-05/thumb_0_595cb195b267d.jpg', 19),
(25, 'Goods/2017-07-05/595cb195e0832.jpg', 'Goods/2017-07-05/thumb_2_595cb195e0832.jpg', 'Goods/2017-07-05/thumb_1_595cb195e0832.jpg', 'Goods/2017-07-05/thumb_0_595cb195e0832.jpg', 19),
(26, 'Goods/2017-07-24/5975706ba5e6e.jpg', 'Goods/2017-07-24/thumb_2_5975706ba5e6e.jpg', 'Goods/2017-07-24/thumb_1_5975706ba5e6e.jpg', 'Goods/2017-07-24/thumb_0_5975706ba5e6e.jpg', 22),
(27, 'Goods/2017-07-24/5975706bc51d3.jpg', 'Goods/2017-07-24/thumb_2_5975706bc51d3.jpg', 'Goods/2017-07-24/thumb_1_5975706bc51d3.jpg', 'Goods/2017-07-24/thumb_0_5975706bc51d3.jpg', 22);

-- --------------------------------------------------------

--
-- 表的结构 `p39_member`
--

CREATE TABLE `p39_member` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'Id',
  `username` varchar(30) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  `face` varchar(150) NOT NULL DEFAULT '' COMMENT '头像',
  `jifen` mediumint(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '积分'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员';

--
-- 转存表中的数据 `p39_member`
--

INSERT INTO `p39_member` (`id`, `username`, `password`, `face`, `jifen`) VALUES
(2, 'goular', '96e79218965eb72c92a549dd5a330112', '', 7500);

-- --------------------------------------------------------

--
-- 表的结构 `p39_member_address`
--

CREATE TABLE `p39_member_address` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'Id',
  `receiver` varchar(20) NOT NULL DEFAULT '' COMMENT '收货人名称',
  `province` varchar(20) NOT NULL DEFAULT '' COMMENT '省份ID',
  `city` varchar(20) NOT NULL DEFAULT '' COMMENT '城市ID',
  `district` varchar(20) NOT NULL DEFAULT '' COMMENT '城区ID',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '手机号码',
  `detail` varchar(120) NOT NULL DEFAULT '' COMMENT '详细地址',
  `is_default` enum('是','否') DEFAULT '否' COMMENT '默认地址'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='收货地址列表';

--
-- 转存表中的数据 `p39_member_address`
--

INSERT INTO `p39_member_address` (`id`, `receiver`, `province`, `city`, `district`, `mobile`, `detail`, `is_default`) VALUES
(2, '陈导', '上海', '西城区', '西三旗', '123895', '骨水泥股骨1685', '是'),
(3, '陈导', '上海', '西城区', '西三旗', '123895', '骨水泥股骨1685', '是'),
(4, '地方', '北京', '朝阳区', '西二旗', '132', '的是非得失', '是'),
(5, '地方', '北京', '朝阳区', '西二旗', '132', '', '是'),
(6, '', '北京', '朝阳区', '西二旗', '', '', '是'),
(7, '', '北京', '朝阳区', '西三旗', '2322323', 'sdfds', '是'),
(8, '', '北京', '朝阳区', '西三旗', '324', 'dfds', '是'),
(9, '', '北京', '朝阳区', '西三旗', '324', 'dfds', '是'),
(10, '', '北京', '朝阳区', '西三旗', '324', 'dfds', '是'),
(11, '发送到', '北京', '东城区', '西二旗', '31234', '地方第三方士大夫规范化', '是'),
(12, '发送到233', '北京', '东城区', '西二旗', '5585558', '1dsf', '是'),
(13, '发送到2337888', '上海', '西城区', '西三旗', '235455', '二维热若', '是'),
(14, '发送到2337888', '上海', '西城区', '西三旗', '235455', '二维热若', '是');

-- --------------------------------------------------------

--
-- 表的结构 `p39_member_level`
--

CREATE TABLE `p39_member_level` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'ID',
  `level_name` varchar(30) NOT NULL COMMENT '级别名称',
  `jifen_bottom` mediumint(8) UNSIGNED NOT NULL COMMENT '积分下限',
  `jifen_top` mediumint(8) UNSIGNED NOT NULL COMMENT '积分上限'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员级别';

--
-- 转存表中的数据 `p39_member_level`
--

INSERT INTO `p39_member_level` (`id`, `level_name`, `jifen_bottom`, `jifen_top`) VALUES
(1, '注册会员', 0, 5000),
(2, '初级会员', 5001, 10000),
(3, '高级会员', 10001, 20000),
(4, 'VIP', 20001, 16777215);

-- --------------------------------------------------------

--
-- 表的结构 `p39_member_price`
--

CREATE TABLE `p39_member_price` (
  `price` decimal(10,2) NOT NULL COMMENT '会员价格',
  `level_id` mediumint(8) UNSIGNED NOT NULL COMMENT '级别ID',
  `goods_id` mediumint(8) UNSIGNED NOT NULL COMMENT '商品ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员-级别中间表';

--
-- 转存表中的数据 `p39_member_price`
--

INSERT INTO `p39_member_price` (`price`, `level_id`, `goods_id`) VALUES
('12.00', 1, 9),
('13.00', 2, 9),
('14.00', 3, 9),
('15.00', 4, 9),
('12.00', 1, 9),
('13.00', 2, 9),
('14.00', 3, 9),
('15.00', 4, 9),
('16.00', 1, 6),
('15.23', 2, 6),
('14.00', 3, 6),
('13.12', 4, 6),
('16.00', 1, 6),
('15.23', 2, 6),
('14.00', 3, 6),
('13.12', 4, 6),
('12.00', 1, 10),
('16.00', 2, 10),
('17.00', 3, 10),
('18.00', 4, 10),
('192.00', 1, 11),
('187.00', 2, 11),
('182.00', 3, 11),
('77.00', 4, 11),
('192.00', 1, 12),
('187.00', 2, 12),
('182.00', 3, 12),
('77.00', 4, 12),
('159.00', 1, 15),
('1785.00', 2, 15),
('1987.00', 3, 15),
('2500.00', 4, 15),
('159.00', 1, 15),
('1785.00', 2, 15),
('1987.00', 3, 15),
('2500.00', 4, 15),
('650.00', 1, 16),
('664.00', 2, 16),
('690.00', 3, 16),
('580.00', 4, 16),
('650.00', 1, 16),
('664.00', 2, 16),
('690.00', 3, 16),
('580.00', 4, 16),
('120.00', 1, 17),
('121.00', 2, 17),
('122.00', 3, 17),
('123.00', 4, 17),
('120.00', 1, 17),
('121.00', 2, 17),
('122.00', 3, 17),
('123.00', 4, 17),
('400.50', 1, 18),
('300.40', 2, 18),
('250.50', 3, 18),
('225.50', 4, 18),
('400.50', 1, 18),
('300.40', 2, 18),
('250.50', 3, 18),
('225.50', 4, 18),
('160.33', 1, 19),
('150.44', 2, 19),
('140.55', 3, 19),
('125.66', 4, 19),
('160.33', 1, 19),
('150.44', 2, 19),
('140.55', 3, 19),
('125.66', 4, 19),
('360.00', 1, 22),
('320.00', 2, 22),
('280.00', 3, 22),
('240.00', 4, 22),
('2332.00', 1, 14),
('2332.00', 2, 14),
('2334.00', 3, 14),
('43434.00', 4, 14),
('2332.00', 1, 14),
('2332.00', 2, 14),
('2334.00', 3, 14),
('43434.00', 4, 14),
('23.00', 1, 13),
('23.00', 2, 13),
('4564.00', 3, 13),
('23.00', 1, 13),
('23.00', 2, 13),
('4564.00', 3, 13);

-- --------------------------------------------------------

--
-- 表的结构 `p39_order`
--

CREATE TABLE `p39_order` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'Id',
  `member_id` mediumint(8) UNSIGNED NOT NULL COMMENT '会员ID',
  `addtime` int(10) UNSIGNED NOT NULL COMMENT '下单时间',
  `pay_status` enum('是','否') NOT NULL DEFAULT '否' COMMENT '支付状态',
  `pay_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '支付时间',
  `total_price` decimal(10,2) NOT NULL COMMENT '订单价格',
  `shr_name` varchar(30) NOT NULL COMMENT '收货人姓名',
  `shr_tel` varchar(30) NOT NULL COMMENT '收货人电话',
  `shr_province` varchar(30) NOT NULL COMMENT '收货人省份',
  `shr_city` varchar(30) NOT NULL COMMENT '收货人城市',
  `shr_area` varchar(30) NOT NULL COMMENT '收货人地区',
  `shr_address` varchar(30) NOT NULL COMMENT '收货人地址',
  `post_status` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '发货状态,0:未发货，1:已发货,2：已收到货',
  `post_number` varchar(30) NOT NULL DEFAULT '' COMMENT '快递号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单';

--
-- 转存表中的数据 `p39_order`
--

INSERT INTO `p39_order` (`id`, `member_id`, `addtime`, `pay_status`, `pay_time`, `total_price`, `shr_name`, `shr_tel`, `shr_province`, `shr_city`, `shr_area`, `shr_address`, `post_status`, `post_number`) VALUES
(1, 2, 1499765383, '否', 0, '2704.56', '春申君', '13111111111', '北京', '朝阳区', '西三旗', '水电费第三方', 0, ''),
(2, 2, 1499767068, '否', 0, '2704.56', '春申君', '13111111111', '北京', '朝阳区', '西三旗', '水电费第三方', 0, ''),
(3, 2, 1499767236, '否', 0, '2704.56', '春申君', '13111111111', '北京', '朝阳区', '西三旗', '水电费第三方', 0, ''),
(4, 2, 1499828572, '是', 0, '1802.88', '辛弃疾', '13178954215', '上海', '东城区', '西二旗', '自来水厂226号', 0, ''),
(5, 2, 1499828816, '否', 0, '1802.88', '辛弃疾', '13178954215', '上海', '东城区', '西二旗', '自来水厂226号', 0, ''),
(6, 2, 1499828817, '否', 0, '1802.88', '辛弃疾', '13178954215', '上海', '东城区', '西二旗', '自来水厂226号', 0, ''),
(7, 2, 1499828817, '否', 0, '1802.88', '辛弃疾', '13178954215', '上海', '东城区', '西二旗', '自来水厂226号', 0, ''),
(8, 2, 1499828817, '否', 0, '1802.88', '辛弃疾', '13178954215', '上海', '东城区', '西二旗', '自来水厂226号', 0, ''),
(9, 2, 1499828817, '否', 0, '1802.88', '辛弃疾', '13178954215', '上海', '东城区', '西二旗', '自来水厂226号', 0, ''),
(10, 2, 1499828817, '否', 0, '1802.88', '辛弃疾', '13178954215', '上海', '东城区', '西二旗', '自来水厂226号', 0, ''),
(11, 2, 1499828817, '否', 0, '1802.88', '辛弃疾', '13178954215', '上海', '东城区', '西二旗', '自来水厂226号', 0, ''),
(12, 2, 1499828817, '否', 0, '1802.88', '辛弃疾', '13178954215', '上海', '东城区', '西二旗', '自来水厂226号', 0, ''),
(13, 2, 1499828817, '否', 0, '1802.88', '辛弃疾', '13178954215', '上海', '东城区', '西二旗', '自来水厂226号', 0, ''),
(14, 2, 1499828818, '否', 0, '1802.88', '辛弃疾', '13178954215', '上海', '东城区', '西二旗', '自来水厂226号', 0, ''),
(15, 2, 1499828818, '否', 0, '1802.88', '辛弃疾', '13178954215', '上海', '东城区', '西二旗', '自来水厂226号', 0, ''),
(16, 2, 1499828818, '否', 0, '1802.88', '辛弃疾', '13178954215', '上海', '东城区', '西二旗', '自来水厂226号', 0, ''),
(17, 2, 1499828818, '否', 0, '1802.88', '辛弃疾', '13178954215', '上海', '东城区', '西二旗', '自来水厂226号', 0, ''),
(18, 2, 1499828818, '否', 0, '1802.88', '辛弃疾', '13178954215', '上海', '东城区', '西二旗', '自来水厂226号', 0, ''),
(19, 2, 1499828818, '否', 0, '1802.88', '辛弃疾', '13178954215', '上海', '东城区', '西二旗', '自来水厂226号', 0, ''),
(20, 2, 1499828818, '否', 0, '1802.88', '辛弃疾', '13178954215', '上海', '东城区', '西二旗', '自来水厂226号', 0, ''),
(21, 2, 1499828818, '否', 0, '1802.88', '辛弃疾', '13178954215', '上海', '东城区', '西二旗', '自来水厂226号', 0, ''),
(22, 2, 1499828818, '否', 0, '1802.88', '辛弃疾', '13178954215', '上海', '东城区', '西二旗', '自来水厂226号', 0, ''),
(23, 2, 1499828819, '否', 0, '1802.88', '辛弃疾', '13178954215', '上海', '东城区', '西二旗', '自来水厂226号', 0, ''),
(24, 2, 1499828819, '否', 0, '1802.88', '辛弃疾', '13178954215', '上海', '东城区', '西二旗', '自来水厂226号', 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `p39_order_goods`
--

CREATE TABLE `p39_order_goods` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'Id',
  `order_id` mediumint(8) UNSIGNED NOT NULL COMMENT '订单ID',
  `goods_id` mediumint(8) UNSIGNED NOT NULL COMMENT '商品ID',
  `goods_attr_id` varchar(150) NOT NULL DEFAULT '' COMMENT '属性ID',
  `goods_number` tinyint(3) UNSIGNED NOT NULL COMMENT '购买数量',
  `price` decimal(10,2) NOT NULL COMMENT '商品单价'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单商品';

--
-- 转存表中的数据 `p39_order_goods`
--

INSERT INTO `p39_order_goods` (`id`, `order_id`, `goods_id`, `goods_attr_id`, `goods_number`, `price`) VALUES
(1, 1, 18, '24,37', 3, '300.40'),
(2, 1, 19, '', 4, '150.44'),
(3, 1, 18, '25,37', 4, '300.40'),
(4, 2, 18, '24,37', 3, '300.40'),
(5, 2, 19, '', 4, '150.44'),
(6, 2, 18, '25,37', 4, '300.40'),
(7, 3, 18, '24,37', 3, '300.40'),
(8, 3, 19, '', 4, '150.44'),
(9, 3, 18, '25,37', 4, '300.40'),
(10, 4, 18, '24,36', 2, '300.40'),
(11, 4, 18, '24,34', 3, '300.40'),
(12, 4, 19, '', 2, '150.44'),
(13, 5, 18, '24,36', 2, '300.40'),
(14, 5, 18, '24,34', 3, '300.40'),
(15, 5, 19, '', 2, '150.44'),
(16, 6, 18, '24,36', 2, '300.40'),
(17, 6, 18, '24,34', 3, '300.40'),
(18, 6, 19, '', 2, '150.44'),
(19, 7, 18, '24,36', 2, '300.40'),
(20, 7, 18, '24,34', 3, '300.40'),
(21, 7, 19, '', 2, '150.44'),
(22, 8, 18, '24,36', 2, '300.40'),
(23, 8, 18, '24,34', 3, '300.40'),
(24, 8, 19, '', 2, '150.44'),
(25, 9, 18, '24,36', 2, '300.40'),
(26, 9, 18, '24,34', 3, '300.40'),
(27, 9, 19, '', 2, '150.44'),
(28, 10, 18, '24,36', 2, '300.40'),
(29, 10, 18, '24,34', 3, '300.40'),
(30, 10, 19, '', 2, '150.44'),
(31, 11, 18, '24,36', 2, '300.40'),
(32, 11, 18, '24,34', 3, '300.40'),
(33, 11, 19, '', 2, '150.44'),
(34, 12, 18, '24,36', 2, '300.40'),
(35, 12, 18, '24,34', 3, '300.40'),
(36, 12, 19, '', 2, '150.44'),
(37, 13, 18, '24,36', 2, '300.40'),
(38, 13, 18, '24,34', 3, '300.40'),
(39, 13, 19, '', 2, '150.44'),
(40, 14, 18, '24,36', 2, '300.40'),
(41, 14, 18, '24,34', 3, '300.40'),
(42, 14, 19, '', 2, '150.44'),
(43, 15, 18, '24,36', 2, '300.40'),
(44, 15, 18, '24,34', 3, '300.40'),
(45, 15, 19, '', 2, '150.44'),
(46, 16, 18, '24,36', 2, '300.40'),
(47, 16, 18, '24,34', 3, '300.40'),
(48, 16, 19, '', 2, '150.44'),
(49, 17, 18, '24,36', 2, '300.40'),
(50, 17, 18, '24,34', 3, '300.40'),
(51, 17, 19, '', 2, '150.44'),
(52, 18, 18, '24,36', 2, '300.40'),
(53, 18, 18, '24,34', 3, '300.40'),
(54, 18, 19, '', 2, '150.44'),
(55, 19, 18, '24,36', 2, '300.40'),
(56, 19, 18, '24,34', 3, '300.40'),
(57, 19, 19, '', 2, '150.44'),
(58, 20, 18, '24,36', 2, '300.40'),
(59, 20, 18, '24,34', 3, '300.40'),
(60, 20, 19, '', 2, '150.44'),
(61, 21, 18, '24,36', 2, '300.40'),
(62, 21, 18, '24,34', 3, '300.40'),
(63, 21, 19, '', 2, '150.44'),
(64, 22, 18, '24,36', 2, '300.40'),
(65, 22, 18, '24,34', 3, '300.40'),
(66, 22, 19, '', 2, '150.44'),
(67, 23, 18, '24,36', 2, '300.40'),
(68, 23, 18, '24,34', 3, '300.40'),
(69, 23, 19, '', 2, '150.44'),
(70, 24, 18, '24,36', 2, '300.40'),
(71, 24, 18, '24,34', 3, '300.40'),
(72, 24, 19, '', 2, '150.44');

-- --------------------------------------------------------

--
-- 表的结构 `p39_privilege`
--

CREATE TABLE `p39_privilege` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'Id',
  `pri_name` varchar(30) NOT NULL DEFAULT '' COMMENT '权限名称',
  `module_name` varchar(30) NOT NULL DEFAULT '' COMMENT '模块名称',
  `controller_name` varchar(30) NOT NULL DEFAULT '' COMMENT '控制器名称',
  `action_name` varchar(30) NOT NULL DEFAULT '' COMMENT '方法名称',
  `parent_id` mediumint(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '上级权限Id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限';

--
-- 转存表中的数据 `p39_privilege`
--

INSERT INTO `p39_privilege` (`id`, `pri_name`, `module_name`, `controller_name`, `action_name`, `parent_id`) VALUES
(1, '商品模块', '', '', '', 0),
(2, '权限模块', '', '', '', 0),
(3, '会员模块', '', '', '', 0),
(4, '商品管理', 'Admin', 'Goods', 'lst', 1),
(5, '品牌管理', 'Admin', 'Brand', 'lst', 1),
(6, '分类管理', 'Admin', 'Category', 'lst', 1),
(7, '类型管理', 'Admin', 'Type', 'lst', 1),
(8, '权限管理', 'Admin', 'Privilege', 'lst', 2),
(9, '角色管理', 'Admin', 'Role', 'lst', 2),
(10, '管理员管理', 'Admin', 'Admin', 'lst', 2),
(11, '级别管理', 'Admin', 'MemberLevel', 'lst', 3),
(12, '商品添加', 'Admin', 'Goods', 'add', 4),
(13, '商品修改', 'Admin', 'Goods', 'edit', 4),
(14, '商品删除', 'Admin', 'Goods', 'delete', 4),
(15, '品牌添加', 'Admin', 'Brand', 'add', 5),
(16, '品牌修改', 'Admin', 'Brand', 'edit', 5),
(17, '品牌删除', 'Admin', 'Brand', 'delete', 5),
(18, '分类添加', 'Admin', 'Category', 'add', 6),
(19, '分类修改', 'Admin', 'Category', 'edit', 6),
(20, '分类删除', 'Admin', 'Category', 'delete', 6),
(21, '类型添加', 'Admin', 'Type', 'add', 7),
(22, '类型修改', 'Admin', 'Type', 'edit', 7),
(23, '类型删除', 'Admin', 'Type', 'delete', 7),
(24, '会员级别添加', 'Admin', 'MemberLevel', 'add', 11),
(25, '会员级别修改', 'Admin', 'MemberLevel', 'edit', 11),
(26, '会员级别删除', 'Admin', 'MemberLevel', 'delete', 11),
(27, '权限添加', 'Admin', 'Privilege', 'add', 8),
(28, '权限修改', 'Admin', 'Privilege', 'edit', 8),
(29, '权限删除', 'Admin', 'Privilege', 'delete', 8),
(30, '角色添加', 'Admin', 'Role', 'add', 9),
(31, '角色修改', 'Admin', 'Role', 'edit', 9),
(32, '角色删除', 'Admin', 'Role', 'delete', 9),
(33, '管理员添加', 'Admin', 'Admin', 'add', 10),
(34, '管理员修改', 'Admin', 'Admin', 'edit', 10),
(35, '管理员删除', 'Admin', 'Admin', 'delete', 10),
(36, '属性列表', 'Admin', 'Attribute', 'lst', 7),
(37, '属性添加', 'Admin', 'Attribute', 'add', 36),
(38, '属性修改', 'Admin', 'Attribute', 'edit', 36),
(39, '属性删除', 'Admin', 'Attribute', 'delete', 36),
(40, 'Ajax获取分类', 'Admin', 'Category', 'ajaxGetCats', 19),
(41, 'Ajax删除商品属性', 'Admin', 'GoodsAttr', 'ajaxDelAttr', 13),
(42, 'Ajax删除商品图片', 'Admin', 'Goods', 'ajaxDelPic', 13),
(43, '商品库存量列表', 'Admin', 'GoodsNumber', 'lst', 13);

-- --------------------------------------------------------

--
-- 表的结构 `p39_role`
--

CREATE TABLE `p39_role` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'Id',
  `role_name` varchar(30) NOT NULL DEFAULT '' COMMENT '角色名称'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色';

--
-- 转存表中的数据 `p39_role`
--

INSERT INTO `p39_role` (`id`, `role_name`) VALUES
(3, '商品管理员'),
(4, '商品管理员2');

-- --------------------------------------------------------

--
-- 表的结构 `p39_role_pri`
--

CREATE TABLE `p39_role_pri` (
  `role_id` mediumint(8) UNSIGNED NOT NULL COMMENT '角色Id',
  `pri_id` mediumint(8) UNSIGNED NOT NULL COMMENT '权限Id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色权限';

--
-- 转存表中的数据 `p39_role_pri`
--

INSERT INTO `p39_role_pri` (`role_id`, `pri_id`) VALUES
(3, 1),
(3, 4),
(3, 12),
(3, 13),
(3, 14),
(3, 5),
(3, 15),
(3, 16),
(3, 17),
(4, 2),
(4, 10),
(4, 33),
(4, 34),
(4, 35);

-- --------------------------------------------------------

--
-- 表的结构 `p39_sphinx_id`
--

CREATE TABLE `p39_sphinx_id` (
  `id` mediumint(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Sphinx商品索引表';

--
-- 转存表中的数据 `p39_sphinx_id`
--

INSERT INTO `p39_sphinx_id` (`id`) VALUES
(26);

-- --------------------------------------------------------

--
-- 表的结构 `p39_type`
--

CREATE TABLE `p39_type` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'Id',
  `type_name` varchar(30) NOT NULL COMMENT '类型名称'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='类型';

--
-- 转存表中的数据 `p39_type`
--

INSERT INTO `p39_type` (`id`, `type_name`) VALUES
(2, '手机'),
(3, '服饰'),
(4, '运动鞋');

-- --------------------------------------------------------

--
-- 表的结构 `p39_yinxiang`
--

CREATE TABLE `p39_yinxiang` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'Id',
  `goods_id` mediumint(8) UNSIGNED NOT NULL COMMENT '商品ID',
  `yx_name` varchar(30) NOT NULL COMMENT '印象名称',
  `yx_count` mediumint(8) UNSIGNED NOT NULL DEFAULT '1' COMMENT '印象次数'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品印象';

--
-- 转存表中的数据 `p39_yinxiang`
--

INSERT INTO `p39_yinxiang` (`id`, `goods_id`, `yx_name`, `yx_count`) VALUES
(1, 18, '123', 6),
(2, 18, '456', 3);

-- --------------------------------------------------------

--
-- 表的结构 `test`
--

CREATE TABLE `test` (
  `id` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='测试Mysql的锁机制和PHP文件锁机制';

--
-- 转存表中的数据 `test`
--

INSERT INTO `test` (`id`) VALUES
(69);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `p39_admin`
--
ALTER TABLE `p39_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p39_admin_role`
--
ALTER TABLE `p39_admin_role`
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `p39_attribute`
--
ALTER TABLE `p39_attribute`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `p39_brand`
--
ALTER TABLE `p39_brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p39_cart`
--
ALTER TABLE `p39_cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `p39_category`
--
ALTER TABLE `p39_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `is_floor` (`is_floor`);

--
-- Indexes for table `p39_comment`
--
ALTER TABLE `p39_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goods_id` (`goods_id`);

--
-- Indexes for table `p39_comment_reply`
--
ALTER TABLE `p39_comment_reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `p39_goods`
--
ALTER TABLE `p39_goods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shop_price` (`shop_price`),
  ADD KEY `addtime` (`addtime`),
  ADD KEY `is_on_sale` (`is_on_sale`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `cat_id` (`cat_id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `promote_price` (`promote_price`),
  ADD KEY `promote_start_date` (`promote_start_date`),
  ADD KEY `promote_end_date` (`promote_end_date`),
  ADD KEY `is_new` (`is_new`),
  ADD KEY `is_hot` (`is_hot`),
  ADD KEY `is_best` (`is_best`),
  ADD KEY `is_floor` (`is_floor`),
  ADD KEY `sort_num` (`sort_num`);

--
-- Indexes for table `p39_goods_attr`
--
ALTER TABLE `p39_goods_attr`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goods_id` (`goods_id`),
  ADD KEY `attr_id` (`attr_id`);

--
-- Indexes for table `p39_goods_cat`
--
ALTER TABLE `p39_goods_cat`
  ADD KEY `cat_id` (`cat_id`),
  ADD KEY `goods_id` (`goods_id`);

--
-- Indexes for table `p39_goods_number`
--
ALTER TABLE `p39_goods_number`
  ADD KEY `goods_id` (`goods_id`);

--
-- Indexes for table `p39_goods_pic`
--
ALTER TABLE `p39_goods_pic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goods_id` (`goods_id`);

--
-- Indexes for table `p39_member`
--
ALTER TABLE `p39_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p39_member_address`
--
ALTER TABLE `p39_member_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p39_member_level`
--
ALTER TABLE `p39_member_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p39_member_price`
--
ALTER TABLE `p39_member_price`
  ADD KEY `level_id` (`level_id`),
  ADD KEY `goods_id` (`goods_id`);

--
-- Indexes for table `p39_order`
--
ALTER TABLE `p39_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `addtime` (`addtime`),
  ADD KEY `post_status` (`post_status`);

--
-- Indexes for table `p39_order_goods`
--
ALTER TABLE `p39_order_goods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `goods_id` (`goods_id`);

--
-- Indexes for table `p39_privilege`
--
ALTER TABLE `p39_privilege`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p39_role`
--
ALTER TABLE `p39_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p39_role_pri`
--
ALTER TABLE `p39_role_pri`
  ADD KEY `role_id` (`role_id`),
  ADD KEY `pri_id` (`pri_id`);

--
-- Indexes for table `p39_type`
--
ALTER TABLE `p39_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p39_yinxiang`
--
ALTER TABLE `p39_yinxiang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goods_id` (`goods_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `p39_admin`
--
ALTER TABLE `p39_admin`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `p39_attribute`
--
ALTER TABLE `p39_attribute`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=17;
--
-- 使用表AUTO_INCREMENT `p39_brand`
--
ALTER TABLE `p39_brand`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=10;
--
-- 使用表AUTO_INCREMENT `p39_cart`
--
ALTER TABLE `p39_cart`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `p39_category`
--
ALTER TABLE `p39_category`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=46;
--
-- 使用表AUTO_INCREMENT `p39_comment`
--
ALTER TABLE `p39_comment`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=9;
--
-- 使用表AUTO_INCREMENT `p39_comment_reply`
--
ALTER TABLE `p39_comment_reply`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `p39_goods`
--
ALTER TABLE `p39_goods`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=27;
--
-- 使用表AUTO_INCREMENT `p39_goods_attr`
--
ALTER TABLE `p39_goods_attr`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=46;
--
-- 使用表AUTO_INCREMENT `p39_goods_pic`
--
ALTER TABLE `p39_goods_pic`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=28;
--
-- 使用表AUTO_INCREMENT `p39_member`
--
ALTER TABLE `p39_member`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `p39_member_address`
--
ALTER TABLE `p39_member_address`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=15;
--
-- 使用表AUTO_INCREMENT `p39_member_level`
--
ALTER TABLE `p39_member_level`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `p39_order`
--
ALTER TABLE `p39_order`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=25;
--
-- 使用表AUTO_INCREMENT `p39_order_goods`
--
ALTER TABLE `p39_order_goods`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=73;
--
-- 使用表AUTO_INCREMENT `p39_privilege`
--
ALTER TABLE `p39_privilege`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=44;
--
-- 使用表AUTO_INCREMENT `p39_role`
--
ALTER TABLE `p39_role`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `p39_type`
--
ALTER TABLE `p39_type`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `p39_yinxiang`
--
ALTER TABLE `p39_yinxiang`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
