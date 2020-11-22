<?php
namespace vendor\ASh\Filter;

use ASh;
use abstracts\Base;
use vendor\ASh\Filter\DataFilter;
use vendor\ASh\Url\UrlManager;

class FilterForm extends Base
{
    /**
     * @var string $html
     */
    private static $html = '';
    
    /**
     * @var DataFilter $filter
     */
    private static $filter;
    
    /**
     * @param DataFilter $filter
     * @return string
     */
    public static function widget(DataFilter $filter)
    {
        if (static::$filter === null) {
            static::$filter = $filter;
        }
        
        if (empty(static::$html) && count(static::$filter->options) > 0) {
            static::$html .= '<div class="filter-form my-4"><form method="GET" action="" autocomplete="off">';
            static::$html .= '<input type="hidden" name="'.ASh::$app->queryVar.'" value="'.ASh::$app->route.'">';
            static::$html .= '<div class="form-group"><div class="row">';
            
            static::$html .= '<div class="col-auto">';
            static::$html .= '<input type="text" name="'.static::$filter->filterVar.'" class="form-control" value="'.static::$filter->filter.'" placeholder="фильтр по">';
            static::$html .= '</div>';
            
            static::$html .= '<div class="col-auto">';
            static::$html .= '<select name="'.static::$filter->byVar.'" class="form-control">';
            foreach (static::$filter->options as $value => $option) {
                static::$html .= '<option value="'.$value.'"';
                if ($value == static::$filter->by) {
                    static::$html .= ' selected';
                }
                static::$html .= '>'.$option.'</option>';
            }
            static::$html .= '</select>';
            static::$html .= '</div>';
            
            static::$html .= '<div class="col-auto">';
            static::$html .= '<button type="submit" class="btn btn-primary">применить</button>';
            static::$html .= '</div>';
            
            if (static::$filter->hasFiltering) {
                static::$html .= '<div class="col-auto">';
                static::$html .= '<a href="'.UrlManager::link(ASh::$app->route).'" class="btn btn-secondary">сбросить</a>';
                static::$html .= '</div>';
            }
            
            static::$html .= '</div></div>';
            static::$html .= '</form></div>';
        }
        
        return static::$html;
    }
}