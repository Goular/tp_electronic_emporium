<?php
namespace Admin\Controller;

use Think\Controller;

//权限的控制器
class PrivilegeController extends Controller
{
    public function add()
    {
        $model = D('privilege');
        if (IS_POST) {
            if ($model->create(I('post.'), 1)) {
                if ($model->add()) {
                    $this->success('添加成功!', U('lst'));
                    exit;
                }
            }
            $this->error($model->getError());
        }
        $parentData = $model->getChildren();
        $this->assign(array(
            'parentData' => $parentData
        ));

        // 设置页面中的信息
        $this->assign(array(
            '_page_title' => '权限添加',
            '_page_btn_name' => '权限列表',
            '_page_btn_link' => U('lst'),
        ));
        $this->display();
    }

    public function edit()
    {
        $id = I('get.id');
        $model = D('privilege');
        if (IS_POST) {
            if ($model->create(I('post.'), 2)) {
                if ($model->save()) {
                    $this->success('修改成功!', U('lst'));
                    exit;
                }
            }
            $this->error($model->getError());
        }
        $parentData = $model->getChildren();
        $data = $model->where(array('id' => array('eq', $id)))->find();

        $this->assign(array(
            'data' => $data,
            'parentData' => $parentData
        ));

        // 设置页面中的信息
        $this->assign(array(
            '_page_title' => '权限编辑',
            '_page_btn_name' => '权限列表',
            '_page_btn_link' => U('lst'),
        ));
        $this->display();
    }

    public function lst()
    {
        $model = D('privilege');
        $parentData = $model->getChildren();
        $this->assign(array(
            'data' => $parentData
        ));

        // 设置页面中的信息
        $this->assign(array(
            '_page_title' => '权限列表',
            '_page_btn_name' => '权限添加',
            '_page_btn_link' => U('add'),
        ));
        $this->display();
    }
}