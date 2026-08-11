<?php
/**
 * VortexSoft Title Services LLC
 * Application Configuration
 */

// Error reporting (set to 0 on production)
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Site constants
define('SITE_NAME',     'VortexSoft Title Services LLC');
define('SITE_URL',      'https://www.vortexsofttitles.com');
define('SITE_EMAIL',    'Contact@vortexsofttitles.com');
define('SITE_PHONE',    '1-307-205-0681');
define('ADMIN_EMAIL',   'admin@vortexsofttitles.com');

// Directory constants
define('ROOT_PATH',     dirname(__DIR__));
define('INCLUDES_PATH', ROOT_PATH . '/includes');
define('PAGES_PATH',    ROOT_PATH . '/pages');
define('ADMIN_PATH',    ROOT_PATH . '/admin');
define('ASSETS_PATH',   ROOT_PATH . '/assets');
define('VENDOR_PATH',   ROOT_PATH . '/vendor');

// Session configuration
define('SESSION_NAME',      'vts_session');
define('SESSION_LIFETIME',  7200); // 2 hours

// Security
define('CSRF_TOKEN_NAME', 'vts_csrf_token');

// Pagination
define('ADMIN_PER_PAGE', 20);

// Timezone
date_default_timezone_set('America/New_York');

// Start session securely
if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_set_cookie_params([
        'lifetime' => SESSION_LIFETIME,
        'path'     => '/',
        'secure'   => true,
        'httponly' => true,
        'samesite' => 'Strict',
    ]);
    session_start();
}
