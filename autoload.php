<?php
/**
 * @const string ROOT
 */
defined('ROOT') or define('ROOT', __DIR__);

spl_autoload_register(function($class) {    
    $class = ltrim($class, '\\');
    
    $classFile = ROOT."/".str_replace('\\', '/', $class).".php";
    if (!file_exists($classFile)) {
        die("file <strong>{$classFile}</strong> is not exists.");
    }
    
    require $classFile;
    if (!class_exists($class)) {
        die("class <strong>{$class}</strong> is not exists.");
    }
});