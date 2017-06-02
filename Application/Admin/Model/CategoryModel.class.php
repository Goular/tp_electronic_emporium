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
//    protected $insertFields = array();
//    protected $updateFields = array();
//    protected $_validate = array();

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
}