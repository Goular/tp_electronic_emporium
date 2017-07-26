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
}