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

    /**
     * 检查当前管理员是否有权限访问这个页面
     */
    public function chkPri()
    {
        // 获取当前管理员正要访问的模型名称、控制器名称、方法名称
        // tP中正带三个常量
        //MODULE_NAME , CONTROLLER_NAME , ACTION_NAME
        $adminId = session('id');
        // 如果是超级管理员直接返回 TRUE
        if ($adminId == 1)
            return TRUE;
        $arModel = D('admin_role');
        $has = $arModel->alias('a')
            ->join('LEFT JOIN __ROLE_PRI__ b ON a.role_id=b.role_id 
		        LEFT JOIN __PRIVILEGE__ c ON b.pri_id=c.id')
            ->where(array(
                'a.admin_id' => array('eq', $adminId),
                'c.module_name' => array('eq', MODULE_NAME),
                'c.controller_name' => array('eq', CONTROLLER_NAME),
                'c.action_name' => array('eq', ACTION_NAME),
            ))->count();
        return ($has > 0);
    }

    /**
     * 获取当前管理员所拥有的前两级的权限
     *
     */
    public function ownerShipAccessMenu()
    {
        /*************** 先取出当前管理员所拥有的所有的权限 ****************/
        $adminId = session('id');
        if ($adminId == 1) { //万能的管理员
            $priModel = D('Privilege');
            $priData = $priModel->select();
        } else {
            // 取出当前管理员所在角色 所拥有的权限
            // DISTINCT这样是由于一个用户可以拥有多个的角色，角色间的权限可能是重复的，这样我们需要使用DISTINCT来进行处理重复的内容
            $arModel = D('admin_role');
            $priData = $arModel->alias('a')
                ->field('DISTINCT c.id,c.pri_name,c.module_name,c.controller_name,c.action_name,c.parent_id')
                ->join('LEFT JOIN __ROLE_PRI__ b ON a.role_id=b.role_id 
			        LEFT JOIN __PRIVILEGE__ c ON b.pri_id=c.id')
                ->where(array(
                    'a.admin_id' => array('eq', $adminId),
                ))->select();
        }
        /*************** 从所有的权限中挑出前两级的 **********************/
        $btns = array();  // 前两级权限
        foreach ($priData as $k => $v) {
            if ($v['parent_id'] == 0) {
                // 再找这个顶的子级
                foreach ($priData as $k1 => $v1) {
                    if ($v1['parent_id'] == $v['id']) {
                        $v['children'][] = $v1;
                    }
                }
                $btns[] = $v;
            }
        }
        return $btns;
    }
}