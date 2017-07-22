-- 添加订单商品表
DROP TABLE IF EXISTS p39_member_address;
CREATE TABLE p39_member_address(
  id mediumint unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  receiver VARCHAR(20) not null DEFAULT '' COMMENT '收货人名称',
  province VARCHAR(20) not null DEFAULT '' COMMENT '省份ID',
  city VARCHAR(20) not null DEFAULT '' COMMENT '城市ID',
  district VARCHAR(20) not null DEFAULT '' COMMENT '城区ID',
  mobile VARCHAR(20) not null DEFAULT '' COMMENT '手机号码',
  detail VARCHAR(120) not null DEFAULT '' COMMENT '详细地址',
  is_default enum('是','否') DEFAULT '否' COMMENT '默认地址',
  PRIMARY KEY (id)
)ENGINE = INNODB DEFAULT CHARSET=UTF8 COMMENT '收货地址列表';