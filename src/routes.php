<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;

// ==========================================
// HELPER FUNCTIONS
// ==========================================

function loadJson(string $file): array
{
    $path = __DIR__ . '/../data/' . $file;
    if (!file_exists($path)) return [];
    $content = file_get_contents($path);
    return json_decode($content, true) ?? [];
}

function saveJson(string $file, array $data): void
{
    $path = __DIR__ . '/../data/' . $file;
    file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function jsonResponse(Response $response, array $data, int $status = 200): Response
{
    $response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE));
    return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
}

function getLoggedInUser(): ?array
{
    if (!isset($_SESSION['user_id'])) return null;
    $users = loadJson('users.json');
    foreach ($users as $u) {
        if ($u['id'] === $_SESSION['user_id']) {
            $safe = $u;
            unset($safe['password']);
            return $safe;
        }
    }
    return null;
}

// ==========================================
// SEED DEFAULT USERS (on first request)
// ==========================================
function seedUsers(): void
{
    $users = loadJson('users.json');
    if (empty($users)) {
        $users = [
            [
                'id' => 1,
                'name' => 'Administrator',
                'email' => 'admin@jasakami.com',
                'password' => 'admin123',
                'role' => 'admin',
                'phone' => '081234567890',
                'avatar' => '👨‍💼',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'name' => 'User Demo',
                'email' => 'user@jasakami.com',
                'password' => 'user123',
                'role' => 'user',
                'phone' => '081234567891',
                'avatar' => '👤',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];
        saveJson('users.json', $users);
    }
}

seedUsers();

// ==========================================
// PUBLIC PAGE ROUTES
// ==========================================

// Home page
$app->get('/', function (Request $request, Response $response) {
    $renderer = $this->get(PhpRenderer::class);
    $services = loadJson('services.json');
    $testimonials = loadJson('testimonials.json');
    $workers = loadJson('workers.json');
    $user = getLoggedInUser();

    return $renderer->render($response, 'home.php', [
        'pageTitle' => 'JasaKami — Pencari Daily Worker Profesional',
        'services' => $services,
        'testimonials' => $testimonials,
        'workers' => $workers,
        'currentPage' => 'home',
        'user' => $user,
    ]);
});

// Login page
$app->get('/login', function (Request $request, Response $response) {
    // Redirect if already logged in
    $user = getLoggedInUser();
    if ($user) {
        $url = $user['role'] === 'admin' ? '/admin' : '/dashboard';
        return $response->withHeader('Location', $url)->withStatus(302);
    }

    $renderer = $this->get(PhpRenderer::class);
    return $renderer->render($response, 'login.php', [
        'pageTitle' => 'Login — JasaKami',
        'currentPage' => 'login',
        'user' => null,
    ]);
});

// Register page
$app->get('/register', function (Request $request, Response $response) {
    // Redirect if already logged in
    $user = getLoggedInUser();
    if ($user) {
        $url = $user['role'] === 'admin' ? '/admin' : '/dashboard';
        return $response->withHeader('Location', $url)->withStatus(302);
    }

    $renderer = $this->get(PhpRenderer::class);
    return $renderer->render($response, 'register.php', [
        'pageTitle' => 'Daftar — JasaKami',
        'currentPage' => 'register',
        'user' => null,
    ]);
});

// Booking page
$app->get('/booking', function (Request $request, Response $response) {
    $renderer = $this->get(PhpRenderer::class);
    $services = loadJson('services.json');
    $workers = loadJson('workers.json');
    $user = getLoggedInUser();

    return $renderer->render($response, 'booking.php', [
        'pageTitle' => 'Pesan Layanan — JasaKami',
        'services' => $services,
        'workers' => $workers,
        'currentPage' => 'booking',
        'user' => $user,
    ]);
});

// Logout
$app->get('/logout', function (Request $request, Response $response) {
    session_destroy();
    return $response->withHeader('Location', '/login')->withStatus(302);
});

// ==========================================
// AUTH API ROUTES
// ==========================================

// Login API
$app->post('/api/login', function (Request $request, Response $response) {
    $body = $request->getParsedBody();
    $email = trim($body['email'] ?? '');
    $password = $body['password'] ?? '';

    if (empty($email) || empty($password)) {
        return jsonResponse($response, ['success' => false, 'message' => 'Email dan password harus diisi.'], 400);
    }

    $users = loadJson('users.json');
    $found = null;
    foreach ($users as $u) {
        if (strtolower($u['email']) === strtolower($email)) {
            $found = $u;
            break;
        }
    }

    if (!$found || $password !== $found['password']) {
        return jsonResponse($response, ['success' => false, 'message' => 'Email atau password salah.'], 401);
    }

    // Create session
    $_SESSION['user_id'] = $found['id'];
    $_SESSION['user_role'] = $found['role'];
    $_SESSION['user_name'] = $found['name'];

    $redirect = $found['role'] === 'admin' ? '/admin' : '/dashboard';

    return jsonResponse($response, [
        'success' => true,
        'message' => 'Login berhasil!',
        'redirect' => $redirect,
        'user' => [
            'id' => $found['id'],
            'name' => $found['name'],
            'email' => $found['email'],
            'role' => $found['role'],
            'avatar' => $found['avatar'],
        ],
    ]);
});

// Register API
$app->post('/api/register', function (Request $request, Response $response) {
    $body = $request->getParsedBody();
    $name = trim($body['name'] ?? '');
    $email = trim($body['email'] ?? '');
    $phone = trim($body['phone'] ?? '');
    $password = $body['password'] ?? '';
    $passwordConfirm = $body['password_confirm'] ?? '';

    // Validation
    if (empty($name) || empty($email) || empty($password)) {
        return jsonResponse($response, ['success' => false, 'message' => 'Semua field wajib diisi.'], 400);
    }

    if (strlen($name) < 3) {
        return jsonResponse($response, ['success' => false, 'message' => 'Nama minimal 3 karakter.'], 400);
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return jsonResponse($response, ['success' => false, 'message' => 'Format email tidak valid.'], 400);
    }

    if (strlen($password) < 6) {
        return jsonResponse($response, ['success' => false, 'message' => 'Password minimal 6 karakter.'], 400);
    }

    if ($password !== $passwordConfirm) {
        return jsonResponse($response, ['success' => false, 'message' => 'Konfirmasi password tidak cocok.'], 400);
    }

    $users = loadJson('users.json');

    // Check duplicate email
    foreach ($users as $u) {
        if (strtolower($u['email']) === strtolower($email)) {
            return jsonResponse($response, ['success' => false, 'message' => 'Email sudah terdaftar.'], 409);
        }
    }

    // Generate new ID
    $maxId = 0;
    foreach ($users as $u) {
        if ($u['id'] > $maxId) $maxId = $u['id'];
    }

    $avatarNum  = rand(1, 70);
    $avatarGender = 'men'; // default
    $newUser = [
        'id' => $maxId + 1,
        'name' => $name,
        'email' => $email,
        'password' => $password,
        'role' => 'user',
        'phone' => $phone,
        'gender' => 'male',
        'avatar' => "https://randomuser.me/api/portraits/{$avatarGender}/{$avatarNum}.jpg",
        'created_at' => date('Y-m-d H:i:s'),
    ];

    $users[] = $newUser;
    saveJson('users.json', $users);

    // Auto-login after register
    $_SESSION['user_id'] = $newUser['id'];
    $_SESSION['user_role'] = $newUser['role'];
    $_SESSION['user_name'] = $newUser['name'];

    return jsonResponse($response, [
        'success' => true,
        'message' => 'Registrasi berhasil!',
        'redirect' => '/dashboard',
        'user' => [
            'id' => $newUser['id'],
            'name' => $newUser['name'],
            'email' => $newUser['email'],
            'role' => $newUser['role'],
            'avatar' => $newUser['avatar'],
        ],
    ]);
});

// ==========================================
// USER DASHBOARD ROUTES
// ==========================================

$app->get('/dashboard', function (Request $request, Response $response) {
    $user = getLoggedInUser();
    if (!$user) {
        return $response->withHeader('Location', '/login')->withStatus(302);
    }

    $renderer = $this->get(PhpRenderer::class);
    $bookings = loadJson('bookings.json');
    $myBookings = array_filter($bookings, fn($b) => $b['user_id'] === $user['id']);

    return $renderer->render($response, 'user/dashboard.php', [
        'pageTitle' => 'Dashboard — JasaKami',
        'currentPage' => 'user-dashboard',
        'user' => $user,
        'bookings' => array_values($myBookings),
    ]);
});

// ==========================================
// ADMIN ROUTES
// ==========================================

$app->get('/admin', function (Request $request, Response $response) {
    $user = getLoggedInUser();
    if (!$user || $user['role'] !== 'admin') {
        return $response->withHeader('Location', '/login')->withStatus(302);
    }

    $renderer = $this->get(PhpRenderer::class);
    $users = loadJson('users.json');
    $bookings = loadJson('bookings.json');
    $workers = loadJson('workers.json');

    // Remove passwords from users
    $safeUsers = array_map(function ($u) {
        unset($u['password']);
        return $u;
    }, $users);

    // Stats
    $stats = [
        'total_users' => count($users),
        'total_bookings' => count($bookings),
        'pending_bookings' => count(array_filter($bookings, fn($b) => $b['status'] === 'pending')),
        'total_workers' => count($workers),
        'revenue' => array_sum(array_column($bookings, 'total')),
        'completed_bookings' => count(array_filter($bookings, fn($b) => $b['status'] === 'completed')),
    ];

    return $renderer->render($response, 'admin/dashboard.php', [
        'pageTitle' => 'Admin Dashboard — JasaKami',
        'currentPage' => 'admin-dashboard',
        'user' => $user,
        'users' => $safeUsers,
        'bookings' => $bookings,
        'workers' => $workers,
        'stats' => $stats,
        'adminPage' => 'dashboard',
    ]);
});

$app->get('/admin/users', function (Request $request, Response $response) {
    $user = getLoggedInUser();
    if (!$user || $user['role'] !== 'admin') {
        return $response->withHeader('Location', '/login')->withStatus(302);
    }

    $renderer = $this->get(PhpRenderer::class);
    $users = loadJson('users.json');
    $safeUsers = array_map(function ($u) {
        unset($u['password']);
        return $u;
    }, $users);

    return $renderer->render($response, 'admin/users.php', [
        'pageTitle' => 'Kelola Users — JasaKami Admin',
        'currentPage' => 'admin-users',
        'user' => $user,
        'users' => $safeUsers,
        'adminPage' => 'users',
    ]);
});

$app->get('/admin/bookings', function (Request $request, Response $response) {
    $user = getLoggedInUser();
    if (!$user || $user['role'] !== 'admin') {
        return $response->withHeader('Location', '/login')->withStatus(302);
    }

    $renderer = $this->get(PhpRenderer::class);
    $bookings = loadJson('bookings.json');

    return $renderer->render($response, 'admin/bookings.php', [
        'pageTitle' => 'Kelola Bookings — JasaKami Admin',
        'currentPage' => 'admin-bookings',
        'user' => $user,
        'bookings' => $bookings,
        'adminPage' => 'bookings',
    ]);
});

// ==========================================
// ADMIN API ROUTES
// ==========================================

// Update user role
$app->post('/api/admin/users/role', function (Request $request, Response $response) {
    $currentUser = getLoggedInUser();
    if (!$currentUser || $currentUser['role'] !== 'admin') {
        return jsonResponse($response, ['success' => false, 'message' => 'Unauthorized'], 403);
    }

    $body = $request->getParsedBody();
    $userId = (int)($body['user_id'] ?? 0);
    $newRole = $body['role'] ?? '';

    if (!in_array($newRole, ['admin', 'user'])) {
        return jsonResponse($response, ['success' => false, 'message' => 'Role tidak valid.'], 400);
    }

    $users = loadJson('users.json');
    $found = false;
    foreach ($users as &$u) {
        if ($u['id'] === $userId) {
            $u['role'] = $newRole;
            $found = true;
            break;
        }
    }
    unset($u);

    if (!$found) {
        return jsonResponse($response, ['success' => false, 'message' => 'User tidak ditemukan.'], 404);
    }

    saveJson('users.json', $users);
    return jsonResponse($response, ['success' => true, 'message' => 'Role berhasil diupdate.']);
});

// Delete user
$app->post('/api/admin/users/delete', function (Request $request, Response $response) {
    $currentUser = getLoggedInUser();
    if (!$currentUser || $currentUser['role'] !== 'admin') {
        return jsonResponse($response, ['success' => false, 'message' => 'Unauthorized'], 403);
    }

    $body = $request->getParsedBody();
    $userId = (int)($body['user_id'] ?? 0);

    if ($userId === $currentUser['id']) {
        return jsonResponse($response, ['success' => false, 'message' => 'Tidak bisa menghapus akun sendiri.'], 400);
    }

    $users = loadJson('users.json');
    $users = array_filter($users, fn($u) => $u['id'] !== $userId);
    $users = array_values($users);
    saveJson('users.json', $users);

    return jsonResponse($response, ['success' => true, 'message' => 'User berhasil dihapus.']);
});

// Update booking status
$app->post('/api/admin/bookings/status', function (Request $request, Response $response) {
    $currentUser = getLoggedInUser();
    if (!$currentUser || $currentUser['role'] !== 'admin') {
        return jsonResponse($response, ['success' => false, 'message' => 'Unauthorized'], 403);
    }

    $body = $request->getParsedBody();
    $bookingId = (int)($body['booking_id'] ?? 0);
    $newStatus = $body['status'] ?? '';

    if (!in_array($newStatus, ['pending', 'confirmed', 'completed', 'cancelled'])) {
        return jsonResponse($response, ['success' => false, 'message' => 'Status tidak valid.'], 400);
    }

    $bookings = loadJson('bookings.json');
    $found = false;
    foreach ($bookings as &$b) {
        if ($b['id'] === $bookingId) {
            $b['status'] = $newStatus;
            $found = true;
            break;
        }
    }
    unset($b);

    if (!$found) {
        return jsonResponse($response, ['success' => false, 'message' => 'Booking tidak ditemukan.'], 404);
    }

    saveJson('bookings.json', $bookings);
    return jsonResponse($response, ['success' => true, 'message' => 'Status booking berhasil diupdate.']);
});

// ==========================================
// PUBLIC API ROUTES
// ==========================================

// Get all workers (with optional filters)
$app->get('/api/workers', function (Request $request, Response $response) {
    $workers = loadJson('workers.json');
    $params = $request->getQueryParams();

    if (!empty($params['gender'])) {
        $workers = array_filter($workers, fn($w) => $w['gender'] === $params['gender']);
    }

    if (!empty($params['department'])) {
        $workers = array_filter($workers, fn($w) => $w['department'] === $params['department']);
    }

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

// Get current user info
$app->get('/api/me', function (Request $request, Response $response) {
    $user = getLoggedInUser();
    if (!$user) {
        return jsonResponse($response, ['success' => false, 'message' => 'Not authenticated'], 401);
    }
    return jsonResponse($response, ['success' => true, 'user' => $user]);
});
