<?php
namespace Common\Test;

/**
 * 单例模式的写法
 */
class Singleton
{
    private static $_instance;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (!self::_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

}