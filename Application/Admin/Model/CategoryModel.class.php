<?php
namespace Admin\Model;

use Think\Model;

/**
 * 添加商品分类的的模型类
 * Class CategoryModel
 * @package Home\Model
 */
class CategoryModel extends Model
{
    //添加插入和更新的的校验内容
    protected $insertFields = array('cat_name', 'parent_id', 'is_floor');
    protected $updateFields = array('id', 'cat_name', 'parent_id', 'is_floor');
    protected $_validate = array(
        array("cat_name", "require", "商品分类名称必须填写", 1, "regex", self::MODEL_BOTH),
        array("cat_name", "", "商品分类名称已存在", 1, "unique", self::MODEL_BOTH)
    );

    /**
     * 根据指定的分类ID搜索其所有的子类ID
     * 以一维数组的形式进行展示
     */
    public function getChildren($catId = 0)
    {
        //取出所有的分类
        $data = $this->select();
        //递归同时遍历所有的分类，并从中挑选指定ID的后代分类ID
        return $this->__getChildren($data, $catId);
    }

    /**
     *  仅仅返回以为数组的子类分类ID
     */
    public function getChildrenOnlyNumber($catId = 0)
    {
        //取出所有的分类
        $data = $this->select();
        //递归同时遍历所有的分类，并从中挑选指定ID的后代分类ID
        return $this->__getChildrenOnlyNumber($data, $catId);
    }

    /**
     * 根据指定的分类ID搜索其所有的子类ID
     * 以二维数组(树状)的形式进行展示
     */
    public function getTrees($catId = 0)
    {
        //取出所有的分类
        $data = $this->select();
        //递归同时遍历所有的分类，并从中挑选指定ID的后代分类ID
        return $this->__getTree($data, $catId);
    }

    /**
     * 获取指定分类ID的子节点，非后台节点
     * @param $catId
     */
    public function getFirstLevelChildren($catId)
    {
        //取出所有的分类
        $data = $this->select();
        //递归同时遍历所有的分类，并从中挑选指定ID的后代分类ID
        return $this->__getFirstLevelChildren($data, $catId);
    }

    /**
     * 递归算法，规矩全部的商品分类，返回一维的分类的排序信息，即父类子类会以同一纬度进行有序展示
     * @param $catId
     * @param $data
     * @return array
     */
    private function __getChildren($data, $catId = 0, $level = 0)
    {
        //定义函数静态变量(这个静态区域仅限于函数范围内)
        static $_ret = array();//static创建的函数变量创建一次
        foreach ($data as $key => $value) {
            if ($catId == $value['parent_id']) {
                $value['level'] = $level;
                $_ret[] = $value;
                $this->__getChildren($data, $value['id'], $level + 1);
            }
        }
        return $_ret;
    }

    /**
     * 递归算法，规矩全部的商品分类，返回一维的分类的排序信息，即父类子类会以同一纬度进行有序展示
     * @param $catId
     * @param $data
     * @return array
     */
    private function __getChildrenOnlyNumber($data, $catId = 0)
    {
        //定义函数静态变量(这个静态区域仅限于函数范围内)
        static $_ret = array();//static创建的函数变量创建一次
        foreach ($data as $key => $value) {
            if ($catId == $value['parent_id']) {
                $_ret[] = $value['id'];
                $this->__getChildren($data, $value['id']);
            }
        }
        return $_ret;
    }

    /**
     * 递归算法，规矩全部的商品分类，返回二维的分类的排序信息，即树状形式有序展示
     * @param $catId
     * @param $data
     * @return array
     */
    private function __getTree($data, $catId = 0, $level = 0)
    {
        $_ret = array();
        foreach ($data as $key => $value) {
            if ($catId == $value['parent_id']) {
                $obj = array();
                $obj['id'] = $value['id'];
                $obj['cat_name'] = $value['cat_name'];
                $obj['parent_id'] = $value['parent_id'];
                $obj['level'] = $level;
                $obj['children'] = $this->__getTree($data, $value['id'], $level + 1);
                $_ret[] = $obj;
            }
        }
        return $_ret;
    }

    /**
     * 根据商品分类ID，获取当前的子节点
     * @param $data
     * @param $catId
     */
    private function __getFirstLevelChildren($data, $catId)
    {
        $_ret = array();
        foreach ($data as $key => $value) {
            if ($catId == $value['parent_id']) {
                $_ret[] = $value;
            }
        }
        return $_ret;
    }

    /**
     * 钩子方法(删除前执行)
     */
    protected function _before_delete($options)
    {
        //找到所有商品分类中所有子类的ID
        $children = $this->getChildrenOnlyNumber($options['where']['id']);
        if ($children) {
            $children = implode(",", $children);
            $model = M('Category');//不能使用D函数，不然又去调用当前类就会死循环，而M方法，仅仅会创建数据表的内容
            $model->delete($children);
        }
    }

    /**
     * 获取导航条上的数据[使用ThinkPHP自带的S方法来进行默认的缓存]
     */
    public function getNavData()
    {
        // 先从缓存中取出数据
        $catData = S('catData');
        // 判断如果没有缓存或者缓存过期就重新构造数组
        if (!$catData) {
            // 取出所有的分类
            $all = $this->select();
            $ret = array();
            // 循环所有的分类找出顶级分类
            foreach ($all as $k => $v) {
                if ($v['parent_id'] == 0) {
                    // 循环所有的分类找出这个顶级分类的子分类
                    foreach ($all as $k1 => $v1) {
                        if ($v1['parent_id'] == $v['id']) {
                            // 循环所有的分类找出这个二级分类的子分类
                            foreach ($all as $k2 => $v2) {
                                if ($v2['parent_id'] == $v1['id']) {
                                    $v1['children'][] = $v2;
                                }
                            }
                            $v['children'][] = $v1;
                        }
                    }
                    $ret[] = $v;
                }
            }
            // 把数组缓存1天
            S('catData', $ret, 86400);
            return $ret;
        } else
            return $catData;  // 有缓存直接返回缓存数据
    }

    /**
     * 获取前台首页楼层的数据
     */
    public function floorData()
    {
//        $floorData = S('floorData');
//        if ($floorData)
//            return $floorData;
//        else {
        // 先取出推荐到楼层的顶级分类
        //select * from php_39 where parent_id = 0 and is_floor = '是';
        $ret = $this->where(array(
            'parent_id' => array('eq', 0),
            'is_floor' => array('eq', '是'),
        ))->select();
        $goodsModel = D('Admin/Goods');
        // 循环每个楼层取出楼层中的数据
        foreach ($ret as $k => $v) {
            /****************** 这个楼层中的品牌数据 *********************/
            // 先取出这个楼层下所有的商品ID
            $goodsId = $goodsModel->getGoodsIdByCatId($v['id']);
            if ($goodsId) {
                // 再取出这些商品所用到的品牌
                $ret[$k]['brand'] = $goodsModel->alias('a')
                    ->join('LEFT JOIN __BRAND__ b ON a.brand_id=b.id')
                    ->field('DISTINCT brand_id,b.brand_name,b.logo')
                    ->where(array(
                        'a.id' => array('in', $goodsId),
                        'a.brand_id' => array('neq', 0),
                    ))->limit(9)->select();
            }
            /**** 取出未推荐的二级分类并保存到这个顶级分类的subCat字段中 *************/
            $ret[$k]['subCat'] = $this->where(array(
                'parent_id' => array('eq', $v['id']),
                'is_floor' => array('eq', '否'),
            ))->select();
            /**** 取出推荐的二级分类并保存到这个顶级分类的subCat字段中 *************/
            $ret[$k]['recSubCat'] = $this->where(array(
                'parent_id' => array('eq', $v['id']),
                'is_floor' => array('eq', '是'),
            ))->select();
            /********* 循环每个推荐的二级分类取出分类下的8件被推荐到楼层的商品 *********/
            foreach ($ret[$k]['recSubCat'] as $k1 => &$v1) {
                // 取出这个分类下所有商品的ID并返回一维数组
                $gids = $goodsModel->getGoodsIdByCatId($v1['id']);
                if ($gids) {
                    // 再根据商品ID取出商品的详细信息
                    $v1['goods'] = $goodsModel->field('id,mid_logo,goods_name,shop_price')->where(array(
                        'is_on_sale' => array('eq', '是'),
                        'is_floor' => array('eq', '是'),
                        'id' => array('in', $gids),
                    ))->order('sort_num ASC')->limit(8)->select();
                }
            }
        }
//            S('floorData', $ret, 86400);
        return $ret;
    }
//    }
}