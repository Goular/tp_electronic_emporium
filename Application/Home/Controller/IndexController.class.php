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
        //获取商品详细信息
        $model = D('Admin/Goods');
        $info = $model->find($id);
        //获取分类的内容
        $catModel = D('Admin/Category');
        $catPath = $catModel->parentPath($info['cat_id']);
        //取出商品的相册
        $goodPic = D('goods_pic');
        $goodsPics = $goodPic->where(array('goods_id' => array('eq', $id)))->select();
        $viewConfig = C("IMAGE_CONFIG");
        //取出这件商品的所有属性
        $gaModel = D('goods_attr');
        $gaDatas = $gaModel->alias('a')
            ->field('a.*,b.attr_name,b.attr_type')
            ->join('left join __ATTRIBUTE__ b ON a.attr_id = b.id')
            ->where(array(
                'a.goods_id' => array('eq', $id)
            ))->select();

        //统计分类的数据
        $weiYiData = array();
        $keXuanData = array();
        foreach ($gaDatas as $key => $value) {
            if ($value['attr_type'] == '唯一') {
                $weiYiData[] = $value;
            } else if ($value['attr_type'] == '可选') {
                $keXuanData[] = $value;
            }
        }

        echo "<pre>";
        var_dump($weiYiData);
        var_dump($keXuanData);
        echo "</pre>";



        //绑定数据到我们的页面
        $this->assign(array(
            'info' => $info,
            'goodsPics' => $goodsPics,
            'viewPath' => $viewConfig['viewPath'],
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