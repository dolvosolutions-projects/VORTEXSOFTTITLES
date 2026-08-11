<?php
/**
 * VortexSoft Title Services — Admin Auth Guard
 * Include this at the top of every admin page
 */

if (!defined('ROOT_PATH')) {
    require_once dirname(dirname(__DIR__)) . '/config/app.php';
    require_once dirname(dirname(__DIR__)) . '/config/database.php';
    require_once dirname(dirname(__DIR__)) . '/includes/functions.php';
}

if (!isAdminLoggedIn()) {
    setFlash('error', 'Please login to access the admin panel.');
    redirect('/admin/login.php');
}

// Refresh last_login periodically
if (empty($_SESSION['last_activity_refresh']) || (time() - $_SESSION['last_activity_refresh']) > 300) {
    try {
        $db = getDB();
        $db->prepare('UPDATE vts_admins SET last_login = NOW() WHERE id = ?')->execute([$_SESSION['admin_id']]);
    } catch (Exception $e) {}
    $_SESSION['last_activity_refresh'] = time();
}
