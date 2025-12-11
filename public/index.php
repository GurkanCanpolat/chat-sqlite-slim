<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();
$app->addBodyParsingMiddleware();
// Add routing and error middleware so Slim handles exceptions and 404s
$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// ROUTES.PHP dosyasını çalıştır
$routes = require __DIR__ . '/../src/routes.php';
if (is_callable($routes)) {
    $routes($app);
} else {
    error_log('routes.php bir fonksiyon döndürmedi');
}

$app->run();
