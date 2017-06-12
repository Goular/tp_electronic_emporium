<?php
namespace Admin\Controller;

use Think\Controller;

//商品属性控制器
class AttributeController extends BaseController
{
    //商品属性添加
    public function add()
    {
        $model = D('attribute');
        if (IS_POST) {
            if ($model->create(I('post.'), 1)) {
                if ($model->add()) {
                    $this->success('添加成功!', U('lst', array('type_id' => I('get.type_id'))));
                    exit;
                }
            }
            $error = $model->getError();
            $this->error($error);
        }
        $this->assign(array(
            '_page_title' => '类型添加',
            '_page_btn_name' => '类型列表',
            '_page_btn_link' => U('lst', array('type_id' => I('get.type_id'))),
        ));
        $this->display();
    }

    //商品属性添加
    public function edit()
    {
        $id = I('get.id');
        $model = D('attribute');
        if (IS_POST) {
            if ($model->create(I('post.'), 2)) {
                if ($model->save() !== FALSE) {
                    $this->success('修改成功!', U('lst', array('type_id' => I('get.type_id'))));
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
            '_page_btn_link' => U('lst', array('type_id' => I('get.type_id'))),
        ));
        $this->display();
    }

    //属性删除
    public function delete()
    {
        $model = D('attribute');
        if ($model->delete(I('get.id')) !== FALSE)
            $this->success('删除成功！', U('lst', array('type_id' => I('get.type_id'))));
        else
            $this->error('删除失败！原因：' . $model->getError());
    }

    //属性列表
    public function lst()
    {
        $model = D('attribute');
        $data = $model->search();
        $this->assign(array(
            'data' => $data['data'],
            'page' => $data['page'],
        ));

        // 设置页面中的信息
        $this->assign(array(
            '_page_title' => '类型列表',
            '_page_btn_name' => '添加类型',
            '_page_btn_link' => U('add', array('type_id' => I('get.type_id'))),
        ));
        $this->display();
    }

    //属性列表查询
    public function ajaxGetAttr()
    {
        $typeId = I('get.type_id');
        // 根据ID从硬盘上数据删除中删除图片
        $attrModel = D('Attribute');
        $attrData = $attrModel->where(array('type_id' => array('eq', $typeId)))->select();
        echo json_encode($attrData);
    }
}