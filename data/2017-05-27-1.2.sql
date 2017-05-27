alter TABLE p39_goods ADD brand_id mediumint unsigned not null DEFAULT '0' comment '品牌ID';
alter TABLE p39_goods add index brand_id (brand_id);