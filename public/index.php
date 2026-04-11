<?php

use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;

require __DIR__ . '/../vendor/autoload.php';

// Start session for auth
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Create Container
$container = new Container();

// Set up PhpRenderer
$container->set(PhpRenderer::class, function () {
    $renderer = new PhpRenderer(__DIR__ . '/../templates');
    return $renderer;
});

// Create App with container
AppFactory::setContainer($container);
$app = AppFactory::create();

// Parse JSON body for POST requests
$app->addBodyParsingMiddleware();

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Load routes
require __DIR__ . '/../src/routes.php';

$app->run();
