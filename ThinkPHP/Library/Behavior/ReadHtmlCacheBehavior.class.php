<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
namespace Behavior;

use Think\Storage;

/**
 * 系统行为扩展：静态缓存读取
 */
$fp = null;

class ReadHtmlCacheBehavior
{
    // 行为扩展的执行入口必须是run
    public function run(&$params)
    {
        // 开启静态缓存
        if (IS_GET && C('HTML_CACHE_ON')) {
            $cacheTime = $this->requireHtmlCache();
            if (false !== $cacheTime && $this->checkHTMLCache(HTML_FILE_NAME, $cacheTime)) {
                //静态页面有效
                // 读取静态页面输出
                echo Storage::read(HTML_FILE_NAME, 'html');
                exit();
            }

            // 如果静态页不存在或者已经过期就向后执行 --》 只让一个客户端通过这里生成静态页，其他客户端阻塞在这等待第一个客户端生成静态页
            global $fp;
            $fp = fopen('./read_html_cache.lock', 'r');
            flock($fp, LOCK_EX); // 只有一个客户端可以通过其他的阻塞在这

            if (false !== $cacheTime && $this->checkHTMLCache(HTML_FILE_NAME, $cacheTime)) { //静态页面有效
                // 读取静态页面输出
                echo Storage::read(HTML_FILE_NAME, 'html');
                exit();
            }
        }
    }

    // 判断是否需要静态缓存
    private static function requireHtmlCache()
    {
        // 分析当前的静态规则
        $htmls = C('HTML_CACHE_RULES'); // 读取静态规则
        if (!empty($htmls)) {
            $htmls = array_change_key_case($htmls);
            // 静态规则文件定义格式 actionName=>array('静态规则','缓存时间','附加规则')
            // 'read'=>array('{id},{name}',60,'md5') 必须保证静态规则的唯一性 和 可判断性
            // 检测静态规则
            $controllerName = strtolower(CONTROLLER_NAME);
            $actionName = strtolower(ACTION_NAME);
            if (isset($htmls[$controllerName . ':' . $actionName])) {
                $html = $htmls[$controllerName . ':' . $actionName]; // 某个控制器的操作的静态规则
            } elseif (isset($htmls[$controllerName . ':'])) {
// 某个控制器的静态规则
                $html = $htmls[$controllerName . ':'];
            } elseif (isset($htmls[$actionName])) {
                $html = $htmls[$actionName]; // 所有操作的静态规则
            } elseif (isset($htmls['*'])) {
                $html = $htmls['*']; // 全局静态规则
            }
            if (!empty($html)) {
                // 解读静态规则
                $rule = is_array($html) ? $html[0] : $html;
                // 以$_开头的系统变量
                $callback = function ($match) {
                    switch ($match[1]) {
                        case '_GET':
                            $var = $_GET[$match[2]];
                            break;
                        case '_POST':
                            $var = $_POST[$match[2]];
                            break;
                        case '_REQUEST':
                            $var = $_REQUEST[$match[2]];
                            break;
                        case '_SERVER':
                            $var = $_SERVER[$match[2]];
                            break;
                        case '_SESSION':
                            $var = $_SESSION[$match[2]];
                            break;
                        case '_COOKIE':
                            $var = $_COOKIE[$match[2]];
                            break;
                    }
                    return (count($match) == 4) ? $match[3]($var) : $var;
                };
                $rule = preg_replace_callback('/{\$(_\w+)\.(\w+)(?:\|(\w+))?}/', $callback, $rule);
                // {ID|FUN} GET变量的简写
                $rule = preg_replace_callback('/{(\w+)\|(\w+)}/', function ($match) {
                    return $match[2]($_GET[$match[1]]);
                }, $rule);
                $rule = preg_replace_callback('/{(\w+)}/', function ($match) {
                    return $_GET[$match[1]];
                }, $rule);
                // 特殊系统变量
                $rule = str_ireplace(
                    array('{:controller}', '{:action}', '{:module}'),
                    array(CONTROLLER_NAME, ACTION_NAME, MODULE_NAME),
                    $rule);
                // {|FUN} 单独使用函数
                $rule = preg_replace_callback('/{|(\w+)}/', function ($match) {
                    return $match[1]();
                }, $rule);
                $cacheTime = C('HTML_CACHE_TIME', null, 60);
                if (is_array($html)) {
                    if (!empty($html[2])) {
                        $rule = $html[2]($rule);
                    }
                    // 应用附加函数
                    $cacheTime = isset($html[1]) ? $html[1] : $cacheTime; // 缓存有效期
                } else {
                    $cacheTime = $cacheTime;
                }

                // 当前缓存文件
                define('HTML_FILE_NAME', HTML_PATH . $rule . C('HTML_FILE_SUFFIX', null, '.html'));
                return $cacheTime;
            }
        }
        // 无需缓存
        return false;
    }

    /**
     * 检查静态HTML文件是否有效
     * 如果无效需要重新更新
     * @access public
     * @param string $cacheFile 静态文件名
     * @param integer $cacheTime 缓存有效期
     * @return boolean
     */
    public static function checkHTMLCache($cacheFile = '', $cacheTime = '')
    {
        if (!is_file($cacheFile) && 'sae' != APP_MODE) {
            return false;
        } elseif (filemtime(\Think\Think::instance('Think\View')->parseTemplate()) > Storage::get($cacheFile, 'mtime', 'html')) {
            // 模板文件如果更新静态文件需要更新
            return false;
        } elseif (!is_numeric($cacheTime) && function_exists($cacheTime)) {
            return $cacheTime($cacheFile);
        } elseif (0 != $cacheTime && NOW_TIME > Storage::get($cacheFile, 'mtime', 'html') + $cacheTime) {
            // 文件是否在有效期
            return false;
        }
        //静态文件有效
        return true;
    }

}
