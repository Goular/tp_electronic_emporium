<?php

namespace Admin\Controller;

use Think\Controller;

class GoodsController extends Controller
{
    /**
     * 添加商品,显示并添加处理
     */
    public function add()
    {
        //判断是否提交了表单
        if (IS_POST) {
            $model = D('goods');
            /**
             * CREATE方法：a. 接收数据并保存到模型中 b.根据模型中定义的规则验证表单
             *
             * 第一个参数：要接收的数据默认是$_POST
             * 第二个参数：表单的类型。当前是添加还是修改的表单,1：添加 2：修改
             * $_POST：表单中原始的数据 ，I('post.')：过滤之后的$_POST的数据，过滤XSS攻击
             */
            if ($model->create(I('post.'), 1)) {
                //创建并校验后添加到数据库中
                // 在add()里又先调用了_before_insert方法,用于添加addTime字段
                if ($model->add()) { //添加成功后，转跳到页面并结束后面的操作
                    $this->success('操作成功!', U('lst')); //U方法为创建URL的访问内容
                    exit();
                }
            }
            // 如果走到 这说明上面失败了在这里处理失败的请求
            // 从模型中取出失败的原因
            $error = $model->getError();
            // 由控制器显示错误信息,并在3秒跳回上一个页面
            $this->error($error);
        }

        //获取所有的品牌
        $brandModel = D('brand');
        //获取品牌数据
        $brandData = $brandModel->select();

        //获取会员级别
        $mLModel = D('member_level');
        $memberLevelData = $mLModel->select();

        // 设置页面信息
        $this->assign(array(
            'mlData' => $memberLevelData,
            'brandData' => $brandData,
            '_page_title' => '修改添加',
            '_page_btn_name' => '商品列表',
            '_page_btn_link' => U('lst'),
        ));

        //显示表单
        $this->display();
    }

    /**
     * 商品修改
     */
    public function edit()
    {
        $id = I('get.id');  // 要修改的商品的ID
        $model = D('goods');
        if (IS_POST) {
            if ($model->create(I('post.'), 2)) {
                if (FALSE !== $model->save())  // save()的返回值是，如果失败返回false,如果成功返回受影响的条数【如果修改后和修改前相同就会返回0】
                {
                    $this->success('操作成功！', U('lst'));
                    exit;
                }
            }
            $error = $model->getError();
            $this->error($error);
        }
        // 根据ID取出要修改的商品的原信息
        $data = $model->find($id);
        $this->assign('data', $data);

        //获取所有的品牌
        $brandModel = D('brand');
        //获取品牌数据
        $brandData = $brandModel->select();

        //获取会员级别
        $mLModel = D('member_level');
        $memberLevelData = $mLModel->select();

        //获取会员价格
        $mpModel = D('member_price');
        $memberPriceData = $mpModel->goodsIdPrices($id);

        //获取商品图片
        $gpModel = D('goods_pic');
        $goodsPicData = $gpModel->where(array("goods_id" => array('eq', $id)))->select();

        // 设置页面信息
        $this->assign(array(
            'gpData' => $goodsPicData,
            'mpData' => $memberPriceData,
            'mlData' => $memberLevelData,
            'brandData' => $brandData,
            '_page_title' => '修改商品',
            '_page_btn_name' => '商品列表',
            '_page_btn_link' => U('lst'),
        ));
        $this->display();
    }

    /**
     * 商品列表 由于php自带list方法用于数组读取，所以不能使用list()
     */
    public function lst()
    {
        $model = D('goods');//D方法回去寻找class文件并创建对象
        //返回数据和翻页
        $data = $model->search();
        $this->assign(array(
            'listData' => $data['data'],
            'page' => $data['page']
        ));

        //获取所有的品牌
        $brandModel = D('brand');
        //获取品牌数据
        $brandData = $brandModel->select();

        // 设置页面信息
        $this->assign(array(
            'brandData' => $brandData,
            '_page_title' => '商品列表',
            '_page_btn_name' => '商品添加',
            '_page_btn_link' => U('add'),
        ));
        $this->display();
    }

    /**
     * 删除商品的内容
     */
    public function delete()
    {
        $model = D('goods');
        if (FALSE !== $model->delete(I('get.id')))
            $this->success('删除成功！', U('lst'));
        else
            $this->error('删除失败！原因：' . $model->getError());
    }

    /**
     * 删除指定商品的指定图片
     */
    public function deleteImg()
    {
        $id = I('get.picid');
        $gpModel = D('goods_pic');
        $ret = $gpModel->where(array('id' => array("eq", $id)))->delete();
        if ($ret) {
            echo "删除成功!";
        } else {
            echo "删除失败!";
        }
    }
}