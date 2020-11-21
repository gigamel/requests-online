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
    
    private function __construct()
    {
    }
}