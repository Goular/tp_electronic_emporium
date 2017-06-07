<?php
namespace Admin\Controller;

use Think\Controller;

class TypeController extends Controller
{
    //商品分类添加
    public function add()
    {
        $model = D('type');
        if (IS_POST) {
            if ($model->create(I('post.'), 1)) {
                if ($model->add()) {
                    $this->success('商品分类添加成功!', 'lst');
                    exit;
                }
            }
            $error = $model->getError();
            $this->error($error);
        }
        $this->assign(array(
            '_page_title' => '类型添加',
            '_page_btn_name' => '类型列表',
            '_page_btn_link' => U('lst'),
        ));
        $this->display();
    }

    //商品分类添加
    public function edit()
    {
        $id = I('get.id');
        $model = D('type');
        if (IS_POST) {
            if ($model->create(I('post.'), 2)) {
                if ($model->add()) {
                    $this->success('商品分类修改成功!', 'lst');
                    exit;
                }
            }
            $error = $model->getError();
            $this->error($error);
        }
        $this->assign(array(
            '_page_title' => '类型编辑',
            '_page_btn_name' => '类型列表',
            '_page_btn_link' => U('lst'),
        ));
        $this->display();
    }

    //商品列表
    public function lst()
    {
        $model = D('type');
        $data = $model->search();
        $this->assign(array(
            'data' => $data['data'],
            'page' => $data['page'],
            '_page_title' => '类型列表',
            '_page_btn_name' => '添加类型',
            '_page_btn_link' => U('add'),
        ));
        $this->display();
    }
}