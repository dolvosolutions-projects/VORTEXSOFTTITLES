<?php
/**
 * Admin — Site Settings (Superadmin only)
 */
require_once dirname(__DIR__) . '/config/app.php';
require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once __DIR__ . '/includes/auth.php';

if (!isSuperAdmin()) {
    setFlash('error', 'Access denied. Superadmin required.');
    redirect('/admin/');
}

$db = getDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verifyCsrfToken()) {
    $allowed = ['site_title','site_tagline','site_email','site_phone','site_address_us','site_address_in','meta_description','smtp_host','smtp_port','smtp_user','smtp_pass','smtp_from_name','google_analytics'];
    $stmt = $db->prepare('INSERT INTO vts_settings (setting_key, setting_value) VALUES (?,?) ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value)');
    foreach ($allowed as $key) {
        if (isset($_POST[$key])) {
            $stmt->execute([$key, sanitize($_POST[$key])]);
        }
    }
    setFlash('success', 'Settings saved successfully.');
    redirect('/admin/settings.php');
}

// Load all settings
$settingsRaw = $db->query('SELECT setting_key, setting_value FROM vts_settings')->fetchAll();
$s = [];
foreach ($settingsRaw as $row) $s[$row['setting_key']] = $row['setting_value'];

$adminTitle = 'Site Settings';
$adminPage  = 'settings';
require_once __DIR__ . '/includes/admin_header.php';
?>

<h1 style="font-size:1.25rem;font-weight:800;margin-bottom:1.5rem;">⚙ Site Settings</h1>

<form method="POST">
  <?= csrfInput() ?>

  <!-- General Info -->
  <div class="adm-card adm-mb-6">
    <div class="adm-card-header"><h2 class="adm-card-title">🏢 General Information</h2></div>
    <div class="adm-card-body">
      <div class="adm-form-grid">
        <div class="adm-form-group">
          <label class="adm-label">Site Title</label>
          <input type="text" name="site_title" class="adm-input" value="<?= htmlspecialchars($s['site_title'] ?? '') ?>">
        </div>
        <div class="adm-form-group">
          <label class="adm-label">Site Tagline</label>
          <input type="text" name="site_tagline" class="adm-input" value="<?= htmlspecialchars($s['site_tagline'] ?? '') ?>">
        </div>
        <div class="adm-form-group">
          <label class="adm-label">Contact Email</label>
          <input type="email" name="site_email" class="adm-input" value="<?= htmlspecialchars($s['site_email'] ?? '') ?>">
        </div>
        <div class="adm-form-group">
          <label class="adm-label">Phone Number</label>
          <input type="text" name="site_phone" class="adm-input" value="<?= htmlspecialchars($s['site_phone'] ?? '') ?>">
        </div>
        <div class="adm-form-group" style="grid-column:1/-1;">
          <label class="adm-label">Meta Description</label>
          <textarea name="meta_description" class="adm-textarea"><?= htmlspecialchars($s['meta_description'] ?? '') ?></textarea>
        </div>
        <div class="adm-form-group">
          <label class="adm-label">US Office Address</label>
          <input type="text" name="site_address_us" class="adm-input" value="<?= htmlspecialchars($s['site_address_us'] ?? '') ?>">
        </div>
        <div class="adm-form-group">
          <label class="adm-label">India HQ Address</label>
          <input type="text" name="site_address_in" class="adm-input" value="<?= htmlspecialchars($s['site_address_in'] ?? '') ?>">
        </div>
        <div class="adm-form-group">
          <label class="adm-label">Google Analytics ID (GA4)</label>
          <input type="text" name="google_analytics" class="adm-input" placeholder="G-XXXXXXXXXX" value="<?= htmlspecialchars($s['google_analytics'] ?? '') ?>">
        </div>
      </div>
    </div>
  </div>

  <!-- SMTP -->
  <div class="adm-card adm-mb-6">
    <div class="adm-card-header"><h2 class="adm-card-title">📧 SMTP Email Configuration</h2></div>
    <div class="adm-card-body">
      <div class="adm-form-grid">
        <div class="adm-form-group">
          <label class="adm-label">SMTP Host</label>
          <input type="text" name="smtp_host" class="adm-input" placeholder="mail.vortexsofttitles.com" value="<?= htmlspecialchars($s['smtp_host'] ?? '') ?>">
        </div>
        <div class="adm-form-group">
          <label class="adm-label">SMTP Port (465=SSL, 587=TLS)</label>
          <input type="number" name="smtp_port" class="adm-input" value="<?= htmlspecialchars($s['smtp_port'] ?? '465') ?>">
        </div>
        <div class="adm-form-group">
          <label class="adm-label">SMTP Username (Email)</label>
          <input type="email" name="smtp_user" class="adm-input" value="<?= htmlspecialchars($s['smtp_user'] ?? '') ?>">
        </div>
        <div class="adm-form-group">
          <label class="adm-label">SMTP Password</label>
          <input type="password" name="smtp_pass" class="adm-input" placeholder="Leave blank to keep current" value="">
        </div>
        <div class="adm-form-group">
          <label class="adm-label">From Name</label>
          <input type="text" name="smtp_from_name" class="adm-input" value="<?= htmlspecialchars($s['smtp_from_name'] ?? 'VortexSoft Title Services') ?>">
        </div>
      </div>
    </div>
  </div>

  <button type="submit" class="adm-btn primary" style="padding:0.75rem 2rem;font-size:1rem;">💾 Save All Settings</button>
</form>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
