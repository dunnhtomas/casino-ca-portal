<?php
/**
 * OPENAI-ONLY RESEARCH API ENDPOINT
 * Official OpenAI API implementation - NO FALLBACKS
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

try {
    // Check if OpenAI research results exist
    $resultsFile = __DIR__ . '/casino-research-openai-only.json';
    
    if (!file_exists($resultsFile)) {
        http_response_code(404);
        echo json_encode([
            'error' => 'OpenAI research data not found',
            'message' => 'Please run the OpenAI research first: php openai-research-official.php',
            'openai_required' => true,
            'api_docs' => 'https://platform.openai.com/docs/api-reference/introduction'
        ]);
        exit;
    }
    
    // Load OpenAI research results
    $data = json_decode(file_get_contents($resultsFile), true);
    
    if (!$data) {
        http_response_code(500);
        echo json_encode([
            'error' => 'Failed to load OpenAI research data',
            'message' => 'Research file is corrupted or invalid',
            'openai_required' => true
        ]);
        exit;
    }
    
    // Validate OpenAI data structure
    if (!isset($data['casinos']) || !is_array($data['casinos'])) {
        http_response_code(500);
        echo json_encode([
            'error' => 'Invalid OpenAI research data structure',
            'message' => 'Please re-run OpenAI research to generate valid data',
            'openai_required' => true
        ]);
        exit;
    }
    
    // Check if specific casino requested
    $casinoId = $_GET['casino'] ?? null;
    if ($casinoId) {
        $casino = null;
        foreach ($data['casinos'] as $c) {
            if ($c['id'] === $casinoId || $c['name'] === $casinoId) {
                $casino = $c;
                break;
            }
        }
        
        if (!$casino) {
            http_response_code(404);
            echo json_encode([
                'error' => 'Casino not found in OpenAI research',
                'message' => "Casino '{$casinoId}' not found in research data",
                'available_casinos' => array_column($data['casinos'], 'name')
            ]);
            exit;
        }
        
        echo json_encode($casino);
        exit;
    }
    
    // Return all OpenAI research data
    $response = [
        'casinos' => $data['casinos'],
        'stats' => $data['stats'],
        'metadata' => [
            'source' => 'OpenAI API',
            'generated_at' => $data['generated_at'],
            'total_processed' => $data['total_processed'],
            'research_method' => 'openai_official',
            'api_documentation' => 'https://platform.openai.com/docs/api-reference/introduction',
            'model_used' => 'gpt-4o-mini'
        ],
        'openai_available' => true,
        'fallback_used' => false
    ];
    
    // Handle format parameter
    $format = $_GET['format'] ?? 'json';
    if ($format === 'csv') {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="openai-casino-research.csv"');
        
        $output = fopen('php://output', 'w');
        
        // CSV headers
        $headers = ['Name', 'Rating', 'Games Count', 'Welcome Bonus', 'Mobile Optimized', 'Website', 'Research Method'];
        fputcsv($output, $headers);
        
        // CSV data
        foreach ($data['casinos'] as $casino) {
            fputcsv($output, [
                $casino['name'],
                $casino['rating'],
                $casino['games_count'],
                $casino['welcome_bonus'],
                $casino['mobile_optimized'] ? 'Yes' : 'No',
                $casino['website_url'],
                $casino['research_method']
            ]);
        }
        
        fclose($output);
        exit;
    }
    
    echo json_encode($response, JSON_PRETTY_PRINT);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'API Error',
        'message' => $e->getMessage(),
        'openai_required' => true,
        'solution' => 'Ensure OpenAI research has been completed and billing is active'
    ]);
}
?>
