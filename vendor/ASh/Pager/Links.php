<?php

namespace vendor\ASh\Pager;

use abstracts\Base;
use vendor\ASh\Pager\Pagination;

class Links extends Base
{
    /** @var string */
    private static $html = '';
    
    /** @var Pagination */
    private static $pagination;
    
    /**
     * @param Pagination $pagination
     *
     * @return string
     */
    public static function widget(Pagination $pagination): string
    {
        if (static::$pagination === null) {
            static::$pagination = $pagination;
        }
        
        if (empty(static::$html) && static::$pagination->max > 1) {
            static::$html .= '<div class="navigation"><ul class="pagination">';
            
            for ($page = 1; $page <= static::$pagination->max; $page++) {
                static::$html .= "<li class='page-item";

                if ($page == static::$pagination->page) {
                    static::$html .= " active'>";
                    static::$html .= "<span class='page-link ";
                    static::$html .= "disabled'>{$page}</span>";
                } else {
                    static::$html .= "'><a ";
                    static::$html .= "href='" . static::buildLink($page) . "' ";
                    static::$html .= "class='page-link'>{$page}</a>";
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
    private static function buildLink(int $number = 1)
    {
        $uri = $_SERVER['REQUEST_URI'];
        
        if ($number < 1) {
            if (isset($_GET[static::$pagination->queryVar])) {
                $search = static::$pagination->queryVar .
                    '=' . $_GET[static::$pagination->queryVar];

                foreach (['&', '?'] as $prefix) {
                    $uri = str_replace($prefix . $search, '', $uri);
                }
            }
            
            return $uri;
        }
        
        if (empty($_GET) && \ASh::$app->hasRoute) {
            return $uri . '?' . static::$pagination->queryVar . '=' . $number;
        }
        
        if (!isset($_GET[static::$pagination->queryVar])) {
            return $uri . '&' . static::$pagination->queryVar . '=' . $number;
        }
        
        $prefix = static::$pagination->queryVar . '=';

        return str_replace(
            $prefix . $_GET[static::$pagination->queryVar],
            $prefix . $number,
            $uri
        );
    }
}
