<?php
// Load environment variables from .env file
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        
        if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
}

require_once 'src/Services/OpenAIService.php';

use App\Services\OpenAIService;

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

try {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input || !isset($input['type']) || !isset($input['casino_data'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid input. Required: type, casino_data']);
        exit;
    }
    
    $openai = new OpenAIService();
    
    if ($input['type'] === 'casino_review') {
        $content = $openai->generateCasinoReview($input['casino_data']);
        
        echo json_encode([
            'success' => true,
            'content' => $content,
            'casino' => $input['casino_data']['name'],
            'timestamp' => date('Y-m-d H:i:s'),
            'detection_status' => 'Anti-AI processed'
        ]);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Unsupported content type']);
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Content generation failed',
        'message' => $e->getMessage()
    ]);
}
?>
