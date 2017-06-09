<?php
namespace Admin\Controller;

use Think\Controller;

//商品库存量控制器
class GoodsNumberController extends Controller
{
    public function lst()
    {
        //获取接收商品的ID
        $goodsId = I('get.id');
        //根据商品ID取出商品所有可选的属性的值
        $gaModel = D('goods_attr');
        $gaData = $gaModel
            ->alias("a")
            ->join("LEFT JOIN __ATTRIBUTE__ b ON a.attr_id=b.id")
            ->where(array('a.goods_id' => array('eq', $goodsId)))
            ->select();

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