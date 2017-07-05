<?php
return array(
    //前台管理页面的CSS访问路径
    'HOME_CSS_URL' => __ROOT__ . '/Public/Home/Styles',
    //前台管理页面的Js访问路径
    'HOME_JS_URL' => __ROOT__ . '/Public/Home/Js',
    //前台管理页面的Images访问路径
    'HOME_IMG_URL' => __ROOT__ . '/Public/Home/Images',
    //添加静态页面规则定义
    'HTML_CACHE_ON' => true, // 开启静态缓存
    'HTML_CACHE_TIME' => 60,   // 全局静态缓存有效期（秒）
    'HTML_FILE_SUFFIX' => '.shtml', // 设置静态缓存文件后缀
    'HTML_CACHE_RULES' => array(  // 定义静态缓存规则
        //前台首页
//        'index:index' => array('index', '86400', 'md5'),
        //前台商品详情
//        'index:goods' => array('goods-{id}', 86400)
    )
);