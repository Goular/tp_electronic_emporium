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

    /**
     * 在更新之前操作的内容
     * @param $data
     * @param $options
     */
    protected function _before_update(&$data, $options)
    {
        $id = $options['where']['id'];
        /********************处理会员价格********************/
        $mp = I('post.member_price');
        $mpModel = D('member_price');
        //先删除原来的价格
        $mpModel->where(array(
            'goods_id' => array('eq', $id)
        ))->delete();
        foreach ($mp as $key => $value) {
            $_v = (float)$value;
            if ($_v > 0) {
                $mpModel->add(array(
                    'price' => $_v,
                    'level_id' => $key,
                    'goods_id' => $id
                ));
            }
        }
    }


}