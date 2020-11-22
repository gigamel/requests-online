<?php
namespace vendor\ASh\Filter;

use abstracts\Base;

class DataFilter extends Base
{
    public $filterVar;
    public $byVar;
    public $filter = '';
    public $by = null;
    public $options = [];
    public $condition = '';
    public $hasFiltering;
    
    /**
     * @param array $params
     */
    public function __construct($params = [])
    {
        $params = is_array($params) ? $params : [];
        foreach ($params as $param => $value) {
            if (property_exists($this, $param)) {
                $this->{$param} = $value;
            }
        }
        
        $this->adjustStringVars();
        
        $this->buildCondition();
        
        $this->adjustOptions();
    }
    
    private function adjustStringVars()
    {
        $this->condition = is_string($this->condition) ? trim($this->condition) : '';
        
        $this->filterVar = is_string($this->filterVar) ? trim($this->filterVar) : '';
        $this->filterVar = empty($this->filterVar) ? 'filter' : $this->filterVar;
        
        $this->byVar = is_string($this->byVar) ? trim($this->byVar) : '';
        $this->byVar = empty($this->byVar) ? 'by' : $this->byVar;
    }
    
    private function adjustOptions()
    {
        $this->options = is_array($this->options) ? $this->options : [];
        foreach ($this->options as $value => $option) {
            if (is_string($value) && is_string($option)) {
                $value = trim($value);
                $option = trim($option);
                if (empty($value) || empty($option)) {
                    unset($this->options[$value]);
                } else {
                    $this->options[$value] = $option;
                }
            } else {
                unset($this->options[$value]);
            }
        }
    }
    
    private function buildCondition()
    {
        $this->hasFiltering = false;
        
        if (isset($_GET[$this->byVar]) && isset($_GET[$this->filterVar])) {
            $this->by = $_GET[$this->byVar];
            $this->filter = $_GET[$this->filterVar];
            if (!empty($this->by) && !empty($this->filter)) {
                $this->condition = $this->by." LIKE '%".$this->filter."%'";
                
                $this->hasFiltering = true;
            }
        }
    }
}