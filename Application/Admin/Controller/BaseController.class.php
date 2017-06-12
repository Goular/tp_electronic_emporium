<?php
namespace Admin\Controller;

use Think\Controller;

class BaseController extends Controller
{
    public function __construct()
    {
        //必须先调用父类的构造的方法
        parent::__construct();
        //判断是否登录
        if (!session('id')) {
            $this->error('必须先登录!', U('Login/login'));
        }
    }

}