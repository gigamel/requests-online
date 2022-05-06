<?php

defined('ROOT') or define('ROOT', __DIR__);

spl_autoload_register(function ($class) {
    $class = ltrim($class, '\\');
    
    $classFile = ROOT . '/' . str_replace('\\', '/', $class) . '.php';
    if (!file_exists($classFile)) {
        die('file: ' . $classFile . ' is not exists');
    }
    
    require_once $classFile;
    if (!class_exists($class)) {
        die('class: ' . $class . ' is not exists');
    }
});
