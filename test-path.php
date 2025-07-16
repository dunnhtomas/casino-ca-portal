<?php
echo "Script location: " . __FILE__ . "\n";
echo "Directory: " . __DIR__ . "\n";
echo "Parent directory: " . dirname(__DIR__) . "\n";
echo "Router path: " . dirname(__DIR__) . '/src/Core/Router.php' . "\n";
echo "File exists: " . (file_exists(dirname(__DIR__) . '/src/Core/Router.php') ? 'YES' : 'NO') . "\n";
echo "Is readable: " . (is_readable(dirname(__DIR__) . '/src/Core/Router.php') ? 'YES' : 'NO') . "\n";
echo "Real path: " . realpath(dirname(__DIR__) . '/src/Core/Router.php') . "\n";
?>
