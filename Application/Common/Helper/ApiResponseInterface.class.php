<?php
namespace Common\Helper;
/**
 * Interface ApiResponseInterface
 * Api Response的响应
 */
interface ApiResponseInterface
{
    /**********返回形式**********/
    const JSON = 'json';
    const XML = 'xml';

    /**
     * 按综合方式输出通信数据
     * @param $code                 状态码
     * @param string $message 提示信息
     * @param array $data 数据
     * @param string $type 数据类型
     * @return mixed                返回结果
     */
    public static function show($code, $message = '', $data = array(), $type = self::JSON);
}