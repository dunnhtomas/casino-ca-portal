<?php
// Script to fix the problematic routes in routes.php

$content = file_get_contents('src/routes.php');

// Replace the specific routes
$content = str_replace(
    "\$router->get('/bonuses', 'BonusDatabaseController@getAllBonuses');",
    "\$router->get('/bonuses', 'BonusController@index');",
    $content
);

$content = str_replace(
    "\$router->get('/api/bonuses', 'BonusDatabaseController@getAllBonuses');",
    "\$router->get('/api/bonuses', 'BonusController@ajax');",
    $content
);

$content = str_replace(
    "\$router->get('/api/bonuses/filter', 'BonusDatabaseController@filterBonuses');",
    "\$router->get('/api/bonuses/filter', 'BonusController@ajax');",
    $content
);

file_put_contents('src/routes.php', $content);
echo "Routes fixed successfully!\n";
?>
