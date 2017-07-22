-- 添加订单商品表
DROP TABLE IF EXISTS p39_member_address;
CREATE TABLE p39_member_address(
  id mediumint unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  member_id mediumint unsigned not null COMMENT '用户ID',
  province VARCHAR(20) not null DEFAULT '' COMMENT '省份ID',
  city VARCHAR(20) not null DEFAULT '' COMMENT '城市ID',
  district VARCHAR(20) not null DEFAULT '' COMMENT '城区ID',
  mobile VARCHAR(20) not null DEFAULT '' COMMENT '手机号码',
  detail VARCHAR(120) not null DEFAULT '' COMMENT '详细地址',
  is_default enum('是','否') DEFAULT '否' COMMENT '默认地址',
  PRIMARY KEY (id),
  KEY member_id(member_id)
)ENGINE = INNODB DEFAULT CHARSET=UTF8 COMMENT '会员地址列表';