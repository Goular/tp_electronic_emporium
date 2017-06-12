<?php
namespace Admin\Controller;

use Think\Controller;

class LoginController extends BaseController
{
    //登录的Action
    public function login()
    {
        if (IS_POST) {
            $model = D('Admin');
            //接收表单并且验证表单[这里就进行了验证码操作]
            if ($model->validate($model->_login_validate)->create()) {
                if ($model->login()) {
                    $this->success('登录成功!', U('Index/index'));
                    exit();
                }
            }
            $this->error($model->getError());
        }
        $this->display();
    }

    //登出的Action
    public function logout()
    {
        $model = D('Admin');
        $model->logout();
        redirect('login');
    }

    //验证码的创建
    public function chkcode()
    {
        $config = array(
            'fontSize' => 30,    // 验证码字体大小
            'length' => 4,     // 验证码位数
            'useNoise' => false, // 关闭验证码杂点
        );
        $Verify = new \Think\Verify($config);
        $Verify->entry();
    }
}