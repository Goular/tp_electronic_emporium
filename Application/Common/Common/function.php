<?php
/**
 * 自定义方法
 * Created by PhpStorm.
 * User: zhaoj
 * Date: 2017/5/19
 * Time: 0:19
 */
// 有选择性的过滤XSS --》 说明：性能非常低-》尽量少用
//将HTML实体按白名单进行显示和保存，同时禁止一些与XSS相关的脚本标签和实体。
function removeXSS($data)
{
    require_once './vendor/autoload.php';
    $_clean_xss_config = HTMLPurifier_Config::createDefault();
    $_clean_xss_config->set('Core.Encoding', 'UTF-8');
    // 设置保留的标签
    $_clean_xss_config->set('HTML.Allowed', 'div,b,strong,i,em,a[href|title],ul,ol,li,p[style],br,span[style],img[width|height|alt|src]');
    $_clean_xss_config->set('CSS.AllowedProperties', 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align');
    $_clean_xss_config->set('HTML.TargetBlank', TRUE);
    $_clean_xss_obj = new HTMLPurifier($_clean_xss_config);
    // 执行过滤
    return $_clean_xss_obj->purify($data);
}

/**
 * 删除图片
 */
function deleteImage($image = array())
{
    $savePath = C('IMAGE_CONFIG');
    foreach ($image as $v) {
        unlink($savePath['rootPath'] . $v);
    }
}

/**
 * 上传图片并生成缩略图
 * 用法：
 * $ret = uploadOne('logo', 'Goods', array(
 * array(600, 600),
 * array(300, 300),
 * array(100, 100),
 * ));
 * 返回值：
 * if($ret['ok'] == 1)
 * {
 * $ret['images'][0];   // 原图地址
 * $ret['images'][1];   // 第一个缩略图地址
 * $ret['images'][2];   // 第二个缩略图地址
 * $ret['images'][3];   // 第三个缩略图地址
 * }
 * else
 * {
 * $this->error = $ret['error'];
 * return FALSE;
 * }
 *
 */
function uploadOne($imgName, $dirName, $thumb = array())
{
    // 上传LOGO
    if (isset($_FILES[$imgName]) && $_FILES[$imgName]['error'] == 0) {
        $ic = C('IMAGE_CONFIG');
        $upload = new \Think\Upload(array(
            'rootPath' => $ic['rootPath'],
            'maxSize' => $ic['maxSize'],
            'exts' => $ic['exts'],
        ));// 实例化上传类
        $upload->savePath = $dirName . '/'; // 图片二级目录的名称
        // 上传文件
        // 上传时指定一个要上传的图片的名称，否则会把表单中所有的图片都处理，之后再想其他图片时就再找不到图片了
        $info = $upload->upload(array($imgName => $_FILES[$imgName]));
        if (!$info) {
            return array(
                'ok' => 0,
                'error' => $upload->getError(),
            );
        } else {
            $ret['ok'] = 1;
            $ret['images'][0] = $logoName = $info[$imgName]['savepath'] . $info[$imgName]['savename'];
            // 判断是否生成缩略图
            if ($thumb) {
                $image = new \Think\Image();
                // 循环生成缩略图
                foreach ($thumb as $k => $v) {
                    $ret['images'][$k + 1] = $info[$imgName]['savepath'] . 'thumb_' . $k . '_' . $info[$imgName]['savename'];
                    // 打开要处理的图片
                    $image->open($ic['rootPath'] . $logoName);
                    $image->thumb($v[0], $v[1])->save($ic['rootPath'] . $ret['images'][$k + 1]);
                }
            }
            return $ret;
        }
    }
}

/**
 * 展示相关的图片
 */
function showImage($url, $width = '', $height = '')
{
    $ic = C('IMAGE_CONFIG');
    if ($width)
        $width = "width='$width'";
    if ($height)
        $height = "height='$height'";
    echo "<img $width $height src='{$ic['viewPath']}$url'/>";
}

/**
 * 使用一个表中的数据制作下拉圈
 */
function buildSelect($tableName, $selectName, $valueFieldName, $textFieldName, $selectedValue = '')
{
    $model = D($tableName);
    $data = $model->field("$valueFieldName,$textFieldName")->select();
    $select = "<select name='$selectName'><option value=''>请选择</option>";
    foreach ($data as $k => $v) {
        $value = $v[$valueFieldName];
        $text = $v[$textFieldName];
        if ($selectedValue && $selectedValue == $value)
            $selected = 'selected="selected"';
        else
            $selected = '';
        $select .= '<option ' . $selected . ' value="' . $value . '">' . $text . '</option>';
    }
    $select .= '</select>';
    echo $select;
}

/**
 * 格式化显示var_dump()
 */
function formatVarDump($obj)
{
    echo "<pre>";
    var_dump($obj);
    echo "</pre>";
    exit();
}

/**
 * 让多文件上传过来的数组从原来的分开归集种类，变为向单一上传文件的数组
 */
function formatUploadFiles($arrayName)
{
    $arrFiles = $_FILES[$arrayName];
    $fileNum = count($arrFiles);
    if ($fileNum == 1) {
        $files = $arrFiles;
    } else {
        for ($i = 0; $i < $fileNum; $i++) {
            $files[$i]['name'] = $arrFiles['name'][$i];
            $files[$i]['type'] = $arrFiles['type'][$i];
            $files[$i]['tmp_name'] = $arrFiles['tmp_name'][$i];
            $files[$i]['error'] = $arrFiles['error'][$i];
            $files[$i]['size'] = $arrFiles['size'][$i];
        }
    }
    return $files;
}