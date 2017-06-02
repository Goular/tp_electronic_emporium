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
    public function getChildren($catId)
    {
        //取出所有的分类
        $data = $this->select();
        //递归同时遍历所有的分类，并从中挑选指定ID的后代分类ID
        return $this->__getChildren($catId, $data);
    }

    /**
     * 递归算法，规矩全部的商品分类，返回一维的分类的排序信息，即父类子类会以同一纬度进行有序展示
     * @param $catId
     * @param $data
     * @return array
     */
    private function __getChildren($catId, $data)
    {
        //定义函数静态变量(这个静态区域仅限于函数范围内)
        static $_ret = array();//static创建的函数变量创建一次
        foreach ($data as $key => $value) {
            if ($catId == $value['parent_id']) {
                $_ret[] = $value['cat_name'];
                $this->__getChildren($value['id'], $data);
            }
        }
        return $_ret;
    }
}