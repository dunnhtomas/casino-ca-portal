<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Services\CasinoResearchService;
use Exception;

class CasinoResearchController extends Controller
{
    private $researchService;
    
    public function __construct()
    {
        $this->researchService = new CasinoResearchService();
    }
    
    /**
     * Execute full casino research for all affiliates
     */
    public function executeFullResearch(): void
    {
        header('Content-Type: application/json');
        
        try {
            echo json_encode([
                'status' => 'started',
                'message' => 'Casino research initiated. This may take several minutes...',
                'timestamp' => date('Y-m-d H:i:s')
            ]);
            
            // Flush output to show progress
            if (ob_get_level()) {
                ob_end_flush();
            }
            flush();
            
            // Execute research
            $results = $this->researchService->researchAllCasinos();
            
            // Save results
            $filepath = $this->researchService->saveResearchResults($results);
            
            // Generate integration code
            $integrationCode = $this->researchService->generateIntegrationCode($results);
            $integrationPath = dirname($filepath) . '/casino-integration-code.php';
            file_put_contents($integrationPath, $integrationCode);
            
            echo json_encode([
                'status' => 'completed',
                'total_casinos' => count($results),
                'successful' => count(array_filter($results, fn($r) => $r['research_status'] === 'completed')),
                'failed' => count(array_filter($results, fn($r) => $r['research_status'] === 'failed')),
                'results_file' => $filepath,
                'integration_file' => $integrationPath,
                'timestamp' => date('Y-m-d H:i:s')
            ]);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage(),
                'timestamp' => date('Y-m-d H:i:s')
            ]);
        }
    }
    
    /**
     * Research a single casino by name
     */
    public function researchSingleCasino($casinoId = null): void
    {
        header('Content-Type: application/json');
        
        // Get casino ID from parameter or fallback to GET/POST
        if (!$casinoId) {
            $casinoId = $_GET['casinoId'] ?? $_POST['casinoId'] ?? null;
        }
        
        if (!$casinoId) {
            http_response_code(400);
            echo json_encode(['error' => 'Casino ID parameter required']);
            return;
        }
        
        try {
            // Find casino in affiliate database by ID
            $databasePath = __DIR__ . '/../../casino-affiliates-database.json';
            $database = json_decode(file_get_contents($databasePath), true);
            
            $casino = null;
            foreach ($database['casinos'] as $c) {
                if ($c['id'] === $casinoId) {
                    $casino = $c;
                    break;
                }
            }
            
            if (!$casino) {
                http_response_code(404);
                echo json_encode(['error' => "Casino with ID '{$casinoId}' not found in affiliate database"]);
                return;
            }
            
            // Research the casino
            $result = $this->researchService->researchCasino($casino);
            
            echo json_encode([
                'status' => 'completed',
                'casino' => $result,
                'timestamp' => date('Y-m-d H:i:s')
            ]);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage(),
                'timestamp' => date('Y-m-d H:i:s')
            ]);
        }
    }
    
    /**
     * Show research dashboard
     */
    public function showDashboard(): void
    {
        // Load affiliate database for stats
        $databasePath = __DIR__ . '/../../casino-affiliates-database.json';
        $database = json_decode(file_get_contents($databasePath), true);
        
        echo $this->renderDashboard($database);
    }
    
    /**
     * Render research dashboard HTML
     */
    private function renderDashboard(array $database): string
    {
        $totalCasinos = count($database['casinos']);
        $uniqueCasinos = $database['database_info']['unique_casinos'];
        $totalGeos = $database['database_info']['total_geos'];
        
        return '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casino Research Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: #f8f9fa;
            padding: 2rem;
        }
        .dashboard {
            max-width: 1200px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 3rem;
        }
        .header h1 {
            color: #333;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }
        .header p {
            color: #666;
            font-size: 1.1rem;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }
        .stat-card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .stat-card .number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #d63384;
            margin-bottom: 0.5rem;
        }
        .stat-card .label {
            color: #666;
            font-weight: 500;
        }
        .actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }
        .action-card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .action-card h3 {
            color: #333;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .action-card p {
            color: #666;
            margin-bottom: 1.5rem;
        }
        .btn {
            background: #d63384;
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        .btn:hover {
            background: #b02a5b;
            transform: translateY(-2px);
        }
        .btn.secondary {
            background: #28a745;
        }
        .btn.secondary:hover {
            background: #218838;
        }
        .progress {
            display: none;
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .progress.show {
            display: block;
        }
        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #d63384;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .casino-list {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 2rem;
        }
        .casino-list h3 {
            margin-bottom: 1.5rem;
            color: #333;
        }
        .casino-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }
        .casino-item {
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            padding: 1rem;
            transition: all 0.3s ease;
        }
        .casino-item:hover {
            border-color: #d63384;
            box-shadow: 0 2px 8px rgba(214, 51, 132, 0.2);
        }
        .casino-name {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        .casino-geos {
            font-size: 0.9rem;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="header">
            <h1><i class="fas fa-search"></i> Casino Research Dashboard</h1>
            <p>Comprehensive casino data research using OpenAI GPT-4o-mini</p>
        </div>
        
        <div class="stats">
            <div class="stat-card">
                <div class="number">' . $totalCasinos . '</div>
                <div class="label">Total Casino Programs</div>
            </div>
            <div class="stat-card">
                <div class="number">' . $uniqueCasinos . '</div>
                <div class="label">Unique Casino Brands</div>
            </div>
            <div class="stat-card">
                <div class="number">' . $totalGeos . '</div>
                <div class="label">Geographic Markets</div>
            </div>
        </div>
        
        <div class="actions">
            <div class="action-card">
                <h3><i class="fas fa-rocket"></i> Full Research Execution</h3>
                <p>Research all ' . $totalCasinos . ' casino programs with comprehensive data collection including logos, licenses, games, bonuses, and ratings.</p>
                <button class="btn" onclick="startFullResearch()">Start Full Research</button>
            </div>
            
            <div class="action-card">
                <h3><i class="fas fa-target"></i> Single Casino Research</h3>
                <p>Research a specific casino to test the system and get detailed information about one brand.</p>
                <input type="text" id="casinoName" placeholder="Enter casino name..." style="width: 100%; padding: 0.5rem; margin-bottom: 1rem; border: 1px solid #ddd; border-radius: 4px;">
                <button class="btn secondary" onclick="startSingleResearch()">Research Casino</button>
            </div>
        </div>
        
        <div class="progress" id="progressSection">
            <div class="spinner"></div>
            <h3>Research in Progress...</h3>
            <p id="progressText">Initializing casino research system...</p>
        </div>
        
        <div class="casino-list">
            <h3>Available Casinos for Research</h3>
            <div class="casino-grid">';
        
        foreach ($database['casinos'] as $casino) {
            $geoCount = count($casino['geographic_coverage']);
            $geos = $geoCount > 3 
                ? implode(', ', array_slice($casino['geographic_coverage'], 0, 3)) . " (+{$geoCount} total)"
                : implode(', ', $casino['geographic_coverage']);
                
            echo '<div class="casino-item">
                    <div class="casino-name">' . htmlspecialchars($casino['name']) . '</div>
                    <div class="casino-geos">' . htmlspecialchars($geos) . '</div>
                  </div>';
        }
        
        return $this->finishDashboardHTML();
    }
    
    private function finishDashboardHTML(): string
    {
        return '
            </div>
        </div>
    </div>
    
    <script>
        function startFullResearch() {
            document.getElementById("progressSection").classList.add("show");
            document.getElementById("progressText").textContent = "Starting comprehensive research for all casinos...";
            
            fetch("/casino-research/execute", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "completed") {
                    document.getElementById("progressText").innerHTML = `
                        <strong>Research Complete!</strong><br>
                        Total: ${data.total_casinos} casinos<br>
                        Successful: ${data.successful}<br>
                        Failed: ${data.failed}<br>
                        Results saved to: ${data.results_file}
                    `;
                } else if (data.status === "error") {
                    document.getElementById("progressText").innerHTML = `
                        <strong>Research Failed:</strong><br>
                        ${data.message}
                    `;
                }
            })
            .catch(error => {
                document.getElementById("progressText").innerHTML = `
                    <strong>Error:</strong><br>
                    ${error.message}
                `;
            });
        }
        
        function startSingleResearch() {
            const casinoName = document.getElementById("casinoName").value;
            if (!casinoName) {
                alert("Please enter a casino name");
                return;
            }
            
            document.getElementById("progressSection").classList.add("show");
            document.getElementById("progressText").textContent = `Researching ${casinoName}...`;
            
            fetch(`/casino-research/single?casino=${encodeURIComponent(casinoName)}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === "completed") {
                    document.getElementById("progressText").innerHTML = `
                        <strong>Research Complete for ${casinoName}!</strong><br>
                        <pre>${JSON.stringify(data.casino, null, 2)}</pre>
                    `;
                } else if (data.status === "error") {
                    document.getElementById("progressText").innerHTML = `
                        <strong>Research Failed:</strong><br>
                        ${data.message}
                    `;
                }
            })
            .catch(error => {
                document.getElementById("progressText").innerHTML = `
                    <strong>Error:</strong><br>
                    ${error.message}
                `;
            });
        }
    </script>
</body>
</html>';
    }
}
