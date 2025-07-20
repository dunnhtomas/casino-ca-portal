<?php

namespace App\Controllers;

use App\Core\Controller;

class CasinoResearchResultsController extends Controller
{
    /**
     * Display research dashboard
     */
    public function index(): void
    {
        $resultsFile = __DIR__ . '/../../casino-research-complete.json';
        
        if (!file_exists($resultsFile)) {
            $this->render('error', [
                'title' => 'Research Results Not Found',
                'message' => 'Casino research has not been completed yet.',
                'action_link' => '/casino-research/run',
                'action_text' => 'Run Research Now'
            ]);
            return;
        }
        
        $results = json_decode(file_get_contents($resultsFile), true);
        
        $this->render('research/dashboard', [
            'title' => 'Casino Research Results Dashboard',
            'results' => $results,
            'stats' => $this->calculateStats($results),
            'meta_description' => 'Complete casino research results with detailed analysis and data for all affiliate casinos.'
        ]);
    }
    
    /**
     * Display individual casino research
     */
    public function show(string $casinoId): void
    {
        $casino = $this->getCasinoData($casinoId);
        
        if (!$casino) {
            $this->render('error', [
                'title' => 'Casino Not Found',
                'message' => "Casino with ID '{$casinoId}' was not found in research results.",
                'action_link' => '/casino-research',
                'action_text' => 'View All Results'
            ]);
            return;
        }
        
        $this->render('research/casino-details', [
            'title' => $casino['name'] . ' - Research Results',
            'casino' => $casino,
            'seo_data' => $this->generateSEOData($casino),
            'meta_description' => "Detailed research results for {$casino['name']} casino including ratings, pros, cons, and comprehensive analysis."
        ]);
    }
    
    /**
     * API endpoint for research data
     */
    public function api(): void
    {
        header('Content-Type: application/json');
        
        $resultsFile = __DIR__ . '/../../casino-research-complete.json';
        
        if (!file_exists($resultsFile)) {
            http_response_code(404);
            echo json_encode(['error' => 'Research results not found']);
            return;
        }
        
        $results = json_decode(file_get_contents($resultsFile), true);
        
        // Add API metadata
        $apiResponse = [
            'status' => 'success',
            'version' => '1.0',
            'last_updated' => $results['generated_at'],
            'total_casinos' => $results['total_processed'],
            'data' => $results
        ];
        
        echo json_encode($apiResponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
    
    /**
     * Run research process
     */
    public function runResearch(): void
    {
        set_time_limit(300); // 5 minutes
        
        echo "🚀 Starting Casino Research Process...\n";
        echo "=====================================\n";
        
        // Execute research script
        $output = shell_exec('cd ' . __DIR__ . '/../../ && php complete-casino-research.php 2>&1');
        
        echo $output;
        
        echo "\n✅ Research process completed!\n";
        echo "<br><a href='/casino-research'>View Results Dashboard</a>";
    }
    
    /**
     * Export research data in various formats
     */
    public function export(string $format = 'json'): void
    {
        $resultsFile = __DIR__ . '/../../casino-research-complete.json';
        
        if (!file_exists($resultsFile)) {
            http_response_code(404);
            echo "Research results not found";
            return;
        }
        
        $results = json_decode(file_get_contents($resultsFile), true);
        $casinos = $results['casinos'] ?? [];
        
        switch (strtolower($format)) {
            case 'csv':
                $this->exportCSV($casinos);
                break;
                
            case 'xml':
                $this->exportXML($casinos);
                break;
                
            case 'json':
            default:
                $this->exportJSON($results);
                break;
        }
    }
    
    private function getCasinoData(string $casinoId): ?array
    {
        $resultsFile = __DIR__ . '/../../casino-research-complete.json';
        
        if (!file_exists($resultsFile)) {
            return null;
        }
        
        $results = json_decode(file_get_contents($resultsFile), true);
        $casinos = $results['casinos'] ?? [];
        
        foreach ($casinos as $casino) {
            if ($casino['id'] === $casinoId) {
                return $casino;
            }
        }
        
        return null;
    }
    
    private function calculateStats(array $results): array
    {
        $casinos = $results['casinos'] ?? [];
        
        if (empty($casinos)) {
            return [];
        }
        
        $ratings = array_column($casinos, 'rating');
        $gamesCount = array_column($casinos, 'games_count');
        
        return [
            'total_casinos' => count($casinos),
            'average_rating' => round(array_sum($ratings) / count($ratings), 2),
            'highest_rating' => max($ratings),
            'lowest_rating' => min($ratings),
            'total_games' => array_sum($gamesCount),
            'average_games' => round(array_sum($gamesCount) / count($gamesCount)),
            'mobile_optimized' => count(array_filter($casinos, fn($c) => $c['mobile_optimized'] ?? false)),
            'research_methods' => $results['research_methods'] ?? [],
            'last_updated' => $results['generated_at'] ?? 'Unknown'
        ];
    }
    
    private function generateSEOData(array $casino): array
    {
        $name = $casino['name'];
        $rating = $casino['rating'];
        
        return [
            'title' => "{$name} Casino Review 2025 - Rating: {$rating}/10 | Best Casino Portal",
            'description' => "Complete {$name} casino review with {$rating}/10 rating. Honest pros & cons, games selection, bonuses & more. Research-backed analysis for Canadian players.",
            'keywords' => [
                "{$name} casino",
                "{$name} review", 
                "{$name} rating",
                "canadian casino",
                "online casino review"
            ],
            'og_title' => "{$name} Casino - Honest Review & {$rating}/10 Rating",
            'og_description' => "Research-backed review of {$name} casino. Rating: {$rating}/10. See pros, cons, games & bonuses.",
            'canonical' => "/casino-research/" . $casino['id']
        ];
    }
    
    private function exportCSV(array $casinos): void
    {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="casino-research-results.csv"');
        
        $output = fopen('php://output', 'w');
        
        // CSV headers
        $headers = ['ID', 'Name', 'Rating', 'Games Count', 'Method', 'Processed At'];
        fputcsv($output, $headers);
        
        foreach ($casinos as $casino) {
            $row = [
                $casino['id'],
                $casino['name'],
                $casino['rating'],
                $casino['games_count'],
                $casino['research_method'],
                $casino['processed_at']
            ];
            fputcsv($output, $row);
        }
        
        fclose($output);
    }
    
    private function exportXML(array $casinos): void
    {
        header('Content-Type: application/xml');
        header('Content-Disposition: attachment; filename="casino-research-results.xml"');
        
        $xml = new \SimpleXMLElement('<casino_research/>');
        $xml->addAttribute('generated_at', date('Y-m-d H:i:s'));
        
        foreach ($casinos as $casino) {
            $casinoNode = $xml->addChild('casino');
            $casinoNode->addAttribute('id', $casino['id']);
            $casinoNode->addChild('name', htmlspecialchars($casino['name']));
            $casinoNode->addChild('rating', $casino['rating']);
            $casinoNode->addChild('games_count', $casino['games_count']);
            $casinoNode->addChild('research_method', $casino['research_method']);
        }
        
        echo $xml->asXML();
    }
    
    private function exportJSON(array $results): void
    {
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="casino-research-results.json"');
        
        echo json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
?>
