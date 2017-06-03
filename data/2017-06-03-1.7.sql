-- 商品拓展分类表(中间表)
DROP TABLE IF EXISTS p39_goods_cat;
CREATE TABLE IF NOT EXISTS p39_goods_cat(
  cat_id mediumint unsigned not null comment '分类Id',
  goods_id mediumint unsigned not null comment '商品Id',
  key cat_id(cat_id),
  key goods_id(goods_id)
)engine = InnoDB DEFAULT CHARSET=UTF8 COMMENT '商品拓展分类';