<?php
namespace Admin\Controller;

use Think\Controller;

class CategoryController extends Controller
{
    /**
     * 获取商品分类的列表
     */
    public function lst()
    {
        //获取排序好的队列
        $cgModel = D('Category');
        $ret = $cgModel->getChildren();
        // 设置页面信息
        $this->assign(array(
            'data' => $ret,
            '_page_title' => '分类列表',
            '_page_btn_name' => '添加分类',
            '_page_btn_link' => U('add'),
        ));
        $this->display();
    }

    /**
     * 添加商品分类
     */
    public function add()
    {
        // 设置页面信息
        $this->assign(array(
            '_page_title' => '分类添加',
            '_page_btn_name' => '分类列表',
            '_page_btn_link' => U('lst'),
        ));
        $this->display();
    }

    /**
     * 编辑商品分类
     */
    public function edit()
    {
        // 设置页面信息
        $this->assign(array(
            '_page_title' => '分类修改',
            '_page_btn_name' => '分类列表',
            '_page_btn_link' => U('lst'),
        ));
        $this->display();
    }

    /**
     * 删除商品分类
     */
    public function delete()
    {

    }
}