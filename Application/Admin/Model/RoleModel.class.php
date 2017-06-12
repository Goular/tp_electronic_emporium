<?php
namespace Admin\Model;

use Think\Model;

//角色模型
class RoleModel extends Model
{
    protected $insertFields = array('role_name');
    protected $updateFields = array('id', 'role_name');
    protected $_validate = array(
        array('role_name', 'require', '角色名称不能为空！', 1, 'regex', 3),
        array('role_name', '1,30', '角色名称的值最长不能超过 30 个字符！', 1, 'length', 3),
        array('role_name', '', '角色名称已经存在！', 1, 'unique', 3),
    );

    protected function _after_insert($data, $options)
    {
        //获取角色的ID
        $id = $data['id'];
        $priIds = I('post.pri_id');
        /***************************插入属性表***************************/
        $model = D('role_pri');
        foreach ($priIds as $key => $value) {
            $model->add(array(
                'role_id' => $id,
                'pri_id' => $value
            ));
        }
    }


}