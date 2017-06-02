<?php
namespace Home\Model;

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
     */
    public function getChildren($catId)
    {
        //取出所有的分类
        $data = $this->select();
        //递归同时遍历所有的分类，并从中挑选指定ID的后代分类ID
        return $this->_getChildren($data, $catId, TRUE);
    }

    /**
     * 利用递归的方法，从数据中寻找子类
     */
    private function _getChildren($data, $catId, $isClear = FALSE)
    {
        static $_ret = array();
        if ($isClear) $_ret = array();
        //循环所有的分类寻找子类
        foreach ($data as $key => $value) {
            if ($value['parent_id'] == $catId) {
                $_ret[] = $value['id'];
                $this->_getChildren($data, $value['id']);
            }
        }
        return $_ret;
    }
}