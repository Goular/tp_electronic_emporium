<?php
namespace Home\Controller;

use Think\Controller;

//添加API的控制器
class AddressController extends Controller
{
    public function lst(){
        // 设置页面信息
        $this->assign(array(
            '_page_title' => '收货地址管理页',
            '_page_keywords' => '收货地址管理页',
            '_page_description' => '收货地址管理页',
        ));
        $this->display();
    }
}