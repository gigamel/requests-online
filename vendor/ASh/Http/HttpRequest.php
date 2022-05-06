<?php

namespace vendor\ASh\Http;

use abstracts\Base;

class HttpRequest extends Base
{
    /**
     * @return bool
     */
    public function isAjax(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
    }
    
    /**
     * 
     * @param string $key
     *
     * @return mixed
     */
    public function post(string $key)
    {
        return isset($_POST[$key]) ? $_POST[$key] : $_POST;
    }
}
