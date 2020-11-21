<?php
namespace abstracts;

abstract class Model extends Base
{
    /**
     * @param array $properties
     */
    public function load(array $properties = [])
    {
        foreach ($properties as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }
    
    /**
     * @param null|string $key
     * @return boolean
     */
    public function isSubmitted($key = null)
    {
        return isset($_POST[$key]) ? true : ($_SERVER['REQUEST_METHOD'] == 'POST');
    }
}