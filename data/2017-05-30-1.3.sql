--会员积分表
DROP TABLE IF EXISTS p39_member_level;
CREATE TABLE p39_member_level(
  id mediumint unsigned not null auto_increment comment 'ID',
  level_name VARCHAR(30) not null comment '级别名称',
  jifen_bottom mediumint unsigned not null comment '积分下限',
  jifen_top mediumint unsigned not null comment '积分上限',
  PRIMARY KEY (id)
)ENGINE = INNODB DEFAULT CHARSET=UTF8 COMMENT '会员级别';

--中间表
DROP TABLE IF EXISTS p39_member_price;
CREATE TABLE p39_member_price(
  price DECIMAL(10,2) not null comment '会员价格',
  level_id mediumint unsigned not null comment '级别ID',
  goods_id mediumint unsigned not null comment '商品ID',
  key level_id(level_id),
  key goods_id(goods_id)
)ENGINE = INNODB DEFAULT CHARSET=UTF8 COMMENT '会员-级别中间表';
