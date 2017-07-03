<?php
namespace Home\Controller;

use Think\Controller;

class MemberController extends Controller
{
    //制作二维码
    public function chkCode()
    {
        $Verify = new \Think\Verify(array(
            'fontSize' => 30,    // 验证码字体大小
            'length' => 2,     // 验证码位数
            'useNoise' => false, // 关闭验证码杂点
        ));
        $Verify->entry();
    }

    //登录操作
    public function login()
    {
        if (IS_POST) {
            $model = D('Admin/Member');
            if ($model->validate($model->_login_validate)->create()) {

                //formatVarDump(I('post.'));


                if ($model->login()) {

                    $this->success('登录成功');
                    exit;
                }
            }
            $this->error($model->getError());
        }
        // 设置页面信息
        $this->assign(array(
            '_page_title' => '登录',
            '_page_keywords' => '登录',
            '_page_description' => '登录',
        ));
        $this->display();
    }

    //登出操作
    public function logout()
    {
        $model = D('Admin/Member');
        $model->logout();
        redirect('/');
    }

    //注册操作
    public function register()
    {
        if (IS_POST) {
            $model = D('Admin/Member');
            if ($model->create(I('post.'), 1)) {
                if ($model->add()) {
                    $this->success('注册成功!', U('login'));
                    exit;
                }
            }
            $this->error($model->getError());
        }
        // 设置页面信息
        $this->assign(array(
            '_page_title' => '注册',
            '_page_keywords' => '注册',
            '_page_description' => '注册',
        ));
        $this->display();
    }
}