<?php
namespace App\Services;

class OpenAIService {
    private $apiKey;
    private $baseUrl = "https://api.openai.com/v1";
    
    public function __construct() {
        $this->apiKey = $_ENV["OPENAI_API_KEY"] ?? "";
        if (empty($this->apiKey)) {
            throw new \Exception("OpenAI API key not configured");
        }
    }
    
    public function generateCasinoReview(array $casinoData): string {
        // Get a real human author for this review
        require_once __DIR__ . '/AuthorService.php';
        $authorService = new AuthorService();
        $author = $authorService->getRandomAuthor();
        
        $prompt = $this->buildHumanReviewPrompt($casinoData, $author);
        
        // Optimized parameters for natural content generation
        $response = $this->makeRequest("/chat/completions", [
            "model" => "gpt-4o-mini",
            "messages" => [
                ["role" => "system", "content" => $this->getAntiAISystemPrompt()],
                ["role" => "user", "content" => $prompt]
            ],
            "max_tokens" => 2800,
            "temperature" => 1.1,        // Higher randomness for natural variation
            "top_p" => 0.95,            // Nucleus sampling for unpredictability
            "frequency_penalty" => 0.9,  // Heavily penalize repetition
            "presence_penalty" => 0.8,   // Encourage topic diversity
            "stop" => null              // No stop sequences for natural flow
        ]);
        
        $content = $response["choices"][0]["message"]["content"] ?? "";
        
        // Add author byline and bio to the content
        $authorByline = $authorService->formatAuthorByline($author);
        $authorBio = $authorService->formatAuthorBio($author);
        
        // Format the final review with human author information
        $finalContent = $this->formatReviewWithAuthor($content, $author, $authorByline, $authorBio);
        
        // Apply human-like content processing
        $finalContent = $this->humanizeContent($finalContent);
        
        return $finalContent;
    }
    
    public function generateImage(string $prompt): string {
        $enhancedPrompt = $this->enhanceImagePrompt($prompt);
        
        $response = $this->makeRequest("/images/generations", [
            "model" => "dall-e-3",
            "prompt" => $enhancedPrompt,
            "size" => "1792x1024",
            "quality" => "hd",
            "style" => "natural",
            "n" => 1
        ]);
        
        return $response["data"][0]["url"] ?? "";
    }
    
    private function getAntiAISystemPrompt(): string {
        return "You are a professional Canadian casino expert writing authentic reviews for fellow players.

WRITING STYLE REQUIREMENTS:
- Write as a seasoned gambler with real casino experience
- Use personal anecdotes from actual casino visits
- Include specific details that only an experienced player would know
- Reference real Canadian locations and cultural elements
- Write naturally with conversational flow and personal opinions
- Include first-person experiences ('I tested', 'During my visit', 'I noticed')

AUTHENTICITY MARKERS:
- Use Canadian spelling (colour, favourite, centre)
- Reference Canadian money (loonies, toonies)
- Mention specific Canadian cities and landmarks
- Include weather references and Canadian cultural touchstones
- Use natural Canadian expressions and casual language

HUMAN WRITING PATTERNS:
- Vary sentence length naturally
- Include personal opinions and subjective observations
- Add emotional reactions to gambling experiences
- Reference specific times and memorable sessions
- Show genuine expertise through technical knowledge
- Include minor inconsistencies that humans naturally make

Write as an expert sharing honest insights with fellow Canadian players.";
    }
    
    private function buildHumanReviewPrompt(array $casino, array $author): string {
        $currentMonth = date("F Y");
        
        return "Write a detailed casino review of {$casino["name"]} for Canadian players in {$currentMonth}.

CASINO INFORMATION:
- Name: {$casino["name"]}
- Welcome Bonus: {$casino["bonus"]}
- Number of Games: {$casino["games"]}
- Established: {$casino["established"]}

AUTHOR CONTEXT:
- You are {$author["name"]}, {$author["bio"]}
- Your expertise: " . implode(', ', $author["expertise"]) . "
- Writing from: {$author["location"]}

REVIEW REQUIREMENTS:
- Write 800-1200 words as a professional casino expert
- Include personal testing experience and observations
- Cover: welcome bonus, game selection, payment methods, mobile experience, customer support
- Add specific details that show real expertise
- Use first-person perspective with your professional experience
- Include both positive aspects and honest criticisms
- End with a clear recommendation and rating explanation

Write as {$author["name"]} sharing your expert analysis with fellow Canadian players.";
    }
    
    private function formatReviewWithAuthor(string $content, array $author, string $byline, string $bio): string {
        return "# " . $author['name'] . "'s Casino Review\n\n" .
               $byline . "\n\n" .
               $content . "\n\n" .
               "## About the Author\n\n" .
               $bio . "\n\n" .
               "**Credentials:** " . $author['credentials'];
    }
    
    private function humanizeContent(string $content): string {
        // ADVANCED 2025 ANTI-AI DETECTION PROCESSING
        
        // 1. ELIMINATE AI ARTIFACTS (Research-proven patterns)
        $aiArtifacts = [
            "/\bcomprehensive\b/i" => "thorough",
            "/\bextensive\b/i" => "massive",
            "/\bvarious\b/i" => "different",
            "/\bseamless\b/i" => "smooth",
            "/\bleverage\b/i" => "use",
            "/\butilize\b/i" => "use",
            "/\bfacilitate\b/i" => "help",
            "/In conclusion,?/i" => "Bottom line -",
            "/Furthermore,?/i" => "Plus,",
            "/Additionally,?/i" => "Also,",
            "/Moreover,?/i" => "And get this -",
            "/It is worth noting/i" => "Worth mentioning",
            "/significantly/i" => "way",
            "/substantially/i" => "seriously",
            "/remarkably/i" => "damn"
        ];
        
        foreach ($aiArtifacts as $pattern => $replacement) {
            $content = preg_replace($pattern, $replacement, $content);
        }
        
        // 2. INJECT PERPLEXITY VARIANCE (Sentence length chaos)
        $content = $this->manipulatePerplexity($content);
        
        // 3. CREATE BURSTINESS PATTERNS (Clustering similar structures)
        $content = $this->createBurstiness($content);
        
        // 4. ADD HUMAN COGNITIVE PATTERNS
        $content = $this->injectHumanThinking($content);
        
        // 5. CANADIAN AUTHENTICITY INJECTION
        $content = $this->addCanadianAuthenticity($content);
        
        // 6. TEMPORAL ANCHORING (2025 specific references)
        $content = $this->add2025References($content);
        
        return $content;
    }
    
    private function manipulatePerplexity(string $content): string {
        $sentences = preg_split('/(?<=[.!?])\s+/', $content);
        $newSentences = [];
        
        foreach ($sentences as $i => $sentence) {
            // Randomly break long sentences
            if (str_word_count($sentence) > 20 && rand(1, 3) === 1) {
                $words = explode(' ', $sentence);
                $breakPoint = rand(8, 15);
                $newSentences[] = implode(' ', array_slice($words, 0, $breakPoint)) . '.';
                $newSentences[] = implode(' ', array_slice($words, $breakPoint));
            }
            // Randomly combine short sentences
            elseif (str_word_count($sentence) < 8 && isset($sentences[$i + 1]) && str_word_count($sentences[$i + 1]) < 10 && rand(1, 4) === 1) {
                $newSentences[] = rtrim($sentence, '.') . ' - ' . lcfirst($sentences[$i + 1]);
                $i++; // Skip next sentence as we combined it
            } else {
                $newSentences[] = $sentence;
            }
        }
        
        return implode(' ', $newSentences);
    }
    
    private function createBurstiness(string $content): string {
        $paragraphs = explode("\n\n", $content);
        
        foreach ($paragraphs as $i => $paragraph) {
            if (rand(1, 5) === 1) {
                // Create burst of short sentences
                $sentences = explode('. ', $paragraph);
                if (count($sentences) >= 3) {
                    $burstPoint = rand(1, count($sentences) - 2);
                    $sentences[$burstPoint] = $sentences[$burstPoint] . '. Quick. Simple. Done.';
                    $paragraphs[$i] = implode('. ', $sentences);
                }
            }
        }
        
        return implode("\n\n", $paragraphs);
    }
    
    private function injectHumanThinking(string $content): string {
        $thinkingPatterns = [
            "Actually, wait..." => 0.03,
            "I'm not sure but..." => 0.04,
            "Maybe it's just me, but..." => 0.02,
            "Here's the thing though -" => 0.05,
            "Honestly?" => 0.06,
            "Can't decide if..." => 0.03,
            "Reminds me of..." => 0.04
        ];
        
        $sentences = explode('. ', $content);
        foreach ($sentences as $i => $sentence) {
            foreach ($thinkingPatterns as $pattern => $probability) {
                if (rand(1, 100) <= ($probability * 100)) {
                    $sentences[$i] = $pattern . ' ' . lcfirst($sentence);
                    break;
                }
            }
        }
        
        return implode('. ', $sentences);
    }
    
    private function addCanadianAuthenticity(string $content): string {
        $canadianMarkers = [
            "eh?" => 0.02,
            "Tim Hortons" => 0.01,
            "loonie" => 0.015,
            "toque" => 0.01,
            "double-double" => 0.008,
            "for sure" => 0.08,
            "no doubt" => 0.06
        ];
        
        $sentences = explode('. ', $content);
        foreach ($sentences as $i => $sentence) {
            foreach ($canadianMarkers as $marker => $probability) {
                if (rand(1, 100) <= ($probability * 100)) {
                    if ($marker === "Tim Hortons") {
                        $sentence .= " (grabbed a Tim's before this session)";
                    } elseif ($marker === "loonie" || $marker === "toque") {
                        $sentence .= " - cost me a few " . $marker . "s";
                    } else {
                        $sentence .= ", " . $marker;
                    }
                    $sentences[$i] = $sentence;
                    break;
                }
            }
        }
        
        return implode('. ', $sentences);
    }
    
    private function add2025References(string $content): string {
        $references2025 = [
            "inflation hitting my gambling budget" => 0.01,
            "since the pandemic changed everything" => 0.01,
            "TikTok casino videos got me curious" => 0.008,
            "iPhone 16 makes mobile gaming sick" => 0.005,
            "housing prices are nuts so I stay home and gamble" => 0.003
        ];
        
        $paragraphs = explode("\n\n", $content);
        foreach ($paragraphs as $i => $paragraph) {
            foreach ($references2025 as $ref => $probability) {
                if (rand(1, 100) <= ($probability * 100)) {
                    $paragraphs[$i] .= " (" . $ref . ")";
                    break;
                }
            }
        }
        
        return implode("\n\n", $paragraphs);
    }
    
    private function addRandomTypos(string $content): string {
        // Add subtle human typing errors (very sparingly)
        $typoPatterns = [
            "/\bteh\b/" => "the",
            "/\brecieve\b/" => "receive", 
            "/\boccur\b/" => "occur",
            "/\bdefintely\b/" => "definitely"
        ];
        
        // Only add 1-2 typos per content piece (1% chance per word)
        if (rand(1, 100) <= 5) {
            $words = explode(' ', $content);
            $typoIndex = rand(0, count($words) - 1);
            
            // Common Canadian typos
            if ($words[$typoIndex] === 'the' && rand(1, 100) <= 2) {
                $words[$typoIndex] = 'teh';
            } elseif ($words[$typoIndex] === 'definitely' && rand(1, 100) <= 3) {
                $words[$typoIndex] = 'defintely';
            }
            
            $content = implode(' ', $words);
        }
        
        return $content;
    }
    
    private function addEmotionalMarkers(string $content): string {
        // Add emotional punctuation and expressions
        $emotions = [
            "!" => 0.15,        // Excitement
            "..." => 0.08,      // Trailing thought
            "?!" => 0.03,       // Confusion/surprise
            " lol" => 0.02,     // Casual laugh
            " omg" => 0.01,     // Surprise
            " wtf" => 0.005     // Frustration (rare)
        ];
        
        $sentences = explode('. ', $content);
        foreach ($sentences as $i => $sentence) {
            foreach ($emotions as $marker => $probability) {
                if (rand(1, 100) <= ($probability * 100)) {
                    if ($marker === "!") {
                        $sentences[$i] = rtrim($sentence, '.') . '!';
                    } elseif ($marker === "...") {
                        $sentences[$i] = rtrim($sentence, '.') . '...';
                    } elseif ($marker === "?!") {
                        $sentences[$i] = rtrim($sentence, '.') . '?!';
                    } else {
                        $sentences[$i] = $sentence . $marker;
                    }
                    break;
                }
            }
        }
        
        return implode('. ', $sentences);
    }
    
    private function enhanceImagePrompt(string $prompt): string {
        return $prompt . " - photorealistic, professional photography style, high quality, natural lighting, no obvious AI artifacts, authentic casino atmosphere";
    }
    
    private function getCurrentSeason(): string {
        $month = (int)date("n");
        if ($month >= 12 || $month <= 2) return "winter";
        if ($month >= 3 && $month <= 5) return "spring"; 
        if ($month >= 6 && $month <= 8) return "summer";
        return "fall";
    }
    
    private function makeRequest(string $endpoint, array $data): array {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $this->baseUrl . $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer " . $this->apiKey,
                "Content-Type: application/json"
            ],
            CURLOPT_TIMEOUT => 45,
            CURLOPT_SSL_VERIFYPEER => true
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode !== 200) {
            throw new \Exception("OpenAI API request failed with code: $httpCode");
        }
        
        return json_decode($response, true);
    }

    // ADVANCED 2025 ANTI-AI DETECTION METHODS
    
    public function generateBlogPost(array $data): string {
        $prompt = $this->buildBlogPrompt($data);
        
        $response = $this->makeRequest("/chat/completions", [
            "model" => "gpt-4o-mini",
            "messages" => [
                ["role" => "system", "content" => $this->getAdvancedAntiAIPrompt()],
                ["role" => "user", "content" => $prompt]
            ],
            "max_tokens" => 3000,
            "temperature" => 0.95,
            "frequency_penalty" => 0.8,
            "presence_penalty" => 0.7
        ]);
        
        $content = $response["choices"][0]["message"]["content"] ?? "";
        return $this->deepHumanizeContent($content);
    }
    
    private function getAdvancedAntiAIPrompt(): string {
        return "You are Sarah, a 32-year-old content creator from Vancouver who writes about online gaming and entertainment.

2025 ULTRA-STRICT ANTI-AI DETECTION RULES:

BANNED AI PHRASES (NEVER USE):
- \"In conclusion\" / \"To conclude\"
- \"Furthermore\" / \"Additionally\" / \"Moreover\"
- \"It is worth noting\" / \"It should be noted\"
- \"In summary\" / \"To summarize\"
- \"significantly\" / \"remarkably\" / \"substantially\"
- \"comprehensive\" / \"extensive\" / \"various\"
- \"cutting-edge\" / \"state-of-the-art\"
- \"seamless\" / \"user-friendly\"
- \"leverage\" / \"utilize\" / \"facilitate\"

REQUIRED HUMAN ELEMENTS:
- Random sentence lengths (3 words to 30+ words)
- Emotional reactions: \"Ugh, seriously?\" \"Wait, what?\" \"No way!\"
- Personal anecdotes: \"Last Tuesday I...\" \"My friend Jake told me...\"
- Conversational fillers: \"I mean...\" \"Like...\" \"You know what I mean?\"
- Contractions everywhere (don't, won't, can't, shouldn't)
- Canadian slang: \"eh\", \"loonie\", \"toque\", \"double-double\"
- 2025 references: current events, memes, trends, pop culture
- Imperfect grammar occasionally (like real humans)
- Skeptical tone when appropriate
- Break your own patterns mid-content

TONE REQUIREMENTS:
- Write like you're explaining to a friend over coffee
- Include doubts, second thoughts, contradictions
- Use modern internet slang appropriately
- Reference real experiences and complaints
- Sound opinionated, not neutral

NEVER sound corporate, robotic, or AI-generated. Be messy, human, and authentic.";
    }
    
    private function buildBlogPrompt(array $data): string {
        $topic = $data["topic"] ?? "casino gaming";
        $keywords = $data["keywords"] ?? [];
        $length = $data["length"] ?? "1500";
        
        return "Write a {$length}-word blog post about {$topic} for Canadian readers in July 2025.

TARGET KEYWORDS (use naturally): " . implode(", ", $keywords) . "

CONTENT REQUIREMENTS:
- Personal, conversational tone
- 3-5 subheadings (H2/H3) with natural keyword placement
- Include current 2025 trends and events
- Mix of paragraphs: short (1-2 sentences) and long (4-6 sentences)
- At least 2 personal stories or examples
- One controversial or contrarian opinion
- Modern Canadian context and references
- Natural SEO without keyword stuffing
- Include questions readers might ask
- End with a call-to-action that feels natural

Make it sound like a real person wrote this based on genuine experience. No AI fingerprints.";
    }
    
    private function deepHumanizeContent(string $content): string {
        // Advanced AI pattern removal
        $aiPatterns = [
            "/\bcomprehensive\b/i" => "complete",
            "/\bextensive\b/i" => "tons of",
            "/\bvarious\b/i" => "different",
            "/\bcutting-edge\b/i" => "latest",
            "/\bstate-of-the-art\b/i" => "top-notch",
            "/\bseamless\b/i" => "smooth",
            "/\buser-friendly\b/i" => "easy to use",
            "/\bleverage\b/i" => "use",
            "/\butilize\b/i" => "use",
            "/\bfacilitate\b/i" => "help",
            "/\bIt's important to note\b/i" => "Just heads up",
            "/\bAs we can see\b/i" => "Look at this",
            "/\bIn today's digital age\b/i" => "These days",
            "/\bSignificantly\b/i" => "Way",
            "/\bSubstantially\b/i" => "Much",
            "/\bRemarkably\b/i" => "Pretty"
        ];
        
        foreach ($aiPatterns as $pattern => $replacement) {
            $content = preg_replace($pattern, $replacement, $content);
        }
        
        // Add human imperfections
        $content = $this->addHumanImperfections($content);
        
        // Insert Canadian personality
        $content = $this->addCanadianFlavor($content);
        
        // Break AI rhythm patterns
        $content = $this->breakAIPatterns($content);
        
        return $content;
    }
    
    private function addHumanImperfections(string $content): string {
        $sentences = explode(". ", $content);
        $humanizedSentences = [];
        
        foreach ($sentences as $i => $sentence) {
            // Randomly add human elements
            if (rand(1, 8) === 1) {
                $fillers = ["I mean", "Like", "You know", "Honestly", "Real talk", "No joke"];
                $filler = $fillers[array_rand($fillers)];
                $sentence = $filler . ", " . lcfirst($sentence);
            }
            
            // Occasionally start with "And" or "But" (human writing)
            if (rand(1, 12) === 1 && $i > 0) {
                $starters = ["And", "But", "Plus", "Also"];
                $starter = $starters[array_rand($starters)];
                $sentence = $starter . " " . lcfirst($sentence);
            }
            
            $humanizedSentences[] = $sentence;
        }
        
        return implode(". ", $humanizedSentences);
    }
    
    private function addCanadianFlavor(string $content): string {
        $canadianPhrases = [
            "eh?" => 0.05,
            "for sure" => 0.08,
            "no doubt" => 0.06,
            "pretty solid" => 0.04,
            "honestly" => 0.10,
            "real talk" => 0.03
        ];
        
        $paragraphs = explode("\n\n", $content);
        foreach ($paragraphs as $i => $paragraph) {
            foreach ($canadianPhrases as $phrase => $probability) {
                if (rand(1, 100) <= ($probability * 100)) {
                    // Insert phrase naturally
                    $sentences = explode(". ", $paragraph);
                    if (count($sentences) > 1) {
                        $insertAt = rand(0, count($sentences) - 1);
                        $sentences[$insertAt] .= " - " . $phrase;
                        $paragraphs[$i] = implode(". ", $sentences);
                        break; // Only one phrase per paragraph
                    }
                }
            }
        }
        
        return implode("\n\n", $paragraphs);
    }
    
    private function breakAIPatterns(string $content): string {
        // Randomly vary paragraph starts
        $paragraphs = explode("\n\n", $content);
        $starters = [
            "Look,", "Here's the thing:", "Okay, so", "Now,", "Listen,", 
            "Wait,", "Actually,", "Funny thing is,", "Get this:"
        ];
        
        foreach ($paragraphs as $i => $paragraph) {
            if (rand(1, 6) === 1 && $i > 0) {
                $starter = $starters[array_rand($starters)];
                $paragraphs[$i] = $starter . " " . lcfirst($paragraph);
            }
        }
        
        return implode("\n\n", $paragraphs);
    }
}
