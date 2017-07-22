<?php
namespace Admin\Model;

use Think\Model;

class MemberAddressModel extends Model
{
    protected $insertFields = array('receiver', 'province', 'city', 'district', 'mobile', 'detail', 'is_default');
    protected $updateFields = array('id', 'receiver', 'province', 'city', 'district', 'mobile', 'detail', 'is_default');
    protected $_validate = array(
        array('receiver', 'require', '品牌名称不能为空！', 1, 'regex', 3),
        array('province', 'require', '省份名称不能为空！', 1, 'regex', 3),
        array('city', 'require', '城市名称不能为空！', 1, 'regex', 3),
        array('district', 'require', '区域名称不能为空！', 1, 'regex', 3),
        array('mobile', 'require', '联系方式不能为空！', 1, 'regex', 3),
        array('detail', 'require', '地址详情不能为空！', 1, 'regex', 3),
        array('is_default', 'require', '默认地址不能为空！', 1, 'regex', 3),
    );
}