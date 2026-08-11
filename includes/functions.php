<?php
/**
 * VortexSoft Title Services LLC
 * Helper / Utility Functions
 */

/**
 * Sanitize input string
 */
function sanitize(string $input): string {
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

/**
 * Validate email address
 */
function isValidEmail(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Generate a CSRF token and store in session
 */
function generateCsrfToken(): string {
    if (empty($_SESSION[CSRF_TOKEN_NAME])) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }
    return $_SESSION[CSRF_TOKEN_NAME];
}

/**
 * Verify CSRF token from POST request
 */
function verifyCsrfToken(): bool {
    $token = $_POST[CSRF_TOKEN_NAME] ?? '';
    return isset($_SESSION[CSRF_TOKEN_NAME]) && hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
}

/**
 * Get CSRF hidden input HTML
 */
function csrfInput(): string {
    return '<input type="hidden" name="' . CSRF_TOKEN_NAME . '" value="' . generateCsrfToken() . '">';
}

/**
 * Get client IP address
 */
function getClientIP(): string {
    $keys = ['HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'];
    foreach ($keys as $key) {
        if (!empty($_SERVER[$key])) {
            return sanitize(explode(',', $_SERVER[$key])[0]);
        }
    }
    return '0.0.0.0';
}

/**
 * Flash message: set
 */
function setFlash(string $type, string $message): void {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

/**
 * Flash message: get and clear
 */
function getFlash(): ?array {
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}

/**
 * Render flash message HTML (admin)
 */
function renderFlash(): string {
    $flash = getFlash();
    if (!$flash) return '';
    $color = $flash['type'] === 'success' ? '#22c55e' : ($flash['type'] === 'error' ? '#ef4444' : '#f59e0b');
    return '<div class="flash-msg" style="background:' . $color . ';color:#fff;padding:12px 20px;border-radius:8px;margin-bottom:16px;">'
         . htmlspecialchars($flash['message']) . '</div>';
}

/**
 * Get site setting from DB (with cache)
 */
function getSetting(string $key, string $default = ''): string {
    static $settings = null;
    if ($settings === null) {
        try {
            $db = getDB();
            $stmt = $db->query('SELECT setting_key, setting_value FROM vts_settings');
            $settings = [];
            while ($row = $stmt->fetch()) {
                $settings[$row['setting_key']] = $row['setting_value'];
            }
        } catch (Exception $e) {
            $settings = [];
        }
    }
    return $settings[$key] ?? $default;
}

/**
 * Redirect to URL
 */
function redirect(string $url): void {
    header('Location: ' . $url);
    exit;
}

/**
 * Paginate query results
 */
function paginate(int $total, int $perPage, int $currentPage): array {
    $totalPages = (int) ceil($total / $perPage);
    $offset     = ($currentPage - 1) * $perPage;
    return [
        'total'       => $total,
        'per_page'    => $perPage,
        'current'     => $currentPage,
        'total_pages' => $totalPages,
        'offset'      => $offset,
    ];
}

/**
 * Format date/time
 */
function fmtDate(string $dt): string {
    return date('M j, Y g:i A', strtotime($dt));
}

/**
 * Check if user is logged into admin
 */
function isAdminLoggedIn(): bool {
    return isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id']);
}

/**
 * Check if logged-in admin is superadmin
 */
function isSuperAdmin(): bool {
    return isset($_SESSION['admin_role']) && $_SESSION['admin_role'] === 'superadmin';
}
