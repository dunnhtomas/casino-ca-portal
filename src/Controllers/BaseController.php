<?php

namespace App\Controllers;

/**
 * Base controller with common functionality
 */
class BaseController
{
    protected $viewData = [];
    
    public function __construct()
    {
        // Base initialization
    }
    
    /**
     * Render a view with data
     */
    protected function render(string $view, array $data = []): void
    {
        // Extract data to variables
        extract(array_merge($this->viewData, $data));
        
        // Build view path
        $viewPath = __DIR__ . '/../Views/' . str_replace('.', '/', $view) . '.php';
        
        if (!file_exists($viewPath)) {
            throw new \Exception("View not found: {$view}");
        }
        
        // Include view
        include $viewPath;
    }
    
    /**
     * Set view data
     */
    protected function set(string $key, $value): void
    {
        $this->viewData[$key] = $value;
    }
    
    /**
     * Get view data
     */
    protected function get(string $key, $default = null)
    {
        return $this->viewData[$key] ?? $default;
    }
}
