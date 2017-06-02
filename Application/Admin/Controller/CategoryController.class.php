<?php
namespace Admin\Controller;

use Think\Controller;
use Think\Model;

class CategoryController extends Controller
{
    /**
     * 添加商品分类
     */
    public function add()
    {
        $model = D('Category');
        if (IS_POST) {
            if ($model->create(I('post.'), Model::MODEL_INSERT)) {
                if ($model->add()) {
                    $this->success('添加商品分类成功!', U('lst'));
                    exit;
                }
            }
            $this->error($model->getError());
        }

        //获取当前所有的分类
        $catDatas = $model->getChildren();

        // 设置页面信息
        $this->assign(array(
            'catData' => $catDatas,
            '_page_title' => '分类添加',
            '_page_btn_name' => '分类列表',
            '_page_btn_link' => U('lst'),
        ));
        $this->display();
    }

    /**
     * 编辑商品分类
     */
    public function edit()
    {
        $id = I('get.id');
        $model = D('Category');
        if (IS_POST) {
            if ($model->create(I('p.'), 2)) {
                if ($model->save()) {
                    $this->success('修改成功!');
                }
            }
            $this->error($model->getError());
        }

        //获取全部分类的资料
        $catDatas = $model->getChildren();

        //获取指定ID的分类的内容(一个内容即可)
        $catObj = $model->where(array('id' => array('eq', $id)))->find();

        // 设置页面信息
        $this->assign(array(
            'catObj' => $catObj,
            'catData' => $catDatas,
            '_page_title' => '分类修改',
            '_page_btn_name' => '分类列表',
            '_page_btn_link' => U('lst'),
        ));
        $this->display();
    }

    /**
     * 获取商品分类的列表
     */
    public function lst()
    {
        //获取排序好的队列
        $cgModel = D('Category');
        $ret = $cgModel->getChildren();
        // 设置页面信息
        $this->assign(array(
            'data' => $ret,
            '_page_title' => '分类列表',
            '_page_btn_name' => '添加分类',
            '_page_btn_link' => U('add'),
        ));
        $this->display();
    }

    /**
     * 删除商品分类
     */
    public function delete()
    {
        $cgModel = D('Category');
        if (FALSE !== $cgModel->delete(I('get.id')))
            $this->success('删除成功', U('lst'));
        else
            $this->error('删除成功!原因:' . $cgModel->getError());
    }
}