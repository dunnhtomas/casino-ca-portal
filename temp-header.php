<!DOCTYPE html>
<html lang="en-CA">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? "Best Casino Portal Canada") ?></title>
    <meta name="description" content="<?= htmlspecialchars($metaDescription ?? "Canada's premier online casino guide with reviews, bonuses, and trusted gaming sites.") ?>">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= $_ENV["APP_URL"] ?? "https://bestcasinoportal.com" ?><?= $_SERVER["REQUEST_URI"] ?>">
    
    <!-- CSS Includes -->
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header class="main-header">
        <nav class="navbar">
            <div class="nav-container">
                <a href="/" class="nav-logo">
                    <span class="logo-text">Best Casino Portal</span>
                </a>
                <ul class="nav-menu">
                    <li class="nav-item"><a href="/" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="/casinos" class="nav-link">Casinos</a></li>
                    <li class="nav-item"><a href="/bonuses" class="nav-link">Bonuses</a></li>
                    <li class="nav-item"><a href="/games" class="nav-link">Games</a></li>
                    <li class="nav-item"><a href="/review-methodology" class="nav-link">How We Review</a></li>
                    <li class="nav-item"><a href="/problem-gambling" class="nav-link">Responsible Gambling</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <main class="main-content">
