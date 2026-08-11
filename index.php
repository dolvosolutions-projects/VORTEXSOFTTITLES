<?php
/**
 * VortexSoft Title Services LLC
 * Front Controller / Router — index.php
 */

require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/mail.php';
require_once __DIR__ . '/includes/functions.php';

// Parse the request URI (strip query string)
$uri = strtok($_SERVER['REQUEST_URI'], '?');
$uri = rtrim($uri, '/');
if ($uri === '') $uri = '/';

// Route map
$routes = [
    '/'            => 'pages/home.php',
    '/services'    => 'pages/services.php',
    '/about'       => 'pages/about.php',
    '/contact'     => 'pages/contact.php',
    '/faq'         => 'pages/faq.php',
    '/terms'       => 'pages/terms.php',
    '/privacy'     => 'pages/privacy.php',
    '/newsletter'  => 'pages/newsletter.php',
];

// Handle AJAX contact form POST
if ($uri === '/contact' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/pages/contact.php';
    exit;
}

// Handle AJAX newsletter subscribe POST
if ($uri === '/newsletter' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/pages/newsletter.php';
    exit;
}

// Dispatch route
if (array_key_exists($uri, $routes)) {
    $pageFile = __DIR__ . '/' . $routes[$uri];
    if (file_exists($pageFile)) {
        require_once $pageFile;
    } else {
        http_response_code(500);
        echo '<h1>Page file not found</h1>';
    }
} else {
    // 404
    http_response_code(404);
    $pageTitle = '404 — Page Not Found | VortexSoft Title Services';
    require_once __DIR__ . '/includes/header.php';
    echo '<main style="min-height:60vh;display:flex;align-items:center;justify-content:center;text-align:center;padding:4rem 1rem;">';
    echo '<div><h1 style="font-size:5rem;font-weight:900;color:#38317F;margin:0;">404</h1>';
    echo '<h2 style="font-size:1.5rem;color:#2E2E2E;margin:1rem 0;">Page Not Found</h2>';
    echo '<p style="color:#64748B;margin-bottom:2rem;">The page you are looking for doesn\'t exist or has been moved.</p>';
    echo '<a href="/" style="background:#E31E25;color:#fff;padding:.875rem 2rem;border-radius:9999px;text-decoration:none;font-weight:600;">← Back to Home</a></div></main>';
    require_once __DIR__ . '/includes/footer.php';
}
