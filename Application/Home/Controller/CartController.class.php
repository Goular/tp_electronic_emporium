<?php

namespace Home\Controller;

class CartController extends NavController
{
    public function add()
    {
        if (IS_POST) {
            $cartModel = D('Cart');
            if ($cartModel->create(I('post.'), 1)) {
                if ($cartModel->add()) {
                    $this->success('添加成功!', U('lst'));
                    exit;
                }
            }
            $this->error('添加失败，原因：' . $cartModel->getError());
        }
    }


    //购物车列表
    public function lst()
    {
        $cartModel = D('cart');
        $data = $cartModel->cartList();
        //设置页面信息的页面
        $this->assign(array(
            'data' => $data,
            '_page_title' => '购物车列表',
            '_page_keywords' => '购物车列表',
            '_page_description' => '购物车列表',
        ));
        $this->display();
    }

    //ajax获取购物城列表
    public function ajaxCartList()
    {
        $cartModel = D('Cart');
        $data = $cartModel->cartList();
        return json_encode($data);
    }
}