-- 单纯的商品的展示图片列表
DROP TABLE if EXISTS p39_goods_pic;
CREATE TABLE IF NOT EXISTS p39_goods_pic(
  id mediumint unsigned not null auto_increment comment 'Id',
  pic VARCHAR(150) not null comment '原图',
  sm_pic VARCHAR(150) not null comment '小图',
  mid_pic VARCHAR(150) not null comment '中图',
  big_pic VARCHAR(150) not null comment '大图',
  goods_id mediumint unsigned not null comment '商品Id',
  PRIMARY KEY (id),
  key goods_id(goods_id)
)engine=InnoDB DEFAULT charset=UTF8 COMMENT '商品相册';
