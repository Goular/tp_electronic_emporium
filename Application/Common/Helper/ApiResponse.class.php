<?php
namespace Common\Helper;
/**
 * Class ApiResponse
 * API访问接口返回
 */
class ApiResponse implements ApiResponseInterface
{

    /**
     * 按综合方式输出通信数据
     * @param $code                 状态码
     * @param string $message 提示信息
     * @param array $data 数据
     * @param string $type 数据类型
     * @return mixed                返回结果
     */
    public static function show($code, $message = '', $data = array(), $type = self::JSON)
    {
        //判断是否返回状态码
        if (!is_numeric($code)) {
            return '';
        }
        //判断返回数据传递的类型
        $type = isset($type) ? $type : self::JSON;
        //创建响应的格式
        $result = self::createResponseModel($code, $message, $data);
        if ($type == 'json') {
            self::json($code, $message, $data);
            exit();
        } elseif ($type == 'xml') {
            var_dump($result);
            exit();
        } elseif ($type == 'array') {
            self::xmlEncode($code, $message, $data);
            exit();
        } else {
            //todo
        }
    }

    /**
     * 创建并返回响应的模型
     * @param $code
     * @param $message
     * @param $data
     * @return array
     */
    private static function createResponseModel($code, $message, $data)
    {
        return array(
            'code' => $code,
            'message' => $message,
            'data' => $data
        );
    }

    /**
     * 按json方式输出通信数据
     * @param $code             状态码
     * @param string $message 提示消息
     * @param array $data 数据
     */
    public static function json($code, $message = '', $data = array())
    {
        if (!is_numeric($code)) {
            return '';
        }
        $result = self::createResponseModel($code, $message, $data);
        echo json_encode($result);
        exit();
    }

    /**
     * 按XML方式输出通信数据
     * @param $code     状态码
     * @param $message  提示信息
     * @param array $data 数据
     */
    public static function xmlEncode($code, $message, $data = array())
    {
        if (!is_numeric($code)) {
            return '';
        }
        $result = self::createResponseModel($code, $message, $data);
        header('Content-Type:text/xml');
        $xml = "<?xml version='1.0' encoding='UTF-8'?>\n";
        $xml .= "<root>\n";
        $xml .= self::xmlToEncode($result);
        $xml .= "</root>";
        echo $xml;
    }

    /**
     * @param $data
     * @return string
     */
    public static function xmlToEncode($data)
    {

        $xml = $attr = "";
        foreach ($data as $key => $value) {
            if (is_numeric($key)) {
                $attr = " id='{$key}'";
                $key = "item";
            }
            $xml .= "<{$key}{$attr}>";
            $xml .= is_array($value) ? self::xmlToEncode($value) : $value;
            $xml .= "</{$key}>\n";
        }
        return $xml;
    }
}