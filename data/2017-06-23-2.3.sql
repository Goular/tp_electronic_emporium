-- 为商品表添加分类的ID
alter TABLE p39_goods add COLUMN is_floor enum('是','否') not null DEFAULT '否' comment '是否推荐楼层';
alter TABLE p39_goods add COLUMN sort_num tinyint unsigned not null DEFAULT '100' comment '排序的数字';

alter TABLE p39_goods add index is_floor(is_floor);
alter TABLE p39_goods add index sort_num(sort_num);

alter TABLE p39_category add COLUMN is_floor enum('是','否') not null DEFAULT '否' comment '是否推荐楼层';
alter TABLE p39_category add index is_floor(is_floor);
