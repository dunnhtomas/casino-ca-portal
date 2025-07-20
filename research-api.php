<?php
// Standalone Research Results API
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Get request path
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
$path = parse_url($requestUri, PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// Load research results
$resultsFile = __DIR__ . '/casino-research-complete.json';

if (!file_exists($resultsFile)) {
    http_response_code(404);
    echo json_encode([
        'error' => 'Research results not found',
        'message' => 'Run the research system first: php complete-casino-research.php',
        'timestamp' => date('Y-m-d H:i:s')
    ]);
    exit;
}

$results = json_decode(file_get_contents($resultsFile), true);

// Route handling
if ($path === '/api/research-results' || $path === '/research-api.php') {
    // Main API endpoint
    $response = [
        'status' => 'success',
        'version' => '1.0',
        'endpoint' => '/api/research-results',
        'timestamp' => date('Y-m-d H:i:s'),
        'meta' => [
            'total_casinos' => count($results['casinos'] ?? []),
            'openai_available' => $results['openai_available'] ?? false,
            'last_updated' => $results['generated_at'] ?? 'Unknown',
            'research_methods' => $results['research_methods'] ?? []
        ],
        'data' => $results
    ];
    
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    
} elseif (preg_match('/\/api\/casino\/(.+)/', $path, $matches)) {
    // Individual casino endpoint
    $casinoId = $matches[1];
    $casino = null;
    
    foreach ($results['casinos'] ?? [] as $c) {
        if ($c['id'] === $casinoId) {
            $casino = $c;
            break;
        }
    }
    
    if ($casino) {
        $response = [
            'status' => 'success',
            'casino_id' => $casinoId,
            'timestamp' => date('Y-m-d H:i:s'),
            'data' => $casino
        ];
        echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    } else {
        http_response_code(404);
        echo json_encode([
            'error' => 'Casino not found',
            'casino_id' => $casinoId,
            'available_casinos' => array_column($results['casinos'] ?? [], 'id'),
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    }
    
} elseif ($path === '/api/research-stats') {
    // Statistics endpoint
    $casinos = $results['casinos'] ?? [];
    $ratings = array_column($casinos, 'rating');
    $gamesCount = array_column($casinos, 'games_count');
    
    $stats = [
        'status' => 'success',
        'timestamp' => date('Y-m-d H:i:s'),
        'statistics' => [
            'total_casinos' => count($casinos),
            'average_rating' => count($ratings) > 0 ? round(array_sum($ratings) / count($ratings), 2) : 0,
            'highest_rating' => count($ratings) > 0 ? max($ratings) : 0,
            'lowest_rating' => count($ratings) > 0 ? min($ratings) : 0,
            'total_games' => array_sum($gamesCount),
            'average_games' => count($gamesCount) > 0 ? round(array_sum($gamesCount) / count($gamesCount)) : 0,
            'mobile_optimized' => count(array_filter($casinos, fn($c) => $c['mobile_optimized'] ?? false)),
            'research_methods' => $results['research_methods'] ?? [],
            'openai_available' => $results['openai_available'] ?? false,
            'last_updated' => $results['generated_at'] ?? 'Unknown'
        ]
    ];
    
    echo json_encode($stats, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    
} else {
    // API documentation
    $docs = [
        'name' => 'Casino Research Results API',
        'version' => '1.0',
        'timestamp' => date('Y-m-d H:i:s'),
        'endpoints' => [
            'GET /api/research-results' => 'Get all research results',
            'GET /api/casino/{id}' => 'Get specific casino research',
            'GET /api/research-stats' => 'Get research statistics'
        ],
        'examples' => [
            'All data' => 'https://bestcasinoportal.com/api/research-results',
            'Single casino' => 'https://bestcasinoportal.com/api/casino/bonrush_001',
            'Statistics' => 'https://bestcasinoportal.com/api/research-stats'
        ],
        'total_casinos_available' => count($results['casinos'] ?? []),
        'sample_casino_ids' => array_slice(array_column($results['casinos'] ?? [], 'id'), 0, 5)
    ];
    
    echo json_encode($docs, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}
?>
