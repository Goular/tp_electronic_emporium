<?php
namespace Home\Controller;
class SearchController extends NavController
{
    /**
     * 分类搜索
     */
    public function cat_search()
    {
        $cat_Id = I('get.cat_id');
        //取出商品和进行翻页
        $goodsModel = D('Admin/Goods');
        $data = $goodsModel->cat_search($cat_Id);

        $catModel = D('Admin/Category');
        //$searchFilter = $catModel->getSearchConditionByCatId($cat_Id);
        $searchFilter = $catModel->getSearchConditionByGoodsId($data['goods_id']);

        // 设置页面信息
        $this->assign(array(
            'page' => $data['page'],
            'data' => $data['data'],
            'searchFilter' => $searchFilter,
            '_page_title' => '分类搜索页',
            '_page_keywords' => '分类搜索页',
            '_page_description' => '分类搜索页',
        ));
        $this->display();
    }

    /**
     * 关键字搜索，这个可能使用全文索引才能加快搜索的效率
     */
    public function key_search()
    {
        $cat_Id = I('get.cat_id');
        //取出商品和进行翻页
        $goodsModel = D('Admin/Goods');
        $data = $goodsModel->key_search(I('get.key'));

        $catModel = D('Admin/Category');
        //$searchFilter = $catModel->getSearchConditionByCatId($cat_Id);
        $searchFilter = $catModel->getSearchConditionByGoodsId($data['goods_id']);

        // 设置页面信息
        $this->assign(array(
            'page' => $data['page'],
            'data' => $data['data'],
            'searchFilter' => $searchFilter,
            '_page_title' => '分类搜索页',
            '_page_keywords' => '分类搜索页',
            '_page_description' => '分类搜索页',
        ));
        $this->display();
    }
}