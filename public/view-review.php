<?php
// Individual Review Display Page

$file = $_GET['file'] ?? '';
$contentDir = '../content/';
$filePath = $contentDir . basename($file);

if (!file_exists($filePath) || !is_file($filePath)) {
    header('HTTP/1.0 404 Not Found');
    echo '<h1>Review Not Found</h1>';
    exit;
}

$content = file_get_contents($filePath);
$lines = explode("\n", $content);

// Extract metadata
$title = str_replace('# ', '', $lines[0]);
$rating = '';
$bonus = '';
$website = '';
$originalSource = '';

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
    if (strpos($line, '**Original Source:**') !== false) {
        $originalSource = trim(str_replace('**Original Source:**', '', $line));
    }
}

// Extract review content (after ---)
$reviewContent = '';
$startContent = false;
foreach ($lines as $line) {
    if ($line === '---') {
        $startContent = true;
        continue;
    }
    if ($startContent) {
        $reviewContent .= $line . "\n";
    }
}

// Convert markdown to HTML (basic)
$reviewContent = str_replace('**', '<strong>', $reviewContent);
$reviewContent = str_replace('**', '</strong>', $reviewContent);
$reviewContent = nl2br($reviewContent);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?> - Best Casino Portal</title>
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
            font-size: 2rem;
            font-weight: bold;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .back-btn {
            background: rgba(255,255,255,0.1);
            color: white;
            padding: 10px 20px;
            border: 1px solid rgba(212,175,55,0.3);
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 30px;
            transition: background 0.3s ease;
        }
        
        .back-btn:hover {
            background: rgba(212,175,55,0.2);
        }
        
        .review-header {
            background: rgba(255,255,255,0.05);
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            border: 1px solid rgba(212,175,55,0.2);
        }
        
        .casino-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #ffd700;
            margin-bottom: 20px;
        }
        
        .meta-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        
        .meta-item {
            background: rgba(212,175,55,0.1);
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #ffd700;
        }
        
        .meta-label {
            font-weight: bold;
            color: #ffd700;
            display: block;
            margin-bottom: 5px;
        }
        
        .meta-value {
            color: #cccccc;
        }
        
        .rating-big {
            background: linear-gradient(45deg, #d4af37, #ffd700);
            color: #1a1a2e;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 1.5rem;
            font-weight: bold;
            display: inline-block;
        }
        
        .review-content {
            background: rgba(255,255,255,0.03);
            padding: 40px;
            border-radius: 15px;
            border: 1px solid rgba(255,255,255,0.1);
            font-size: 1.1rem;
            line-height: 1.8;
        }
        
        .ai-badge {
            background: linear-gradient(45deg, #ff6b6b, #ee5a24);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 30px;
        }
        
        .visit-casino {
            background: linear-gradient(45deg, #27ae60, #2ecc71);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            margin-top: 30px;
            transition: transform 0.3s ease;
        }
        
        .visit-casino:hover {
            transform: scale(1.05);
        }
        
        @media (max-width: 768px) {
            .casino-title { font-size: 2rem; }
            .container { padding: 20px 10px; }
            .review-header, .review-content { padding: 20px; }
            .meta-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1><?= htmlspecialchars($title) ?></h1>
    </div>
    
    <div class="container">
        <a href="reviews.php" class="back-btn">← Back to All Reviews</a>
        
        <div class="ai-badge">
            🤖 Generated with 2025 Anti-AI Detection Technology
        </div>
        
        <div class="review-header">
            <div class="casino-title"><?= htmlspecialchars(str_replace(' Review - July 2025', '', $title)) ?></div>
            
            <div class="meta-grid">
                <div class="meta-item">
                    <span class="meta-label">🌟 Rating</span>
                    <span class="rating-big"><?= htmlspecialchars($rating) ?></span>
                </div>
                
                <div class="meta-item">
                    <span class="meta-label">🎁 Welcome Bonus</span>
                    <span class="meta-value"><?= htmlspecialchars($bonus) ?></span>
                </div>
                
                <?php if ($website): ?>
                <div class="meta-item">
                    <span class="meta-label">🌐 Official Website</span>
                    <span class="meta-value"><?= htmlspecialchars($website) ?></span>
                </div>
                <?php endif; ?>
                
                <div class="meta-item">
                    <span class="meta-label">🇨🇦 For Canadian Players</span>
                    <span class="meta-value">Optimized & Legal</span>
                </div>
            </div>
            
            <?php if ($website): ?>
            <a href="<?= htmlspecialchars($website) ?>" target="_blank" class="visit-casino">
                🎰 Visit Casino →
            </a>
            <?php endif; ?>
        </div>
        
        <div class="review-content">
            <?= $reviewContent ?>
        </div>
    </div>
</body>
</html>
