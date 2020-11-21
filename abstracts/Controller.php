<?php
namespace abstracts;

abstract class Controller extends Base
{
    /**
     * @var array $errors
     */
    public $errors = [];
    
    /**
     * @var string $title
     */
    protected $title = '';
    
    /**
     * @var string $layout
     */
    protected $layout = 'default';
    
    /**
     * 
     * @param string $path
     */
    public function redirect(string $path)
    {
        $path = is_string($path) ? $path : '';
        
        header("Location: {$path}");
        
        die;
    }
    
    /**
     * 
     * @param string $view
     * @param array $vars
     */
    public function render(string $view, array $vars = [])
    {
        $CONTENT_VIEW = '';
        
        $viewDir = ROOT."/app/views";
        $viewFile = "{$viewDir}/{$view}.php";
        if (file_exists($viewFile)) {
            extract($vars);
            ob_start();
            require $viewFile;
            $CONTENT_VIEW = ob_get_contents();
            ob_end_clean();
        }
        
        $TITLE_VIEW = is_string($this->title) ? $this->title : '';
        
        $viewFile = "{$viewDir}/layout/{$this->layout}.php";
        if (file_exists($viewFile)) {
            require_once $viewFile;
        }
    }
    
    /**
     * @return boolean
     */
    public function hasErrors()
    {
        return (count($this->errors) > 0);
    }
    
    /**
     * @param string|array $errors
     */
    public function attachErrors($errors = null)
    {
        if (is_string($errors)) {
            $this->errors[] = $errors;
        } elseif (is_array($errors)) {
            foreach ($errors as $error) {
                $this->errors[] = is_string($error) ? $error : '?';
            }
        }
    }
}