--一级权限
INSERT INTO `p39_privilege`
(`pri_name`,`module_name`,`controller_name`,`action_name`,`parent_id`)
VALUES
('商品模块','','','',0),
('权限模块','','','',0),
('会员模块','','','',0);

--二级权限
INSERT INTO `p39_privilege`
(`pri_name`,`module_name`,`controller_name`,`action_name`,`parent_id`)
VALUES
('商品管理','Admin','Goods','lst',1),
('品牌管理','Admin','Brand','lst',1),
('分类管理','Admin','Category','lst',1),
('类型管理','Admin','Type','lst',1),

('权限管理','Admin','Privilege','lst',2),
('角色管理','Admin','Role','lst',2),
('管理员管理','Admin','Admin','lst',2),

('级别管理','Admin','MemberLevel','lst',3);

--三级权限
INSERT INTO `p39_privilege`
(`pri_name`,`module_name`,`controller_name`,`action_name`,`parent_id`)
VALUES
('商品添加','Admin','Goods','add',4),
('商品修改','Admin','Goods','edit',4),
('商品删除','Admin','Goods','delete',4),

('品牌添加','Admin','Brand','add',5),
('品牌修改','Admin','Brand','edit',5),
('品牌删除','Admin','Brand','delete',5),

('分类添加','Admin','Category','add',6),
('分类修改','Admin','Category','edit',6),
('分类删除','Admin','Category','delete',6),

('类型添加','Admin','Type','add',7),
('类型修改','Admin','Type','edit',7),
('类型删除','Admin','Type','delete',7),

('会员级别添加','Admin','MemberLevel','add',8),
('会员级别修改','Admin','MemberLevel','edit',8),
('会员级别删除','Admin','MemberLevel','delete',8);

INSERT INTO `p39_privilege`
(`pri_name`,`module_name`,`controller_name`,`action_name`,`parent_id`)
VALUES
('权限添加','Admin','Privilege','add',8),
('权限修改','Admin','Privilege','edit',8),
('权限删除','Admin','Privilege','delete',8),

('角色添加','Admin','Role','add',9),
('角色修改','Admin','Role','edit',9),
('角色删除','Admin','Role','delete',9),

('管理员添加','Admin','Admin','add',10),
('管理员修改','Admin','Admin','edit',10),
('管理员删除','Admin','Admin','delete',10);

--四级权限
INSERT INTO `p39_privilege`
(`pri_name`,`module_name`,`controller_name`,`action_name`,`parent_id`)
VALUES
('商品添加','Admin','Goods','add',4),
('商品修改','Admin','Goods','edit',4),
('商品删除','Admin','Goods','delete',4);