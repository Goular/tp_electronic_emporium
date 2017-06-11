/*********************** RBAC ***********************************/

/*********************** 权限表 ***********************************/
DROP TABLE IF EXISTS p39_privilege;
CREATE TABLE IF NOT EXISTS p39_privilege(
  id mediumint unsigned not null auto_increment comment 'Id',
  pri_name varchar(30) not null DEFAULT '' comment '权限名称',
  module_name varchar(30) not null DEFAULT '' comment '模块名称',
  controller_name varchar(30) not null DEFAULT '' comment '控制器名称',
  action_name varchar(30) not null DEFAULT '' comment '方法名称',
  parent_id mediumint unsigned not null DEFAULT 0 comment '上级权限Id',
  PRIMARY KEY(id)
)engine=InnoDB DEFAULT charset=utf8 comment '权限';

/*********************** 角色表 ***********************************/
DROP TABLE IF EXISTS p39_role;
CREATE TABLE IF NOT EXISTS p39_role(
  id mediumint unsigned not null auto_increment comment 'Id',
  role_name varchar(30) not null DEFAULT '' comment '角色名称',
  PRIMARY KEY(id)
)engine=InnoDB DEFAULT charset=utf8 comment '角色';

/*********************** 管理员/人员表 ***********************************/
DROP TABLE IF EXISTS p39_admin;
CREATE TABLE IF NOT EXISTS p39_admin(
  id mediumint unsigned not null auto_increment comment 'Id',
  username VARCHAR(30) not null comment '用户名',
  password CHAR(32) not null comment '密码',
  PRIMARY KEY(id)
)engine=InnoDB DEFAULT charset=utf8 comment '管理员/人员';

/*********************** 角色权限表 ***********************************/
DROP TABLE IF EXISTS p39_role_pri;
CREATE TABLE IF NOT EXISTS p39_role_pri(
  role_id mediumint unsigned not null comment '角色Id',
  pri_id mediumint unsigned not null comment '权限Id',
  KEY role_id(role_id),
  KEY pri_id(pri_id)
)engine=InnoDB DEFAULT charset=utf8 comment '角色权限';

/*********************** 人员角色表 ***********************************/
DROP TABLE IF EXISTS p39_admin_role;
CREATE TABLE IF NOT EXISTS p39_admin_role(
  admin_id mediumint unsigned not null comment '管理员Id',
  role_id mediumint unsigned not null comment '权限Id',
  KEY admin_id(admin_id),
  KEY role_id(role_id)
)engine=InnoDB DEFAULT charset=utf8 comment '人员角色';

INSERT INTO p39_admin(id,username,password) VALUES(1,'root','96e79218965eb72c92a549dd5a330112');