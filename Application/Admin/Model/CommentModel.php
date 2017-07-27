<?php
namespace Admin\Model;

use Think\Model;

class CommentModel extends Model
{
    // 评论时允许提交的字段
    protected $insertFields = "star,content,goods_id";

    // 发表评论时表单验证规则
    protected $_validate = array(
        array('goods_id', 'require', '参数错误!', 1),
        array('star', '1,2,3,4,5', '分值只能是1-5之间的数字!', 1, 'in'),
        array('content', '1,200', '内容必须是1-200个字符', 1, 'length')
    );

    protected function _before_insert(&$data, $options)
    {
        $memberId = session('m_id');
        if (!$memberId) {
            $this->error = '必须先登录！';
            return FALSE;
        }
        $data['member_id'] = $memberId;
        $data['addtime'] = date('Y-m-d H:i:s');

        /*********** 处理印象的数据 ******************/
        $yxId = I('post.yx_id');  // 选择的旧印象
        $yxName = I('post.yx_name');
        $yxModel = D('Yinxiang');
        // 处理选择的印象
        if ($yxId) {
            foreach ($yxId as $k => $v)
                $yxModel->where(array('id' => $v))->setInc('yx_count');
        }
        // 处理新添加的印象
        if ($yxName) {
            // 处理,号为英文
            $yxName = str_replace('，', ',', $yxName);
            $yxName = explode(',', $yxName);
            foreach ($yxName as $k => $v) {
                $v = trim($v);
                if (empty($v))
                    continue;
                // 先判断这个印象是否已经存在
                $has = $yxModel->where(array(
                    'goods_id' => $data['goods_id'],
                    'yx_name' => $v,
                ))->find();
                if ($has)
                    $yxModel->where(array(
                        'goods_id' => $data['goods_id'],
                        'yx_name' => $v,
                    ))->setInc('yx_count');
                else
                    $yxModel->add(array(
                        'goods_id' => $data['goods_id'],
                        'yx_name' => $v,
                        'yx_count' => 1,
                    ));
            }
        }
    }
}