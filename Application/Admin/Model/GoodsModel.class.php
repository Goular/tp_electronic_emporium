<?php
namespace Admin\Model;

use Think\Image;
use Think\Model;

class GoodsModel extends Model
{
    // 添加时调用create方法允许接收的字段
    protected $insertFields = 'goods_name,market_price,shop_price,is_on_sale,goods_desc,brand_id';
    // 修改时调用create方法允许接收的字段
    protected $updateFields = 'id,goods_name,market_price,shop_price,is_on_sale,goods_desc,brand_id';

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
        /**************** 处理LOGO *******************/
        // 判断有没有选择图片
        if ($_FILES['logo']['error'] == 0) {
            $ret = uploadOne('logo', 'Goods', array(
                array(700, 700),
                array(350, 350),
                array(130, 130),
                array(50, 50),
            ));
            $data['logo'] = $ret['images'][0];
            $data['mbig_logo'] = $ret['images'][1];
            $data['big_logo'] = $ret['images'][2];
            $data['mid_logo'] = $ret['images'][3];
            $data['sm_logo'] = $ret['images'][4];
        }
        // 获取当前时间并添加到表单中这样就会插入到数据库中
        $data['addtime'] = date('Y-m-d H:i:s', time());
        // 我们自己来过滤这个字段
        $data['goods_desc'] = removeXSS($_POST['goods_desc']);
    }

    // 这个方法在更新操作之前会自动被调用 --》 钩子方法
    protected function _before_update(&$data, $options)
    {
        $id = $options['where']['id'];  // 要修改的商品的ID
        /**************** 处理LOGO *******************/
        // 判断有没有选择图片
        if ($_FILES['logo']['error'] == 0) {
            $ret = uploadOne('logo', 'Goods', array(
                array(700, 700),
                array(350, 350),
                array(130, 130),
                array(50, 50),
            ));
            $data['logo'] = $ret['images'][0];
            $data['mbig_logo'] = $ret['images'][1];
            $data['big_logo'] = $ret['images'][2];
            $data['mid_logo'] = $ret['images'][3];
            $data['sm_logo'] = $ret['images'][4];
            /*************** 删除原来的图片 *******************/
            // 先查询出原来图片的路径
            $oldLogo = $this->field('logo,mbig_logo,big_logo,mid_logo,sm_logo')->find($id);
            deleteImage($oldLogo);
        }

        // 我们自己来过滤这个字段
        $data['goods_desc'] = removeXSS($_POST['goods_desc']);
    }

    protected function _before_delete($options)
    {
        $id = $options['where']['id'];   // 要删除的商品的ID
        /*************** 删除原来的图片 *******************/
        // 先查询出原来图片的路径
        $oldLogo = $this->field('logo,mbig_logo,big_logo,mid_logo,sm_logo')->find($id);
        deleteImage($oldLogo);
    }


    /**
     * 搜索商品内容，可以实现翻页，搜索和排序的操作
     * __WORK__和 __CARD__在最终解析的时候会转换为 think_work和 think_card。
     */
    public function search($perPage = 3)
    {
        C('SHOW_PAGE_TRACE', true);
        /*************** 搜索 ******************/
        $where = array();  // 空的where条件
        // 商品名称
        $gn = I('get.goods_name');
        if ($gn)
            $where['a.goods_name'] = array('like', "%$gn%");  // WHERE goods_name LIKE '%$gn%'
        //商品品牌
        $brand_id = I('get.brand_id');
        if ($brand_id)
            $where['brand_id'] = array('eq', $brand_id);
        // 价格
        $fp = I('get.goods_low_price');
        $tp = I('get.goods_high_price');
        if ($fp && $tp)
            $where['a.shop_price'] = array('between', array($fp, $tp)); // WHERE shop_price BETWEEN $fp AND $tp
        elseif ($fp)
            $where['a.shop_price'] = array('egt', $fp);   // WHERE shop_price >= $fp
        elseif ($tp)
            $where['a.shop_price'] = array('elt', $tp);   // WHERE shop_price <= $fp
        // 是否上架
        $ios = I('get.ios');
        if ($ios)
            $where['a.is_on_sale'] = array('eq', $ios);  // WHERE is_on_sale = $ios
        // 添加时间
        $fa = I('get.goods_add_start_time');
        $ta = I('get.goods_add_end_time');
        if ($fa && $ta)
            $where['a.addtime'] = array('between', array($fa, $ta)); // WHERE shop_price BETWEEN $fp AND $tp
        elseif ($fa)
            $where['a.addtime'] = array('egt', $fa);   // WHERE shop_price >= $fp
        elseif ($ta)
            $where['a.addtime'] = array('elt', $ta);   // WHERE shop_price <= $fp


        /*************** 翻页 ****************/
        // 取出总的记录数
        $count = $this->where($where)->count();
        // 生成翻页类的对象
        $pageObj = new \Think\Page($count, $perPage);
        // 设置样式
        $pageObj->setConfig('next', '下一页');
        $pageObj->setConfig('prev', '上一页');
        $pageObj->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');

        // 生成页面下面显示的上一页、下一页的字符串
        $pageString = $pageObj->show();

        /***************** 排序 *****************/
        $orderby = 'a.id';      // 默认的排序字段
        $orderway = 'desc';   // 默认的排序方式
        $odby = I('get.odby');
        if ($odby) {
            if ($odby == 'id_asc')
                $orderway = 'asc';
            elseif ($odby == 'price_desc')
                $orderby = 'shop_price';
            elseif ($odby == 'price_asc') {
                $orderby = 'shop_price';
                $orderway = 'asc';
            }
        }

        /************** 取某一页的数据 ***************/
        //select a.* , b.brand_name from p39_goods a
        //left join b p39_brand
        //on a.brand_id = b.id
        $data = $this->order("$orderby $orderway")// 排序
        ->field('a.* , b.brand_name')
            ->alias('a')
            ->join('left join __BRAND__ b ON a.brand_id = b.id')//添加join
            ->where($where)// 搜索
            ->limit($pageObj->firstRow . ',' . $pageObj->listRows)// 翻页
            ->select();

        /************** 返回数据 ******************/
        return array(
            'data' => $data,  // 数据
            'page' => $pageString,  // 翻页字符串
        );
    }

    /**
     * 插入之后内容操作
     * @param $data
     * @param $options
     */
    protected function _after_insert($data, $options)
    {
        $mp = I('post.member_price');
        $mpModel = D('member_price');
        foreach ($mp as $k => $v) {
            $_v = (float)$v;
            if ($_v > 0) {
                $mpModel->add(array(
                    'price' => $_v,
                    'level_id' => $k,
                    'goods_id' => $data['id']
                ));
            }
        }
    }


}