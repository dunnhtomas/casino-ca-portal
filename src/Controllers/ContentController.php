<?php
namespace App\Controllers;

use App\Services\OpenAIService;
use Exception;

class ContentController {
    private $openAI;
    
    public function __construct() {
        $this->openAI = new OpenAIService();
    }
    
    public function generate(): void {
        $title = "AI Content Generator - Casino Reviews & Articles";
        $description = "Generate high-quality casino reviews and articles using advanced AI technology with anti-detection features.";
        
        echo $this->renderContentGenerator($title, $description);
    }
    
    public function generateReview($casinoId = null) {
        try {
            // For now, use a mock casino object since we don't have the model yet
            $casino = [
                'id' => $casinoId ?: 1,
                'name' => 'Demo Casino',
                'bonus' => '$500 Welcome Bonus',
                'games' => 300,
                'established' => 2020
            ];
            
            if (!$casino) {
                http_response_code(404);
                echo json_encode(["error" => "Casino not found"]);
                return;
            }
            
            // Generate human-like review using strict anti-AI rules
            $review = $this->openAI->generateCasinoReview($casino);
            
            // Generate feature image
            $imagePrompt = "Professional casino review hero image for {$casino['name']}, showing modern online casino interface on laptop and mobile";
            $imageUrl = $this->openAI->generateImage($imagePrompt);
            
            header('Content-Type: application/json');
            echo json_encode([
                "success" => true,
                "casino" => $casino['name'],
                "review" => $review,
                "feature_image" => $imageUrl,
                "word_count" => str_word_count($review),
                "ai_detection_score" => $this->estimateAIDetection($review)
            ]);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
    
    public function generateBlogPost() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            $blogData = [
                "topic" => $data["topic"] ?? "Best Canadian Online Casinos 2025",
                "keywords" => $data["keywords"] ?? ["online casino canada", "best casino bonuses", "slots canada"],
                "length" => $data["length"] ?? "1500"
            ];
            
            $content = $this->openAI->generateBlogPost($blogData);
            
            header('Content-Type: application/json');
            echo json_encode([
                "success" => true,
                "content" => $content,
                "word_count" => str_word_count($content),
                "ai_detection_score" => $this->estimateAIDetection($content),
                "seo_analysis" => $this->analyzeSEO($content, $blogData["keywords"])
            ]);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
    
    public function generateAllReviews() {
        try {
            // Mock casino data for now
            $casinos = [
                ['id' => 1, 'name' => 'Demo Casino 1', 'bonus' => '$500 Welcome', 'games' => 300],
                ['id' => 2, 'name' => 'Demo Casino 2', 'bonus' => '$1000 Bonus', 'games' => 500],
                ['id' => 3, 'name' => 'Demo Casino 3', 'bonus' => '$750 Package', 'games' => 400]
            ];
            $results = [];
            
            foreach ($casinos as $casino) {
                $review = $this->openAI->generateCasinoReview($casino);
                
                // TODO: Save generated review to database when model is ready
                // $this->casino->updateReview($casino['id'], $review);
                
                $results[] = [
                    "casino" => $casino['name'],
                    "word_count" => str_word_count($review),
                    "ai_score" => $this->estimateAIDetection($review)
                ];
                
                // Prevent rate limiting
                sleep(2);
            }
            
            header('Content-Type: application/json');
            echo json_encode([
                "success" => true,
                "generated_reviews" => count($results),
                "results" => $results,
                "average_ai_score" => array_sum(array_column($results, 'ai_score')) / count($results)
            ]);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
    
    private function estimateAIDetection(string $content): float {
        $aiIndicators = 0;
        $totalChecks = 0;
        
        // Check for banned AI phrases
        $bannedPhrases = [
            '/in conclusion/i', '/furthermore/i', '/additionally/i', 
            '/moreover/i', '/it is worth noting/i', '/significantly/i',
            '/comprehensive/i', '/extensive/i', '/seamless/i', '/leverage/i'
        ];
        
        foreach ($bannedPhrases as $phrase) {
            $totalChecks++;
            if (preg_match($phrase, $content)) {
                $aiIndicators++;
            }
        }
        
        // Check sentence length variation
        $sentences = preg_split('/[.!?]+/', $content);
        $lengths = array_map('str_word_count', $sentences);
        $avgLength = array_sum($lengths) / count($lengths);
        $variance = 0;
        
        foreach ($lengths as $length) {
            $variance += pow($length - $avgLength, 2);
        }
        $variance = $variance / count($lengths);
        
        $totalChecks++;
        if ($variance < 10) { // Low variation = more AI-like
            $aiIndicators++;
        }
        
        // Check for human elements
        $humanElements = [
            '/\beh\b/i', '/honestly/i', '/real talk/i', '/no joke/i',
            '/i mean/i', '/you know/i', '/like,/i', '/wait,/i'
        ];
        
        $humanCount = 0;
        foreach ($humanElements as $element) {
            if (preg_match($element, $content)) {
                $humanCount++;
            }
        }
        
        $totalChecks++;
        if ($humanCount < 2) { // Few human elements = more AI-like
            $aiIndicators++;
        }
        
        return ($aiIndicators / $totalChecks) * 100;
    }
    
    private function analyzeSEO(string $content, array $keywords): array {
        $analysis = [];
        
        foreach ($keywords as $keyword) {
            $count = substr_count(strtolower($content), strtolower($keyword));
            $density = ($count * strlen($keyword)) / strlen($content) * 100;
            
            $analysis[$keyword] = [
                "count" => $count,
                "density" => round($density, 2),
                "status" => $this->getSEOStatus($density)
            ];
        }
        
        return $analysis;
    }
    
    private function getSEOStatus(float $density): string {
        if ($density < 0.5) return "too_low";
        if ($density > 3.0) return "too_high";
        return "optimal";
    }
    
    private function renderContentGenerator(string $title, string $description): string {
        ob_start();
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($description) ?>">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: white;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        header {
            background: rgba(0,0,0,0.3);
            padding: 1rem 0;
            border-bottom: 1px solid rgba(212,175,55,0.3);
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: #ffd700;
        }
        
        nav ul {
            list-style: none;
            display: flex;
            gap: 2rem;
        }
        
        nav a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        nav a:hover {
            color: #ffd700;
        }
        
        .page-header {
            text-align: center;
            padding: 3rem 0;
        }
        
        .page-header h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #ffd700;
        }
        
        .page-header p {
            font-size: 1.2rem;
            color: #cccccc;
        }
        
        .generator-container {
            background: rgba(255,255,255,0.1);
            border-radius: 15px;
            padding: 3rem;
            margin: 3rem 0;
            border: 1px solid rgba(212,175,55,0.3);
            text-align: center;
        }
        
        .btn-primary {
            background: linear-gradient(45deg, #d4af37, #ffd700);
            color: #1a1a2e;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            margin: 1rem;
            transition: transform 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: scale(1.05);
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin: 3rem 0;
        }
        
        .feature-card {
            background: rgba(255,255,255,0.1);
            border-radius: 15px;
            padding: 2rem;
            border: 1px solid rgba(212,175,55,0.3);
            text-align: center;
        }
        
        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .feature-title {
            font-size: 1.5rem;
            color: #ffd700;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">🎰 Best Casino Portal</div>
                <nav>
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="/casinos">Casinos</a></li>
                        <li><a href="/reviews">Reviews</a></li>
                        <li><a href="/bonuses">Bonuses</a></li>
                        <li><a href="/news">News</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <section class="page-header">
        <div class="container">
            <h1>🤖 AI Content Generator</h1>
            <p>Generate high-quality casino reviews with advanced anti-AI detection technology</p>
        </div>
    </section>

    <div class="container">
        <div class="generator-container">
            <h2 style="color: #ffd700; margin-bottom: 2rem;">Content Generation Tools</h2>
            <p style="margin-bottom: 2rem;">Advanced AI-powered content generation with anti-detection features</p>
            
            <a href="/demo-anti-ai" class="btn-primary">🛡️ Anti-AI Demo</a>
            <a href="/reviews" class="btn-primary">📝 View Reviews</a>
            <a href="/" class="btn-primary">🏠 Back Home</a>
        </div>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🛡️</div>
                <div class="feature-title">Anti-AI Detection</div>
                <p>Advanced algorithms to bypass AI detection tools with natural writing patterns and human-like content structure.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">🇨🇦</div>
                <div class="feature-title">Canadian Focus</div>
                <p>Content tailored specifically for Canadian players with local regulations, currency, and market preferences.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">📈</div>
                <div class="feature-title">SEO Optimized</div>
                <p>Built-in SEO best practices for 2025 with proper keyword density, semantic optimization, and ranking factors.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">⚡</div>
                <div class="feature-title">Fast Generation</div>
                <p>Generate comprehensive casino reviews in seconds with consistent quality and industry expertise.</p>
            </div>
        </div>
    </div>
</body>
</html>
        <?php
        return ob_get_clean();
    }
}
