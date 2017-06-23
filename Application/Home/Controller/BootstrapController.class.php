<?php
namespace Home\Controller;

use Think\Controller;

/**
 * bootstrap学习的控制器
 * Class IndexController
 * @package Home\Controller
 */
class BootstrapController extends Controller
{
    //使用bootstrap的基本模板
    public function d1Index01(){
        $this->display();
    }

    //首次使用bootstrap，不用管内容
    public function d1Index02(){
        $this->display();
    }
}