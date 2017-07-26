<?php
namespace Home\Controller;

class CommentController extends NavController
{
    //通过AJax来获取商品的评论
    public function ajaxGetPl()
    {
        $goodsId = I('get.goods_id');
        if ($goodsId) {
            $model = D('Admin/Comment');
            $data = $model->search($goodsId, 5);
            return $this->ajaxReturn($data);
        }
    }

    //AJax发表评论
    public function ajaxAdd()
    {
        if (IS_POST) {
            $model = D('Admin/Comment');
            if ($model->create(I('post.'), 1)) {
                if ($id = $model->add()) {
                    $data = $model->find($id);
                    $ret = array(
                        'data' => $data,
                        'message' => '添加成功!',
                        'code' => 1
                    );
                    $this->ajaxReturn($ret);
                    exit;
                }
            }
            $ret = array(
                'data' => '',
                'message' => '添加失败:' . $model->getError(),
                'code' => -1
            );
            $this->ajaxReturn($ret);
            exit;
        }
    }

    //AJax回复
    public function ajaxReply()
    {
        if (IS_POST) {
            $model = D('Admin/CommentReply');
            if ($model->create(I('post.'), 1)) {
                if ($id = $model->add()) {
                    $data = $model->find($id);
                    $ret = array(
                        'data' => $data,
                        'message' => '添加成功!',
                        'code' => 1
                    );
                    $this->ajaxReturn($ret);
                    exit;
                }
            }
            $ret = array(
                'data' => '',
                'message' => '添加失败:' . $model->getError(),
                'code' => -1
            );
            $this->ajaxReturn($ret);
            exit;
        }
    }
}