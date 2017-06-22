<?php
namespace Home\Controller;

use Think\Controller;

/**
 * 导航条的资料的获取
 * Class IndexController
 * @package Home\Controller
 */
class NavController extends Controller
{
    /**
     * 构造方法
     */
    public function __construct()
    {
        parent::__construct();
        $catModel = D('Admin/Category');
        //获取导航分类的数据
        $catData = $catModel->getNavData();
        $this->assign('catData', $catData);
    }
}