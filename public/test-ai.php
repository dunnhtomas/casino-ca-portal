<?php
// Test AI Content Generation
require_once '../vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Simple autoloader
spl_autoload_register(function ($class) {
    $prefix = 'CasinoPortal\\';
    $baseDir = __DIR__ . '/../src/';

    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }

    $relativeClass = substr($class, strlen($prefix));
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $action = $data['action'] ?? '';
        
        switch ($action) {
            case 'test_openai':
                $openAI = new CasinoPortal\Services\OpenAIService();
                $casino = new CasinoPortal\Models\Casino();
                
                // Get first casino for testing
                $casinos = $casino->getAll(1);
                if (empty($casinos)) {
                    throw new Exception("No casinos found for testing");
                }
                
                $testCasino = $casinos[0];
                $review = $openAI->generateCasinoReview($testCasino);
                
                echo json_encode([
                    'success' => true,
                    'casino' => $testCasino['name'],
                    'review_length' => strlen($review),
                    'word_count' => str_word_count($review),
                    'review_preview' => substr($review, 0, 200) . '...',
                    'ai_patterns_detected' => substr_count(strtolower($review), 'in conclusion') + 
                                            substr_count(strtolower($review), 'furthermore') +
                                            substr_count(strtolower($review), 'significantly'),
                    'canadian_elements' => substr_count(strtolower($review), 'canada') +
                                         substr_count(strtolower($review), 'canadian') +
                                         substr_count(strtolower($review), 'eh')
                ]);
                break;
                
            case 'test_blog':
                $openAI = new CasinoPortal\Services\OpenAIService();
                $blogData = [
                    'topic' => 'Best Canadian Online Casinos for Summer 2025',
                    'keywords' => ['online casino canada', 'summer gaming', 'casino bonuses'],
                    'length' => '800'
                ];
                
                $content = $openAI->generateBlogPost($blogData);
                
                echo json_encode([
                    'success' => true,
                    'topic' => $blogData['topic'],
                    'content_length' => strlen($content),
                    'word_count' => str_word_count($content),
                    'content_preview' => substr($content, 0, 300) . '...',
                    'ai_score_estimate' => (substr_count(strtolower($content), 'furthermore') + 
                                          substr_count(strtolower($content), 'significantly') +
                                          substr_count(strtolower($content), 'comprehensive')) * 10,
                    'human_elements' => substr_count(strtolower($content), 'honestly') +
                                      substr_count(strtolower($content), 'real talk') +
                                      substr_count(strtolower($content), 'eh')
                ]);
                break;
                
            default:
                echo json_encode(['error' => 'Invalid action']);
        }
    } else {
        // Show test interface
        echo json_encode([
            'message' => 'AI Content Generation Test API',
            'endpoints' => [
                'POST with action=test_openai' => 'Test casino review generation',
                'POST with action=test_blog' => 'Test blog post generation'
            ],
            'openai_configured' => !empty($_ENV['OPENAI_API_KEY']),
            'api_key_preview' => !empty($_ENV['OPENAI_API_KEY']) ? 'sk-...' . substr($_ENV['OPENAI_API_KEY'], -4) : 'not configured'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
}
