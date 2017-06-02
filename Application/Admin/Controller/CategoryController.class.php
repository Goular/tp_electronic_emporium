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
        $cgModel = D('Category');
        $ret = $cgModel->getChildren(0);
        formatVarDump($ret);
    }

    /**
     * 添加商品分类
     */
    public function add()
    {

    }

    /**
     * 编辑商品分类
     */
    public function edit()
    {

    }

    /**
     * 删除商品分类
     */
    public function delete()
    {

    }
}