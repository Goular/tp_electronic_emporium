<?php
namespace Admin\Model;

use Think\Model;

class CartModel extends Model
{
    // 加入购物车时允许接收的字段
    protected $insertFields = 'goods_id,goods_attr_id,goods_number';
    // 加入购物车时的表单验证规则
    protected $_validate = array(
        array('goods_id', 'require', '必须选择商品', 1),
        array('goods_number', 'chkGoodsNumber', '库存量不足！', 1, 'callback'),
    );

    //检查库存量
    public function chkGoodsNumber($goodsNumber)
    {
        // 选择的商品属性id
        $gaid = I('post.goods_attr_id');
        sort($gaid, SORT_NUMERIC);
        $gaid = (string)implode(',', $gaid);
        // 取出库存量
        $gnModel = D('goods_number');
        $gn = $gnModel->field('goods_number')->where(array(
            'goods_id' => I('post.goods_id'),
            'goods_attr_id' => $gaid,
        ))->find();
        // 返回库存量是否够
        return ($gn['goods_number'] >= $goodsNumber);
    }
}