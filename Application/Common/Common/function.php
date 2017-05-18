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
    $_clean_xss_config->set('HTML.Allowed','div,b,strong,i,em,a[href|title],ul,ol,li,p[style],br,span[style],img[width|height|alt|src]');
    $_clean_xss_config->set('CSS.AllowedProperties', 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align');
    $_clean_xss_config->set('HTML.TargetBlank', TRUE);
    $_clean_xss_obj = new HTMLPurifier($_clean_xss_config);
    // 执行过滤
    return $_clean_xss_obj->purify($data);
}