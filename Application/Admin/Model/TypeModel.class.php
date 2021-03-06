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
        $id = $options['where']['id'];//分类ID
        $model = D('attribute');//获取模型类
        $model->where(array("type_id" => array('eq' => $id)))->delete();
    }

    /**
     * 类型搜索
     * @param int $pageSize
     */
    public function search($pageSize = 3)
    {
        /**************************************** 搜索 ****************************************/
        $where = array();
        /************************************* 翻页 ****************************************/
        $count = $this->alias('a')->where($where)->count();
        $page = new \Think\Page($count, $pageSize);
        // 配置翻页的样式
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $data['page'] = $page->show();
        /************************************** 取数据 ******************************************/
        $data['data'] = $this->alias('a')->where($where)->group('a.id')->limit($page->firstRow . ',' . $page->listRows)->select();
        return $data;
    }
}