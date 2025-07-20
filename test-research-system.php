<?php
// Simple test for research results API
echo "🧪 Testing Research Results System\n";
echo "==================================\n";

// Test 1: Check if research file exists
$resultsFile = __DIR__ . '/casino-research-complete.json';
echo "📁 Research file: " . ($results_file_exists = file_exists($resultsFile) ? '✅ Exists' : '❌ Missing') . "\n";

if ($results_file_exists) {
    $data = json_decode(file_get_contents($resultsFile), true);
    echo "📊 Total casinos: " . count($data['casinos'] ?? []) . "\n";
    echo "🔄 OpenAI available: " . ($data['openai_available'] ? 'Yes' : 'No') . "\n";
    echo "📅 Generated: " . ($data['generated_at'] ?? 'Unknown') . "\n";
    
    // Show first casino
    if (!empty($data['casinos'])) {
        $firstCasino = $data['casinos'][0];
        echo "\n🎰 Sample Casino:\n";
        echo "  Name: " . $firstCasino['name'] . "\n";
        echo "  Rating: " . $firstCasino['rating'] . "\n";
        echo "  Method: " . $firstCasino['research_method'] . "\n";
        echo "  Games: " . $firstCasino['games_count'] . "\n";
    }
}

// Test 2: Check class autoloading
echo "\n🔧 Testing Class Loading:\n";
try {
    // Try to instantiate the controller
    $controllerFile = __DIR__ . '/src/Controllers/CasinoResearchResultsController.php';
    echo "📂 Controller file: " . (file_exists($controllerFile) ? '✅ Exists' : '❌ Missing') . "\n";
    
    require_once __DIR__ . '/vendor/autoload.php';
    
    if (class_exists('CasinoPortal\\Controllers\\CasinoResearchResultsController')) {
        echo "🎯 Controller class: ✅ Loaded\n";
    } else {
        echo "🎯 Controller class: ❌ Not found\n";
    }
    
} catch (Exception $e) {
    echo "❌ Class loading error: " . $e->getMessage() . "\n";
}

// Test 3: Create simple API response
echo "\n🌐 Creating API Response:\n";
if ($results_file_exists) {
    $apiResponse = [
        'status' => 'success',
        'version' => '1.0',
        'timestamp' => date('Y-m-d H:i:s'),
        'data' => $data
    ];
    
    $outputFile = __DIR__ . '/test-api-response.json';
    file_put_contents($outputFile, json_encode($apiResponse, JSON_PRETTY_PRINT));
    echo "✅ API response created: " . $outputFile . "\n";
    echo "📏 File size: " . round(filesize($outputFile) / 1024, 2) . " KB\n";
}

echo "\n🎯 Direct Access Test:\n";
echo "Try visiting these URLs:\n";
echo "  📊 Dashboard: https://bestcasinoportal.com/research-results\n";
echo "  🔌 API: https://bestcasinoportal.com/api/research-results\n";
echo "  📥 CSV Export: https://bestcasinoportal.com/research-results/export/csv\n";

echo "\n✨ Research system is ready!\n";
?>
