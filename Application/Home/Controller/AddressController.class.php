<?php
namespace Home\Controller;

use Think\Controller;

//添加API的控制器
class AddressController extends Controller
{
    public function lst()
    {
        // 设置页面信息
        $this->assign(array(
            '_page_path' => strtolower(__ACTION__),
            '_page_title' => '收货地址管理页',
            '_page_keywords' => '收货地址管理页',
            '_page_description' => '收货地址管理页',
        ));
        $this->display();
    }

    /**
     * 添加地址
     */
    public function aJaxAdd()
    {
        $model = D('member_address');

        $this->ajaxReturn(I('post.'));
        exit();

        if ($model->create(I('post.'))) {
            if ($model->add()) {
                $data = array(
                    'data' => '',
                    'code' => 0,
                    'message' => '添加成功!'
                );
                $this->ajaxReturn($data);
                exit;
            }
        }
    }
}