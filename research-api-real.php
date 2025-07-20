<?php
/**
 * REAL CASINO RESEARCH API - ONLY OPENAI DATA
 * No fallback, no mock - serves only genuine OpenAI research results
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Load the OpenAI research results
$resultsFile = __DIR__ . '/casino-research-results.json';

if (!file_exists($resultsFile)) {
    http_response_code(404);
    echo json_encode([
        'error' => 'Research results not found. Please run real-casino-research.php first.',
        'message' => 'No OpenAI research data available. Execute the research script to generate data.',
        'status' => 'no_data'
    ]);
    exit;
}

$researchData = json_decode(file_get_contents($resultsFile), true);

if (!$researchData || !isset($researchData['casinos'])) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Invalid research data format',
        'message' => 'Research data is corrupted. Please re-run the research.',
        'status' => 'corrupted_data'
    ]);
    exit;
}

// Check if this is OpenAI-generated data
if (!isset($researchData['research_method']) || $researchData['research_method'] !== 'openai_official') {
    http_response_code(503);
    echo json_encode([
        'error' => 'Only OpenAI research data is served by this endpoint',
        'message' => 'Please run real-casino-research.php to generate proper OpenAI data.',
        'status' => 'non_openai_data'
    ]);
    exit;
}

// Optional: Filter by specific casino ID
$casinoId = $_GET['casino'] ?? null;
if ($casinoId) {
    $casino = array_filter($researchData['casinos'], fn($c) => $c['id'] === $casinoId);
    if (empty($casino)) {
        http_response_code(404);
        echo json_encode([
            'error' => 'Casino not found',
            'message' => "No casino found with ID: $casinoId",
            'status' => 'not_found'
        ]);
        exit;
    }
    echo json_encode(array_values($casino)[0]);
    exit;
}

// Return all research data with metadata
$response = [
    'success' => true,
    'data_source' => 'openai_official',
    'generated_at' => $researchData['generated_at'],
    'total_casinos' => $researchData['successful_research'],
    'research_quality' => 'professional_ai_generated',
    'stats' => $researchData['stats'],
    'casinos' => $researchData['casinos'],
    'api_info' => [
        'version' => '2.0',
        'endpoint' => '/research-api-real.php',
        'methods' => ['GET'],
        'parameters' => [
            'casino' => 'Optional casino ID for specific casino data'
        ]
    ]
];

echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
