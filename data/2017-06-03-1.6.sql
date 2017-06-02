-- 为商品表添加分类的ID
alter TABLE p39_goods add COLUMN cat_id mediumint unsigned not null DEFAULT 0 comment '主分类ID';
--修改分类ID放置的位置
alter TABLE p39_goods change cat_id  cat_id mediumint unsigned not null DEFAULT 0 comment '主分类ID' after mbig_logo;