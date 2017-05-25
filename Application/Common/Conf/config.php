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
    )
);