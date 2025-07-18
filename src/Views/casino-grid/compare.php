<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casino Comparison - Compare <?= $comparison_count ?> Casinos | Best Casino Portal</title>
    <meta name="description" content="Compare <?= $comparison_count ?> online casinos side by side. View detailed comparisons of bonuses, games, ratings, and features.">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/css/casino-grid.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main class="main-content">
        <div class="container">
            <div class="page-header">
                <h1>Casino Comparison</h1>
                <p class="page-description">Compare <?= $comparison_count ?> selected casinos side by side to find the best option for your gaming preferences.</p>
            </div>

            <?php if (empty($casinos)): ?>
                <div class="empty-comparison">
                    <h2>No Casinos Selected</h2>
                    <p>Please select casinos from the <a href="/casinos">casino grid</a> to compare them here.</p>
                </div>
            <?php else: ?>
                <div class="comparison-table-container">
                    <table class="comparison-table">
                        <thead>
                            <tr>
                                <th class="feature-column">Features</th>
                                <?php foreach ($casinos as $casino): ?>
                                    <th class="casino-column">
                                        <div class="casino-header">
                                            <div class="casino-logo"><?= htmlspecialchars($casino['logo']) ?></div>
                                            <h3><?= htmlspecialchars($casino['name']) ?></h3>
                                            <div class="casino-rating">⭐ <?= number_format($casino['rating'], 1) ?>/5.0</div>
                                        </div>
                                    </th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="feature-label">Welcome Bonus</td>
                                <?php foreach ($casinos as $casino): ?>
                                    <td><?= htmlspecialchars($casino['bonus']) ?></td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td class="feature-label">Established</td>
                                <?php foreach ($casinos as $casino): ?>
                                    <td><?= $casino['established'] ?></td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td class="feature-label">Total Games</td>
                                <?php foreach ($casinos as $casino): ?>
                                    <td><?= htmlspecialchars($casino['games']) ?></td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td class="feature-label">RTP</td>
                                <?php foreach ($casinos as $casino): ?>
                                    <td><?= htmlspecialchars($casino['rtp']) ?></td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td class="feature-label">Payout Time</td>
                                <?php foreach ($casinos as $casino): ?>
                                    <td><?= htmlspecialchars($casino['payout']) ?></td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td class="feature-label">License</td>
                                <?php foreach ($casinos as $casino): ?>
                                    <td><?= htmlspecialchars($casino['license']) ?></td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td class="feature-label">Live Chat Support</td>
                                <?php foreach ($casinos as $casino): ?>
                                    <td><?= $casino['live_chat'] ? '✅ Yes' : '❌ No' ?></td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td class="feature-label">Mobile App</td>
                                <?php foreach ($casinos as $casino): ?>
                                    <td><?= $casino['mobile_app'] ? '✅ Yes' : '❌ No' ?></td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td class="feature-label">Cryptocurrencies</td>
                                <?php foreach ($casinos as $casino): ?>
                                    <td><?= $casino['crypto'] ? '✅ Accepted' : '❌ Not Accepted' ?></td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td class="feature-label">VIP Program</td>
                                <?php foreach ($casinos as $casino): ?>
                                    <td><?= $casino['vip_program'] ? '✅ Available' : '❌ Not Available' ?></td>
                                <?php endforeach; ?>
                            </tr>
                            <tr class="action-row">
                                <td class="feature-label">Actions</td>
                                <?php foreach ($casinos as $casino): ?>
                                    <td>
                                        <div class="casino-actions">
                                            <a href="/casino/<?= htmlspecialchars($casino['slug']) ?>" class="btn btn-secondary">View Details</a>
                                            <a href="/casino/<?= htmlspecialchars($casino['slug']) ?>/play" class="btn btn-primary">Play Now</a>
                                        </div>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="comparison-summary">
                    <h2>Comparison Summary</h2>
                    <div class="summary-grid">
                        <?php 
                        $best_rating = 0;
                        $best_rating_casino = '';
                        $best_bonus = '';
                        $best_bonus_casino = '';
                        
                        foreach ($casinos as $casino) {
                            if ($casino['rating'] > $best_rating) {
                                $best_rating = $casino['rating'];
                                $best_rating_casino = $casino['name'];
                            }
                        }
                        ?>
                        
                        <div class="summary-card">
                            <h3>🏆 Highest Rated</h3>
                            <p><strong><?= htmlspecialchars($best_rating_casino) ?></strong></p>
                            <p>Rating: <?= number_format($best_rating, 1) ?>/5.0</p>
                        </div>
                        
                        <div class="summary-card">
                            <h3>🎁 Best for Bonuses</h3>
                            <p>Compare welcome bonuses above to find the most generous offer for your playing style.</p>
                        </div>
                        
                        <div class="summary-card">
                            <h3>🎮 Game Variety</h3>
                            <p>Check total games and software providers to ensure your favorite games are available.</p>
                        </div>
                        
                        <div class="summary-card">
                            <h3>💰 Fast Payouts</h3>
                            <p>Compare payout times to find casinos that process withdrawals quickly.</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="comparison-help">
                <h2>How to Use the Casino Comparison Tool</h2>
                <div class="help-content">
                    <ul>
                        <li><strong>Select Casinos:</strong> Choose up to 5 casinos from our casino grid to compare</li>
                        <li><strong>Compare Features:</strong> Review key features side by side including bonuses, games, and support</li>
                        <li><strong>Check Ratings:</strong> Our expert ratings help you identify the top-performing casinos</li>
                        <li><strong>Make Your Choice:</strong> Use the comparison data to select the casino that best matches your preferences</li>
                    </ul>
                </div>
            </div>

            <div class="back-to-grid">
                <a href="/casinos" class="btn btn-primary">← Back to Casino Grid</a>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
