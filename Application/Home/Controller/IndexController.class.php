<?php
namespace Home\Controller;

class IndexController extends NavController
{
    /**
     * 网站首页的内容
     */
    public function index()
    {
        //获取Model模型
        $goodsModel = D('Admin/Goods');
        //获取促销商品
        $goodsCuXiao = $goodsModel->getPromoteGoods();
        //获取新品，热卖，精品的展示数据
        $goodsXinPin = $goodsModel->getRecommendGoods('is_new');
        $goodsReMai = $goodsModel->getRecommendGoods('is_hot');
        $goodsJingPin = $goodsModel->getRecommendGoods('is_best');

        //取出楼层的数据
        $catModel = D('Admin/Category');
        $floorData = $catModel->floorData();

        $this->assign(array(
            'goodsCuXiao' => $goodsCuXiao,
            'goodsXinPin' => $goodsXinPin,
            'goodsReMai' => $goodsReMai,
            'goodsJingPin' => $goodsJingPin,
            'floorData' => $floorData
        ));
        $this->assign(array(
            '_show_nav' => 1,
            '_page_title' => '首页',
            '_page_keywords' => '首页',
            '_page_description' => '首页',
        ));
        $this->display();
    }

    /**
     * 商品详情页
     */
    public function goods()
    {
        //获取面包屑导航
        $id = I('get.id');
        $model = D('Admin/Goods');
        $info = $model->find($id);
        $catModel = D('Admin/Category');
        $catPath = $catModel->parentPath($info['cat_id']);
        $this->assign(array(
            'info' => $info,
            'catPath' => $catPath
        ));
        $this->assign(array(
            '_page_title' => '商品详情页',
            '_page_keywords' => '商品详情页',
            '_page_description' => '商品详情页',
        ));
        $this->display();
    }
}