<?php
namespace Home\Controller;

use Think\Controller;

//添加API的控制器
class AddressController extends Controller
{
    public function lst()
    {
        // 设置页面信息
        $this->assign(array(
            '_page_path' => strtolower(__ACTION__),
            '_page_title' => '收货地址管理页',
            '_page_keywords' => '收货地址管理页',
            '_page_description' => '收货地址管理页',
        ));
        $this->display();
    }

    /**
     * 添加地址
     */
    public function aJaxAdd()
    {
        $model = D('Admin/MemberAddress');
        if ($model->create(I('post.'), 1)) {
            if ($id = $model->add()) {
                $data = array(
                    'data' => array(
                        'address' => $model->find($id)
                    ),
                    'code' => 1,
                    'message' => '添加成功!'
                );
                $this->ajaxReturn($data);
                exit;
            }
        }
        $data = array(
            'data' => array(),
            'code' => -1,
            'message' => $model->getError()
        );
        $this->ajaxReturn($data);
    }

    /**
     * 获取列表
     */
    public function aJaxLst()
    {
        $model = D('Admin/MemberAddress');
        $data = $model->order('id')->select();
        if (!empty($data)) {
            $data = array(
                'addresses' => $data,
                'code' => 1,
                'message' => '获取成功!'
            );
        } else {
            $data = array(
                'addresses' => array(),
                'code' => -1,
                'message' => '获取失败!'
            );
        }
        $this->ajaxReturn($data);
    }

    /**
     * 修改内容
     */
    public function update()
    {
        if (IS_POST) {
            $model = D('Admin/MemberAddress');
            if ($model->create(I('post.'), 2)) {
                if (FALSE !== $model->update()) {
                    $this->success('修改成功！', U('lst'));
                    exit;
                }
            }
            $error = $model->getError();
            $this->error($error);
        }
    }

    /**
     * 删除内容
     */
    public function delete()
    {
        $model = D('Admin/MemberAddress');
        if (FALSE !== $model->delete(I('get.id')))
            $this->success('删除成功！', U('lst'));
        else
            $this->error('删除失败！原因：' . $model->getError());
    }

    /**
     * 设定默认地址
     */
    public function defaultAddress()
    {
        $model = D('Admin/MemberAddress');
        $data = $model->where(array(
            'member_id' => session('')
        ))->select();

    }
}