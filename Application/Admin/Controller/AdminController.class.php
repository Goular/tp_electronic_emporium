<?php
namespace Admin\Controller;

use Think\Controller;

//管理员控制器
class AdminController extends BaseController
{
    //商品分类添加
    public function add()
    {
        if(IS_POST)
        {
            $model = D('Admin');
            if($model->create(I('post.'), 1))
            {
                if($id = $model->add())
                {
                    $this->success('添加成功！', U('lst?p='.I('get.p')));
                    exit;
                }
            }
            $this->error($model->getError());
        }

        $roleModel = D('Role');
        $roleData = $roleModel->select();

        // 设置页面中的信息
        $this->assign(array(
            'roleData' => $roleData,
            '_page_title' => '添加管理员',
            '_page_btn_name' => '管理员列表',
            '_page_btn_link' => U('lst'),
        ));
        $this->display();
    }

    //商品分类添加
    public function edit()
    {
        $id = I('get.id');
        if(IS_POST)
        {
            $model = D('Admin');
            if($model->create(I('post.'), 2))
            {
                if($model->save() !== FALSE)
                {
                    $this->success('修改成功！', U('lst', array('p' => I('get.p', 1))));
                    exit;
                }
            }
            $this->error($model->getError());
        }
        $model = M('Admin');
        $data = $model->find($id);
        $this->assign('data', $data);

        $roleModel = D('Role');
        $roleData = $roleModel->select();
        // 取出当前管理员所在的角色ID
        $arModel = D('admin_role');
        $roleId = $arModel->field('GROUP_CONCAT(role_id) role_id')->where(array(
            'admin_id' => array('eq', $id),
        ))->find();

        // 设置页面中的信息
        $this->assign(array(
            'roleId' => $roleId['role_id'],
            'roleData' => $roleData,
            '_page_title' => '修改管理员',
            '_page_btn_name' => '管理员列表',
            '_page_btn_link' => U('lst'),
        ));
        $this->display();
    }

    //分类删除
    public function delete()
    {
        $model = D('admin');
        if ($model->delete(I('get.id')) !== FALSE)
            $this->success('删除成功！', U('lst'));
        else
            $this->error('删除失败！原因：' . $model->getError());
    }

    //商品列表
    public function lst()
    {
        $model = D('admin');
        $data = $model->search();
        $this->assign(array(
            'data' => $data['data'],
            'page' => $data['page'],
        ));

        // 设置页面中的信息
        $this->assign(array(
            '_page_title' => '类型列表',
            '_page_btn_name' => '添加类型',
            '_page_btn_link' => U('add'),
        ));
        $this->display();
    }
}