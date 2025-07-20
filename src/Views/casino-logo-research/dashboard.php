<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Casino Logo Research Dashboard'; ?></title>
    <link href="/css/casino-portal.css" rel="stylesheet">
    <style>
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border: 1px solid #e1e5e9;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #d69e2e;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #666;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .priority-table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .priority-table h3 {
            background: #1a365d;
            color: white;
            margin: 0;
            padding: 20px;
            font-size: 1.2rem;
        }
        
        .priority-table table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .priority-table th,
        .priority-table td {
            padding: 12px 20px;
            text-align: left;
            border-bottom: 1px solid #e1e5e9;
        }
        
        .priority-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #333;
        }
        
        .priority-score {
            font-weight: bold;
            padding: 4px 8px;
            border-radius: 4px;
            color: white;
            font-size: 0.8rem;
        }
        
        .priority-high { background: #e53e3e; }
        .priority-medium { background: #d69e2e; }
        .priority-low { background: #38a169; }
        
        .logo-status {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 500;
            text-transform: uppercase;
        }
        
        .status-missing { background: #fed7d7; color: #742a2a; }
        .status-placeholder { background: #fef5e7; color: #744210; }
        .status-needs-verification { background: #e6fffa; color: #234e52; }
        .status-authentic { background: #c6f6d5; color: #22543d; }
        
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: #d69e2e;
            color: white;
        }
        
        .btn-primary:hover {
            background: #b7791f;
        }
        
        .btn-secondary {
            background: #e2e8f0;
            color: #4a5568;
        }
        
        .btn-secondary:hover {
            background: #cbd5e0;
        }
        
        .btn-success {
            background: #38a169;
            color: white;
        }
        
        .btn-success:hover {
            background: #2f855a;
        }
        
        .phase-timeline {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .phase-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #e1e5e9;
        }
        
        .phase-item:last-child {
            border-bottom: none;
        }
        
        .phase-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 15px;
        }
        
        .phase-completed {
            background: #38a169;
            color: white;
        }
        
        .phase-pending {
            background: #e2e8f0;
            color: #4a5568;
        }
        
        .phase-info h4 {
            margin: 0 0 5px 0;
            color: #1a365d;
        }
        
        .phase-info p {
            margin: 0;
            color: #666;
            font-size: 0.9rem;
        }
        
        .loading {
            display: none;
            text-align: center;
            padding: 20px;
        }
        
        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #d69e2e;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 0 auto 10px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .alert {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background: #c6f6d5;
            color: #22543d;
            border: 1px solid #9ae6b4;
        }
        
        .alert-error {
            background: #fed7d7;
            color: #742a2a;
            border: 1px solid #feb2b2;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <header style="margin-bottom: 30px;">
            <h1 style="color: #1a365d; margin-bottom: 10px;">🎯 Casino Logo & Data Enhancement Dashboard</h1>
            <p style="color: #666; font-size: 1.1rem;">Systematic enhancement of casino logos and data using OpenAI research</p>
        </header>

        <!-- Statistics Overview -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_casinos ?? 0; ?></div>
                <div class="stat-label">Total Casinos</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $missing_logos ?? 0; ?></div>
                <div class="stat-label">Missing Logos</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $placeholder_logos ?? 0; ?></div>
                <div class="stat-label">Placeholder Logos</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $incomplete_data ?? 0; ?></div>
                <div class="stat-label">Incomplete Data</div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button class="btn btn-primary" onclick="startAudit()">
                🔍 Start New Audit
            </button>
            <button class="btn btn-secondary" onclick="viewQueue()">
                📋 View Enhancement Queue
            </button>
            <button class="btn btn-success" onclick="batchProcess()">
                ⚡ Batch Process Remaining
            </button>
        </div>

        <!-- Loading State -->
        <div id="loading" class="loading">
            <div class="spinner"></div>
            <p>Processing casino enhancement...</p>
        </div>

        <!-- Alert Messages -->
        <div id="alerts"></div>

        <!-- Priority List -->
        <?php if (!empty($priority_list)): ?>
        <div class="priority-table">
            <h3>🚀 Enhancement Priority List</h3>
            <table>
                <thead>
                    <tr>
                        <th>Casino Name</th>
                        <th>Priority Score</th>
                        <th>Logo Status</th>
                        <th>Data Completeness</th>
                        <th>Missing Fields</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_slice($priority_list, 0, 15) as $casino): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($casino['name']); ?></strong></td>
                        <td>
                            <span class="priority-score <?php 
                                echo $casino['priority_score'] >= 70 ? 'priority-high' : 
                                    ($casino['priority_score'] >= 40 ? 'priority-medium' : 'priority-low'); 
                            ?>">
                                <?php echo $casino['priority_score']; ?>
                            </span>
                        </td>
                        <td>
                            <span class="logo-status status-<?php echo str_replace(['_', ' '], '-', $casino['logo_status']); ?>">
                                <?php echo ucwords(str_replace('_', ' ', $casino['logo_status'])); ?>
                            </span>
                        </td>
                        <td><?php echo round($casino['data_completeness'] * 100); ?>%</td>
                        <td><?php echo $casino['missing_data_count']; ?> fields</td>
                        <td>
                            <button class="btn btn-primary btn-sm" onclick="enhanceCasino('<?php echo htmlspecialchars($casino['name']); ?>')">
                                Enhance
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>

        <!-- Phase Timeline -->
        <?php if (!empty($phases)): ?>
        <div class="phase-timeline">
            <h3 style="margin-bottom: 20px;">📅 Enhancement Phases</h3>
            <?php foreach (array_slice($phases, 0, 6) as $phase): ?>
            <div class="phase-item">
                <div class="phase-number <?php echo $phase['status'] === 'completed' ? 'phase-completed' : 'phase-pending'; ?>">
                    <?php echo $phase['phase']; ?>
                </div>
                <div class="phase-info">
                    <h4><?php echo htmlspecialchars($phase['title']); ?></h4>
                    <p>
                        <?php if (isset($phase['casino'])): ?>
                            Casino: <?php echo htmlspecialchars($phase['casino']); ?>
                            <?php if (isset($phase['priority_score'])): ?>
                                (Priority: <?php echo $phase['priority_score']; ?>)
                            <?php endif; ?>
                        <?php elseif (isset($phase['deliverables'])): ?>
                            <?php echo implode(', ', $phase['deliverables']); ?>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
            <?php endforeach; ?>
            
            <?php if (count($phases) > 6): ?>
            <p style="text-align: center; margin-top: 15px; color: #666;">
                ... and <?php echo count($phases) - 6; ?> more phases
            </p>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

    <script>
        function showAlert(message, type = 'success') {
            const alerts = document.getElementById('alerts');
            const alert = document.createElement('div');
            alert.className = `alert alert-${type}`;
            alert.textContent = message;
            alerts.appendChild(alert);
            
            setTimeout(() => {
                alert.remove();
            }, 5000);
        }

        function showLoading(show = true) {
            document.getElementById('loading').style.display = show ? 'block' : 'none';
        }

        async function startAudit() {
            showLoading(true);
            
            try {
                const response = await fetch('/casino-logo-research/start-audit', {
                    method: 'POST'
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showAlert(`Audit completed: ${result.data.enhancement_needed} casinos need enhancement`);
                    setTimeout(() => location.reload(), 2000);
                } else {
                    showAlert(result.error || 'Audit failed', 'error');
                }
            } catch (error) {
                showAlert('Failed to start audit: ' + error.message, 'error');
            } finally {
                showLoading(false);
            }
        }

        async function enhanceCasino(casinoName) {
            showLoading(true);
            
            try {
                const response = await fetch(`/casino-logo-research/enhance/${encodeURIComponent(casinoName)}`, {
                    method: 'POST'
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showAlert(`${casinoName} enhancement queued successfully`);
                } else {
                    showAlert(result.error || 'Enhancement failed', 'error');
                }
            } catch (error) {
                showAlert('Failed to enhance casino: ' + error.message, 'error');
            } finally {
                showLoading(false);
            }
        }

        async function viewQueue() {
            window.open('/casino-logo-research/queue', '_blank');
        }

        async function batchProcess() {
            if (!confirm('Start batch processing of remaining casinos? This will queue all lower-priority casinos for enhancement.')) {
                return;
            }
            
            showLoading(true);
            
            try {
                const response = await fetch('/casino-logo-research/batch-process', {
                    method: 'POST'
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showAlert(`Batch processing completed: ${result.processed_count} casinos queued`);
                } else {
                    showAlert(result.error || 'Batch processing failed', 'error');
                }
            } catch (error) {
                showAlert('Failed to start batch processing: ' + error.message, 'error');
            } finally {
                showLoading(false);
            }
        }

        // Auto-refresh progress every 30 seconds
        setInterval(async () => {
            try {
                const response = await fetch('/casino-logo-research/progress');
                const result = await response.json();
                
                if (result.success) {
                    // Update stats if needed
                    console.log('Progress:', result.stats);
                }
            } catch (error) {
                console.log('Progress check failed:', error);
            }
        }, 30000);
    </script>
</body>
</html>
