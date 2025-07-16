<?php
echo "Current working directory: " . getcwd() . "\n";
echo "ROOT_PATH: " . dirname(__DIR__) . "\n";
echo "SRC_PATH: " . dirname(__DIR__) . '/src' . "\n";
echo "Router path: " . dirname(__DIR__) . '/src/Core/Router.php' . "\n";
echo "File exists: " . (file_exists(dirname(__DIR__) . '/src/Core/Router.php') ? 'YES' : 'NO') . "\n";
echo "Is readable: " . (is_readable(dirname(__DIR__) . '/src/Core/Router.php') ? 'YES' : 'NO') . "\n";
?>
