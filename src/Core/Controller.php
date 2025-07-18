<?php
namespace App\Core;

abstract class Controller {
    protected $data = [];
    
    /**
     * Set data to be passed to views
     */
    protected function setData(array $data): void {
        $this->data = array_merge($this->data, $data);
    }
    
    /**
     * Get a specific data value
     */
    protected function getData(string $key, $default = null) {
        return $this->data[$key] ?? $default;
    }
    
    /**
     * Render a view with data
     */
    protected function render(string $view, array $data = []): string {
        $viewData = array_merge($this->data, $data);
        
        // Extract variables for the view
        extract($viewData);
        
        // Start output buffering
        ob_start();
        
        // Include the view file
        $viewFile = (defined('VIEWS_PATH') ? VIEWS_PATH : dirname(__DIR__) . '/Views') . '/' . $view . '.php';
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            throw new \Exception("View file not found: {$viewFile}");
        }
        
        // Return the rendered content
        return ob_get_clean();
    }
    
    /**
     * Redirect to a URL
     */
    protected function redirect(string $url, int $statusCode = 302): void {
        header("Location: {$url}", true, $statusCode);
        exit;
    }
    
    /**
     * Return JSON response
     */
    protected function json(array $data, int $statusCode = 200): void {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    /**
     * Handle 404 errors
     */
    protected function notFound(): void {
        http_response_code(404);
        echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | Best Casino Portal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: white;
            text-align: center;
            padding: 50px 20px;
            margin: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 15px;
            border: 1px solid rgba(212,175,55,0.3);
        }
        h1 {
            font-size: 4rem;
            color: #ffd700;
            margin-bottom: 20px;
        }
        h2 {
            font-size: 2rem;
            margin-bottom: 20px;
        }
        p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            color: #cccccc;
        }
        .btn {
            background: linear-gradient(45deg, #d4af37, #ffd700);
            color: #1a1a2e;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            margin: 0 10px;
            transition: transform 0.3s ease;
        }
        .btn:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>404</h1>
        <h2>🎰 Page Not Found</h2>
        <p>Sorry, the page you\'re looking for doesn\'t exist.<br>
        Maybe try your luck at our casino reviews instead?</p>
        <a href="/" class="btn">🏠 Go Home</a>
        <a href="/reviews" class="btn">🎲 View Reviews</a>
    </div>
</body>
</html>';
        exit;
    }
    
    /**
     * Validate CSRF token
     */
    protected function validateCsrf(string $token): bool {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
    
    /**
     * Generate CSRF token
     */
    protected function generateCsrf(): string {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}
