-- 添加前台会员列表
DROP TABLE IF EXISTS p39_cart;
CREATE TABLE p39_cart(
  id mediumint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id',
  goods_id mediumint unsigned NOT NULL COMMENT '商品ID',
  goods_attr_id VARCHAR(150) NOT NULL DEFAULT '' COMMENT '商品属性ID',
  goods_number mediumint unsigned NOT NULL COMMENT '购买的数量',
  member_id mediumint unsigned NOT NULL COMMENT '会员id',
  PRIMARY KEY (id),
  KEY member_id(member_id)
)ENGINE = INNODB DEFAULT CHARSET=UTF8 COMMENT '购物车';