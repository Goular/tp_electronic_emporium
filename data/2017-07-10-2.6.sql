-- 添加前台会员列表
DROP TABLE IF EXISTS p39_order;
CREATE TABLE p39_order(
  id mediumint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id',
  member_id mediumint unsigned not null comment '会员ID',
  addtime int unsigned not null comment '下单时间',
  pay_status enum('是','否') not null DEFAULT '否' comment '支付状态',
  pay_time int unsigned not null DEFAULT '0' comment '支付时间',
  total_price DECIMAL(10,2)  not null comment '订单价格',
  shr_name VARCHAR(30) not null comment '收货人姓名',
  shr_tel VARCHAR(30) not null comment '收货人电话',
  shr_province VARCHAR(30) not null comment '收货人省份',
  shr_city VARCHAR(30) not null comment '收货人城市',
  shr_area VARCHAR(30) not null comment '收货人地区',
  shr_address VARCHAR(30) not null comment '收货人地址',
  post_status tinyint unsigned not null DEFAULT '0' comment '发货状态,0:未发货，1:已发货,2：已收到货',
  post_number VARCHAR(30) not null DEFAULT '' COMMENT '快递号',
  PRIMARY KEY(id),
  KEY member_id(member_id),
  key addtime(addtime),
  key post_status(post_status)
)ENGINE = INNODB DEFAULT CHARSET=UTF8 COMMENT '订单';

-- 添加订单商品表
DROP TABLE IF EXISTS p39_order_goods;
CREATE TABLE p39_order_goods(
  id mediumint unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  order_id mediumint unsigned not null COMMENT '订单ID',
  goods_id mediumint unsigned not null COMMENT '商品ID',
  goods_attr_id VARCHAR(150) not null DEFAULT '' COMMENT '属性ID',
  goods_number tinyint unsigned not null  comment '购买数量',
  price DECIMAL(10,2)  not null comment '商品单价',
  PRIMARY KEY (id),
  KEY order_id(order_id),
  key goods_id(goods_id)
)ENGINE = INNODB DEFAULT CHARSET=UTF8 COMMENT '订单商品';
