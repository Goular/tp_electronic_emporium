<?php
namespace Admin\Model;

use Think\Cache\Driver\Db;
use Think\Image;
use Think\Model;

class GoodsModel extends Model
{
    // 添加时调用create方法允许接收的字段
    protected $insertFields = 'goods_name,market_price,shop_price,is_on_sale,goods_desc,brand_id,cat_id,type_id,promote_price,promote_start_date,promote_end_date,is_new,is_best,is_hot,sort_num,is_floor';
    // 修改时调用create方法允许接收的字段
    protected $updateFields = 'id,goods_name,market_price,shop_price,is_on_sale,goods_desc,brand_id,cat_id,type_id,promote_price,promote_start_date,promote_end_date,is_new,is_best,is_hot,sort_num,is_floor';

    //定义验证规则
    protected $_validate = array(
        array('goods_name', 'require', '商品名称不能为空！', 1),
        array('market_price', 'currency', '市场价格必须是货币类型！', 1),
        array('shop_price', 'currency', '本店价格必须是货币类型！', 1),
        array('cat_id', 'require', '必须选择主分类!', 1),
        array('brand_id', 'require', '必须选择商品品牌!', 1),
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
            $data['logo'] = $ret['Images'][0];
            $data['mbig_logo'] = $ret['Images'][1];
            $data['big_logo'] = $ret['Images'][2];
            $data['mid_logo'] = $ret['Images'][3];
            $data['sm_logo'] = $ret['Images'][4];
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
            $data['logo'] = $ret['Images'][0];
            $data['mbig_logo'] = $ret['Images'][1];
            $data['big_logo'] = $ret['Images'][2];
            $data['mid_logo'] = $ret['Images'][3];
            $data['sm_logo'] = $ret['Images'][4];
            /*************** 删除原来的图片 *******************/
            // 先查询出原来图片的路径
            $oldLogo = $this->field('logo,mbig_logo,big_logo,mid_logo,sm_logo')->find($id);
            deleteImage($oldLogo);
        }

        // 我们自己来过滤这个字段
        $data['goods_desc'] = removeXSS($_POST['goods_desc']);


        /********************处理商品在各种会员级别定出的价格********************/
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

        /****************************** 添加商品图片集 ******************************/
        $gpModel = M('goods_pic');
        //上传新的数组内容
        $arrFiles = formatUploadFiles('goods_pics');
        if (isset($arrFiles) && count($arrFiles) > 0) {
            //删除原来的指定商品ID的所有图片
            $gpModel->where(array("goods_id" => array('eq', $id)))->delete();
            foreach ($arrFiles as $k => $v) {
                if ($v['error'] == 0) {
                    $ret = uploadImageFile($v, 'Goods', array(
                        array(650, 650),
                        array(350, 350),
                        array(50, 50)
                    ));
                    if ($ret['ok'] == 1) {
                        $gpModel->add(array(
                            'pic' => $ret['Images'][0],
                            'big_pic' => $ret['Images'][1],
                            'mid_pic' => $ret['Images'][2],
                            'sm_pic' => $ret['Images'][3],
                            'goods_id' => $id
                        ));
                    }
                }
            }
        }

        /****************************** 修改商品属性的修改 ******************************/
        /************ 修改商品属性 *****************/
        $gaid = I('post.goods_attr_id');
        $attrValue = I('post.attr_value');
        $gaModel = D('goods_attr');
        $_i = 0;  // 循环次数
        foreach ($attrValue as $k => $v) {
            foreach ($v as $k1 => $v1) {
                // 这个replace into可以实现同样的功能
                // replace into ：如果记录存在就修改，记录不存在就添加。以主键字段来判断一条记录是否存在
                //$gaModel->execute('REPLACE INTO p39_goods_attr VALUES("'.$gaid[$_i].'","'.$v1.'","'.$k.'","'.$id.'")');
                // 找这个属性值是否有id

                if ($gaid[$_i] == '')
                    $gaModel->add(array(
                        'goods_id' => $id,
                        'attr_id' => $k,
                        'attr_value' => $v1,
                    ));
                else
                    $gaModel->where(array(
                        'id' => array('eq', $gaid[$_i]),
                    ))->setField('attr_value', $v1);

                $_i++;
            }
        }
    }

    protected function _before_delete($options)
    {
        $id = $options['where']['id'];   // 要删除的商品的ID
        /*************** 删除原来的图片 *******************/
        // 先查询出原来图片的路径
        $oldLogo = $this->field('logo,mbig_logo,big_logo,mid_logo,sm_logo')->find($id);
        deleteImage($oldLogo);

        /*********************** 删除会员价格 **************************/
        $mpModel = D('member_price');
        $mpModel->where(array('goods_id' => array('eq', $id)))->delete();

        /*********************** 删除拓展分类 **************************/
        $gcModel = D('goods_cat');
        $gcModel->where(array("goods_id" => array('eq', $id)))->delete();

        /*********************** 删除商品的属性 **************************/
        $gaModel = D('goods_attr');
        $gaModel->where(array('goods_id' => array('eq', $id)))->delete();

        /*********************** 删除库存的属性 **************************/
        $gaModel = D('goods_number');
        $gaModel->where(array('goods_id' => array('eq', $id)))->delete();
    }


    /**
     * 搜索商品内容，可以实现翻页，搜索和排序的操作
     * __WORK__和 __CARD__在最终解析的时候会转换为 think_work和 think_card。
     */
    public function search($perPage = 20)
    {
        /*************** 搜索 ******************/
        $where = array();  // 空的where条件
        // 商品名称
        $gn = I('get.goods_name');
        if ($gn)
            $where['a.goods_name'] = array('like', "%$gn%");  // WHERE goods_name LIKE '%$gn%'
        //商品分类
        $cat_id = I('get.cat_id');
        if ($cat_id) {
            //先查询出这个分类Id下所有的商品ID
            $gids = $this->getGoodsIdByCatId($cat_id);
            $gids = implode(',', $gids);
            $where['a.id'] = array('in', $gids);
        }
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
        $count = $this->alias('a')->where($where)->count();
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
        ->field("a.* , b.brand_name,c.cat_name, group_concat(e.cat_name separator '<br/>') ext_cat_name")//separator '<br/>' 默认分隔符为","
        ->alias('a')
            ->join('left join __BRAND__ b ON a.brand_id = b.id')//添加join
            ->join('left join __CATEGORY__ c ON a.cat_id = c.id')//添加join
            ->join('left join __GOODS_CAT__ d ON d.goods_id = a.id')//添加join
            ->join('left join __CATEGORY__ e ON d.cat_id = e.id')//添加join
            ->where($where)// 搜索
            ->limit($pageObj->firstRow . ',' . $pageObj->listRows)// 翻页
            ->group('a.id')
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

        /****************************** 添加商品图片集 ******************************/
        $gpModel = M('goods_pic');
        //上传新的数组内容
        $arrFiles = formatUploadFiles('goods_pics');
        if (isset($arrFiles) && count($arrFiles) > 0) {
            //删除原来的指定商品ID的所有图片
            $gpModel->where(array("goods_id" => array('eq', $data['id'])))->delete();
            foreach ($arrFiles as $k => $v) {
                if ($v['error'] == 0) {
                    $ret = uploadImageFile($v, 'Goods', array(
                        array(650, 650),
                        array(350, 350),
                        array(50, 50)
                    ));
                    if ($ret['ok'] == 1) {
                        $gpModel->add(array(
                            'pic' => $ret['Images'][0],
                            'big_pic' => $ret['Images'][1],
                            'mid_pic' => $ret['Images'][2],
                            'sm_pic' => $ret['Images'][3],
                            'goods_id' => $data['id']
                        ));
                    }
                }
            }
        }

        /***************** 添加商品的拓展属性 ********************/
        $gcModel = M('goods_cat');
        $gcData = I('post.ext_cat_id');
        $gcData = array_unique($gcData);
        if ($gcData) {
            foreach ($gcData as $key => $value) {
                if ($value != 0) { //由于默认的选项会自动上传为0，所以自动将剔除0再去插入
                    $arr[] = array();
                    $arr['goods_id'] = $data['id'];
                    $arr['cat_id'] = $value;
                    if ($gcModel->create($arr)) {
                        $gcModel->add();
                    }
                }
            }
        }

        /***************** 添加商品的分类属性操作 ***********************/
        $attrValue = I('post.attr_value');//获取分类属性数组
        $gaModel = D('goods_attr');
        foreach ($attrValue as $key => $value) {
            //属性值数组去重
            $arr = array_unique($value);
            foreach ($value as $key2 => $value2) {
                $gaModel->add(array(
                    'goods_id' => $data['id'],
                    'attr_id' => $key,
                    'attr_value' => $value2,
                ));
            }
        }
    }

    /**
     * 修改之后的操作
     * @param $data
     * @param $options
     */
    protected function _after_update($data, $options)
    {
        $goodsId = $data['id'];

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

        /***************** 添加商品的拓展属性 ********************/
        $gcModel = M('goods_cat');
        $gcModel->where(array('goods_id' => array('eq', $goodsId)))->delete();
        $gcData = I('post.ext_cat_id');
        $gcData = array_unique($gcData);
        if ($gcData) {
            foreach ($gcData as $key => $value) {
                if ($value != 0) {//由于默认的选项会自动上传为0，所以自动将剔除0再去插入
                    $arr[] = array();
                    $arr['goods_id'] = $goodsId;
                    $arr['cat_id'] = $value;
                    if ($gcModel->create($arr)) {
                        $gcModel->add();
                    }
                }
            }
        }
    }

    /**
     * 取出一个分类下所有商品的ID [即考虑主分类也考虑拓展分类]
     */
    public function getGoodsIdByCatId($catId)
    {
        //先取出所有分类的ID
        $catModel = D('category');
        $children = $catModel->getChildrenOnlyNumber($catId);
        //将当前选中的分类添加到$children中
        $children[] = $catId;
        /*************** 取出主分类或者扩展分类在这些分类中的商品 ****************/

        $gcModel = D("goods_cat");

        // 取出拓展分类下的商品ID [select id from p39_goods_cat where cat_id in (......)]
        $goodsIdsCAT = $this->field("id")->where(array("cat_id" => array("in", $children)))->select();

        // 取出拓展分类下的商品ID [select id from p39_goods_cat where cat_id in (......)]
        $goodsIdsExtCAT = $gcModel->distinct(true)->field("goods_id id")->where(array("cat_id" => array("in", $children)))->select();

        // 把主分类的ID和扩展分类下的商品ID合并成一个二维数组【两个都不为空时合并，否则取出不为空的数组】
        if ($goodsIdsCAT && $goodsIdsExtCAT)
            $goodsIdsByCAT = array_merge($goodsIdsCAT, $goodsIdsExtCAT);
        else
            $goodsIdsByCAT = $goodsIdsExtCAT;

        // 二维转一维并去重
        $ids = array();
        foreach ($goodsIdsByCAT as $key => $value) {
            if (!in_array($value['id'], $ids)) {
                $ids[] = $value['id'];
            }
        }
        return $ids;
    }

    /**
     * 取出当前正在促销的商品
     * $limit为获取前几个的内容
     */
    public function getPromoteGoods($limit = 5)
    {
        $today = date('Y-m-d H:i');
        return $this->field('id,goods_name,mid_logo,promote_price')
            ->where(array(
                'is_on_sale' => array('eq', '是'),
                'promote_price' => array('gt', 0),
                'promote_start_date' => array('elt', $today),
                'promote_end_date' => array('egt', $today)))
            ->limit($limit)
            ->order('sort_num ASC')
            ->select();
    }
}