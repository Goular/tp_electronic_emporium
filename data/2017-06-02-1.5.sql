-- 添加商品分类的表
DROP TABLE if EXISTS p39_category;
CREATE TABLE IF NOT EXISTS p39_category(
  id mediumint unsigned not null auto_increment comment 'Id',
  cat_name VARCHAR(30) not null comment '分类名称',
  parent_id mediumint unsigned not null DEFAULT 0,
  PRIMARY KEY (id),
  key parent_id(parent_id)
)engine=InnoDB DEFAULT charset=UTF8 COMMENT '商品分类';

--插入数据
INSERT INTO `p39_category` (`id`, `cat_name`, `parent_id`) VALUES
(1, '家用电器', 0),
(2, '手机、数码、京东通信', 0),
(3, '电脑、办公', 0),
(4, '家居、家具、家装、厨具', 0),
(5, '男装、女装、内衣、珠宝', 0),
(6, '个护化妆', 0),
(21, 'iphone', 2),
(8, '运动户外', 0),
(9, '汽车、汽车用品', 0),
(10, '母婴、玩具乐器', 0),
(11, '食品、酒类、生鲜、特产', 0),
(12, '营养保健', 0),
(13, '图书、音像、电子书', 0),
(14, '彩票、旅行、充值、票务', 0),
(15, '理财、众筹、白条、保险', 0),
(16, '大家电', 1),
(17, '生活电器', 1),
(18, '厨房电器', 1),
(19, '个护健康', 1),
(20, '五金家装', 1),
(22, '冰箱', 16);