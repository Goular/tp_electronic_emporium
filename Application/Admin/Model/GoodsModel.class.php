<?php
namespace Admin\Model;

use Think\Image;
use Think\Model;

class GoodsModel extends Model
{
    // 添加时调用create方法允许接收的字段
    protected $insertFields = 'goods_name,market_price,shop_price,is_on_sale,goods_desc';
    //定义验证规则
    protected $_validate = array(
        array('goods_name', 'require', '商品名称不能为空！', 1),
        array('market_price', 'currency', '市场价格必须是货币类型！', 1),
        array('shop_price', 'currency', '本店价格必须是货币类型！', 1),
    );

    // 这个方法在添加之前会自动被调用 --》 钩子方法
    // 第一个参数：表单中即将要插入到数据库中的数据->数组
    // &按引用传递：函数内部要修改函数外部传进来的变量必须按钮引用传递，除非传递的是一个对象,因为对象默认是按引用传递的
    protected function _before_insert(&$data, $options)
    {
        /**************** 处理LOGO *******************/
        // 判断有没有选择图片
        if ($_FILES['logo']['error'] == 0) {
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize = 1024 * 1024; // 1M
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath = './Public/Uploads/'; // 设置附件上传根目录
            $upload->savePath = 'Goods/'; // 设置附件上传（子）目录
            // 上传文件
            $info = $upload->upload();
            if (!$info) {
                // 获取失败原因把错误信息保存到 模型的error属性中，然后在控制器里会调用$model->getError()获取到错误信息并由控制器打印
                $this->error = $upload->getError();
                return FALSE;
            } else {
                /**************** 生成缩略图 *****************/
                // 先拼成原图上的路径
                $logo = $info['logo']['savepath'] . $info['logo']['savename'];
                // 拼出缩略图的路径和名称
                $mbiglogo = $info['logo']['savepath'] . 'mbig_' . $info['logo']['savename'];
                $biglogo = $info['logo']['savepath'] . 'big_' . $info['logo']['savename'];
                $midlogo = $info['logo']['savepath'] . 'mid_' . $info['logo']['savename'];
                $smlogo = $info['logo']['savepath'] . 'sm_' . $info['logo']['savename'];
                $image = new \Think\Image();
                // 打开要生成缩略图的图片
                $image->open('./Public/Uploads/' . $logo);
                // 生成缩略图
                $image->thumb(700, 700)->save('./Public/Uploads/' . $mbiglogo);
                $image->thumb(350, 350)->save('./Public/Uploads/' . $biglogo);
                $image->thumb(130, 130)->save('./Public/Uploads/' . $midlogo);
                $image->thumb(50, 50)->save('./Public/Uploads/' . $smlogo);
                /**************** 把路径放到表单中 *****************/
                $data['logo'] = $logo;
                $data['mbig_logo'] = $mbiglogo;
                $data['big_logo'] = $biglogo;
                $data['mid_logo'] = $midlogo;
                $data['sm_logo'] = $smlogo;
            }
        }
        // 获取当前时间并添加到表单中这样就会插入到数据库中
        $data['addtime'] = date('Y-m-d H:i:s', time());
        // 将通过自定义方法将HTML实体转为大小写符号，同时过滤JS脚本等XSS攻击的脚本
        $data['goods_desc'] = removeXSS($_POST['goods_desc']);
    }

    /**
     * 搜索商品内容，可以实现翻页，搜索和排序的操作
     */
    public function search($perPage = 3)
    {
        /************************* 搜索 **************************/
        $where = array();//默认为空的where搜索条件
        //商品名称
        $goods_name = I('get.goods_name');
        if ($goods_name) {
            $where['goods_name'] = array('like', "%$goods_name%");// WHERE goods_name LIKE '%$gn%'
        }
        //价格
        $goods_low_price = I('get.goods_low_price');//低价格
        $goods_high_price = I('get.goods_high_price');//高价格
        if ($goods_low_price && $goods_high_price) {
            $where['shop_price'] = array('between', array($goods_low_price, $goods_high_price));//WHERE shop_price BETWEEN $fp AND $tp
        } elseif ($goods_low_price) {
            $where['shop_price'] = array('egt', $goods_low_price);//WHERE shop_price>=$goods_low_price
        } elseif ($goods_high_price) {
            $where['shop_price'] = array('elt', $goods_high_price);//WHERE shop_price>=$goods_high_price
        }
        //是否上架
        $ios = I("get.ios");
        if ($ios) {
            $where['is_on_sale'] = array('eq', $ios);// WHERE is_on_sale = $ios
        }
        //添加时间
        $goods_add_start_time = I('get.goods_add_start_time');
        $goods_add_end_time = I('get.goods_add_end_time');
        if ($goods_add_start_time && $goods_add_end_time) {
            $where['addtime'] = array('between', array($goods_add_start_time, $goods_add_end_time));//WHERE shop_price BETWEEN $goods_add_start_time AND $goods_add_end_time
        } elseif ($goods_add_start_time) {
            $where['addtime'] = array('egt', $goods_add_start_time);//WHERE shop_price>=$goods_add_start_time
        } elseif ($goods_add_end_time) {
            $where['addtime'] = array('elt', $goods_add_end_time);//WHERE shop_price>=$goods_add_end_time
        }
        /************************* 翻页 **************************/
        // 取出总的记录数
        $count = $this->where($where)->count;
        // 生成翻页类的对象
        $pageObj = new \Think\Page($count, $perPage);
        //设置样式
        $pageObj->setConfig('next', '下一页');
        $pageObj->setConfig('prev', '上一页');
        $pageObj->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        //生成显示的字符串
        $pageStr = $pageObj->show();

        /***************** 排序 *****************/
        $orderBy = 'id';// 默认的排序字段
        $orderWay = 'desc';// 默认的排序方式
        $odby = I('get.odby');
        if ($odby) {
            if ($odby == 'id_asc')
                $orderWay = 'asc';
            elseif ($odby == 'price_desc')
                $orderBy = 'shop_price';
            elseif ($odby == 'price_asc') {
                $orderBy = 'shop_price';
                $orderWay = 'asc';
            }
        }

        /***********************取某一页的数据****************************/
        $data = $this->order("$orderBy $orderWay")
            ->where($where)//排序
            ->limit($pageObj->firstRow . ',' . $pageObj->listRows)//搜索
            ->select();                                                 //翻页
        /***************************  返回数据   ******************************/
        return array(
            'data' => $data,
            'page' => $pageStr
        );
    }
}