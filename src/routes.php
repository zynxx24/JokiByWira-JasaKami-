<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;

$dataDir = __DIR__ . '/../data';

// Helper function to load JSON data
function loadJson(string $file): array
{
    $path = __DIR__ . '/../data/' . $file;
    if (!file_exists($path))
        return [];
    $content = file_get_contents($path);
    return json_decode($content, true) ?? [];
}

// ==========================================
// PAGE ROUTES
// ==========================================

// Home page
$app->get('/', function (Request $request, Response $response) {
    $renderer = $this->get(PhpRenderer::class);
    $services = loadJson('services.json');
    $testimonials = loadJson('testimonials.json');
    $workers = loadJson('workers.json');

    return $renderer->render($response, 'home.php', [
        'pageTitle' => 'JasaKami — Pencari Daily Worker Profesional',
        'services' => $services,
        'testimonials' => $testimonials,
        'workers' => $workers,
        'currentPage' => 'home',
    ]);
});

// Login page
$app->get('/login', function (Request $request, Response $response) {
    $renderer = $this->get(PhpRenderer::class);

    return $renderer->render($response, 'login.php', [
        'pageTitle' => 'Login — JasaKami',
        'currentPage' => 'login',
    ]);
});

// Booking page
$app->get('/booking', function (Request $request, Response $response) {
    $renderer = $this->get(PhpRenderer::class);
    $services = loadJson('services.json');
    $workers = loadJson('workers.json');

    return $renderer->render($response, 'booking.php', [
        'pageTitle' => 'Pesan Layanan — JasaKami',
        'services' => $services,
        'workers' => $workers,
        'currentPage' => 'booking',
    ]);
});

// ==========================================
// API ROUTES
// ==========================================

// Get all workers (with optional filters)
$app->get('/api/workers', function (Request $request, Response $response) {
    $workers = loadJson('workers.json');
    $params = $request->getQueryParams();

    // Filter by gender
    if (!empty($params['gender'])) {
        $workers = array_filter($workers, fn($w) => $w['gender'] === $params['gender']);
    }

    // Filter by department
    if (!empty($params['department'])) {
        $workers = array_filter($workers, fn($w) => $w['department'] === $params['department']);
    }

    // Filter by section
    if (!empty($params['section'])) {
        $workers = array_filter($workers, fn($w) => $w['section'] === $params['section']);
    }

    $response->getBody()->write(json_encode(array_values($workers)));
    return $response->withHeader('Content-Type', 'application/json');
});

// Get services data
$app->get('/api/services', function (Request $request, Response $response) {
    $services = loadJson('services.json');
    $response->getBody()->write(json_encode($services));
    return $response->withHeader('Content-Type', 'application/json');
});
