<?php

namespace Admin\Controller;

use Think\Controller;

class GoodsController extends Controller
{
    /**
     * 添加商品
     */
    public function add()
    {
        $this->display();
    }

    /**
     * 商品列表 由于php自带list方法用于数组读取，所以不能使用list()
     */
    public function lst()
    {
        $this->display();
    }
}