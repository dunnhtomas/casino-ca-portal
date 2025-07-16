<?php
/**
 * Routes Configuration for Casino Portal
 * Defines all application routes and their handlers
 */

// Home routes
$router->get('/', 'HomeController@index');
$router->get('/home', 'HomeController@index');

// Casino routes
$router->get('/casinos', 'CasinoController@list');
$router->get('/casino/{slug}', 'CasinoController@detail');

// Review routes
$router->get('/reviews', 'ReviewController@list');
$router->get('/review/{slug}', 'ReviewController@detail');

// Content generation routes
$router->get('/generate-content', 'ContentController@generate');
$router->post('/api/generate-review', 'ContentController@generateReview');

// Admin routes
$router->get('/admin', 'AdminController@dashboard');
$router->get('/admin/casinos', 'AdminController@casinos');
$router->get('/admin/reviews', 'AdminController@reviews');

// API routes
$router->get('/api/casinos', 'ApiController@casinos');
$router->get('/api/casino/{id}', 'ApiController@casino');
$router->post('/api/review', 'ApiController@createReview');

// Demo routes
$router->get('/demo-anti-ai', 'DemoController@antiAi');

// Static pages
$router->get('/about', 'PageController@about');
$router->get('/contact', 'PageController@contact');
$router->get('/privacy', 'PageController@privacy');
$router->get('/terms', 'PageController@terms');

// Bonus routes
$router->get('/bonuses', 'BonusController@list');
$router->get('/bonus/{slug}', 'BonusController@detail');

// Game routes
$router->get('/games', 'GameController@list');
$router->get('/games/{category}', 'GameController@category');
$router->get('/game/{slug}', 'GameController@detail');

// News routes
$router->get('/news', 'NewsController@list');
$router->get('/news/{slug}', 'NewsController@detail');

// Search routes
$router->get('/search', 'SearchController@index');
$router->post('/search', 'SearchController@search');

// User routes (if implementing user accounts)
$router->get('/login', 'AuthController@login');
$router->post('/login', 'AuthController@doLogin');
$router->get('/register', 'AuthController@register');
$router->post('/register', 'AuthController@doRegister');
$router->get('/logout', 'AuthController@logout');

// Sitemap and SEO
$router->get('/sitemap.xml', 'SeoController@sitemap');
$router->get('/robots.txt', 'SeoController@robots');
