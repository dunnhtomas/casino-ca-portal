<?php
// Research Dashboard View
$title = $data['title'] ?? 'Casino Research Results';
$results = $data['results'] ?? [];
$stats = $data['stats'] ?? [];
$casinos = $results['casinos'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?> | Best Casino Portal</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #2c3e50; margin: 0 0 10px 0; }
        .header .subtitle { color: #7f8c8d; font-size: 18px; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 25px; border-radius: 10px; text-align: center; }
        .stat-card h3 { margin: 0 0 10px 0; font-size: 28px; }
        .stat-card p { margin: 0; opacity: 0.9; }
        .casino-grid { display: grid; gap: 20px; }
        .casino-card { border: 1px solid #ddd; border-radius: 10px; padding: 20px; background: white; transition: transform 0.2s; }
        .casino-card:hover { transform: translateY(-2px); box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .casino-name { font-size: 20px; font-weight: bold; color: #2c3e50; margin-bottom: 10px; }
        .rating { background: #27ae60; color: white; padding: 5px 10px; border-radius: 5px; display: inline-block; font-weight: bold; }
        .rating.high { background: #27ae60; }
        .rating.medium { background: #f39c12; }
        .rating.low { background: #e74c3c; }
        .casino-details { margin-top: 15px; }
        .casino-details div { margin-bottom: 8px; }
        .method-badge { background: #3498db; color: white; padding: 3px 8px; border-radius: 3px; font-size: 12px; }
        .method-badge.openai { background: #9b59b6; }
        .btn { display: inline-block; padding: 10px 20px; background: #3498db; color: white; text-decoration: none; border-radius: 5px; margin: 5px; }
        .btn:hover { background: #2980b9; }
        .actions { text-align: center; margin: 30px 0; }
        .pros-cons { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 15px; }
        .pros, .cons { padding: 15px; border-radius: 8px; }
        .pros { background: #d5f4e6; border-left: 4px solid #27ae60; }
        .cons { background: #fadbd8; border-left: 4px solid #e74c3c; }
        .pros h4, .cons h4 { margin: 0 0 10px 0; color: #2c3e50; }
        .pros ul, .cons ul { margin: 0; padding-left: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎰 Casino Research Results Dashboard</h1>
            <p class="subtitle">Comprehensive analysis of <?= count($casinos) ?> affiliate casinos</p>
            <?php if (!empty($stats['last_updated'])): ?>
                <p><small>Last updated: <?= htmlspecialchars($stats['last_updated']) ?></small></p>
            <?php endif; ?>
        </div>

        <?php if (!empty($stats)): ?>
        <div class="stats-grid">
            <div class="stat-card">
                <h3><?= $stats['total_casinos'] ?? 0 ?></h3>
                <p>Total Casinos</p>
            </div>
            <div class="stat-card">
                <h3><?= $stats['average_rating'] ?? '0.0' ?></h3>
                <p>Average Rating</p>
            </div>
            <div class="stat-card">
                <h3><?= number_format($stats['total_games'] ?? 0) ?></h3>
                <p>Total Games</p>
            </div>
            <div class="stat-card">
                <h3><?= $stats['mobile_optimized'] ?? 0 ?></h3>
                <p>Mobile Optimized</p>
            </div>
        </div>
        <?php endif; ?>

        <div class="actions">
            <a href="/research-results/run" class="btn">🔄 Run New Research</a>
            <a href="/api/research-results" class="btn">📊 View API Data</a>
            <a href="/research-results/export/csv" class="btn">📥 Export CSV</a>
            <a href="/research-results/export/json" class="btn">📥 Export JSON</a>
        </div>

        <div class="casino-grid">
            <?php foreach (array_slice($casinos, 0, 20) as $casino): ?>
                <div class="casino-card">
                    <div class="casino-name"><?= htmlspecialchars($casino['name']) ?></div>
                    
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                        <?php 
                        $rating = floatval($casino['rating']);
                        $ratingClass = $rating >= 8.5 ? 'high' : ($rating >= 7 ? 'medium' : 'low');
                        ?>
                        <span class="rating <?= $ratingClass ?>"><?= $rating ?>/10</span>
                        <span class="method-badge <?= $casino['research_method'] === 'openai' ? 'openai' : '' ?>">
                            <?= htmlspecialchars($casino['research_method']) ?>
                        </span>
                    </div>
                    
                    <div class="casino-details">
                        <div><strong>Website:</strong> <a href="<?= htmlspecialchars($casino['website_url'] ?? '#') ?>" target="_blank" rel="noopener"><?= htmlspecialchars($casino['website_url'] ?? 'N/A') ?></a></div>
                        <div><strong>Games:</strong> <?= number_format($casino['games_count'] ?? 0) ?></div>
                        <div><strong>Welcome Bonus:</strong> <?= htmlspecialchars($casino['welcome_bonus'] ?? 'N/A') ?></div>
                        <div><strong>Mobile:</strong> <?= ($casino['mobile_optimized'] ?? false) ? '✅ Yes' : '❌ No' ?></div>
                    </div>
                    
                    <?php if (!empty($casino['description'])): ?>
                        <p style="margin-top: 15px; color: #555; line-height: 1.5;">
                            <?= htmlspecialchars(substr($casino['description'], 0, 150)) ?><?= strlen($casino['description']) > 150 ? '...' : '' ?>
                        </p>
                    <?php endif; ?>
                    
                    <?php if (!empty($casino['pros']) || !empty($casino['cons'])): ?>
                        <div class="pros-cons">
                            <?php if (!empty($casino['pros'])): ?>
                                <div class="pros">
                                    <h4>✅ Pros</h4>
                                    <ul>
                                        <?php foreach (array_slice($casino['pros'], 0, 3) as $pro): ?>
                                            <li><?= htmlspecialchars($pro) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($casino['cons'])): ?>
                                <div class="cons">
                                    <h4>❌ Cons</h4>
                                    <ul>
                                        <?php foreach (array_slice($casino['cons'], 0, 2) as $con): ?>
                                            <li><?= htmlspecialchars($con) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <div style="margin-top: 15px; text-align: center;">
                        <a href="/research-results/<?= htmlspecialchars($casino['id']) ?>" class="btn">View Details</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (count($casinos) > 20): ?>
            <div style="text-align: center; margin-top: 30px;">
                <p>Showing 20 of <?= count($casinos) ?> casinos</p>
                <a href="/api/research-results" class="btn">View All Data via API</a>
            </div>
        <?php endif; ?>

        <div style="text-align: center; margin-top: 40px; padding-top: 30px; border-top: 1px solid #ddd;">
            <p><strong>Research System Status:</strong></p>
            <p>OpenAI Available: <?= ($results['openai_available'] ?? false) ? '✅ Yes' : '❌ No (Using Fallback)' ?></p>
            <?php if (!empty($results['research_methods'])): ?>
                <p>Methods Used: 
                    <?php foreach ($results['research_methods'] as $method => $count): ?>
                        <span class="method-badge"><?= $method ?>: <?= $count ?></span>
                    <?php endforeach; ?>
                </p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Add some interactivity
        document.addEventListener('DOMContentLoaded', function() {
            // Highlight high-rated casinos
            document.querySelectorAll('.rating.high').forEach(function(rating) {
                rating.style.boxShadow = '0 0 10px rgba(39, 174, 96, 0.3)';
            });
            
            // Auto-refresh indication
            console.log('📊 Casino Research Dashboard Loaded');
            console.log('Total Casinos: <?= count($casinos) ?>');
            console.log('Research Methods: <?= json_encode($results['research_methods'] ?? []) ?>');
        });
    </script>
</body>
</html>
