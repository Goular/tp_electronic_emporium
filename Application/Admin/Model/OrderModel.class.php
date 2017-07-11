<?php
namespace Admin\Model;

use Think\Model;

class OrderModel extends Model
{
    // 下单时允许表单的字段
    protected $insertFields = array('shr_name','shr_tel','shr_province','shr_city','shr_area','shr_address');
    // 下单时的表单验证规则
    protected $_validate = array(
        array('shr_name', 'require', '收货人姓名不能为空！', 1, 'regex', 3),
        array('shr_tel', 'require', '收货人电话不能为空！', 1, 'regex', 3),
        array('shr_province', 'require', '所在省不能为空！', 1, 'regex', 3),
        array('shr_city', 'require', '所在城市不能为空！', 1, 'regex', 3),
        array('shr_area', 'require', '所在地区不能为空！', 1, 'regex', 3),
        array('shr_address', 'require', '详细地址不能为空！', 1, 'regex', 3)
    );

    public function search($pageSize = 20)
    {
        /**************************************** 搜索 ****************************************/
        $memberId = session('m_id');//获取会员ID
        $where = array();
        $where['member_id'] = array('eq', $memberId);
        $noPayCount = $this->where(array(
            'member_id' => array('eq', $memberId),
            'pay_status' => array('eq', '否')
        ))->count();
        /************************************* 翻页 ****************************************/
        $count = $this->alias('a')->where($where)->count();
        $page = new \Think\Page($count, $pageSize);
        // 配置翻页的样式
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $data['page'] = $page->show();
        /************************************** 取数据 ******************************************/
        $data['data'] = $this->alias('a')
            ->field('a.id,a.shr_name,a.total_price,a.addtime,a.pay_status,GROUP_CONCAT(DISTINCT c.sm_logo) logo')
            ->join('LEFT JOIN __ORDER_GOODS__ b ON a.id=b.order_id 
                LEFT JOIN __GOODS__ c ON b.goods_id = c.id')
            ->where($where)
            ->group('a.id')
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        $data['noPayCount'] = $noPayCount;
        return $data;
    }

    private $fp;//文件锁

    /**
     * @param $data
     * @param $options 使用地址引用才能去改变变量中的内存保存的值
     * @return bool
     */
    protected function _before_insert(&$data, &$options)
    {
        //获取用户ID
        $memberID = session('m_id');
        /********************* 下单前的检查 **************************/
        // 是否登录
        if (!$memberID) {
            $this->error = "必须先登录!";
            return FALSE;
        }
        //判断购物车是否还有商品
        $cartModel = D('Admin/Cart');
        $options['goods'] = $goods = $cartModel->cartList();
        if (!$goods) {
            $this->error = '购物车没有商品，无法下单.';
            return FALSE;
        }
        // 读库存之前加锁,注意：把锁赋给这个模型，这样这个锁可以一直保存到下单结束，否则如果是局部变量这个锁在_before_insert函数执行完之后注释放了
        $this->fp = fopen('./order_create.lock');
        flock($this->fp, LOCK_EX);

        // 循环购物车中的商品检查库存量并且计算商品总价
        $gnModel = D('goods_number');
        $total_price = 0;
        foreach ($goods as $key => $value) {
            //检查库存量
            $gnNumber = $gnModel->field('goods_number')
                ->where(array(
                    'goods_id' => array('eq', $value['goods_id']),
                    'goods_attr_id' => array('eq', $value['goods_attr_id']),
                ))->find();
            if ($gnNumber['goods_number'] < $value['goods_number']) {
                $this->error = '下单失败，原因：商品：<strong>' . $value['goods_name'] . '</strong> 库存量不足！';
                return FALSE;
            }
            //统计总价
            $total_price += $value['price'] * $value['goods_number'];
        }
        // 把其他信息补到定单中
        $data['total_price'] = $total_price;
        $data['member_id'] = $memberID;
        $data['addtime'] = time();

        // 为了确定三张表的操作都能成功：定单基本信息表，定单商品表，库存量表
        $this->startTrans();//开启事务
    }

    // 定单基本信息生成之后, $data['id']就是新生成的定单的id
    protected function _after_insert($data, &$options)
    {
        // 从$option中取出购物车中的商品并循环插入到定单商品表中并且减少库存
        $ogModel = D('order_goods');
        $gnModel = D('goods_number');
        foreach ($options['goods'] as $key => $value) {
            $ret = $ogModel->add(array(
                'order_id' => $data['id'],
                'goods_id' => $value['goods_id'],
                'goods_attr_id' => $value['goods_attr_id'],
                'goods_number' => $value['goods_number'],
                'price' => $value['price'],
            ));
            if (!$ret) {
                $this->rollback();
                return FALSE;
            }
            //减库存
            $ret = $gnModel->where(array(
                'goods_id'=>array('eq',$value['goods_id']),
                'goods_attr_id'=>array('eq',$value['goods_attr_id'])
            ))->setDec('goods_number', $value['goods_number']);
            if (FALSE === $ret) {
                $this->rollback();
                return FALSE;
            }
        }
        //所有操作都成功提交事务
        $this->commit();

        //释放锁
        flock($this->fp,LOCK_UN);
        fclose($this->fp);

        //清空购物车
        $cartModel = D('Admin/Cart');
        $cartModel->clear();
    }

    /**
     * 设置为已支付状态
     */
    public function setPaid($orderId)
    {
        /************ 更新定单的支付状态 *******************/
        $this->where(array(
            'id' => array('eq', $orderId)
        ))->save(array(
            'pay_status' => '是',
            'pay_time' => time()
        ));
        /************ 更新会员积分 *******************/
        $tp = $this->field('total_price,member_id')->find($orderId);
        // 因为如果用D生成模型，那么在修改字段时会调用这个模型的_before_update方法，但现在这个功能不需要调用这个这个方法，所以这里使用M生成父类模型这样就不会调用_before_update了
        $memberModel = M('member');
        $memberModel->where(array(
            'id' => array('eq', $tp['member_id'])
        ))->setInc('jifen', $tp['total_pricd
        ']);
    }
}