<?php
namespace Admin\Controller;

use Think\Controller;

//商品属性控制器
class GoodsAttrController extends Controller
{
    //处理删除属性
    public function ajaxDelAttr()
    {
        $goodsId = addslashes(I('get.goods_id'));
        $gaid = addslashes(I('get.gaid'));
        $gaModel = D('goods_attr');
        $gaModel->delete($gaid);
        // 删除相关库存量数据
        $gnModel = D('goods_number'); //商品库存量
        $gnModel->where(array('goods_id' => array('EXP', "=$goodsId or AND FIND_IN_SET($gaid, attr_list)"),
        ))->delete();
    }
}