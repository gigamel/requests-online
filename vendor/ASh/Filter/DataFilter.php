<?php

namespace vendor\ASh\Filter;

use abstracts\Base;

class DataFilter extends Base
{
    /** @var string */
    public $filterVar;
    
    /** @var string */
    public $byVar;
    
    /** @var string */
    public $filter;
    
    /** @var string */
    public $by;
    
    /** @var array */
    public $options;
    
    /** @var string */
    public $condition;
    
    /** @var bool */
    public $hasFiltering;
    
    /**
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        foreach ($params as $param => $value) {
            if (property_exists($this, $param)) {
                $this->{$param} = $value;
            }
        }
        
        $this->filter = '';
        $this->options = [];
        $this->condition = '';
        
        $this->adjustStringVars();
        $this->buildCondition();
        $this->adjustOptions();
    }
    
    /**
     * @return void
     */
    private function adjustStringVars(): void
    {
        $this->condition = trim((string)($this->condition));

        $this->filterVar = trim((string)($this->filterVar ?? ''));
        if (empty($this->filterVar)) {
            $this->filterVar = 'filter';
        }
        
        $this->byVar = trim((string)($this->byVar ?? ''));
        if (empty($this->byVar)) {
            $this->byVar = 'by';
        }
    }
    
    /**
     * @return void
     */
    private function adjustOptions(): void
    {
        foreach ($this->options as $value => $option) {
            if (
                is_string($value) &&
                is_string($option) &&
                !empty($value) &&
                !empty($option)
            ) {
                $this->options[$value] = $option;
            } else {
                unset($this->options[$value]);
            }
        }
    }
    
    /**
     * @return void
     */
    private function buildCondition(): void
    {
        $this->hasFiltering = false;

        if (!isset($_GET[$this->byVar]) || !isset($_GET[$this->filterVar])) {
            return;
        }

        $this->by = $_GET[$this->byVar];
        $this->filter = $_GET[$this->filterVar];
        
        if (empty($this->by) || empty($this->filter)) {
            return;
        }
        
        $this->condition = $this->by . " LIKE '%" . $this->filter . "%'";
        $this->hasFiltering = true;
    }
}
