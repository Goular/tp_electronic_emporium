<?php
namespace Admin\Controller;

use Think\Controller;

//角色控制器
class RoleController extends Controller
{
    //商品分类添加
    public function add()
    {
        $model = D('role');
        if (IS_POST) {
            if ($model->create(I('post.'), 1)) {
                if ($model->add()) {
                    $this->success('添加成功!', 'lst');
                    exit;
                }
            }
            $error = $model->getError();
            $this->error($error);
        }
        //获取所有的权限
        $priModel = D('privilege');
        $priData = $priModel->getChildren();

        $this->assign(array(
            'priData' => $priData,

            '_page_title' => '角色添加',
            '_page_btn_name' => '角色列表',
            '_page_btn_link' => U('lst'),
        ));
        $this->display();
    }

    //商品分类添加
    public function edit()
    {
        $id = I('get.id');
        $model = D('role');
        if (IS_POST) {
            if ($model->create(I('post.'), 2)) {
                if ($model->save() !== FALSE) {
                    $this->success('修改成功!', U('lst', array('p' => I('get.p', 1))));
                    exit;
                }
            }
            $error = $model->getError();
            $this->error($error);
        }

        //获取指定ID的资料
        $data = $model->where(array('id' => array("eq", $id)))->find();

        $this->assign(array(
            'data' => $data,
            '_page_title' => '类型编辑',
            '_page_btn_name' => '类型列表',
            '_page_btn_link' => U('lst'),
        ));
        $this->display();
    }

    //分类删除
    public function delete()
    {
        $model = D('role');
        if ($model->delete(I('get.id')) !== FALSE)
            $this->success('删除成功！', U('lst'));
        else
            $this->error('删除失败！原因：' . $model->getError());
    }

    //商品列表
    public function lst()
    {
        $model = D('role');



        // 设置页面中的信息
        $this->assign(array(
            '_page_title' => '类型列表',
            '_page_btn_name' => '添加类型',
            '_page_btn_link' => U('add'),
        ));
        $this->display();
    }
}