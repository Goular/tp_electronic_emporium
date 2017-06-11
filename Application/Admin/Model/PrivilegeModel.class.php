<?php
namespace Admin\Model;

use Think\Model;

//角色模型
class PrivilegeModel extends Model
{
    protected $insertFields = array('pri_name', 'module_name', 'controller_name', 'action_name', 'parent_id');
    protected $updateFields = array('id', 'pri_name', 'module_name', 'controller_name', 'action_name', 'parent_id');
    protected $_validate = array(
        array('pri_name', 'require', '权限名称不能为空！', 1, 'regex', 3),
        array('pri_name', '1,30', '权限名称的值最长不能超过 30 个字符！', 1, 'length', 3),
        array('module_name', '1,30', '模块名称的值最长不能超过 30 个字符！', 2, 'length', 3),
        array('controller_name', '1,30', '控制器名称的值最长不能超过 30 个字符！', 2, 'length', 3),
        array('action_name', '1,30', '方法名称的值最长不能超过 30 个字符！', 2, 'length', 3),
        array('parent_id', 'number', '上级权限Id必须是一个整数！', 2, 'regex', 3),
    );

    /**
     * 根据指定的权限ID搜索其所有的子类ID
     * 以一维数组的形式进行展示
     */
    public function getChildren($priId = 0)
    {
        //取出所有的权限
        $data = $this->select();
        //递归同时遍历所有的权限，并从中挑选指定ID的后代权限ID
        return $this->__getChildren($data, $priId);
    }

    /**
     *  仅仅返回以为数组的子类权限ID
     */
    public function getChildrenOnlyNumber($priId = 0)
    {
        //取出所有的权限
        $data = $this->select();
        //递归同时遍历所有的权限，并从中挑选指定ID的后代权限ID
        return $this->__getChildrenOnlyNumber($data, $priId);
    }

    /**
     * 根据指定的权限ID搜索其所有的子类ID
     * 以二维数组(树状)的形式进行展示
     */
    public function getTrees($priId = 0)
    {
        //取出所有的权限
        $data = $this->select();
        //递归同时遍历所有的权限，并从中挑选指定ID的后代权限ID
        return $this->__getTree($data, $priId);
    }

    /**
     * 获取指定权限ID的子节点，非后台节点
     * @param $priId
     */
    public function getFirstLevelChildren($priId)
    {
        //取出所有的权限
        $data = $this->select();
        //递归同时遍历所有的权限，并从中挑选指定ID的后代权限ID
        return $this->__getFirstLevelChildren($data, $priId);
    }

    /**
     * 递归算法，规矩全部的权限，返回一维的权限的排序信息，即父类子类会以同一纬度进行有序展示
     * @param $priId
     * @param $data
     * @return array
     */
    private function __getChildren($data, $priId = 0, $level = 0)
    {
        //定义函数静态变量(这个静态区域仅限于函数范围内)
        static $_ret = array();//static创建的函数变量创建一次
        foreach ($data as $key => $value) {
            if ($priId == $value['parent_id']) {
                $value['level'] = $level;
                $_ret[] = $value;
                $this->__getChildren($data, $value['id'], $level + 1);
            }
        }
        return $_ret;
    }

    /**
     * 递归算法，规矩全部的权限，返回一维的权限的排序信息，即父类子类会以同一纬度进行有序展示
     * @param $priId
     * @param $data
     * @return array
     */
    private function __getChildrenOnlyNumber($data, $priId = 0)
    {
        //定义函数静态变量(这个静态区域仅限于函数范围内)
        static $_ret = array();//static创建的函数变量创建一次
        foreach ($data as $key => $value) {
            if ($priId == $value['parent_id']) {
                $_ret[] = $value['id'];
                $this->__getChildren($data, $value['id']);
            }
        }
        return $_ret;
    }

    /**
     * 递归算法，规矩全部的权限，返回二维的权限的排序信息，即树状形式有序展示
     * @param $priId
     * @param $data
     * @return array
     */
    private function __getTree($data, $priId = 0, $level = 0)
    {
        $_ret = array();
        foreach ($data as $key => $value) {
            if ($priId == $value['parent_id']) {
                $obj = array();
                $obj['id'] = $value['id'];
                $obj['pri_name'] = $value['pri_name'];
                $obj['module_name'] = $value['module_name'];
                $obj['contolller_name'] = $value['contolller_name'];
                $obj['action_name'] = $value['action_name'];
                $obj['parent_id'] = $value['parent_id'];
                $obj['level'] = $level;
                $obj['children'] = $this->__getTree($data, $value['id'], $level + 1);
                $_ret[] = $obj;
            }
        }
        return $_ret;
    }

    /**
     * 根据权限ID，获取当前的子节点
     * @param $data
     * @param $priId
     */
    private function __getFirstLevelChildren($data, $priId)
    {
        $_ret = array();
        foreach ($data as $key => $value) {
            if ($priId == $value['parent_id']) {
                $_ret[] = $value;
            }
        }
        return $_ret;
    }
}