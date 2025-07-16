<?php
echo "Testing require_once...\n";

try {
    require_once dirname(__DIR__) . '/src/Core/Router.php';
    echo "Router.php loaded successfully!\n";
    
    // Test if the class exists
    if (class_exists('\\App\\Core\\Router')) {
        echo "Router class exists!\n";
        $router = new \\App\\Core\\Router();
        echo "Router instantiated successfully!\n";
    } else {
        echo "Router class does not exist!\n";
        echo "Available classes: " . implode(', ', get_declared_classes()) . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} catch (Error $e) {
    echo "Fatal Error: " . $e->getMessage() . "\n";
}
?>
