<?php
namespace Home\Controller;

use Common\Helper\FileCache;
use Think\Controller;

//添加API的控制器
class ApiController extends Controller
{
    public function test01()
    {
        $data = array(
            'id' => 1,
            'name' => 'singwa',
            'type' => array(4, 5, 6),
            'test' => array(1, 45, 67 => array(123, 'tsysa'))
        );
        \Common\Helper\ApiResponse::show(200, 'success', $data);
    }

    public function test02()
    {
        $data = array(
            'id' => 1,
            'name' => 'singwa',
            'type' => array(4, 5, 6),
            'test' => array(1, 45, 67 => array(123, 'tsysa'))
        );
        $file = new FileCache();
        $file->cacheData('test01', $data, 1600);
    }
}