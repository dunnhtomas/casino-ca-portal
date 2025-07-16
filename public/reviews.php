<?php
// Casino Reviews Display Page

$contentDir = 'content/';
$reviews = [];

// Scan for review files
if (is_dir($contentDir)) {
    $files = glob($contentDir . '*-review.md');
    foreach ($files as $file) {
        $content = file_get_contents($file);
        $lines = explode("\n", $content);
        
        // Extract metadata
        $title = str_replace('# ', '', $lines[0]);
        $rating = '';
        $bonus = '';
        $website = '';
        
        foreach ($lines as $line) {
            if (strpos($line, '**Rating:**') !== false) {
                $rating = trim(str_replace('**Rating:**', '', $line));
            }
            if (strpos($line, '**Bonus:**') !== false) {
                $bonus = trim(str_replace('**Bonus:**', '', $line));
            }
            if (strpos($line, '**Website:**') !== false) {
                $website = trim(str_replace('**Website:**', '', $line));
            }
        }
        
        // Extract preview (first few lines after metadata)
        $contentStart = false;
        $preview = '';
        $wordCount = 0;
        foreach ($lines as $line) {
            if ($line === '---') {
                $contentStart = true;
                continue;
            }
            if ($contentStart && !empty(trim($line)) && $wordCount < 50) {
                $preview .= $line . ' ';
                $wordCount += str_word_count($line);
            }
        }
        
        $reviews[] = [
            'title' => $title,
            'rating' => $rating,
            'bonus' => $bonus,
            'website' => $website,
            'preview' => trim($preview),
            'file' => $file
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Best Casino Portal - Canadian Casino Reviews 2025</title>
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
        
        .header {
            background: linear-gradient(90deg, #d4af37, #ffd700);
            padding: 20px 0;
            text-align: center;
            color: #1a1a2e;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }
        
        .header h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .header p {
            font-size: 1.2rem;
            opacity: 0.8;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        
        .stat-card {
            background: rgba(255,255,255,0.1);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            border: 1px solid rgba(212,175,55,0.3);
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #ffd700;
        }
        
        .reviews-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }
        
        .review-card {
            background: rgba(255,255,255,0.05);
            border-radius: 15px;
            padding: 25px;
            border: 1px solid rgba(212,175,55,0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .review-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(212,175,55,0.2);
        }
        
        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .casino-name {
            font-size: 1.4rem;
            font-weight: bold;
            color: #ffd700;
        }
        
        .rating {
            background: linear-gradient(45deg, #d4af37, #ffd700);
            color: #1a1a2e;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
        }
        
        .bonus {
            background: rgba(212,175,55,0.2);
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            border-left: 4px solid #ffd700;
        }
        
        .preview {
            color: #cccccc;
            margin-bottom: 20px;
            line-height: 1.5;
        }
        
        .view-btn {
            background: linear-gradient(45deg, #d4af37, #ffd700);
            color: #1a1a2e;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: transform 0.2s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .view-btn:hover {
            transform: scale(1.05);
        }
        
        .footer {
            text-align: center;
            padding: 40px 20px;
            color: #999;
            border-top: 1px solid rgba(255,255,255,0.1);
            margin-top: 60px;
        }
        
        .ai-badge {
            background: linear-gradient(45deg, #ff6b6b, #ee5a24);
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            .header h1 { font-size: 2rem; }
            .reviews-grid { grid-template-columns: 1fr; }
            .container { padding: 20px 10px; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎰 Best Casino Portal</h1>
        <p>Canadian Casino Reviews with Advanced AI Content Detection Bypass</p>
    </div>
    
    <div class="container">
        <div class="ai-badge">
            🤖 Powered by 2025 Anti-AI Detection Technology
        </div>
        
        <div class="stats">
            <div class="stat-card">
                <div class="stat-number"><?= count($reviews) ?></div>
                <div>Casino Reviews</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">100%</div>
                <div>AI Detection Bypass</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">2025</div>
                <div>Latest Techniques</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">🇨🇦</div>
                <div>Canadian Focused</div>
            </div>
        </div>
        
        <?php if (empty($reviews)): ?>
            <div style="text-align: center; padding: 60px 20px;">
                <h2>🚧 Content Generation in Progress</h2>
                <p style="margin-top: 20px; color: #999;">
                    Our AI-powered content system is currently generating casino reviews.<br>
                    Check back soon for the latest reviews with advanced anti-AI detection.
                </p>
            </div>
        <?php else: ?>
            <div class="reviews-grid">
                <?php foreach ($reviews as $review): ?>
                    <div class="review-card">
                        <div class="review-header">
                            <div class="casino-name"><?= htmlspecialchars($review['title']) ?></div>
                            <div class="rating"><?= htmlspecialchars($review['rating']) ?></div>
                        </div>
                        
                        <div class="bonus">
                            <strong>🎁 Bonus:</strong> <?= htmlspecialchars($review['bonus']) ?>
                        </div>
                        
                        <div class="preview">
                            <?= htmlspecialchars(substr($review['preview'], 0, 200)) ?>...
                        </div>
                        
                        <a href="view-review.php?file=<?= urlencode(basename($review['file'])) ?>" class="view-btn">
                            Read Full Review →
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="footer">
        <p>© 2025 Best Casino Portal - Advanced AI Content with Anti-Detection Technology</p>
        <p style="margin-top: 10px; font-size: 0.9rem;">
            🔥 All content generated using 2025 research-based anti-AI detection methods<br>
            🇨🇦 Optimized for Canadian casino players
        </p>
    </div>
</body>
</html>
