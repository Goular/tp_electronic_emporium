--添加Sphinx商品ID索引id
DROP TABLE IF EXISTS p39_sphinx_id;
create table p39_sphinx_id(
  id mediumint unsigned not null DEFAULT '0' comment 'Id'
)engine=InnoDB DEFAULT charset=utf8 comment 'Sphinx商品索引表';
INSERT INTO p39_sphinx_id VALUES(0);

--用于Sphinx的内容的索引的显示
ALTER TABLE p39_goods add is_updated tinyint unsigned not null DEFAULT '0' comment '是否被修改';