<?php
namespace Admin\Model;

use Think\Model;

class MemberPriceModel extends Model
{
    //获取指定商品的价格资料
    public function goodsIdPrices($goodsId)
    {
        $where = array();
        $where['goods_id'] = array('eq', $goodsId);
        return $this->where($where)->select();
    }
}