<?php
namespace vendor\ASh\Pager;

use ASh;
use abstracts\Base;
use vendor\ASh\Pager\Pagination;

class Links extends Base
{
    /**
     * @var string $html
     */
    private static $html = '';
    
    /**
     * @var Pagination $pagination
     */
    private static $pagination;
    
    /**
     * @param Pagination $pagination
     * @return string
     */
    public static function widget(Pagination $pagination)
    {
        if (static::$pagination === null) {
            static::$pagination = $pagination;
        }
        
        if (empty(static::$html) && static::$pagination->max > 1) {
            static::$html .= '<div class="navigation"><ul class="pagination">';
            
            for ($page = 1; $page <= static::$pagination->max; $page++) {
                static::$html .= "<li class='page-item";
                
                if ($page == static::$pagination->page) {
                    static::$html .= " active'><span class='page-link disabled'>{$page}</span>";
                } else {
                    
                    static::$html .= "'><a href='".static::buildLink($page)."' class='page-link'>{$page}</a>";
                }
                
                static::$html .= '</li>';
            }
            
            static::$html .= '</ul></div>';
        }
        
        return static::$html;
    }
    
    /**
     * @param int $number
     */
    private static function buildLink($number = 1)
    {
        $uri = $_SERVER['REQUEST_URI'];
        
        $number = (int) $number;
        if ($number > 1) {
            if (empty($_GET) && ASh::$app->hasRoute) {
                $uri .= '?' . static::$pagination->queryVar . '=' . $number;
            } else {
                if (isset($_GET[static::$pagination->queryVar])) {
                    $uri = str_replace(
                        static::$pagination->queryVar . '=' . $_GET[static::$pagination->queryVar],
                        static::$pagination->queryVar . '=' . $number,
                        $uri
                    );
                } else {
                    $uri .= '&' . static::$pagination->queryVar . '=' . $number;
                }
            }
        } else {
            if (isset($_GET[static::$pagination->queryVar])) {
                $prefixes = ['&', '?'];
                $search = static::$pagination->queryVar . '=' . $_GET[static::$pagination->queryVar];
                foreach ($prefixes as $prefix) {
                    $uri = str_replace($prefix . $search, '', $uri);
                }
            }
        }
        
        return $uri;
    }
}