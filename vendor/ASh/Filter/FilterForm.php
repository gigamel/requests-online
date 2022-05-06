<?php

namespace vendor\ASh\Filter;

use abstracts\Base;
use vendor\ASh\Filter\DataFilter;
use vendor\ASh\Url\UrlManager;

class FilterForm extends Base
{
    /** @var string */
    private static $html = '';
    
    /** @var DataFilter */
    private static $filter;
    
    /**
     * @param DataFilter $filter
     *
     * @return string
     */
    public static function widget(DataFilter $filter): string
    {
        if (static::$filter === null) {
            static::$filter = $filter;
        }
        
        if (empty(static::$html) && count(static::$filter->options) > 0) {
            static::$html .= '<div class="filter-form my-4">';
            static::$html .= '<form method="GET" action="" autocomplete="off">';
            static::$html .= '<input type="hidden" ';
            static::$html .= 'name="' . \ASh::$app->queryVar . '" ';
            static::$html .= 'value="' . \ASh::$app->route . '">';
            static::$html .= '<div class="form-group"><div class="row">';
            
            static::$html .= '<div class="col-auto">';
            static::$html .= '<input type="text" ';
            static::$html .= 'name="' . static::$filter->filterVar . '" ';
            static::$html .= 'class="form-control" ';
            static::$html .= 'value="' . static::$filter->filter . '" ';
            static::$html .= 'placeholder="фильтр по">';
            static::$html .= '</div>';
            
            static::$html .= '<div class="col-auto">';
            static::$html .= '<select name="' . static::$filter->byVar . '" ';
            static::$html .= 'class="form-control">';
            foreach (static::$filter->options as $value => $option) {
                static::$html .= '<option value="' . $value . '"';
                if ($value == static::$filter->by) {
                    static::$html .= ' selected';
                }
                static::$html .= '>' . $option . '</option>';
            }
            static::$html .= '</select>';
            static::$html .= '</div>';
            
            static::$html .= '<div class="col-auto">';
            static::$html .= '<button type="submit" ';
            static::$html .= 'class="btn btn-primary">применить</button>';
            static::$html .= '</div>';
            
            if (static::$filter->hasFiltering) {
                static::$html .= '<div class="col-auto">';
                static::$html .= '<a href="';
                static::$html .= UrlManager::link(\ASh::$app->route) . '" ';
                static::$html .= 'class="btn btn-secondary">сбросить</a>';
                static::$html .= '</div>';
            }
            
            static::$html .= '</div></div>';
            static::$html .= '</form></div>';
        }
        
        return static::$html;
    }
}
