<?php
namespace Admin\Model;

use Think\Model;

//角色模型
class PrivilegeModel extends Model
{
    protected $insertFields = array('pri_name', 'module_name', 'controller_name', 'action_name', 'parent_id');
    protected $updateFields = array('id', 'pri_name', 'module_name', 'controller_name', 'action_name', 'parent_id');
    protected $_validate = array(
        array('pri_name', 'require', '权限名称不能为空！', 1, 'regex', 3),
        array('pri_name', '1,30', '权限名称的值最长不能超过 30 个字符！', 1, 'length', 3),
        array('module_name', '1,30', '模块名称的值最长不能超过 30 个字符！', 2, 'length', 3),
        array('controller_name', '1,30', '控制器名称的值最长不能超过 30 个字符！', 2, 'length', 3),
        array('action_name', '1,30', '方法名称的值最长不能超过 30 个字符！', 2, 'length', 3),
        array('parent_id', 'number', '上级权限Id必须是一个整数！', 2, 'regex', 3),
    );
}