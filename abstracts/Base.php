<?php

namespace abstracts;

abstract class Base
{
    /**
     * @param string $name
     */
    public function __get($name)
    {
        die(
            'property ' . static::class . '::' . $name . 
                ' is not defined (from __get)'
        );
    }
    
    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        die(
            'property ' . static::class . '::' . $name .
                ' is not defined (from __set)'
        );
    }
    
    /**
     * @param string $name
     * @param array $arguments
     */
    public function __call($name, $arguments)
    {
        die(
            'method ' . static::class . '->' . $name . '() ' .
                'is not defined (from __call)'
        );
    }
    
    /**
     * @param string $name
     * @param array $arguments
     */
    public static function __callStatic($name, $arguments)
    {
        die(
            'method ' . static::class . '::' . $name .
                '() is not defined (from __callStatic)'
        );
    }
}
