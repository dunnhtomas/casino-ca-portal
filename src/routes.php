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

// Casino Categories routes (PRD #04)
$router->get('/categories', 'CasinoCategoriesController@index');
$router->get('/categories/{categoryId}', 'CasinoCategoriesController@showCategory');
$router->get('/categories/multiple', 'CasinoCategoriesController@showMultipleCategories');
$router->get('/api/categories/{categoryId}/filter', 'CasinoCategoriesController@filterCategory');
$router->get('/api/categories/{categoryId}/filters', 'CasinoCategoriesController@getCategoryFilters');

// Interactive Casino Grid routes (PRD #02)
$router->get('/casino-grid', 'CasinoGridController@index');
$router->get('/compare-all-casinos', 'CasinoGridController@index');
$router->get('/api/casino-grid', 'CasinoGridController@api');

// Review routes
$router->get('/reviews', 'ReviewController@list');
$router->get('/review/{slug}', 'ReviewController@detail');

// Review Methodology routes (PRD #19)
$router->get('/review-methodology', 'ReviewMethodologyController@index');
$router->get('/methodology/{criteriaSlug}', 'ReviewMethodologyController@criteria');
$router->get('/expert-team', 'ReviewMethodologyController@expertTeam');
$router->get('/testing-process', 'ReviewMethodologyController@testingProcess');

// Review Methodology API routes
$router->get('/api/review-methodology', 'ReviewMethodologyController@apiMethodology');
$router->get('/api/methodology-criteria', 'ReviewMethodologyController@apiCriteria');
$router->get('/api/expert-team', 'ReviewMethodologyController@apiExpertTeam');

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

// Bonus Comparison routes (PRD #05)
$router->get('/bonuses', 'BonusController@list');
$router->get('/bonus/{slug}', 'BonusController@detail');
$router->get('/api/bonus-comparison', 'BonusComparisonController@index');
$router->get('/bonuses/comparison-table', 'BonusComparisonController@comparisonTable');

// Expert Team routes (PRD #06)
$router->get('/experts', 'ExpertTeamController@index');
$router->get('/experts/{expertSlug}', 'ExpertTeamController@show');
$router->get('/api/experts', 'ExpertTeamController@index');
$router->get('/api/expert-recommendations', 'ExpertTeamController@getExpertRecommendations');
$router->get('/api/expert-recommendations/{expertId}', 'ExpertTeamController@getExpertRecommendations');

// Popular Slots routes (PRD #07)
$router->get('/slots', 'PopularSlotsController@index');
$router->get('/slots/{slotSlug}', 'PopularSlotsController@show');
$router->get('/api/slots', 'PopularSlotsController@index');
$router->get('/api/slots/search', 'PopularSlotsController@search');
$router->get('/api/slots/provider/{providerId}', 'PopularSlotsController@getSlotsByProvider');
$router->get('/api/slots/section', 'PopularSlotsController@getPopularSlotsSection');

// Detailed Casino Reviews routes (PRD #08)
$router->get('/casino/{casinoSlug}', 'CasinoReviewController@showCasinoReview');
$router->get('/api/casino-reviews/top-3', 'CasinoReviewController@getReviewsData');
$router->get('/reviews/detailed', 'CasinoReviewController@getTop3ReviewsSection');

// Game routes
$router->get('/games', 'GameController@list');
$router->get('/games/{category}', 'GameController@category');
$router->get('/game/{slug}', 'GameController@detail');

// News routes (PRD #14)
$router->get('/news', 'NewsController@index');
$router->get('/news/category/{category}', 'NewsController@category');
$router->get('/news/{slug}', 'NewsController@article');
$router->get('/news/search', 'NewsController@search');
$router->get('/api/news/featured', 'NewsController@apiFeaturedNews');
$router->get('/api/news/latest', 'NewsController@apiLatestUpdates');
$router->get('/api/news/breaking', 'NewsController@apiBreakingNews');
$router->get('/api/news/trending', 'NewsController@apiTrendingNews');

// Search routes
$router->get('/search', 'SearchController@index');
$router->post('/search', 'SearchController@search');

// User routes (if implementing user accounts)
$router->get('/login', 'AuthController@login');
$router->post('/login', 'AuthController@doLogin');
$router->get('/register', 'AuthController@register');
$router->post('/register', 'AuthController@doRegister');
$router->get('/logout', 'AuthController@logout');

// Bonus Database routes (PRD #09)
$router->get('/bonuses', 'BonusDatabaseController@getAllBonuses');
$router->get('/bonus/{bonusId}', 'BonusDatabaseController@showBonusTerms');
$router->get('/api/bonuses', 'BonusDatabaseController@getAllBonuses');
$router->get('/api/bonuses/filter', 'BonusDatabaseController@filterBonuses');
$router->get('/api/bonus/{bonusId}', 'BonusDatabaseController@getBonusDetails');

// Free Games Library routes (PRD #10)
$router->get('/free-games', 'FreeGamesLibraryController@index');
$router->get('/free-games/filter', 'FreeGamesLibraryController@filterGames');
$router->get('/api/free-games', 'FreeGamesLibraryController@getPopularGamesForHomepage');
$router->get('/api/free-games/provider/{provider}', 'FreeGamesLibraryController@getGamesByProvider');
$router->get('/api/free-games/category/{category}', 'FreeGamesLibraryController@getGamesByCategory');
$router->get('/api/free-games/search', 'FreeGamesLibraryController@searchGames');
$router->get('/api/free-games/statistics', 'FreeGamesLibraryController@getStatistics');
$router->get('/slots/{gameId}', 'FreeGamesLibraryController@showGame');
$router->get('/play-demo/{gameId}', 'FreeGamesLibraryController@playDemo');

// Sitemap and SEO
$router->get('/sitemap.xml', 'SeoController@sitemap');
$router->get('/robots.txt', 'SeoController@robots');

// Live Dealer Games routes (PRD #11)
$router->get('/live-dealer-games', 'LiveDealerGamesController@index');
$router->get('/live-dealer-games/filter', 'LiveDealerGamesController@filterGames');
$router->get('/api/live-dealer-games', 'LiveDealerGamesController@getApiData');
$router->get('/api/live-dealer-games/provider/{provider}', 'LiveDealerGamesController@getGamesByProvider');
$router->get('/api/live-dealer-games/category/{category}', 'LiveDealerGamesController@getGamesByCategory');
$router->get('/api/live-dealer-games/search', 'LiveDealerGamesController@searchGames');
$router->get('/api/live-dealer-games/statistics', 'LiveDealerGamesController@getStatistics');
$router->get('/live-games/{gameId}', 'LiveDealerGamesController@showGame');
$router->get('/play-live/{gameId}', 'LiveDealerGamesController@playLive');

// Payment Methods routes (PRD #12)
$router->get('/payment-methods', 'PaymentMethodsController@index');
$router->get('/payment-methods/filter', 'PaymentMethodsController@filterMethods');
$router->get('/api/payment-methods', 'PaymentMethodsController@getApiData');
$router->get('/api/payment-methods/category/{category}', 'PaymentMethodsController@getMethodsByCategory');
$router->get('/api/payment-methods/canadian', 'PaymentMethodsController@getCanadianBankingOptions');
$router->get('/payment-methods/{methodId}', 'PaymentMethodsController@showMethodDetails');
$router->get('/casinos/payment-method/{methodId}', 'PaymentMethodsController@getCasinosAcceptingMethod');

// Mobile App routes (PRD #13)
$router->get('/mobile-apps', 'MobileAppController@index');
$router->get('/mobile-apps/platform/{platform}', 'MobileAppController@getAppsByPlatform');
$router->get('/api/mobile-apps', 'MobileAppController@getApiData');
$router->get('/api/mobile-apps/featured', 'MobileAppController@getFeaturedApps');
$router->get('/api/mobile-apps/statistics', 'MobileAppController@getStatistics');
$router->get('/api/mobile-apps/advantages', 'MobileAppController@getAdvantages');
$router->get('/mobile-apps/{appId}', 'MobileAppController@showAppDetails');
$router->post('/mobile-apps/{appId}/track-download', 'MobileAppController@trackDownload');
$router->get('/mobile-apps/casino/{casinoId}', 'MobileAppController@getCasinoApp');

// Canadian Provinces routes (PRD #16)
$router->get('/provinces', 'ProvinceController@index');
$router->get('/provinces/{provinceCode}', 'ProvinceController@show');
$router->get('/api/provinces', 'ProvinceController@api');
$router->get('/api/provinces/{provinceCode}', 'ProvinceController@apiProvince');
$router->get('/api/provinces/{provinceCode}/casinos', 'ProvinceController@apiProvinceCasinos');

// Software Providers routes (PRD #17)
$router->get('/providers', 'SoftwareProviderController@index');
$router->get('/providers/{providerSlug}', 'SoftwareProviderController@show');
$router->get('/api/providers', 'SoftwareProviderController@api');
$router->get('/api/providers/{providerSlug}', 'SoftwareProviderController@apiProvider');
$router->get('/api/providers/{providerSlug}/casinos', 'SoftwareProviderController@apiProviderCasinos');
$router->get('/api/providers/category/{category}', 'SoftwareProviderController@apiProvidersByCategory');

// Legal Status & Regulation routes (PRD #18)
$router->get('/legal-status', 'LegalStatusController@index');
$router->get('/legal/{provinceCode}', 'LegalStatusController@province');
$router->get('/legal/authority/{authorityCode}', 'LegalStatusController@authority');
$router->get('/api/legal-status', 'LegalStatusController@api');
$router->get('/api/legal/province/{provinceCode}', 'LegalStatusController@apiProvince');
$router->get('/api/legal/authority/{authorityCode}', 'LegalStatusController@apiAuthority');
$router->get('/api/legal/payment-methods', 'LegalStatusController@apiPaymentMethods');

// Problem Gambling Resources routes (PRD #20)
$router->get('/problem-gambling', 'ProblemGamblingController@index');
$router->get('/problem-gambling/assessment', 'ProblemGamblingController@selfAssessment');
$router->get('/problem-gambling/tools', 'ProblemGamblingController@responsibleGamblingTools');
$router->get('/problem-gambling/treatment', 'ProblemGamblingController@treatmentOptions');
$router->get('/problem-gambling/{province}', 'ProblemGamblingController@provincialResources');

// Problem Gambling API routes
$router->get('/api/problem-gambling-resources', 'ProblemGamblingController@apiResources');
$router->get('/api/emergency-contacts', 'ProblemGamblingController@apiEmergencyContacts');
$router->get('/api/self-assessment', 'ProblemGamblingController@apiSelfAssessment');
$router->post('/api/self-assessment', 'ProblemGamblingController@apiSelfAssessment');
$router->get('/api/provincial-resource/{province}', 'ProblemGamblingController@apiProvincialResource');
