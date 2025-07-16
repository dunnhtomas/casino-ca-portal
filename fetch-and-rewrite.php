<?php
// Quick Content Fetcher and Rewriter for Casino.ca
// Uses our advanced anti-AI detection system

// Check if autoloader exists
if (file_exists('vendor/autoload.php')) {
    require_once 'vendor/autoload.php';
} else {
    echo "❌ Error: Composer dependencies not installed. Run 'composer install' first.\n";
    exit(1);
}

require_once 'src/Services/OpenAIService.php';

use Dotenv\Dotenv;
use App\Services\OpenAIService;

// Load environment - check if .env exists
if (file_exists('.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
} else {
    echo "❌ Error: .env file not found. Please create .env file with required configurations.\n";
    exit(1);
}

$openAI = new OpenAIService();

// Casino.ca casinos to fetch and rewrite
$casinosToFetch = [
    [
        'name' => 'Jackpot City Casino',
        'bonus' => '$1600 Welcome Bonus + 100 Free Spins',
        'bonus_description' => '$1600 Welcome Bonus + 100 Free Spins',
        'games' => 1500,
        'established' => 1998,
        'rating' => 9.5,
        'website_url' => 'https://www.jackpotcitycasino.com',
        'original_url' => 'https://www.casino.ca/jackpot-city-casino-review/'
    ],
    [
        'name' => 'Spin Casino',
        'bonus' => '$1000 Welcome Bonus + 100 Free Spins',
        'bonus_description' => '$1000 Welcome Bonus + 100 Free Spins',
        'games' => 1200,
        'established' => 2001,
        'rating' => 9.3,
        'website_url' => 'https://www.spincasino.com',
        'original_url' => 'https://www.casino.ca/spin-casino-review/'
    ],
    [
        'name' => 'Royal Vegas Casino',
        'bonus' => '$1200 Welcome Package + 120 Free Spins',
        'bonus_description' => '$1200 Welcome Package + 120 Free Spins',
        'games' => 800,
        'established' => 2000,
        'rating' => 9.1,
        'website_url' => 'https://www.royalvegas.com',
        'original_url' => 'https://www.casino.ca/royal-vegas-casino-review/'
    ],
    [
        'name' => 'Ruby Fortune Casino',
        'bonus' => '$750 Welcome Bonus + 100 Free Spins',
        'bonus_description' => '$750 Welcome Bonus + 100 Free Spins',
        'games' => 650,
        'established' => 2003,
        'rating' => 8.9,
        'website_url' => 'https://www.rubyfortune.com',
        'original_url' => 'https://www.casino.ca/ruby-fortune-casino-review/'
    ],
    [
        'name' => 'Captain Cooks Casino',
        'bonus' => '$500 Welcome Bonus + 100 Chances to Win',
        'bonus_description' => '$500 Welcome Bonus + 100 Chances to Win',
        'games' => 500,
        'established' => 1999,
        'rating' => 8.7,
        'website_url' => 'https://www.captaincooks.com',
        'original_url' => 'https://www.casino.ca/captain-cooks-casino-review/'
    ]
];

echo "🎰 Casino.ca Content Fetcher & Rewriter\n";
echo "🤖 Using Advanced Anti-AI Detection System\n";
echo "=====================================\n\n";

foreach ($casinosToFetch as $index => $casino) {
    echo "Processing " . ($index + 1) . "/" . count($casinosToFetch) . ": {$casino['name']}\n";
    echo "Original: {$casino['original_url']}\n";
    
    try {
        // Check if OpenAI API key is available
        if (empty($_ENV['OPENAI_API_KEY'])) {
            throw new Exception("OpenAI API key not found in environment variables");
        }
        
        // Generate rewritten review using our anti-AI system
        $rewrittenContent = $openAI->generateCasinoReview($casino);
        
        // Save to file
        $filename = 'content/' . strtolower(str_replace([' ', '&'], ['-', 'and'], $casino['name'])) . '-review.md';
        
        // Create content directory if it doesn't exist
        if (!is_dir('content')) {
            mkdir('content', 0755, true);
        }
        
        $fileContent = "# {$casino['name']} Review - July 2025\n\n";
        $fileContent .= "**Rating:** {$casino['rating']}/10\n";
        $fileContent .= "**Bonus:** {$casino['bonus_description']}\n";
        $fileContent .= "**Website:** {$casino['website_url']}\n";
        $fileContent .= "**Original Source:** {$casino['original_url']}\n\n";
        $fileContent .= "---\n\n";
        $fileContent .= $rewrittenContent;
        
        file_put_contents($filename, $fileContent);
        
        echo "✅ Rewritten and saved to: $filename\n";
        echo "📝 Content length: " . str_word_count($rewrittenContent) . " words\n";
        
        // Show first 100 characters as preview
        $preview = substr($rewrittenContent, 0, 100) . "...";
        echo "👀 Preview: $preview\n";
        echo "\n";
        
        // Small delay to avoid API rate limits
        sleep(2);
        
    } catch (Exception $e) {
        echo "❌ Error processing {$casino['name']}: " . $e->getMessage() . "\n";
        
        // Create a placeholder review when API fails
        $placeholderContent = "This is a comprehensive review of {$casino['name']}, a leading online casino established in {$casino['established']}. With over {$casino['games']} games and an attractive welcome bonus of {$casino['bonus']}, this casino offers an excellent gaming experience for Canadian players.\n\n[Note: This is a placeholder review. API integration pending.]";
        
        $filename = 'content/' . strtolower(str_replace([' ', '&'], ['-', 'and'], $casino['name'])) . '-review.md';
        
        if (!is_dir('content')) {
            mkdir('content', 0755, true);
        }
        
        $fileContent = "# {$casino['name']} Review - July 2025\n\n";
        $fileContent .= "**Rating:** {$casino['rating']}/10\n";
        $fileContent .= "**Bonus:** {$casino['bonus_description']}\n";
        $fileContent .= "**Website:** {$casino['website_url']}\n";
        $fileContent .= "**Original Source:** {$casino['original_url']}\n\n";
        $fileContent .= "---\n\n";
        $fileContent .= $placeholderContent;
        
        file_put_contents($filename, $fileContent);
        echo "📝 Created placeholder review: $filename\n\n";
    }
}

echo "=====================================\n";
echo "🎯 Content Rewriting Complete!\n";
echo "📁 Check the 'content/' directory for all rewritten reviews\n";
echo "🔥 All content uses 2025 anti-AI detection techniques\n";
echo "🇨🇦 Optimized for Canadian casino players\n";
?>
