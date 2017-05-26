<?php
namespace Admin\Controller;

use Think\Controller;

/**
 * 品牌类的控制器
 * Class BrandController
 * @package Admin\Controller
 */
class BrandController extends Controller
{

    /**
     * 添加品牌资料
     */
    public function add()
    {
       $this->display();
    }

    /**
     * 修改品牌资料
     */
    public function edit()
    {
        $this->display();
    }


    /**
     * 删除品牌资料
     */
    public function delete()
    {
        $this->display();
    }
}