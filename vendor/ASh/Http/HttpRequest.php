<?php
namespace vendor\ASh\Http;

use abstracts\Base;

class HttpRequest extends Base
{
    /**
     * @return boolean
     */
    public function isAjax()
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest');
    }
    
    /**
     * 
     * @param null|string $key
     * @return boolean
     */
    public function post($key = null)
    {
        return isset($_POST[$key]) ? $_POST[$key] : $_POST;
    }
}