<?php
namespace Admin\Controller;

use Think\Controller;

/**
 * 品牌类的控制器
 * Class BrandController
 * @package Admin\Controller
 */
class BrandController extends Controller
{

    /**
     * 添加品牌资料
     */
    public function add()
    {
        // 设置页面信息
        $this->assign(array(
            '_page_title' => '品牌添加',
            '_page_btn_name' => '品牌列表',
            '_page_btn_link' => U('lst'),
        ));
        $this->display();
    }

    /**
     * 修改品牌资料
     */
    public function edit()
    {
        // 设置页面信息
        $this->assign(array(
            '_page_title' => '品牌编辑',
            '_page_btn_name' => '品牌列表',
            '_page_btn_link' => U('lst'),
        ));
        $this->display();
    }


    /**
     * 品牌资料列表
     */
    public function lst()
    {
        // 设置页面信息
        $this->assign(array(
            '_page_title' => '品牌列表',
            '_page_btn_name' => '品牌添加',
            '_page_btn_link' => U('lst'),
        ));
        $this->display();
    }

    /**
     * 删除指定品牌
     */
    public function delete()
    {
        $model = D('brand');
        if (FALSE !== $model->delete(I('get.id'))) {
            $this->success('删除成功!', U('lst'));
        } else {
            $this->error('删除失败！原因：' . $model->getError(), U('lst'));
        }
    }
}