<?php
namespace Admin\Controller;

use Think\Controller;

//商品库存量控制器
class GoodsNumberController extends BaseController
{
    public function lst()
    {
        // 接收商品ID
        $id = I('get.id');
        $gnModel = D('goods_number');

        // 处理表单
        if (IS_POST) {
            // 先删除原库存
            $gnModel->where(array(
                'goods_id' => array('eq', $id),
            ))->delete();
            //var_dump($_POST);die;
            $gaid = I('post.goods_attr_id');
            $gn = I('post.goods_number');
            // 先计算商品属性ID和库存量的比例
            $gaidCount = count($gaid);
            $gnCount = count($gn);
            $rate = $gaidCount / $gnCount;
            // 循环库存量
            $_i = 0;  // 取第几个商品属性ID
            foreach ($gn as $k => $v) {
                $_goodsAttrId = array();  // 把下面取出来的ID放这里
                // 后来从商品属性ID数组中取出 $rate 个，循环一次取一个
                for ($i = 0; $i < $rate; $i++) {
                    $_goodsAttrId[] = $gaid[$_i];
                    $_i++;
                }
                // 先升序排列
                sort($_goodsAttrId, SORT_NUMERIC);  // 以数字的形式排序
                // 把取出来的商品属性ID转化成字符串
                $_goodsAttrId = (string)implode(',', $_goodsAttrId);
                $gnModel->add(array(
                    'goods_id' => $id,
                    'goods_attr_id' => $_goodsAttrId,
                    'goods_number' => $v,
                ));
            }
            $this->success('设置成功！', U('lst?id=' . I('get.id')));
            exit;
        }

        // 根据商品ID取出这件商品所有可选属性的值
        $gaModel = D('goods_attr');
        $gaData = $gaModel->alias('a')
            ->field('a.*,b.attr_name')
            ->join('LEFT JOIN __ATTRIBUTE__ b ON a.attr_id=b.id')
            ->where(array(
                'a.goods_id' => array('eq', $id),
                'b.attr_type' => array('eq', '可选'),
            ))->select();
        // 处理这个二维数组：转化成三维：把属性相同的放到一起
        $_gaData = array();
        foreach ($gaData as $k => $v) {
            $_gaData[$v['attr_name']][] = $v;
        }

        // 先取出这件商品已经设置过的库存量
        $gnData = $gnModel->where(array(
            'goods_id' => $id,
        ))->select();
        //var_dump($gnData);

        $this->assign(array(
            'gaData' => $_gaData,
            'gnData' => $gnData,
        ));

        // 设置页面信息
        $this->assign(array(
            '_page_title' => '库存量',
            '_page_btn_name' => '返回列表',
            '_page_btn_link' => U('lst'),
        ));
        // 1.显示表单
        $this->display();
    }
}