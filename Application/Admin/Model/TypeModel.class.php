<?php
namespace Admin\Model;

use Think\Model;

class TypeModel extends Model
{
    protected $insertFields = array('type_name');
    protected $updateFields = array('id', 'type_name');
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
        /*************** 搜索 ****************/
        $where = array();

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
    }
}