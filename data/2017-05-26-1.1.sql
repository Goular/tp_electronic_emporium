DROP TABLE IF EXISTS p39_brand;
CREATE TABLE p39_brand(
    `id` mediumint unsigned not null auto_increment comment 'ID',
    `brand_name` VARCHAR(30) not null comment '品牌名称',
    `site_url` VARCHAR(150) not null DEFAULT '' comment '官方网站',
    `logo` VARCHAR(150) not null DEFAULT '' comment '品牌Logo图片',
    PRIMARY KEY (id)
)engine=InnoDB DEFAULT charset=utf8 comment '品牌';