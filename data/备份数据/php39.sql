-- MySQL dump 10.16  Distrib 10.1.21-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: localhost
-- ------------------------------------------------------
-- Server version	10.1.21-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `p39_admin`
--

DROP TABLE IF EXISTS `p39_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `p39_admin` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `username` varchar(30) NOT NULL COMMENT '鐢ㄦ埛鍚?,
  `password` char(32) NOT NULL COMMENT '瀵嗙爜',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='绠＄悊鍛?浜哄憳';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `p39_admin`
--

LOCK TABLES `p39_admin` WRITE;
/*!40000 ALTER TABLE `p39_admin` DISABLE KEYS */;
INSERT INTO `p39_admin` VALUES (1,'root','96e79218965eb72c92a549dd5a330112'),(3,'user1','e10adc3949ba59abbe56e057f20f883e');
/*!40000 ALTER TABLE `p39_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `p39_admin_role`
--

DROP TABLE IF EXISTS `p39_admin_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `p39_admin_role` (
  `admin_id` mediumint(8) unsigned NOT NULL COMMENT '绠＄悊鍛業d',
  `role_id` mediumint(8) unsigned NOT NULL COMMENT '鏉冮檺Id',
  KEY `admin_id` (`admin_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='浜哄憳瑙掕壊';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `p39_admin_role`
--

LOCK TABLES `p39_admin_role` WRITE;
/*!40000 ALTER TABLE `p39_admin_role` DISABLE KEYS */;
INSERT INTO `p39_admin_role` VALUES (3,3),(3,4);
/*!40000 ALTER TABLE `p39_admin_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `p39_attribute`
--

DROP TABLE IF EXISTS `p39_attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `p39_attribute` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `attr_name` varchar(30) NOT NULL COMMENT '灞炴€у悕绉?,
  `attr_type` enum('鍞竴','鍙€?) NOT NULL COMMENT '灞炴€х被鍨?,
  `attr_option_values` varchar(300) NOT NULL DEFAULT '' COMMENT '灞炴€у彲閫夊€?,
  `type_id` mediumint(8) unsigned NOT NULL COMMENT '鎵€灞炵被鍨婭d',
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='灞炴€ц〃';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `p39_attribute`
--

LOCK TABLES `p39_attribute` WRITE;
/*!40000 ALTER TABLE `p39_attribute` DISABLE KEYS */;
INSERT INTO `p39_attribute` VALUES (1,'灏虹爜','鍙€?,'S,M,X,XL,XXL,XXXL,XXXXL',3),(2,'棰滆壊','鍙€?,'鐧借壊,榛戣壊,缁胯壊,钃濊壊,榛勮壊,绾㈣壊,绱壊,妫曡壊',3),(6,'鏉愭枡','鍞竴','',3),(7,'鍑哄巶鏃ユ湡','鍞竴','',3);
/*!40000 ALTER TABLE `p39_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `p39_brand`
--

DROP TABLE IF EXISTS `p39_brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `p39_brand` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `brand_name` varchar(30) NOT NULL COMMENT '鍝佺墝鍚嶇О',
  `site_url` varchar(150) NOT NULL DEFAULT '' COMMENT '瀹樻柟缃戠珯',
  `logo` varchar(150) NOT NULL DEFAULT '' COMMENT '鍝佺墝Logo鍥剧墖',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='鍝佺墝';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `p39_brand`
--

LOCK TABLES `p39_brand` WRITE;
/*!40000 ALTER TABLE `p39_brand` DISABLE KEYS */;
INSERT INTO `p39_brand` VALUES (1,'娆у皵鐧?,'http://www.baidu.com','Brand/2017-05-29/592af4e821454.jpg'),(2,'鑰愬厠','http://www.qq.com','Brand/2017-05-29/592b93e1283bb.jpg'),(3,'鑵捐','http://www.ifeng.com','Brand/2017-05-29/592b93fa8e1ad.jpg');
/*!40000 ALTER TABLE `p39_brand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `p39_category`
--

DROP TABLE IF EXISTS `p39_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `p39_category` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `cat_name` varchar(30) NOT NULL COMMENT '鍒嗙被鍚嶇О',
  `parent_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='鍟嗗搧鍒嗙被';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `p39_category`
--

LOCK TABLES `p39_category` WRITE;
/*!40000 ALTER TABLE `p39_category` DISABLE KEYS */;
INSERT INTO `p39_category` VALUES (1,'瀹剁敤鐢靛櫒',0),(2,'鎵嬫満銆佹暟鐮併€佷含涓滈€氫俊',0),(3,'鐢佃剳銆佸姙鍏?,0),(4,'瀹跺眳銆佸鍏枫€佸瑁呫€佸帹鍏?,0),(5,'鐢疯銆佸コ瑁呫€佸唴琛ｃ€佺彔瀹?,0),(6,'涓姢鍖栧',0),(8,'杩愬姩鎴峰',0),(9,'姹借溅銆佹苯杞︾敤鍝?,0),(10,'姣嶅┐銆佺帺鍏蜂箰鍣?,0),(11,'椋熷搧銆侀厭绫汇€佺敓椴溿€佺壒浜?,0),(12,'钀ュ吇淇濆仴',0),(13,'鍥句功銆侀煶鍍忋€佺數瀛愪功',0),(14,'褰╃エ銆佹梾琛屻€佸厖鍊笺€佺エ鍔?,0),(16,'澶у鐢?,1),(17,'鐢熸椿鐢靛櫒',1),(18,'鍘ㄦ埧鐢靛櫒',1),(19,'涓姢鍋ュ悍',1),(20,'浜旈噾瀹惰',1),(21,'iphone',2),(22,'鍐扮',16),(28,'鐝犳捣鏍煎姏',1),(29,'鐝犳捣鎭掗殕',28),(30,'ABC',0);
/*!40000 ALTER TABLE `p39_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `p39_goods`
--

DROP TABLE IF EXISTS `p39_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `p39_goods` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `goods_name` varchar(150) NOT NULL COMMENT '鍟嗗搧鍚嶇О',
  `market_price` decimal(10,2) NOT NULL COMMENT '甯傚満浠锋牸',
  `shop_price` decimal(10,2) NOT NULL COMMENT '鏈簵浠锋牸',
  `goods_desc` longtext COMMENT '鍟嗗搧鎻忚堪',
  `is_on_sale` enum('鏄?,'鍚?) NOT NULL DEFAULT '鍚? COMMENT '鏄惁涓婃灦',
  `is_delete` enum('鏄?,'鍚?) NOT NULL DEFAULT '鍚? COMMENT '鏄惁鏀惧埌鍥炴敹绔?,
  `addtime` datetime NOT NULL COMMENT '娣诲姞鏃堕棿',
  `logo` varchar(150) NOT NULL DEFAULT '' COMMENT '鍘熷浘',
  `sm_logo` varchar(150) NOT NULL DEFAULT '' COMMENT '灏忓浘',
  `mid_logo` varchar(150) NOT NULL DEFAULT '' COMMENT '涓浘',
  `big_logo` varchar(150) NOT NULL DEFAULT '' COMMENT '澶у浘',
  `mbig_logo` varchar(150) NOT NULL DEFAULT '' COMMENT '鏇村ぇ鍥?,
  `cat_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '涓诲垎绫籌D',
  `brand_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '鍝佺墝ID',
  `type_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '绫诲瀷ID',
  PRIMARY KEY (`id`),
  KEY `shop_price` (`shop_price`),
  KEY `addtime` (`addtime`),
  KEY `is_on_sale` (`is_on_sale`),
  KEY `brand_id` (`brand_id`),
  KEY `cat_id` (`cat_id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='鍟嗗搧';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `p39_goods`
--

LOCK TABLES `p39_goods` WRITE;
/*!40000 ALTER TABLE `p39_goods` DISABLE KEYS */;
INSERT INTO `p39_goods` VALUES (1,'娴佽杩愬姩闉?,160.00,120.00,'<p>鍒涘缓缇庡浘濂界湅</p><p><img src=\"http://www.ee.com/Public/Tools/umeditor1.2.3-utf8-php/php/upload/20170519/14951607082734.jpg\" alt=\"14951607082734.jpg\" /></p>','鍚?,'鍚?,'2017-05-19 10:25:17','Goods/2017-05-19/591e578dc23a5.jpg','Goods/2017-05-19/sm_591e578dc23a5.jpg','Goods/2017-05-19/mid_591e578dc23a5.jpg','Goods/2017-05-19/big_591e578dc23a5.jpg','Goods/2017-05-19/mbig_591e578dc23a5.jpg',0,0,0),(2,'杩愬姩闉婸OP',361.00,262.00,'<p><strong><em>鍒涘缓浼犱綘</em></strong></p><p><strong><em><br /></em></strong></p><p><strong><em>鏄殑鍙戠敓澶?/em></strong></p><p><strong><em><br /></em></strong></p><p><strong><em><br /></em></strong></p><p><strong><em>澶鏄撳お瀹规槗</em></strong></p>','鏄?,'鍚?,'2017-05-19 10:40:50','Goods/2017-05-26/5927baebbbe1e.jpg','Goods/2017-05-26/thumb_3_5927baebbbe1e.jpg','Goods/2017-05-26/thumb_2_5927baebbbe1e.jpg','Goods/2017-05-26/thumb_1_5927baebbbe1e.jpg','Goods/2017-05-26/thumb_0_5927baebbbe1e.jpg',0,2,0),(5,'闊╃増娼祦杩愬姩闉婸OI',899.36,268.00,'<p><img src=\"http://www.ee.com/Public/Tools/umeditor1.2.3-utf8-php/php/upload/20170526/14957800895316.jpg\" alt=\"14957800895316.jpg\" /></p><p><img src=\"http://www.ee.com/Public/Tools/umeditor1.2.3-utf8-php/php/upload/20170526/1495780092228.jpg\" alt=\"1495780092228.jpg\" /></p><p><img src=\"http://www.ee.com/Public/Tools/umeditor1.2.3-utf8-php/php/upload/20170526/14957801002266.jpg\" alt=\"14957801002266.jpg\" /></p><p>FDSFDSFSDFSDFDSFDSFFDS<br /></p>','鍚?,'鍚?,'2017-05-26 14:27:26','Goods/2017-05-26/5927cacde70ed.jpg','Goods/2017-05-26/thumb_3_5927cacde70ed.jpg','Goods/2017-05-26/thumb_2_5927cacde70ed.jpg','Goods/2017-05-26/thumb_1_5927cacde70ed.jpg','Goods/2017-05-26/thumb_0_5927cacde70ed.jpg',13,1,0),(6,'鍞囪啅',25.01,16.00,'<p>璁㈠崟鐨?/p>','鏄?,'鍚?,'2017-05-30 13:14:47','Goods/2017-05-30/592cffc72af5f.jpg','Goods/2017-05-30/thumb_3_592cffc72af5f.jpg','Goods/2017-05-30/thumb_2_592cffc72af5f.jpg','Goods/2017-05-30/thumb_1_592cffc72af5f.jpg','Goods/2017-05-30/thumb_0_592cffc72af5f.jpg',12,3,0),(9,'Nike Air Force 1',650.00,500.00,'<p style=\"text-align:left;\">fsdsdfdfsfdsfdsfdfsdfdsfdsfdsfsdfsdfsdfsdfdsfa,</p>','鏄?,'鍚?,'2017-05-31 16:51:07','Goods/2017-05-31/592e83fb368e1.jpg','Goods/2017-05-31/thumb_3_592e83fb368e1.jpg','Goods/2017-05-31/thumb_2_592e83fb368e1.jpg','Goods/2017-05-31/thumb_1_592e83fb368e1.jpg','Goods/2017-05-31/thumb_0_592e83fb368e1.jpg',1,2,0),(10,'澶у箙搴?,16.50,12.00,'<p style=\"text-align:left;\">閮芥槸鑼冨痉钀ㄨ寖寰疯惃</p>','鏄?,'鍚?,'2017-06-04 11:08:15','Goods/2017-06-04/5933799ed6ccd.jpg','Goods/2017-06-04/thumb_3_5933799ed6ccd.jpg','Goods/2017-06-04/thumb_2_5933799ed6ccd.jpg','Goods/2017-06-04/thumb_1_5933799ed6ccd.jpg','Goods/2017-06-04/thumb_0_5933799ed6ccd.jpg',1,1,0),(11,'Nike Air Force 1',2500.00,1698.00,'<p style=\"text-align:left;\">娓¤繃闅惧叧灏辫兘鐪嬭褰╄櫣銆?/p>','鏄?,'鍚?,'2017-06-05 09:58:48','Goods/2017-06-05/5934bad8008dd.jpg','Goods/2017-06-05/thumb_3_5934bad8008dd.jpg','Goods/2017-06-05/thumb_2_5934bad8008dd.jpg','Goods/2017-06-05/thumb_1_5934bad8008dd.jpg','Goods/2017-06-05/thumb_0_5934bad8008dd.jpg',1,1,0),(12,'Nike Air Force 1',2500.00,1698.00,'<p style=\"text-align:left;\">娓¤繃闅惧叧灏辫兘鐪嬭褰╄櫣銆?/p>','鏄?,'鍚?,'2017-06-05 09:59:53','Goods/2017-06-05/5934bb19909d5.jpg','Goods/2017-06-05/thumb_3_5934bb19909d5.jpg','Goods/2017-06-05/thumb_2_5934bb19909d5.jpg','Goods/2017-06-05/thumb_1_5934bb19909d5.jpg','Goods/2017-06-05/thumb_0_5934bb19909d5.jpg',1,1,0),(13,'fdsf',321321.00,21312.00,'<p>sdfsd</p>','鏄?,'鍚?,'2017-06-05 10:01:59','Goods/2017-06-05/5934bb9710871.jpg','Goods/2017-06-05/thumb_3_5934bb9710871.jpg','Goods/2017-06-05/thumb_2_5934bb9710871.jpg','Goods/2017-06-05/thumb_1_5934bb9710871.jpg','Goods/2017-06-05/thumb_0_5934bb9710871.jpg',2,2,0),(14,'鎺у埗',591.00,789.00,'<p style=\"text-align:left;\">姘寸數璐圭殑鎵€鍙戠敓鐨?/p>','鏄?,'鍚?,'2017-06-05 10:03:20','Goods/2017-06-05/5934bbe8494c1.jpg','Goods/2017-06-05/thumb_3_5934bbe8494c1.jpg','Goods/2017-06-05/thumb_2_5934bbe8494c1.jpg','Goods/2017-06-05/thumb_1_5934bbe8494c1.jpg','Goods/2017-06-05/thumb_0_5934bbe8494c1.jpg',1,1,0),(15,'鎺у埗159',9877.00,789.00,'<p style=\"text-align:left;\">绗笁鏂圭涓夋柟灞变笢甯堣寖</p>','鏄?,'鍚?,'2017-06-05 10:05:05','Goods/2017-06-05/5934bc515eaf5.jpg','Goods/2017-06-05/thumb_3_5934bc515eaf5.jpg','Goods/2017-06-05/thumb_2_5934bc515eaf5.jpg','Goods/2017-06-05/thumb_1_5934bc515eaf5.jpg','Goods/2017-06-05/thumb_0_5934bc515eaf5.jpg',1,1,0),(16,'FSCE123',1600.00,1255.00,'<p style=\"text-align:left;\">鍒涙柊宸ュ満</p>','鏄?,'鍚?,'2017-06-09 10:15:03','Goods/2017-06-09/593a04a7770f7.jpg','Goods/2017-06-09/thumb_3_593a04a7770f7.jpg','Goods/2017-06-09/thumb_2_593a04a7770f7.jpg','Goods/2017-06-09/thumb_1_593a04a7770f7.jpg','Goods/2017-06-09/thumb_0_593a04a7770f7.jpg',1,1,3);
/*!40000 ALTER TABLE `p39_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `p39_goods_attr`
--

DROP TABLE IF EXISTS `p39_goods_attr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `p39_goods_attr` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `attr_value` varchar(150) NOT NULL DEFAULT '' COMMENT '灞炴€у€?,
  `attr_id` mediumint(8) unsigned NOT NULL COMMENT '灞炴€d',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '鍟嗗搧Id',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`),
  KEY `attr_id` (`attr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='鍟嗗搧灞炴€?;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `p39_goods_attr`
--

LOCK TABLES `p39_goods_attr` WRITE;
/*!40000 ALTER TABLE `p39_goods_attr` DISABLE KEYS */;
INSERT INTO `p39_goods_attr` VALUES (1,'S',1,16),(2,'XXXXL',1,16),(3,'M',1,16),(4,'X',1,16),(5,'XL',1,16),(6,'XXL',1,16),(7,'XXXL',1,16),(8,'XXXXL',1,16),(9,'榛戣壊',2,16),(10,'妫曡壊',2,16),(11,'榛勮壊',2,16),(12,'钃濊壊',2,16),(13,'绾㈣壊',2,16),(14,'绱壊',2,16),(15,'绾',6,16),(16,'2016-12-29',7,16);
/*!40000 ALTER TABLE `p39_goods_attr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `p39_goods_cat`
--

DROP TABLE IF EXISTS `p39_goods_cat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `p39_goods_cat` (
  `cat_id` mediumint(8) unsigned NOT NULL COMMENT '鍒嗙被Id',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '鍟嗗搧Id',
  KEY `cat_id` (`cat_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='鍟嗗搧鎷撳睍鍒嗙被';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `p39_goods_cat`
--

LOCK TABLES `p39_goods_cat` WRITE;
/*!40000 ALTER TABLE `p39_goods_cat` DISABLE KEYS */;
INSERT INTO `p39_goods_cat` VALUES (16,15),(18,15),(16,16),(19,16);
/*!40000 ALTER TABLE `p39_goods_cat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `p39_goods_number`
--

DROP TABLE IF EXISTS `p39_goods_number`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `p39_goods_number` (
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '鍟嗗搧Id',
  `goods_number` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '搴撳瓨閲?,
  `goods_attr_id` varchar(150) NOT NULL COMMENT '鍟嗗搧灞炴€ц〃鐨処D,濡傛灉鏈夊涓紝灏辩敤绋嬪簭鎷兼垚瀛楃涓插瓨鍒拌繖涓瓧娈典腑',
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='搴撳瓨閲?;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `p39_goods_number`
--

LOCK TABLES `p39_goods_number` WRITE;
/*!40000 ALTER TABLE `p39_goods_number` DISABLE KEYS */;
/*!40000 ALTER TABLE `p39_goods_number` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `p39_goods_pic`
--

DROP TABLE IF EXISTS `p39_goods_pic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `p39_goods_pic` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `pic` varchar(150) NOT NULL COMMENT '鍘熷浘',
  `sm_pic` varchar(150) NOT NULL COMMENT '灏忓浘',
  `mid_pic` varchar(150) NOT NULL COMMENT '涓浘',
  `big_pic` varchar(150) NOT NULL COMMENT '澶у浘',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '鍟嗗搧Id',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='鍟嗗搧鐩稿唽';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `p39_goods_pic`
--

LOCK TABLES `p39_goods_pic` WRITE;
/*!40000 ALTER TABLE `p39_goods_pic` DISABLE KEYS */;
INSERT INTO `p39_goods_pic` VALUES (1,'Goods/2017-06-04/5933799fbd3b2.jpg','Goods/2017-06-04/thumb_2_5933799fbd3b2.jpg','Goods/2017-06-04/thumb_1_5933799fbd3b2.jpg','Goods/2017-06-04/thumb_0_5933799fbd3b2.jpg',10),(2,'Goods/2017-06-04/5933799fdf3c9.jpg','Goods/2017-06-04/thumb_2_5933799fdf3c9.jpg','Goods/2017-06-04/thumb_1_5933799fdf3c9.jpg','Goods/2017-06-04/thumb_0_5933799fdf3c9.jpg',10),(3,'Goods/2017-06-04/593379a0075a0.jpg','Goods/2017-06-04/thumb_2_593379a0075a0.jpg','Goods/2017-06-04/thumb_1_593379a0075a0.jpg','Goods/2017-06-04/thumb_0_593379a0075a0.jpg',10),(4,'Goods/2017-06-05/5934bad8b52fb.jpg','Goods/2017-06-05/thumb_2_5934bad8b52fb.jpg','Goods/2017-06-05/thumb_1_5934bad8b52fb.jpg','Goods/2017-06-05/thumb_0_5934bad8b52fb.jpg',11),(5,'Goods/2017-06-05/5934bad8d53ec.jpg','Goods/2017-06-05/thumb_2_5934bad8d53ec.jpg','Goods/2017-06-05/thumb_1_5934bad8d53ec.jpg','Goods/2017-06-05/thumb_0_5934bad8d53ec.jpg',11),(6,'Goods/2017-06-05/5934bad8f1458.jpg','Goods/2017-06-05/thumb_2_5934bad8f1458.jpg','Goods/2017-06-05/thumb_1_5934bad8f1458.jpg','Goods/2017-06-05/thumb_0_5934bad8f1458.jpg',11),(7,'Goods/2017-06-05/5934bad91bf02.jpg','Goods/2017-06-05/thumb_2_5934bad91bf02.jpg','Goods/2017-06-05/thumb_1_5934bad91bf02.jpg','Goods/2017-06-05/thumb_0_5934bad91bf02.jpg',11),(8,'Goods/2017-06-05/5934bb19eb2e4.jpg','Goods/2017-06-05/thumb_2_5934bb19eb2e4.jpg','Goods/2017-06-05/thumb_1_5934bb19eb2e4.jpg','Goods/2017-06-05/thumb_0_5934bb19eb2e4.jpg',12),(9,'Goods/2017-06-05/5934bb1a142b2.jpg','Goods/2017-06-05/thumb_2_5934bb1a142b2.jpg','Goods/2017-06-05/thumb_1_5934bb1a142b2.jpg','Goods/2017-06-05/thumb_0_5934bb1a142b2.jpg',12),(10,'Goods/2017-06-05/5934bb1a2ed44.jpg','Goods/2017-06-05/thumb_2_5934bb1a2ed44.jpg','Goods/2017-06-05/thumb_1_5934bb1a2ed44.jpg','Goods/2017-06-05/thumb_0_5934bb1a2ed44.jpg',12),(12,'Goods/2017-06-05/5934bbe8e1a85.jpg','Goods/2017-06-05/thumb_2_5934bbe8e1a85.jpg','Goods/2017-06-05/thumb_1_5934bbe8e1a85.jpg','Goods/2017-06-05/thumb_0_5934bbe8e1a85.jpg',14),(13,'Goods/2017-06-05/5934bbe90e0cf.jpg','Goods/2017-06-05/thumb_2_5934bbe90e0cf.jpg','Goods/2017-06-05/thumb_1_5934bbe90e0cf.jpg','Goods/2017-06-05/thumb_0_5934bbe90e0cf.jpg',14);
/*!40000 ALTER TABLE `p39_goods_pic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `p39_member_level`
--

DROP TABLE IF EXISTS `p39_member_level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `p39_member_level` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `level_name` varchar(30) NOT NULL COMMENT '绾у埆鍚嶇О',
  `jifen_bottom` mediumint(8) unsigned NOT NULL COMMENT '绉垎涓嬮檺',
  `jifen_top` mediumint(8) unsigned NOT NULL COMMENT '绉垎涓婇檺',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='浼氬憳绾у埆';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `p39_member_level`
--

LOCK TABLES `p39_member_level` WRITE;
/*!40000 ALTER TABLE `p39_member_level` DISABLE KEYS */;
INSERT INTO `p39_member_level` VALUES (1,'娉ㄥ唽浼氬憳',0,5000),(2,'鍒濈骇浼氬憳',5001,10000),(3,'楂樼骇浼氬憳',10001,20000),(4,'VIP',20001,16777215);
/*!40000 ALTER TABLE `p39_member_level` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `p39_member_price`
--

DROP TABLE IF EXISTS `p39_member_price`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `p39_member_price` (
  `price` decimal(10,2) NOT NULL COMMENT '浼氬憳浠锋牸',
  `level_id` mediumint(8) unsigned NOT NULL COMMENT '绾у埆ID',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '鍟嗗搧ID',
  KEY `level_id` (`level_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='浼氬憳-绾у埆涓棿琛?;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `p39_member_price`
--

LOCK TABLES `p39_member_price` WRITE;
/*!40000 ALTER TABLE `p39_member_price` DISABLE KEYS */;
INSERT INTO `p39_member_price` VALUES (12.00,1,9),(13.00,2,9),(14.00,3,9),(15.00,4,9),(12.00,1,9),(13.00,2,9),(14.00,3,9),(15.00,4,9),(16.00,1,6),(15.23,2,6),(14.00,3,6),(13.12,4,6),(16.00,1,6),(15.23,2,6),(14.00,3,6),(13.12,4,6),(12.00,1,10),(16.00,2,10),(17.00,3,10),(18.00,4,10),(192.00,1,11),(187.00,2,11),(182.00,3,11),(77.00,4,11),(192.00,1,12),(187.00,2,12),(182.00,3,12),(77.00,4,12),(2332.00,1,14),(2332.00,2,14),(2334.00,3,14),(43434.00,4,14),(23.00,1,13),(23.00,2,13),(4564.00,3,13),(23.00,1,13),(23.00,2,13),(4564.00,3,13),(159.00,1,15),(1785.00,2,15),(1987.00,3,15),(2500.00,4,15),(159.00,1,15),(1785.00,2,15),(1987.00,3,15),(2500.00,4,15),(650.00,1,16),(664.00,2,16),(690.00,3,16),(580.00,4,16),(650.00,1,16),(664.00,2,16),(690.00,3,16),(580.00,4,16);
/*!40000 ALTER TABLE `p39_member_price` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `p39_privilege`
--

DROP TABLE IF EXISTS `p39_privilege`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `p39_privilege` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `pri_name` varchar(30) NOT NULL DEFAULT '' COMMENT '鏉冮檺鍚嶇О',
  `module_name` varchar(30) NOT NULL DEFAULT '' COMMENT '妯″潡鍚嶇О',
  `controller_name` varchar(30) NOT NULL DEFAULT '' COMMENT '鎺у埗鍣ㄥ悕绉?,
  `action_name` varchar(30) NOT NULL DEFAULT '' COMMENT '鏂规硶鍚嶇О',
  `parent_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '涓婄骇鏉冮檺Id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COMMENT='鏉冮檺';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `p39_privilege`
--

LOCK TABLES `p39_privilege` WRITE;
/*!40000 ALTER TABLE `p39_privilege` DISABLE KEYS */;
INSERT INTO `p39_privilege` VALUES (1,'鍟嗗搧妯″潡','','','',0),(2,'鏉冮檺妯″潡','','','',0),(3,'浼氬憳妯″潡','','','',0),(4,'鍟嗗搧绠＄悊','Admin','Goods','lst',1),(5,'鍝佺墝绠＄悊','Admin','Brand','lst',1),(6,'鍒嗙被绠＄悊','Admin','Category','lst',1),(7,'绫诲瀷绠＄悊','Admin','Type','lst',1),(8,'鏉冮檺绠＄悊','Admin','Privilege','lst',2),(9,'瑙掕壊绠＄悊','Admin','Role','lst',2),(10,'绠＄悊鍛樼鐞?,'Admin','Admin','lst',2),(11,'绾у埆绠＄悊','Admin','MemberLevel','lst',3),(12,'鍟嗗搧娣诲姞','Admin','Goods','add',4),(13,'鍟嗗搧淇敼','Admin','Goods','edit',4),(14,'鍟嗗搧鍒犻櫎','Admin','Goods','delete',4),(15,'鍝佺墝娣诲姞','Admin','Brand','add',5),(16,'鍝佺墝淇敼','Admin','Brand','edit',5),(17,'鍝佺墝鍒犻櫎','Admin','Brand','delete',5),(18,'鍒嗙被娣诲姞','Admin','Category','add',6),(19,'鍒嗙被淇敼','Admin','Category','edit',6),(20,'鍒嗙被鍒犻櫎','Admin','Category','delete',6),(21,'绫诲瀷娣诲姞','Admin','Type','add',7),(22,'绫诲瀷淇敼','Admin','Type','edit',7),(23,'绫诲瀷鍒犻櫎','Admin','Type','delete',7),(24,'浼氬憳绾у埆娣诲姞','Admin','MemberLevel','add',11),(25,'浼氬憳绾у埆淇敼','Admin','MemberLevel','edit',11),(26,'浼氬憳绾у埆鍒犻櫎','Admin','MemberLevel','delete',11),(27,'鏉冮檺娣诲姞','Admin','Privilege','add',8),(28,'鏉冮檺淇敼','Admin','Privilege','edit',8),(29,'鏉冮檺鍒犻櫎','Admin','Privilege','delete',8),(30,'瑙掕壊娣诲姞','Admin','Role','add',9),(31,'瑙掕壊淇敼','Admin','Role','edit',9),(32,'瑙掕壊鍒犻櫎','Admin','Role','delete',9),(33,'绠＄悊鍛樻坊鍔?,'Admin','Admin','add',10),(34,'绠＄悊鍛樹慨鏀?,'Admin','Admin','edit',10),(35,'绠＄悊鍛樺垹闄?,'Admin','Admin','delete',10),(36,'灞炴€у垪琛?,'Admin','Attribute','lst',7),(37,'灞炴€ф坊鍔?,'Admin','Attribute','add',36),(38,'灞炴€т慨鏀?,'Admin','Attribute','edit',36),(39,'灞炴€у垹闄?,'Admin','Attribute','delete',36),(40,'Ajax鑾峰彇鍒嗙被','Admin','Category','ajaxGetCats',19),(41,'Ajax鍒犻櫎鍟嗗搧灞炴€?,'Admin','GoodsAttr','ajaxDelAttr',13),(42,'Ajax鍒犻櫎鍟嗗搧鍥剧墖','Admin','Goods','ajaxDelPic',13),(43,'鍟嗗搧搴撳瓨閲忓垪琛?,'Admin','GoodsNumber','lst',13);
/*!40000 ALTER TABLE `p39_privilege` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `p39_role`
--

DROP TABLE IF EXISTS `p39_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `p39_role` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `role_name` varchar(30) NOT NULL DEFAULT '' COMMENT '瑙掕壊鍚嶇О',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='瑙掕壊';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `p39_role`
--

LOCK TABLES `p39_role` WRITE;
/*!40000 ALTER TABLE `p39_role` DISABLE KEYS */;
INSERT INTO `p39_role` VALUES (3,'鍟嗗搧绠＄悊鍛?),(4,'鍟嗗搧绠＄悊鍛?');
/*!40000 ALTER TABLE `p39_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `p39_role_pri`
--

DROP TABLE IF EXISTS `p39_role_pri`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `p39_role_pri` (
  `role_id` mediumint(8) unsigned NOT NULL COMMENT '瑙掕壊Id',
  `pri_id` mediumint(8) unsigned NOT NULL COMMENT '鏉冮檺Id',
  KEY `role_id` (`role_id`),
  KEY `pri_id` (`pri_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='瑙掕壊鏉冮檺';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `p39_role_pri`
--

LOCK TABLES `p39_role_pri` WRITE;
/*!40000 ALTER TABLE `p39_role_pri` DISABLE KEYS */;
INSERT INTO `p39_role_pri` VALUES (3,1),(3,4),(3,12),(3,13),(3,14),(3,5),(3,15),(3,16),(3,17),(4,2),(4,10),(4,33),(4,34),(4,35);
/*!40000 ALTER TABLE `p39_role_pri` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `p39_type`
--

DROP TABLE IF EXISTS `p39_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `p39_type` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `type_name` varchar(30) NOT NULL COMMENT '绫诲瀷鍚嶇О',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='绫诲瀷';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `p39_type`
--

LOCK TABLES `p39_type` WRITE;
/*!40000 ALTER TABLE `p39_type` DISABLE KEYS */;
INSERT INTO `p39_type` VALUES (2,'鎵嬫満'),(3,'鏈嶉グ');
/*!40000 ALTER TABLE `p39_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test`
--

DROP TABLE IF EXISTS `test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test` (
  `id` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='娴嬭瘯Mysql鐨勯攣鏈哄埗鍜孭HP鏂囦欢閿佹満鍒?;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test`
--

LOCK TABLES `test` WRITE;
/*!40000 ALTER TABLE `test` DISABLE KEYS */;
INSERT INTO `test` VALUES (69);
/*!40000 ALTER TABLE `test` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-13  9:50:45
