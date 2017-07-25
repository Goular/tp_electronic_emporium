--添加评论表
DROP TABLE IF EXISTS p39_comment;
create table p39_comment(
  id mediumint unsigned not null auto_increment comment 'Id',
  goods_id mediumint unsigned not null comment '商品ID',
  member_id mediumint unsigned not null comment '用户ID',
  content VARCHAR(200) not null comment '内容',
  addtime DATETIME not null comment '发表时间',
  star tinyint unsigned not null comment '分值',
  click_count smallint unsigned not null DEFAULT '0' comment '有用的数字',
  PRIMARY KEY(id),
  KEY goods_id(goods_id)
)engine=InnoDB DEFAULT charset=utf8 comment '商品评论';


--添加回复评论
DROP TABLE IF EXISTS p39_comment_reply;
create table p39_comment_reply(
  id mediumint unsigned not null auto_increment comment 'Id',
  comment_id mediumint unsigned not null comment '评论ID',
  member_id mediumint unsigned not null comment '用户ID',
  content VARCHAR(200) not null comment '内容',
  addtime DATETIME not null comment '发表时间',
  PRIMARY KEY(id),
  KEY comment_id(comment_id),
  KEY member_id(member_id)
)engine=InnoDB DEFAULT charset=utf8 comment '评论回复';


--添加评论表
DROP TABLE IF EXISTS p39_yinxiang;
create table p39_yinxiang(
  id mediumint unsigned not null auto_increment comment 'Id',
  goods_id mediumint unsigned not null comment '商品ID',
  yx_name VARCHAR(30) not null comment '印象名称',
  yx_count mediumint unsigned not null DEFAULT '1' comment '印象次数',
  PRIMARY KEY(id),
  KEY goods_id(goods_id)
)engine=InnoDB DEFAULT charset=utf8 comment '商品印象';