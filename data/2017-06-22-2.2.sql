-- 为商品表添加分类的ID
alter TABLE p39_goods add COLUMN promote_price DECIMAL(10,2) not null DEFAULT '0.00' comment '促销价格';
alter TABLE p39_goods add COLUMN promote_start_date DATETIME not null comment '促销开始时间';
alter TABLE p39_goods add COLUMN promote_end_date DATETIME not null comment '促销结束时间';
alter TABLE p39_goods add COLUMN is_new enum('是','否') not null DEFAULT '否' comment '是否新品';
alter TABLE p39_goods add COLUMN is_hot enum('是','否') not null DEFAULT '否' comment '是否热卖';
alter TABLE p39_goods add COLUMN is_best enum('是','否') not null DEFAULT '否' comment '是否精品';

alter TABLE p39_goods add index promote_price(promote_price);
alter TABLE p39_goods add index promote_start_date(promote_start_date);
alter TABLE p39_goods add index promote_end_date(promote_end_date);
alter TABLE p39_goods add index is_new(is_new);
alter TABLE p39_goods add index is_hot(is_hot);
alter TABLE p39_goods add index is_best(is_best);