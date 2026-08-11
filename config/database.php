<?php
/**
 * VortexSoft Title Services LLC
 * Hostinger MySQL Database Configuration
 * 
 * ⚠️  FILL IN YOUR HOSTINGER CREDENTIALS BELOW BEFORE GOING LIVE
 * Find these in Hostinger hPanel → Hosting → Manage → Databases
 */

define('DB_HOST',   'localhost');           // Usually 'localhost' on Hostinger
define('DB_NAME',   'YOUR_DB_NAME');        // ← Replace with your Hostinger DB name
define('DB_USER',   'YOUR_DB_USERNAME');    // ← Replace with your Hostinger DB username
define('DB_PASS',   'YOUR_DB_PASSWORD');    // ← Replace with your Hostinger DB password
define('DB_CHARSET','utf8mb4');

/**
 * Get PDO database connection (singleton)
 */
function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            error_log('DB Connection failed: ' . $e->getMessage());
            die(json_encode(['success' => false, 'message' => 'Database connection error.']));
        }
    }
    return $pdo;
}
