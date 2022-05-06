<?php

namespace abstracts;

abstract class Controller extends Base
{
    /** @var array */
    protected $errors = [];

    /** @var string */
    protected $content;

    /** @var string */
    protected $layout;

    /** @var string */
    protected $title;

    public function __construct()
    {
        $this->errors = [];
        $this->layout = 'default';
        
        $this->setTitle();
        $this->setContent();
    }

    /**
     * @param mixed $errors
     *
     * @return void
     */
    public function attachErrors($errors = null): void
    {
        if (is_string($errors)) {
            $this->errors[] = $errors;
        }
        
        if (!is_array($errors)) {
            return;
        }
        
        foreach ($errors as $error) {
            $this->errors[] = is_string($error) ? $error : '?';
        }
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
    
    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return (bool)count($this->errors);
    }
    
    /**
     * @param string $path
     * @param bool $permanently
     *
     * @return void
     */
    public function redirect(
        string $path = '/',
        bool $permanently = false
    ): void {
        header('Location: ' . $path, true, $permanently ? 301 : 302);
        exit(1);
    }
    
    /**
     * @param string $view
     * @param array $vars
     *
     * @return void
     */
    public function render(string $view, array $vars = []): void
    {
        $viewDir = ROOT . '/app/views';
        $viewFile = $viewDir . '/' . $view . '.php';
        if (file_exists($viewFile)) {
            extract($vars);
            ob_start();
            require $viewFile;
            $this->setContent(ob_get_contents());
            ob_end_clean();
        }
        
        $viewFile = $viewDir . '/layout/' . $this->layout . '.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        }
    }
    
    /**
     * @param string $content
     *
     * @return void
     */
    public function setContent(string $content = ''): void
    {
        $this->content = $content;
    }
    
    /**
     * @param string $title
     *
     * @return void
     */
    public function setTitle(string $title = ''): void
    {
        $this->title = $title;
    }
}
