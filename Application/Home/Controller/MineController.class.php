<?php
namespace Home\Controller;

class MineController extends NavController
{
    public function __construct()
    {
        parent::__construct();
        $memberId = session('m_id');
        if (!$memberId) {
            session('returnUrl', U('Mine/' . ACTION_NAME));
            $this->redirect(U('Member/login'));
        }
    }

    public function order()
    {
        $orderModel = D('Admin/Order');
        $data = $orderModel->search();
        //设置页面信息
        $this->assign(array(
            'data' => $data,
            '_page_title' => '个人中心-我的定单'
        ));
        $this->display();
    }
}
