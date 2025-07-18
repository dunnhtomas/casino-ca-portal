<?php
require_once 'vendor/autoload.php';

// Load environment
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Initialize OpenAI client
$openaiKey = $_ENV['OPENAI_API_KEY'] ?? '';
if (empty($openaiKey)) {
    echo 'ERROR: OpenAI API key not found in environment' . PHP_EOL;
    exit(1);
}

$client = new GuzzleHttp\Client();

try {
    // Research NOVAJACKPOT casino
    $prompt = 'Research NOVAJACKPOT online casino. Provide accurate information about:
1. Official website URL and license details
2. Welcome bonus package and terms
3. Game portfolio size and main providers  
4. Payment methods including crypto support
5. Key features like mobile app, VIP program
6. Withdrawal limits and processing times
7. Countries/jurisdictions served
8. Establishment year and operator
9. Customer support options
10. Any unique selling points

Format response as structured data that can be used for a casino database. Focus on facts that can be verified from official sources.';

    $response = $client->post('https://api.openai.com/v1/chat/completions', [
        'headers' => [
            'Authorization' => 'Bearer ' . $openaiKey,
            'Content-Type' => 'application/json',
        ],
        'json' => [
            'model' => 'gpt-4o-mini',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are a professional casino industry researcher. Provide accurate, factual information about online casinos that can be verified. Focus on official details like licensing, bonuses, games, and regulatory compliance.'
                ],
                [
                    'role' => 'user', 
                    'content' => $prompt
                ]
            ],
            'max_tokens' => 2000,
            'temperature' => 0.3
        ]
    ]);

    $data = json_decode($response->getBody(), true);
    
    if (isset($data['choices'][0]['message']['content'])) {
        echo '=== NOVAJACKPOT RESEARCH RESULTS ===' . PHP_EOL;
        echo $data['choices'][0]['message']['content'] . PHP_EOL;
        echo PHP_EOL . '=== END RESEARCH ===' . PHP_EOL;
    } else {
        echo 'ERROR: No content in OpenAI response' . PHP_EOL;
        print_r($data);
    }

} catch (Exception $e) {
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
    echo 'Stack trace: ' . $e->getTraceAsString() . PHP_EOL;
}
