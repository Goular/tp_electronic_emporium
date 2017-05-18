<?php
namespace Admin\Model;

use Think\Model;

class GoodsModel extends Model
{
    // 添加时调用create方法允许接收的字段(用于校验，但是是没有主键ID的，因为并没有插入到数据库中)
    protected $insertFields = array("goods_name", "market_price", "shop_price", "is_on_sale", "goods_desc");

    //定义验证的规则
    protected $_validate = array(
        array('goods_name', 'require', '商品名称不能为空！', self::MODEL_INSERT),
        array('market_price', 'currency', '市场价格必须是货币类型！', 1),
        array('shop_price', 'currency', '本店价格必须是货币类型！', 1)
    );

    // 这个方法在添加之前会自动被调用 --》 钩子方法
    // 第一个参数：表单中即将要插入到数据库中的数据->数组
    // &按引用传递：函数内部要修改函数外部传进来的变量必须按钮引用传递，除非传递的是一个对象,因为对象默认是按引用传递的
    protected function _before_insert(&$data, $options)
    {
        /**************** 处理LOGO *******************/
        // 判断有没有选择图片
        var_dump($data);
        var_dump($options);
        exit();
    }

}