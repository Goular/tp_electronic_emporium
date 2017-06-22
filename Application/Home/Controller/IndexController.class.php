<?php
namespace Home\Controller;

class IndexController extends NavController
{
    /**
     * 网站首页的内容
     */
    public function index()
    {
        $this->assign(array(
            '_show_nav' => 0,
            '_page_title' => '首页',
            '_page_keywords' => '首页',
            '_page_description' => '首页',
        ));
        $this->display();
    }

    /**
     * 商品详情页
     */
    public function goods()
    {
        $this->assign(array(
            '_page_title' => '商品详情页',
            '_page_keywords' => '商品详情页',
            '_page_description' => '商品详情页',
        ));
        $this->display();
    }
}