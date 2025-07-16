<?php
namespace App\Controllers;

use App\Services\AuthorService;

class AuthorController {
    private $authorService;
    
    public function __construct() {
        $this->authorService = new AuthorService();
    }
    
    public function list(): void {
        $authors = $this->authorService->getAllAuthors();
        
        echo $this->renderAuthorsPage($authors);
    }
    
    public function profile(string $authorName): void {
        $author = $this->authorService->getAuthorByName(urldecode($authorName));
        
        if (!$author) {
            http_response_code(404);
            echo "Author not found";
            return;
        }
        
        echo $this->renderAuthorProfile($author);
    }
    
    private function renderAuthorsPage(array $authors): string {
        $authorsHtml = '';
        
        foreach ($authors as $author) {
            $expertise = implode(', ', $author['expertise']);
            $authorsHtml .= "
                <div class='author-card'>
                    <div class='author-info'>
                        <h3>{$author['name']}</h3>
                        <p class='author-location'>📍 {$author['location']}</p>
                        <p class='author-bio'>{$author['bio']}</p>
                        <div class='author-expertise'>
                            <strong>Expertise:</strong> {$expertise}
                        </div>
                        <div class='author-credentials'>
                            <strong>Credentials:</strong> {$author['credentials']}
                        </div>
                    </div>
                    <div class='author-actions'>
                        <a href='/author/" . urlencode($author['name']) . "' class='btn-secondary'>View Profile</a>
                    </div>
                </div>
            ";
        }
        
        return "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Our Expert Team | Best Casino Portal</title>
    <meta name='description' content='Meet our team of professional casino experts and industry veterans who provide unbiased reviews and insights.'>
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
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        header {
            background: rgba(0,0,0,0.3);
            padding: 1rem 0;
            border-bottom: 1px solid rgba(212,175,55,0.3);
        }
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: #ffd700;
        }
        nav ul {
            list-style: none;
            display: flex;
            gap: 2rem;
        }
        nav a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        nav a:hover {
            color: #ffd700;
        }
        .page-header {
            text-align: center;
            padding: 3rem 0;
        }
        .page-header h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #ffd700;
        }
        .page-header p {
            font-size: 1.2rem;
            color: #cccccc;
        }
        .authors-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 2rem;
            padding: 2rem 0;
        }
        .author-card {
            background: rgba(255,255,255,0.1);
            border-radius: 15px;
            padding: 2rem;
            border: 1px solid rgba(212,175,55,0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .author-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(212,175,55,0.2);
        }
        .author-card h3 {
            font-size: 1.5rem;
            color: #ffd700;
            margin-bottom: 0.5rem;
        }
        .author-location {
            color: #4ade80;
            margin-bottom: 1rem;
            font-weight: bold;
        }
        .author-bio {
            margin-bottom: 1rem;
            color: #cccccc;
        }
        .author-expertise {
            margin-bottom: 1rem;
            padding: 1rem;
            background: rgba(212,175,55,0.1);
            border-radius: 8px;
        }
        .author-credentials {
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            color: #cccccc;
        }
        .btn-secondary {
            background: transparent;
            color: white;
            padding: 12px 24px;
            border: 1px solid rgba(212,175,55,0.5);
            border-radius: 8px;
            font-weight: bold;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
            display: inline-block;
        }
        .btn-secondary:hover {
            background: rgba(212,175,55,0.1);
            transform: scale(1.05);
        }
        @media (max-width: 768px) {
            .authors-grid {
                grid-template-columns: 1fr;
            }
            .page-header h1 {
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class='container'>
            <div class='header-content'>
                <div class='logo'>🎰 Best Casino Portal</div>
                <nav>
                    <ul>
                        <li><a href='/'>Home</a></li>
                        <li><a href='/casinos'>Casinos</a></li>
                        <li><a href='/reviews'>Reviews</a></li>
                        <li><a href='/authors'>Our Team</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    
    <section class='page-header'>
        <div class='container'>
            <h1>👥 Our Expert Team</h1>
            <p>Meet the professional casino experts behind our trusted reviews and insights</p>
        </div>
    </section>
    
    <section class='authors-grid'>
        <div class='container'>
            <div class='authors-grid'>
                {$authorsHtml}
            </div>
        </div>
    </section>
</body>
</html>";
    }
    
    private function renderAuthorProfile(array $author): string {
        $expertise = implode(', ', $author['expertise']);
        
        return "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>{$author['name']} - Casino Expert | Best Casino Portal</title>
    <meta name='description' content='Learn about {$author['name']}, our casino expert specializing in {$expertise}. Read professional insights and expert reviews.'>
    <style>
        /* Same styles as authors page */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); color: white; line-height: 1.6; }
        .container { max-width: 800px; margin: 0 auto; padding: 2rem 20px; }
        .profile-card { background: rgba(255,255,255,0.1); border-radius: 15px; padding: 3rem; border: 1px solid rgba(212,175,55,0.3); }
        h1 { font-size: 2.5rem; color: #ffd700; margin-bottom: 1rem; }
        .location { color: #4ade80; font-size: 1.2rem; margin-bottom: 2rem; }
        .bio { font-size: 1.1rem; margin-bottom: 2rem; line-height: 1.8; }
        .expertise, .credentials { margin-bottom: 2rem; padding: 1.5rem; background: rgba(212,175,55,0.1); border-radius: 8px; }
        .back-link { display: inline-block; margin-top: 2rem; color: #ffd700; text-decoration: none; font-weight: bold; }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class='container'>
        <div class='profile-card'>
            <h1>{$author['name']}</h1>
            <p class='location'>📍 {$author['location']}</p>
            <div class='bio'>{$author['bio']}</div>
            <div class='expertise'>
                <h3>Areas of Expertise</h3>
                <p>{$expertise}</p>
            </div>
            <div class='credentials'>
                <h3>Professional Credentials</h3>
                <p>{$author['credentials']}</p>
            </div>
            <a href='/authors' class='back-link'>← Back to Team</a>
        </div>
    </div>
</body>
</html>";
    }
}
