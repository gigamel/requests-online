<?php
namespace vendor\ASh\Url;

use ASh;

class UrlManager
{
    /**
     * @param string $path
     * @return string
     */
    public static function link(string $path)
    {
        $path = is_string($path) ? $path : '';
        
        return empty(trim($path)) ? $_SERVER['REQUEST_URI'] : '/index.php?'.ASh::$app->queryVar.'='.$path;
    }
}