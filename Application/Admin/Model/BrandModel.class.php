<?php
namespace Admin\Model;

use Think\Image;
use Think\Model;

class GoodsModel extends Model
{
    // 添加时调用create方法允许接收的字段
    protected $insertFields = '';
    // 修改时调用create方法允许接收的字段
    protected $updateFields = 'id,';

    //定义验证规则
    protected $_validate = array(
        array('goods_name', 'require', '商品名称不能为空！', 1),
        array('market_price', 'currency', '市场价格必须是货币类型！', 1),
        array('shop_price', 'currency', '本店价格必须是货币类型！', 1),
    );

    // 这个方法在添加之前会自动被调用 --》 钩子方法
    // 第一个参数：表单中即将要插入到数据库中的数据->数组
    // &按引用传递：函数内部要修改函数外部传进来的变量必须按钮引用传递，除非传递的是一个对象,因为对象默认是按引用传递的
    protected function _before_insert(&$data, $options)
    {

    }

    // 这个方法在更新操作之前会自动被调用 --》 钩子方法
    protected function _before_update(&$data, $options)
    {

    }

    //这个方法在删除操作之前会自动被调用 --》 钩子方法
    protected function _before_delete($options)
    {

    }


    /**
     * 搜索商品内容，可以实现翻页，搜索和排序的操作
     */
    public function search($perPage = 3)
    {
        C('SHOW_PAGE_TRACE', true);

    }
}