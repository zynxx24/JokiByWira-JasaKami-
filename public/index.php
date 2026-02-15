<?php

use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;

require __DIR__ . '/../vendor/autoload.php';

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

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Load routes
require __DIR__ . '/../src/routes.php';

$app->run();
