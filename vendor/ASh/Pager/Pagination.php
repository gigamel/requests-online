<?php

namespace vendor\ASh\Pager;

use abstracts\Base;

class Pagination extends Base
{
    /** @var int */
    public $limit;
    
    /** @var int */
    public $max;
    
    /** @var int */
    public $offset = 0;
    
    /** @var int */
    public $total;
    
    /** @var string */
    public $queryVar = 'per-page';
    
    /** @var int */
    public $page = 1;
    
    /**
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        foreach ($params as $param => $value) {
            if (property_exists($this, $param)) {
                $this->{$param} = (int) $value;
            }
        }
        
        $this->total = ($this->total < 1) ? 0 : $this->total;
        $this->limit = ($this->limit < 1) ? 1 : $this->limit;
        $this->max = ceil($this->total / $this->limit);
        
        $this->page = isset($_GET[$this->queryVar])
            ? (int)$_GET[$this->queryVar]
            : 1;
        $this->page = ($this->page < 1) ? 1 : $this->page;
        $this->page = ($this->page > $this->max) ? $this->max : $this->page;
        
        $this->offset = ($this->page - 1) * $this->limit;
    }
}
