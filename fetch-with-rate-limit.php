<?php
// Enhanced Content Fetcher with Rate Limiting and Retry Logic
// Uses our advanced anti-AI detection system

require_once 'vendor/autoload.php';
require_once 'src/Services/OpenAIService.php';

use CasinoPortal\Services\OpenAIService;

// Load environment
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

class RateLimitedOpenAIService extends OpenAIService {
    private $requestCount = 0;
    private $lastRequestTime = 0;
    private $minInterval = 3; // 3 seconds between requests
    
    public function generateCasinoReview(array $casinoData): string {
        $this->respectRateLimit();
        
        $maxRetries = 3;
        $backoffDelay = 5; // Start with 5 seconds
        
        for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
            try {
                $result = parent::generateCasinoReview($casinoData);
                echo "✅ Generated review for {$casinoData['name']} (attempt $attempt)\n";
                return $result;
            } catch (Exception $e) {
                if (strpos($e->getMessage(), '429') !== false) {
                    echo "⏳ Rate limited for {$casinoData['name']}, waiting {$backoffDelay}s (attempt $attempt/$maxRetries)\n";
                    if ($attempt < $maxRetries) {
                        sleep($backoffDelay);
                        $backoffDelay *= 2; // Exponential backoff
                    } else {
                        throw new Exception("Max retries exceeded for {$casinoData['name']}: " . $e->getMessage());
                    }
                } else {
                    throw $e;
                }
            }
        }
        
        throw new Exception("Failed to generate review after $maxRetries attempts");
    }
    
    public function generateImage(string $prompt): string {
        $this->respectRateLimit();
        
        $maxRetries = 3;
        $backoffDelay = 5;
        
        for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
            try {
                $result = parent::generateImage($prompt);
                echo "✅ Generated image (attempt $attempt)\n";
                return $result;
            } catch (Exception $e) {
                if (strpos($e->getMessage(), '429') !== false) {
                    echo "⏳ Rate limited for image, waiting {$backoffDelay}s (attempt $attempt/$maxRetries)\n";
                    if ($attempt < $maxRetries) {
                        sleep($backoffDelay);
                        $backoffDelay *= 2;
                    }
                } else {
                    throw $e;
                }
            }
        }
        
        throw new Exception("Failed to generate image after $maxRetries attempts");
    }
    
    private function respectRateLimit() {
        $this->requestCount++;
        $currentTime = time();
        $timeSinceLastRequest = $currentTime - $this->lastRequestTime;
        
        if ($timeSinceLastRequest < $this->minInterval) {
            $sleepTime = $this->minInterval - $timeSinceLastRequest;
            echo "⏳ Rate limiting: sleeping for {$sleepTime}s\n";
            sleep($sleepTime);
        }
        
        $this->lastRequestTime = time();
    }
}

$openAI = new RateLimitedOpenAIService();

// Smaller batch for testing - just 2 casinos first
$casinosToFetch = [
    [
        'name' => 'Jackpot City Casino',
        'bonus_description' => '$1600 Welcome Bonus + 100 Free Spins',
        'rating' => 9.5,
        'website_url' => 'https://www.jackpotcitycasino.com',
        'original_url' => 'https://www.casino.ca/jackpot-city-casino-review/'
    ],
    [
        'name' => 'Spin Casino',
        'bonus_description' => '$1000 Welcome Bonus + 100 Free Spins',
        'rating' => 9.3,
        'website_url' => 'https://www.spincasino.com',
        'original_url' => 'https://www.casino.ca/spin-casino-review/'
    ]
];

echo "🎰 Casino.ca Content Fetcher & Rewriter (Rate Limited)\n";
echo "🤖 Using Advanced Anti-AI Detection System\n";
echo "⏳ Built-in rate limiting and retry logic\n";
echo "=====================================\n\n";

// Create content directory
if (!is_dir('content')) {
    mkdir('content', 0755, true);
    echo "📁 Created content directory\n\n";
}

$successCount = 0;
$totalStartTime = time();

foreach ($casinosToFetch as $index => $casino) {
    $startTime = time();
    echo "Processing " . ($index + 1) . "/" . count($casinosToFetch) . ": {$casino['name']}\n";
    echo "Original: {$casino['original_url']}\n";
    
    try {
        // Generate rewritten review using our anti-AI system
        echo "🤖 Generating AI review with anti-detection...\n";
        $rewrittenContent = $openAI->generateCasinoReview($casino);
        
        // Generate banner image
        echo "🎨 Generating casino banner image...\n";
        $imagePrompt = "Professional casino banner for {$casino['name']}, modern luxury design, gold and red colors, playing cards and poker chips, high-end casino atmosphere, no text overlay, photorealistic";
        $imageUrl = $openAI->generateImage($imagePrompt);
        
        // Download and save image
        $imagePath = null;
        if ($imageUrl) {
            $imageContent = file_get_contents($imageUrl);
            if ($imageContent) {
                $imagePath = 'content/' . strtolower(str_replace([' ', '&'], ['-', 'and'], $casino['name'])) . '-banner.jpg';
                file_put_contents($imagePath, $imageContent);
                echo "🖼️  Image saved to: $imagePath\n";
            }
        }
        
        // Save content to file
        $filename = 'content/' . strtolower(str_replace([' ', '&'], ['-', 'and'], $casino['name'])) . '-review.md';
        
        $fileContent = "# {$casino['name']} Review - July 2025\n\n";
        $fileContent .= "**Rating:** {$casino['rating']}/10\n";
        $fileContent .= "**Bonus:** {$casino['bonus_description']}\n";
        $fileContent .= "**Website:** {$casino['website_url']}\n";
        $fileContent .= "**Original Source:** {$casino['original_url']}\n";
        if ($imagePath) {
            $fileContent .= "**Banner Image:** $imagePath\n";
        }
        $fileContent .= "**Generated:** " . date('Y-m-d H:i:s') . "\n\n";
        $fileContent .= "---\n\n";
        $fileContent .= $rewrittenContent;
        
        file_put_contents($filename, $fileContent);
        
        $processingTime = time() - $startTime;
        echo "✅ Review saved to: $filename\n";
        echo "📝 Content length: " . str_word_count($rewrittenContent) . " words\n";
        echo "⏱️  Processing time: {$processingTime}s\n";
        
        // Show first 150 characters as preview
        $preview = substr($rewrittenContent, 0, 150) . "...";
        echo "👀 Preview: $preview\n";
        echo "\n";
        
        $successCount++;
        
    } catch (Exception $e) {
        echo "❌ Error processing {$casino['name']}: " . $e->getMessage() . "\n\n";
    }
}

$totalTime = time() - $totalStartTime;
echo "=====================================\n";
echo "🎯 Content Generation Complete!\n";
echo "✅ Successfully generated: $successCount/" . count($casinosToFetch) . " reviews\n";
echo "⏱️  Total processing time: {$totalTime}s\n";
echo "📁 Check the 'content/' directory for all generated content\n";
echo "🔥 All content uses 2025 anti-AI detection techniques\n";
echo "🇨🇦 Optimized for Canadian casino players\n";

if ($successCount > 0) {
    echo "\n🚀 Next steps:\n";
    echo "1. Review generated content for quality\n";
    echo "2. Import content into database\n";
    echo "3. Update website with new reviews\n";
    echo "4. Generate more casino reviews\n";
}
?>
