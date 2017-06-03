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
    protected $insertFields = array("cat_name", "parent_id");
    protected $updateFields = array("id", "cat_name", "parent_id");
    protected $_validate = array(
        array("cat_name", "require", "商品分类名称必须填写", 1, "regex", self::MODEL_BOTH)
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
}