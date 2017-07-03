<?php
namespace Admin\Model;

use Think\Model;

class GoodsModel extends Model
{
    protected $insertFields = array('username', 'password', 'cpassword', 'chkcode', 'must_click');
    protected $updateFields = array('id', 'username', 'password', 'cpassword');
    protected $_validate = array(
        array('must_click', 'require', '必须同意注册协议！', 1, 'regex', 3),
        array('username', 'require', '用户名不能为空！', 1, 'regex', 3),
        array('username', '1,30', '用户名的值最长不能超过 30 个字符！', 1, 'length', 3),
        array('password', 'require', '密码不能为空！', 1, 'regex', 1),
        array('password', '6,20', '密码的值最长不能超过 6-20 个字符！', 1, 'length', 3),
        array('cpassword', 'password', '两次密码输入不一致！', 1, 'confirm', 3),
        array('username', '', '用户名已经存在！', 1, 'unique', 3),
        array('chkcode', 'require', '验证码不能为空！', 1),
        array('chkcode', 'check_verify', '验证码不正确！', 1, 'callback'),
    );

    // 为登录的表单定义一个验证规则
    public $_login_validate = array(
        array('username', 'require', '用户名不能为空！', 1),
        array('password', 'require', '密码不能为空！', 1),
        array('chkcode', 'require', '验证码不能为空！', 1),
        array('chkcode', 'check_verify', '验证码不正确！', 1, 'callback'),
    );

    public function check_verify($code, $id = '')
    {
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }

    /**
     * 登录操作
     */
    public function login()
    {

    }

    /**
     * 登出操作
     */
    public function logout()
    {
        session(null);
    }

    /**************************  钩子方法  ***************************/
    protected function _before_insert(&$data, $options)
    {
        $data['password'] = md5($data['password']);
    }
}