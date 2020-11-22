<?php

final class ASh extends \abstracts\Base
{
    /**
     * @var ASh $app
     */
    public static $app = null;
    
    /**
     * @var string $queryVar
     */
    public $queryVar = 'route';
    
    /**
     * @var string $route;
     */
    public $route = 'site/index';
    
    /**
     * @var boolean $hasRoute
     */
    public $hasRoute = false;
    
    /**
     * @var array $_settings
     */
    private $_settings = [];
    
    /**
     * @var array $settings
     */
    private $settings = [];
    
    /**
     * @return ASh
     */
    public static function createApplication()
    {
        if (static::$app === null) {
            static::$app = new static();
        }
        
        return static::$app;
    }
    
    public function run()
    {
        session_start();
        
        if (isset($_GET[$this->queryVar])) {
            $this->route = $_GET[$this->queryVar];
            unset($_GET[$this->queryVar]);
            $hasRoute = true;
        }
        
        $controllerPrefix = '';
        
        $routeParts = explode('/', $this->route);
        if (count($routeParts) > 1) {
            $actionId = array_pop($routeParts);
            $controllerId = array_pop($routeParts);
            
            if (count($routeParts) > 0) {
                $controllerPrefix = implode('\\', $routeParts).'\\';
            }
            $action = 'action'.str_replace('-', '', ucwords($actionId, '-'));
            $controllerName = '\\app\\controllers\\'.$controllerPrefix
                .str_replace('-', '', ucwords($controllerId, '-')).'Controller';

            $controller = new $controllerName;
            if ($controller instanceof \abstracts\Controller) {
                call_user_func_array([$controller, $action], $_GET);    
            } else {
                die("<strong>{$controllerName}</strong> must be extends from <strong>\abstracts\Controller.</strong>");
            }
        } else {
            die("{$this->route} not correct.");
        }
    }
    
    /**
     * @param string $type
     * @return $this
     */
    final public function loadSettings($type = null)
    {
        if (is_string($type)) {
            if (!isset($this->_settings[$type])) {
                $settingsFile = __DIR__ . '/settings/' . $type . '.php';
                if (file_exists($settingsFile)) {
                    $settings = require_once($settingsFile);
                    if (is_array($settings)) {
                        $this->_settings[$type] = true;
                        $this->settings[$type] = array_merge($settings, $this->settings);
                    }
                }
            }
        }

        return $this;
    }
    
    /**
     * @param string $dotsPath
     */
    final public function getOption($dotsPath = null)
    {
        $value = null;

        $dotsPath = is_string($dotsPath) ? $dotsPath : null;
        if (!is_null($dotsPath)) {
            $keys = explode('.', $dotsPath);
            foreach ($keys as $key) {
                if (is_null($value)) {
                    if (isset($this->settings[$key])) {
                        $value = $this->settings[$key];
                    } else {
                        break;
                    }
                } else {
                    if (isset($value[$key])) {
                        $value = $value[$key];
                    } else {
                        break;
                    }
                }
            }
        }
        
        return $value;
    }
    
    private function __construct()
    {
    }
}