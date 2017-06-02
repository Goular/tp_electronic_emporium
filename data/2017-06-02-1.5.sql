-- 添加商品分类的表
DROP TABLE if EXISTS p39_category;
CREATE TABLE IF NOT EXISTS p39_category(
  id mediumint unsigned not null auto_increment comment 'Id',
  cat_name VARCHAR(30) not null comment '分类名称',
  parent_id mediumint unsigned not null DEFAULT 0,
  PRIMARY KEY (id),
  key parent_id(parent_id)
)engine=InnoDB DEFAULT charset=UTF8 COMMENT '商品分类';
