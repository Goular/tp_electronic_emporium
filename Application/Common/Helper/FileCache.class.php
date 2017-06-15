<?php
namespace Common\Helper;

class FileCache
{
    private $_dir;
    const EXT = '.txt';

    public function __construct()
    {
        $this->_dir = dirname(__FILE__) . '/files/';
    }

    public function cacheData($fileName, $value = '', $cacheTime = 0)
    {
        $filename = $this->_dir . $fileName . self::EXT;

        if ($value !== '') { // 将value值写入缓存
            if (is_null($value)) {
                return @unlink($filename);
            }
            $dir = dirname($filename);
            if (!is_dir($dir)) {
                mkdir($dir, 0777);
            }
            $cacheTime = sprintf('%011d', $cacheTime);//11位补0
            return file_put_contents($filename, $cacheTime . json_encode($value));
        }

        if (!is_file($filename)) {
            return FALSE;
        }
        $contents = file_get_contents($filename);
        $cacheTime = (int)substr($contents, 0, 11);
        $value = substr($contents, 11);
        //根据文件的修改时间,判断是否过期
        if ($cacheTime != 0 && ($cacheTime + filemtime($filename) < time())) {
            unlink($filename);
            return FALSE;
        }
        return json_decode($value, true);
    }
}