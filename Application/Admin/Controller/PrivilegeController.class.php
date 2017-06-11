<?php
namespace Admin\Controller;

use Think\Controller;

//权限的控制器
class PrivilegeController extends Controller
{
    public function add(){
        // 设置页面中的信息
        $this->assign(array(
            '_page_title' => '权限添加',
            '_page_btn_name' => '权限列表',
            '_page_btn_link' => U('lst'),
        ));
        $this->display();
    }

    public function edit(){
        // 设置页面中的信息
        $this->assign(array(
            '_page_title' => '权限编辑',
            '_page_btn_name' => '权限列表',
            '_page_btn_link' => U('lst'),
        ));
        $this->display();
    }

    public function lst(){
        // 设置页面中的信息
        $this->assign(array(
            '_page_title' => '权限列表',
            '_page_btn_name' => '权限添加',
            '_page_btn_link' => U('add'),
        ));
        $this->display();
    }
}