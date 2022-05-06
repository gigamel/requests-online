<?php

final class ASh extends \abstracts\Base
{    
    /** @var string */
    private $queryVar = 'route';
    
    /** @var string */
    private $route = 'site/index';
    
    /** @var array */
    private $settings;
    
    private function __construct()
    {
        $this->settings = [];
    }
    
    /**
     * @return self
     */
    public static function createApplication(): self
    {
        return new self();
    }
    
    /**
     * @param string $dotsPath
     *
     * @return mixed
     */
    final public function getOption(string $dotsPath)
    {
        $keys = explode('.', $dotsPath);
        
        $option = array_pop($keys);
        if (!isset($this->settings[$option])) {
            return null;
        }
        
        $value = $this->settings[$option];
        
        foreach ($keys as $option) {
            if (!isset($value[$option])) {
                return null;
            }
            
            $value = $value[$option];
        }
        
        return $value;
    }
    
    /**
     * @param string $id
     *
     * @return $this
     */
    final public function loadSettings(string $id): self
    {
        $settingsFile = __DIR__ . '/settings/' . $id . '.php';
        if (!file_exists($settingsFile)) {
            return $this;
        }
        
        $settings = require_once($settingsFile);
        if (is_array($settings)) {
            $this->settings[$id] = array_merge($settings, $this->settings);
        }

        return $this;
    }
    
    /**
     * @return void
     */
    public function run(): void
    {
        session_start();
        
        if (isset($_GET[$this->queryVar])) {
            $this->route = $_GET[$this->queryVar];
            unset($_GET[$this->queryVar]);
        }
 
        if (empty($routeParts = explode('/', $this->route))) {
            die('Incorrect route: ' . $this->route);
        }
        
        $action = $this->getActionName(array_pop($routeParts));
        
        $controllerName = $this->getControllerName(
            array_pop($routeParts),
            empty($routeParts) ? implode('\\', $routeParts) . '\\' : ''
        );
        
        if (!class_exists($controllerName)) {
            die('Controller: ' . $controllerName . ' is not defined');
        }
        
        $controller = new $controllerName;
        if (
            !($controller instanceof \abstracts\Controller) ||
            !method_exists($controller, $action)
        ) {
            die('Unknown route: ' . $this->route);
        }
        
        call_user_func_array([$controller, $action], $_GET);
    }
    
    /**
     * @param string $id
     *
     * @return string
     */
    private function getActionName(string $id): string
    {
        return 'action' . str_replace('-', '', ucwords($id, '-'));
    }
    
    /**
     * @param string $id
     * @param string $prefix
     *
     * @return string
     */
    private function getControllerName(string $id, string $prefix): string
    {
        return '\\app\\controllers\\' . $prefix .
            str_replace('-', '', ucwords($id, '-')) . 'Controller';
    }
}
