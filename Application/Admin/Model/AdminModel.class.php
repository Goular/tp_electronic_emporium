<?php
namespace Admin\Model;

use Think\Model;

//角色模型
class AdminModel extends Model
{
    protected $insertFields = array('username', 'password', 'cpassword', 'chkcode');
    protected $updateFields = array('id', 'username', 'password', 'cpassword');
    protected $_validate = array(
        array('username', 'require', '用户名不能为空！', 1, 'regex', 3),
        array('username', '1,30', '用户名的值最长不能超过 30 个字符！', 1, 'length', 3),
        // 第六个参数：规则什么时候生效： 1：添加时生效 2：修改时生效 3：所有情况都生效
        array('password', 'require', '密码不能为空！', 1, 'regex', 1),
        array('cpassword', 'password', '两次密码输入不一致！', 1, 'confirm', 3),
        array('username', '', '用户名已经存在！', 1, 'unique', 3)
    );

}