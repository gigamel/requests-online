<?php

namespace vendor\ASh\Url;

class UrlManager
{
    /**
     * @param string $path
     *
     * @return string
     */
    public static function link(string $path = ''): string
    {
        $path = trim($path);
        return empty($path) ? $_SERVER['REQUEST_URI']
            : '/index.php?' . \ASh::$app->queryVar . '=' . $path;
    }
}
