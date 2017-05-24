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
        if(IS_POST)
        {
            if($model->create(I('post.'), 2))
            {
                if(FALSE !== $model->save())  // save()的返回值是，如果失败返回false,如果成功返回受影响的条数【如果修改后和修改前相同就会返回0】
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

        // 设置页面信息
        $this->assign(array(
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
        $this->display();
    }
}