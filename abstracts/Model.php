<?php

namespace abstracts;

abstract class Model extends Base
{
    /**
     * @param array $properties
     *
     * @return void
     */
    public function load(array $properties = []): void
    {
        foreach ($properties as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }
    
    /**
     * @param null|string $key
     *
     * @return bool
     */
    public function isSubmitted(string $key): bool
    {
        return isset($_POST[$key]) ? true
            : ($_SERVER['REQUEST_METHOD'] === 'POST');
    }
}
