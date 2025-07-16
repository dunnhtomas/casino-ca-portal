<?php
namespace App\Core;

class Router {
    private $routes = [];
    private $currentRoute = null;
    
    public function __construct() {
        $this->setupDefaultRoutes();
    }
    
    public function addRoute(string $method, string $path, $handler): void {
        $this->routes[$method][$path] = $handler;
    }
    
    public function get(string $path, $handler): void {
        $this->addRoute('GET', $path, $handler);
    }
    
    public function post(string $path, $handler): void {
        $this->addRoute('POST', $path, $handler);
    }
    
    public function dispatch(): void {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        
        // Parse URI and remove query string
        $path = parse_url($uri, PHP_URL_PATH);
        
        // Remove trailing slash unless it's root
        if ($path !== '/' && substr($path, -1) === '/') {
            $path = rtrim($path, '/');
        }
        
        // Try to match exact route
        if (isset($this->routes[$method][$path])) {
            $this->currentRoute = $path;
            $this->executeHandler($this->routes[$method][$path]);
            return;
        }
        
        // Try to match with parameters
        foreach ($this->routes[$method] ?? [] as $routePath => $handler) {
            if ($this->matchRoute($routePath, $path)) {
                $this->currentRoute = $routePath;
                $this->executeHandler($handler);
                return;
            }
        }
        
        // No route found - 404
        $this->handle404();
    }
    
    private function matchRoute(string $routePath, string $requestPath): bool {
        // Convert route path to regex
        $pattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $routePath);
        $pattern = str_replace('/', '\/', $pattern);
        $pattern = '/^' . $pattern . '$/';
        
        return preg_match($pattern, $requestPath);
    }
    
    private function executeHandler($handler): void {
        if (is_callable($handler)) {
            // Direct callable (closure or array)
            call_user_func($handler);
        } elseif (is_string($handler)) {
            // String controller notation: "ControllerName@method"
            if (strpos($handler, '@') !== false) {
                [$controllerName, $methodName] = explode('@', $handler);
                
                $controllerClass = "\\App\\Controllers\\{$controllerName}";
                $controllerFile = __DIR__ . "/../Controllers/{$controllerName}.php";
                
                if (file_exists($controllerFile)) {
                    require_once $controllerFile;
                    
                    if (class_exists($controllerClass)) {
                        $controller = new $controllerClass();
                        
                        if (method_exists($controller, $methodName)) {
                            $controller->$methodName();
                        } else {
                            throw new \Exception("Method {$methodName} not found in {$controllerClass}");
                        }
                    } else {
                        throw new \Exception("Controller class {$controllerClass} not found");
                    }
                } else {
                    throw new \Exception("Controller file {$controllerFile} not found");
                }
            } else {
                throw new \Exception("Invalid controller string format: {$handler}");
            }
        } else {
            throw new \Exception("Invalid handler type");
        }
    }
    
    private function setupDefaultRoutes(): void {
        // Default routes
        $this->get('/', [$this, 'handleHome']);
        $this->get('/home', [$this, 'handleHome']);
        $this->get('/casinos', [$this, 'handleCasinos']);
        $this->get('/casino/{id}', [$this, 'handleCasinoDetail']);
        $this->get('/reviews', [$this, 'handleReviews']);
        $this->get('/authors', [$this, 'handleAuthors']);
        $this->get('/author/{name}', [$this, 'handleAuthorProfile']);
        $this->get('/generate-content', [$this, 'handleGenerateContent']);
        $this->post('/api/generate-review', [$this, 'handleApiGenerateReview']);
        $this->get('/demo-content', [$this, 'handleContentDemo']);
    }
    
    public function handleHome(): void {
        require_once __DIR__ . '/../Controllers/HomeController.php';
        $controller = new \App\Controllers\HomeController();
        $controller->index();
    }
    
    public function handleCasinos(): void {
        require_once __DIR__ . '/../Controllers/CasinoController.php';
        $controller = new \App\Controllers\CasinoController();
        $controller->list();
        exit;
    }
    
    public function handleCasinoDetail(): void {
        require_once __DIR__ . '/../Controllers/CasinoController.php';
        $controller = new \App\Controllers\CasinoController();
        
        // Extract ID from URL
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $path = parse_url($uri, PHP_URL_PATH);
        $segments = explode('/', trim($path, '/'));
        $id = end($segments);
        
        $controller->detail($id);
        exit;
    }
    
    public function handleReviews(): void {
        // Redirect to reviews.php for now
        include __DIR__ . '/../../public/reviews.php';
        exit;
    }
    
    public function handleAuthors(): void {
        require_once __DIR__ . '/../Controllers/AuthorController.php';
        $controller = new \App\Controllers\AuthorController();
        $controller->list();
        exit;
    }
    
    public function handleAuthorProfile(): void {
        require_once __DIR__ . '/../Controllers/AuthorController.php';
        $controller = new \App\Controllers\AuthorController();
        
        // Extract author name from URL
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $path = parse_url($uri, PHP_URL_PATH);
        $segments = explode('/', trim($path, '/'));
        $authorName = end($segments);
        
        $controller->profile($authorName);
        exit;
    }
    
    public function handleGenerateContent(): void {
        require_once __DIR__ . '/../Controllers/ContentController.php';
        $controller = new \App\Controllers\ContentController();
        $controller->generate();
        exit;
    }
    
    public function handleApiGenerateReview(): void {
        require_once __DIR__ . '/../Controllers/ContentController.php';
        $controller = new \App\Controllers\ContentController();
        $controller->generateReview();
        exit;
    }
    
    public function handleContentDemo(): void {
        require_once __DIR__ . '/../Services/OpenAIService.php';
        $service = new \App\Services\OpenAIService();
        
        header('Content-Type: application/json');
        echo json_encode([
            'demo' => 'Professional Content Generation Demo',
            'status' => 'active',
            'timestamp' => date('Y-m-d H:i:s'),
            'features' => [
                'Expert casino review generation',
                'Professional author attribution', 
                'Canadian cultural authenticity',
                'Natural writing patterns',
                'Real gambling expertise',
                'Authentic personal experiences',
                'Professional quality standards',
                'Human-like content flow'
            ],
            'sample_review' => $service->generateCasinoReview([
                'name' => 'Demo Casino',
                'bonus' => '$500 Welcome Bonus',
                'games' => 300,
                'established' => 2020
            ])
        ], JSON_PRETTY_PRINT);
        exit;
    }
    
    private function handle404(): void {
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
    
    public function getCurrentRoute(): ?string {
        return $this->currentRoute;
    }
    
    /**
     * Handle the current request (alias for dispatch)
     */
    public function handleRequest(): void {
        $this->dispatch();
    }
}
