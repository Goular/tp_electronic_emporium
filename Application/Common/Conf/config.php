<?php
return array(
    //数据库连接设置
    'DB_TYPE' => 'mysql',     // 数据库类型
    'DB_HOST' => 'localhost', // 服务器地址
    'DB_NAME' => 'php39',          // 数据库名
    'DB_USER' => 'root',      // 用户名
    'DB_PWD' => '123456',          // 密码
    'DB_PORT' => '3306',        // 端口
    'DB_PREFIX' => 'p39_',    // 数据库表前缀
    'DB_CHARSET' => 'utf8',      // 数据库编码
    'DB_DEBUG' => TRUE, // 数据库调试模式 开启后可以记录SQL日志,
    'URL_MODEL' => 2,
    'SHOW_PAGE_TRACE' => true,
    'DEFAULT_FILTER' => 'trim,htmlspecialchars', // 默认参数过滤方法 用于I函数...
    'UMEDITOR_URL' => __ROOT__ . '/Public/Tools/umeditor1.2.3-utf8-php',
    'DATETIMEPICKER_URL' => __ROOT__ . "/Public/Tools/datetimepicker",
    /************ 图片相关的配置 ***************/
    'IMAGE_CONFIG' => array(
        'maxSize' => 1024 * 1024,
        'exts' => array('jpg', 'gif', 'png', 'jpeg'),
        'rootPath' => './Public/Uploads/',  // 上传图片的保存路径  -> PHP要使用的路径，硬盘上的路径
        'viewPath' => __ROOT__ . '/Public/Uploads/',   // 显示图片时的路径    -> 浏览器用的路径，相对网站根目录
    ),
    /************ BootStrap相关的CDN加速地址 ***************/
    'BootStrap_bootstrap-theme_css' => 'https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap-theme.css',
    'BootStrap_bootstrap-theme_min_css' => 'https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap-theme.min.css',
    'BootStrap_bootstrap_css' => 'https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css',
    'BootStrap_bootstrap_min_css' => 'https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css',
    'BootStrap_glyphicons-halflings-regular_svg' => 'https://cdn.bootcss.com/bootstrap/3.3.7/fonts/glyphicons-halflings-regular.svg',
    'BootStrap_bootstrap_js' => 'https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.js',
    'BootStrap_bootstrap_min_js' => 'https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js',
    'BootStrap_npm_js' => 'https://cdn.bootcss.com/bootstrap/3.3.7/js/npm.js',

    /************ JQuery相关的CDN加速地址 ***************/
    'JQuery_core_js'=>'https://cdn.bootcss.com/jquery/3.2.1/core.js',
    'JQuery_jquery_js'=>'https://cdn.bootcss.com/jquery/3.2.1/jquery.js',
    'JQuery_jquery_min_js'=>'https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js',
);