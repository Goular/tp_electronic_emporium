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
        //获取分类的内容
        $catModel = D('Admin/Category');
        $catPath = $catModel->parentPath($info['cat_id']);
        //绑定数据到我们的页面
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

    //处理浏览的历史
    public function displayHistory()
    {
        $id = I('get.id');
        // 先从COOKIE中取出浏览历史的ID数组
        $data = isset($_COOKIE['display_history']) ? unserialize($_COOKIE['display_history']) : array();
        // 把最新浏览的这件商品放到数组中的第一个位置上
        array_unshift($data, $id);
        // 去重
        $data = array_unique($data);
        // 只取数组中前6个
        if (count($data) > 6)
            $data = array_slice($data, 0, 6);
        // 数组存回COOKIE
        setcookie('display_history', serialize($data), time() + 30 * 86400, '/');
        // 再根据商品的ID取出商品的详细信息
        $goodsModel = D('Goods');
        $data = implode(',', $data);
        $gData = $goodsModel->field('id,mid_logo,goods_name')->where(array(
            'id' => array('in', $data),
            'is_on_sale' => array('eq', '是'),
        ))->order("FIELD(id,$data)")->select();
        echo json_encode($gData);
    }
}