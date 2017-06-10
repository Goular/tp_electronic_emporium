<?php
namespace Admin\Controller;

use Think\Controller;

//商品库存量控制器
class GoodsNumberController extends Controller
{
    public function lst()
    {
        //获取接收的商品ID
        $id = I('get.id');
        $gnModel = D('goods_number');

        //处理表单
        if (IS_POST) {
        }

        //根据商品ID取出商品所有可选的属性的值
        $gaModel = D('goods_attr');
        $gaData = $gaModel
            ->alias("a")
            ->join("LEFT JOIN __ATTRIBUTE__ b ON a.attr_id=b.id")
            ->where(array(
                'a.goods_id' => array('eq', $id),
                'b.attr_type' => array('eq', '可选')
            ))
            ->select();
        // 处理这个二维数组：转化成三维：把属性相同的放到一起
        $_gaData = array();
        foreach ($gaData as $k => $v) {
            $_gaData[$v['attr_name']][] = $v;
        }

        // 先取出这件商品已经设置过的库存量
        $gnData = $gnModel->where(array(
            'goods_id' => $id,
        ))->select();

        //formatVarDump($_gaData);

        $this->assign(array(
            'gaData' => $gaData,
        ));

        // 设置页面信息
        $this->assign(array(
            '_page_title' => '库存量',
            '_page_btn_name' => '返回列表',
            '_page_btn_link' => U('lst'),
        ));

        $this->display();
    }
}