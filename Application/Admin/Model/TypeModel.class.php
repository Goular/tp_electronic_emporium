<?php
namespace Home\Model;

use Think\Model;

class TypeModel extends Model
{
    protected $insertFields = array();
    protected $updateFields = array();
    protected $_validate = array(
        array('type_name', 'require', '类型名称不能为空!', 1, 'regex', 3),
        array('type_name', '1,30', '类型名称的值最长不能超过30个字符', 1, 'length', 3),
        array('type_name', '', '类型名称已经存在!', 1, 'unique', 3)
    );

    /**
     * 插入前钩子方法
     * @param $data
     * @param $options
     */
    protected function _before_insert(&$data, $options)
    {

    }

    /**
     * 更新前钩子方法
     * @param $data
     * @param $options
     */
    protected function _before_update(&$data, $options)
    {

    }

    /**
     * 删除前钩子方法
     * @param $options
     */
    protected function _before_delete($options)
    {

    }

    /**
     * 类型搜索
     * @param int $pageSize
     */
    public function search($pageSize = 3)
    {

    }
}