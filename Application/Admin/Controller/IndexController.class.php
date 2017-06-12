<?php
/**
 * 后台首页控制器
 */
namespace Admin\Controller;

use Think\Controller;

class IndexController extends BaseController
{
    public function index()
    {
        $this->display();
    }

    public function top()
    {
        $this->display();
    }

    public function menu()
    {
        $priModel = D('privilege');
        $ownerShipAccessActions = $priModel->ownerShipAccessMenu();
        $this->assign(array(
            'menu' => $ownerShipAccessActions
        ));
        $this->display();
    }

    public function main()
    {
        $this->display();
    }
}