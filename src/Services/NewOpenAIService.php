<?php
// Enhanced OpenAI Service using Official PHP Client
namespace CasinoPortal\Services;

require_once __DIR__ . '/../../vendor/autoload.php';

use OpenAI\Client;
use Dotenv\Dotenv;
use Exception;

class NewOpenAIService
{
    private $client;
    private $tokenCount = 0;
    private $requestCount = 0;
    private $rateLimitCount = 0;
    
    public function __construct()
    {
        // Load environment variables
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->safeLoad();
        
        // Get API key
        $apiKey = $_ENV['OPENAI_API_KEY'] ?? getenv('OPENAI_API_KEY');
        if (!$apiKey) {
            throw new Exception('OPENAI_API_KEY not set in .env');
        }
        
        // Create OpenAI client
        $this->client = Client::factory([
            'api_key' => $apiKey,
        ]);
        
        echo "✅ OpenAI PHP Client initialized successfully\n";
    }
    
    /**
     * Rewrite text using GPT-3.5-turbo
     */
    public function rewriteText(string $text): string
    {
        try {
            $response = $this->client->chat->completions->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are an expert Canadian casino content writer. Rewrite the content to be more engaging and SEO-friendly while maintaining authenticity.'],
                    ['role' => 'user', 'content' => "Please rewrite the following text:\n\n{$text}"],
                ],
                'temperature' => 0.7,
                'max_tokens' => 1024,
            ]);
            
            $this->requestCount++;
            if (isset($response->usage->totalTokens)) {
                $this->tokenCount += $response->usage->totalTokens;
            }
            
            return trim($response->choices[0]->message->content);
            
        } catch (Exception $e) {
            error_log("OpenAI rewrite error: " . $e->getMessage());
            return $text; // Return original text on error
        }
    }
    
    /**
     * Generate casino content using GPT-4o-mini
     */
    public function generateCasinoContent(string $prompt): string
    {
        try {
            $response = $this->client->chat->completions->create([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'system', 'content' => $this->getCasinoSystemPrompt()],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.8,
                'max_tokens' => 2000,
            ]);
            
            $this->requestCount++;
            if (isset($response->usage->totalTokens)) {
                $this->tokenCount += $response->usage->totalTokens;
            }
            
            return trim($response->choices[0]->message->content);
            
        } catch (Exception $e) {
            error_log("OpenAI content generation error: " . $e->getMessage());
            return "Content generation temporarily unavailable.";
        }
    }
    
    /**
     * Research casino information
     */
    public function researchCasino(string $casinoName, string $website = ''): array
    {
        try {
            $prompt = $this->buildResearchPrompt($casinoName, $website);
            
            $response = $this->client->chat->completions->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a professional casino research analyst. Provide comprehensive, accurate information about online casinos in JSON format.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.2, // Lower temperature for factual accuracy
                'max_tokens' => 1500,
            ]);
            
            $this->requestCount++;
            if (isset($response->usage->totalTokens)) {
                $this->tokenCount += $response->usage->totalTokens;
            }
            
            $content = trim($response->choices[0]->message->content);
            
            // Try to parse JSON response
            $data = json_decode($content, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $data;
            } else {
                // Return structured fallback
                return [
                    'name' => $casinoName,
                    'website' => $website,
                    'research_content' => $content,
                    'status' => 'parsed_text'
                ];
            }
            
        } catch (Exception $e) {
            error_log("OpenAI research error: " . $e->getMessage());
            return [
                'name' => $casinoName,
                'website' => $website,
                'error' => $e->getMessage(),
                'status' => 'failed'
            ];
        }
    }
    
    /**
     * Generate feature image using DALL-E
     */
    public function generateImage(string $prompt, int $n = 1, string $size = '1024x1024'): array
    {
        try {
            $enhancedPrompt = $this->enhanceImagePrompt($prompt);
            
            $response = $this->client->images->create([
                'prompt' => $enhancedPrompt,
                'n' => $n,
                'size' => $size,
            ]);
            
            $this->requestCount++;
            
            return array_map(fn($d) => $d->url, $response->data);
            
        } catch (Exception $e) {
            error_log("OpenAI image generation error: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Test the connection with minimal request
     */
    public function testConnection(): array
    {
        try {
            $response = $this->client->chat->completions->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'user', 'content' => 'Say "Hello" in exactly one word.'],
                ],
                'max_tokens' => 10,
                'temperature' => 0.1,
            ]);
            
            return [
                'success' => true,
                'response' => trim($response->choices[0]->message->content),
                'tokens_used' => $response->usage->totalTokens ?? 0,
                'model' => $response->model ?? 'unknown'
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'tokens_used' => 0
            ];
        }
    }
    
    /**
     * Get usage statistics
     */
    public function getUsageStats(): array
    {
        return [
            'total_requests' => $this->requestCount,
            'total_tokens' => $this->tokenCount,
            'rate_limits_hit' => $this->rateLimitCount
        ];
    }
    
    /**
     * Enhanced casino system prompt for 2025
     */
    private function getCasinoSystemPrompt(): string
    {
        return "You are Sarah Chen, a professional Canadian casino expert with 8+ years of experience reviewing online casinos. Write authentic, engaging content that helps Canadian players make informed decisions.

WRITING REQUIREMENTS:
- Write in first person with personal experience
- Use Canadian spelling and terminology
- Reference real Canadian locations when relevant
- Include specific details only an experienced player would know
- Avoid AI-sounding phrases like 'comprehensive', 'furthermore', 'moreover'
- Use conversational tone with contractions (don't, won't, can't)
- Include skeptical opinions when appropriate
- Reference 2025 gaming trends and technologies

CONTENT FOCUS:
- Player safety and responsible gambling
- Honest pros and cons
- Real-world testing experiences
- Canadian regulations and compliance
- Mobile gaming optimization
- Payment methods popular in Canada";
    }
    
    /**
     * Build research prompt for casino investigation
     */
    private function buildResearchPrompt(string $casinoName, string $website): string
    {
        return "Research the online casino '{$casinoName}'" . ($website ? " at {$website}" : "") . "

Please provide information in JSON format with these fields:
{
    \"name\": \"Casino Name\",
    \"website\": \"URL\",
    \"license\": \"Licensing authority\",
    \"established\": \"Year established\",
    \"owner\": \"Parent company\",
    \"games\": \"Number and types of games\",
    \"bonuses\": \"Welcome bonus details\",
    \"payment_methods\": \"Available payment options\",
    \"currencies\": \"Supported currencies\",
    \"countries\": \"Restricted/allowed countries\",
    \"mobile\": \"Mobile compatibility\",
    \"support\": \"Customer support options\",
    \"rating\": \"Overall rating out of 10\",
    \"pros\": [\"List of advantages\"],
    \"cons\": [\"List of disadvantages\"],
    \"summary\": \"Brief overview for Canadian players\"
}

Focus on accuracy and provide realistic, helpful information for Canadian casino players.";
    }
    
    /**
     * Enhance image prompts for casino-themed generation
     */
    private function enhanceImagePrompt(string $prompt): string
    {
        return "Professional casino and gaming themed image: {$prompt}. 
Style: modern, clean, vibrant colors, high-quality digital art, 
casino elements like cards, chips, slot machines, roulette wheels.
Avoid text overlays. Suitable for website header or feature image.
High resolution, professional photography style.";
    }
}
?>
