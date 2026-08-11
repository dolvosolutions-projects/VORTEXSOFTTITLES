<?php
/**
 * VortexSoft Title Services — One-Time Installer
 * 
 * Run ONCE via browser or CLI to:
 *  1. Create all database tables
 *  2. Seed admin accounts with proper bcrypt hashes
 *  3. Seed default settings
 * 
 * DELETE THIS FILE after running!
 * URL: https://www.vortexsofttitles.com/install.php
 */

// Simple security token to prevent unauthorized runs
define('INSTALL_TOKEN', 'vts_install_2026');
if (($_GET['token'] ?? '') !== INSTALL_TOKEN) {
    http_response_code(403);
    die('<h2>403 Forbidden</h2><p>Add ?token=vts_install_2026 to the URL to run the installer.</p>');
}

require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/config/database.php';

$log = [];
$errors = [];

function logStep(string $msg, array &$log): void {
    $log[] = '✅ ' . $msg;
}
function logError(string $msg, array &$errors): void {
    $errors[] = '❌ ' . $msg;
}

try {
    $db = getDB();
    $log[] = '📡 Connected to database: ' . DB_NAME . ' @ ' . DB_HOST;

    // 1. Create tables
    $db->exec("CREATE TABLE IF NOT EXISTS `vts_admins` (
      `id`         INT(11) NOT NULL AUTO_INCREMENT,
      `name`       VARCHAR(100) NOT NULL,
      `email`      VARCHAR(150) NOT NULL,
      `password`   VARCHAR(255) NOT NULL,
      `role`       ENUM('superadmin','admin') NOT NULL DEFAULT 'admin',
      `last_login` DATETIME DEFAULT NULL,
      `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      UNIQUE KEY `email` (`email`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    logStep('Table vts_admins created/verified', $log);

    $db->exec("CREATE TABLE IF NOT EXISTS `vts_contacts` (
      `id`          INT(11) NOT NULL AUTO_INCREMENT,
      `name`        VARCHAR(100) NOT NULL,
      `email`       VARCHAR(150) NOT NULL,
      `phone`       VARCHAR(30) DEFAULT NULL,
      `subject`     VARCHAR(200) DEFAULT NULL,
      `message`     TEXT NOT NULL,
      `ip_address`  VARCHAR(45) DEFAULT NULL,
      `is_read`     TINYINT(1) NOT NULL DEFAULT 0,
      `created_at`  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    logStep('Table vts_contacts created/verified', $log);

    $db->exec("CREATE TABLE IF NOT EXISTS `vts_newsletter` (
      `id`            INT(11) NOT NULL AUTO_INCREMENT,
      `email`         VARCHAR(150) NOT NULL,
      `name`          VARCHAR(100) DEFAULT NULL,
      `is_active`     TINYINT(1) NOT NULL DEFAULT 1,
      `subscribed_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      UNIQUE KEY `email` (`email`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    logStep('Table vts_newsletter created/verified', $log);

    $db->exec("CREATE TABLE IF NOT EXISTS `vts_settings` (
      `id`            INT(11) NOT NULL AUTO_INCREMENT,
      `setting_key`   VARCHAR(100) NOT NULL,
      `setting_value` TEXT DEFAULT NULL,
      `updated_at`    TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      UNIQUE KEY `setting_key` (`setting_key`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    logStep('Table vts_settings created/verified', $log);

    // 2. Seed admin accounts
    $admins = [
        ['Super Admin', 'admin@vortexsofttitles.com', 'Mrunal@9996', 'superadmin'],
        ['Aniket',      'Aniket@vortexsofttitles.com', 'ShivaG@1437', 'admin'],
    ];
    foreach ($admins as [$name, $email, $pass, $role]) {
        $hash = password_hash($pass, PASSWORD_BCRYPT, ['cost' => 12]);
        $stmt = $db->prepare('INSERT INTO vts_admins (name, email, password, role) VALUES (?,?,?,?) ON DUPLICATE KEY UPDATE password=VALUES(password), role=VALUES(role)');
        $stmt->execute([$name, $email, $hash, $role]);
        logStep("Admin account seeded: $email ($role)", $log);
    }

    // 3. Seed default settings
    $settings = [
        ['site_title',       'VortexSoft Title Services LLC'],
        ['site_tagline',     'Precision. Speed. Trust.'],
        ['site_email',       'Contact@vortexsofttitles.com'],
        ['site_phone',       '1-307-205-0681'],
        ['site_address_us',  '30 N Gould St Ste 100, Sheridan, WY 82801'],
        ['site_address_in',  'No.125, Ranganath Complex, Madiwala, HSR Layout 5th Sector, Bengaluru 560068'],
        ['meta_description', 'VortexSoft Title Services delivers speed, accuracy, and scale for Title Companies and Lenders across all 50 states. 24/7 Global Operations.'],
        ['smtp_host',        'mail.vortexsofttitles.com'],
        ['smtp_port',        '465'],
        ['smtp_user',        'Contact@vortexsofttitles.com'],
        ['smtp_pass',        'CHANGE_ME'],
        ['smtp_from_name',   'VortexSoft Title Services'],
        ['google_analytics', ''],
    ];
    $stmt = $db->prepare('INSERT INTO vts_settings (setting_key, setting_value) VALUES (?,?) ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value)');
    foreach ($settings as [$k, $v]) {
        $stmt->execute([$k, $v]);
    }
    logStep('Default site settings seeded (' . count($settings) . ' entries)', $log);

    $log[] = '';
    $log[] = '🎉 Installation complete!';

} catch (Exception $e) {
    logError('Database error: ' . $e->getMessage(), $errors);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>VortexSoft Installer</title>
  <style>
    body { font-family: monospace; background: #0f1117; color: #e2e8f0; padding: 2rem; max-width: 700px; margin: 0 auto; }
    h1 { color: #6c63ff; }
    .success { color: #4ade80; }
    .error { color: #f87171; }
    .warning { background: rgba(245,158,11,0.15); border: 1px solid rgba(245,158,11,0.4); padding: 1rem; border-radius: 8px; color: #fcd34d; margin-top: 1.5rem; }
    pre { background: #1a1d27; padding: 1.5rem; border-radius: 8px; overflow-x: auto; line-height: 1.7; }
  </style>
</head>
<body>
<h1>⚙ VortexSoft Installer</h1>
<pre><?php
foreach ($log as $line) echo htmlspecialchars($line) . "\n";
foreach ($errors as $line) echo '<span class="error">' . htmlspecialchars($line) . "</span>\n";
?></pre>
<?php if (empty($errors)): ?>
<div class="warning">
  ⚠ <strong>IMPORTANT:</strong> Delete this <code>install.php</code> file immediately after installation for security!<br><br>
  You can now <a href="/admin/login.php" style="color:#93c5fd;">login to the admin panel</a>.
</div>
<?php endif; ?>
</body>
</html>
