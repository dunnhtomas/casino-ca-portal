    private function getTopCasinos(): array {
        // Use our researched casino data instead of hardcoded mock data
        $casinoDataService = new \App\Services\CasinoDataService();
        $allCasinos = $casinoDataService->getAllCasinos();
        
        // Get top 10 casinos sorted by rating
        usort($allCasinos, function($a, $b) {
            return ($b['rating'] ?? 0) <=> ($a['rating'] ?? 0);
        });
        
        $topCasinos = array_slice($allCasinos, 0, 10);
        
        // Convert to expected format for the homepage
        $formatted = [];
        foreach ($topCasinos as $casino) {
            $formatted[] = [
                'name' => $casino['name'] ?? 'Unknown Casino',
                'established' => $casino['established_year'] ?? null,
                'rating' => $casino['rating'] ?? 0,
                'rating_text' => $this->getRatingText($casino['rating'] ?? 0),
                'bonus' => $casino['bonus_offer'] ?? 'Bonus Available',
                'rtp' => ($casino['rtp'] ?? '96') . '%',
                'payout' => $casino['payout_time'] ?? '1-3 days',
                'games' => ($casino['total_games'] ?? '1000') . '+',
                'slug' => $casino['slug'] ?? strtolower(str_replace(' ', '-', $casino['name'] ?? 'casino'))
            ];
        }
        
        return $formatted;
    }
    
    private function getRatingText($rating): string {
        if ($rating >= 8.5) return 'Outstanding';
        if ($rating >= 8.0) return 'Excellent';
        if ($rating >= 7.5) return 'Very Good';
        if ($rating >= 7.0) return 'Good';
        if ($rating >= 6.0) return 'Fair';
        return 'Average';
    }
