<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Single Casino Research | Best Casino Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: #f8f9fa;
            padding: 2rem;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        .content {
            padding: 2rem;
        }
        .research-result {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            margin: 1rem 0;
        }
        .status {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }
        .status.completed { background: #d4edda; color: #155724; }
        .status.failed { background: #f8d7da; color: #721c24; }
        .status.processing { background: #fff3cd; color: #856404; }
        .back-btn {
            background: #6c757d;
            color: white;
            padding: 0.7rem 1.5rem;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            display: inline-block;
            margin-top: 1rem;
        }
        .back-btn:hover { background: #5a6268; }
        .data-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }
        .data-card {
            background: white;
            padding: 1rem;
            border-radius: 6px;
            border-left: 4px solid #667eea;
        }
        .data-card h4 { color: #495057; margin-bottom: 0.5rem; }
        .data-card p { color: #6c757d; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-search"></i> Single Casino Research</h1>
            <p>Automated research results for individual casino</p>
        </div>
        
        <div class="content">
            <?php if (isset($result) && $result): ?>
                <div class="research-result">
                    <h2><?php echo htmlspecialchars($result['basic_info']['name'] ?? 'Unknown Casino'); ?></h2>
                    <span class="status <?php echo $result['research_status']; ?>">
                        <i class="fas fa-circle"></i> <?php echo ucfirst($result['research_status']); ?>
                    </span>
                    <p><strong>Research Date:</strong> <?php echo $result['research_date']; ?></p>
                    
                    <?php if (isset($result['basic_info'])): ?>
                        <div class="data-grid">
                            <div class="data-card">
                                <h4><i class="fas fa-info-circle"></i> Basic Information</h4>
                                <p><strong>Website:</strong> <?php echo $result['basic_info']['website_url'] ?? 'N/A'; ?></p>
                                <p><strong>Founded:</strong> <?php echo $result['basic_info']['established_year'] ?? 'N/A'; ?></p>
                                <p><strong>Headquarters:</strong> <?php echo $result['basic_info']['headquarters'] ?? 'N/A'; ?></p>
                            </div>
                            
                            <?php if (isset($result['ratings'])): ?>
                                <div class="data-card">
                                    <h4><i class="fas fa-star"></i> Ratings</h4>
                                    <p><strong>Overall:</strong> <?php echo $result['ratings']['overall_rating']; ?>/10</p>
                                    <p><strong>Games:</strong> <?php echo $result['ratings']['game_variety'] ?? 'N/A'; ?>/10</p>
                                    <p><strong>Support:</strong> <?php echo $result['ratings']['customer_support'] ?? 'N/A'; ?>/10</p>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (isset($result['games'])): ?>
                                <div class="data-card">
                                    <h4><i class="fas fa-gamepad"></i> Games</h4>
                                    <p><strong>Total Games:</strong> <?php echo number_format($result['games']['total_games']); ?></p>
                                    <p><strong>Slots:</strong> <?php echo number_format($result['games']['slots_count'] ?? 0); ?></p>
                                    <p><strong>Live Dealer:</strong> <?php echo number_format($result['games']['live_dealer_count'] ?? 0); ?></p>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (isset($result['bonuses'])): ?>
                                <div class="data-card">
                                    <h4><i class="fas fa-gift"></i> Bonuses</h4>
                                    <p><strong>Welcome Bonus:</strong> <?php echo $result['bonuses']['welcome_bonus'] ?? 'N/A'; ?></p>
                                    <p><strong>Wagering:</strong> <?php echo $result['bonuses']['wagering_requirements'] ?? 'N/A'; ?></p>
                                    <p><strong>Min Deposit:</strong> <?php echo $result['bonuses']['min_deposit'] ?? 'N/A'; ?></p>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (isset($result['licensing'])): ?>
                                <div class="data-card">
                                    <h4><i class="fas fa-certificate"></i> Licensing</h4>
                                    <p><strong>Primary License:</strong> <?php echo $result['licensing']['primary_license'] ?? 'N/A'; ?></p>
                                    <p><strong>License #:</strong> <?php echo $result['licensing']['license_number'] ?? 'N/A'; ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
                
            <?php elseif (isset($error)): ?>
                <div class="research-result">
                    <span class="status failed">
                        <i class="fas fa-exclamation-circle"></i> Research Failed
                    </span>
                    <p><strong>Error:</strong> <?php echo htmlspecialchars($error); ?></p>
                </div>
                
            <?php else: ?>
                <div class="research-result">
                    <span class="status processing">
                        <i class="fas fa-spinner fa-spin"></i> Processing Research
                    </span>
                    <p>Gathering comprehensive casino data using AI research...</p>
                </div>
            <?php endif; ?>
            
            <a href="/casino-research" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>
</body>
</html>
