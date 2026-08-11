<?php
/**
 * Admin Dashboard — index.php
 */
require_once dirname(__DIR__) . '/config/app.php';
require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once __DIR__ . '/includes/auth.php';

$adminTitle = 'Dashboard';
$adminPage  = 'dashboard';

// Fetch stats
$stats = ['contacts' => 0, 'unread' => 0, 'newsletter' => 0, 'admins' => 0];
$recentContacts = [];
try {
    $db = getDB();
    $stats['contacts']   = $db->query('SELECT COUNT(*) FROM vts_contacts')->fetchColumn();
    $stats['unread']     = $db->query('SELECT COUNT(*) FROM vts_contacts WHERE is_read = 0')->fetchColumn();
    $stats['newsletter'] = $db->query('SELECT COUNT(*) FROM vts_newsletter WHERE is_active = 1')->fetchColumn();
    $stats['admins']     = $db->query('SELECT COUNT(*) FROM vts_admins')->fetchColumn();
    $recentContacts      = $db->query('SELECT * FROM vts_contacts ORDER BY created_at DESC LIMIT 8')->fetchAll();
} catch (Exception $e) {}

require_once __DIR__ . '/includes/admin_header.php';
?>

<!-- KPI Cards -->
<div class="adm-kpi-grid">
  <div class="adm-kpi navy">
    <div class="adm-kpi-icon">💬</div>
    <div class="adm-kpi-value"><?= number_format($stats['contacts']) ?></div>
    <div class="adm-kpi-label">Total Contact Submissions</div>
  </div>
  <div class="adm-kpi red">
    <div class="adm-kpi-icon">🔴</div>
    <div class="adm-kpi-value"><?= number_format($stats['unread']) ?></div>
    <div class="adm-kpi-label">Unread Messages</div>
  </div>
  <div class="adm-kpi green">
    <div class="adm-kpi-icon">📧</div>
    <div class="adm-kpi-value"><?= number_format($stats['newsletter']) ?></div>
    <div class="adm-kpi-label">Active Subscribers</div>
  </div>
  <div class="adm-kpi yellow">
    <div class="adm-kpi-icon">👤</div>
    <div class="adm-kpi-value"><?= number_format($stats['admins']) ?></div>
    <div class="adm-kpi-label">Admin Users</div>
  </div>
</div>

<!-- Recent Contacts -->
<div class="adm-card">
  <div class="adm-card-header">
    <h2 class="adm-card-title">Recent Contact Submissions</h2>
    <a href="/admin/contacts.php" class="adm-btn primary adm-btn-sm">View All</a>
  </div>
  <div class="adm-table-wrap">
    <table class="adm-table">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Subject</th>
          <th>Status</th>
          <th>Received</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($recentContacts)): ?>
        <tr><td colspan="8" style="text-align:center;color:var(--adm-muted);padding:2rem;">No contact submissions yet.</td></tr>
        <?php else: ?>
        <?php foreach ($recentContacts as $c): ?>
        <tr>
          <td class="adm-text-muted">#<?= $c['id'] ?></td>
          <td style="font-weight:600;"><?= htmlspecialchars($c['name']) ?></td>
          <td><a href="mailto:<?= htmlspecialchars($c['email']) ?>" style="color:#93c5fd;"><?= htmlspecialchars($c['email']) ?></a></td>
          <td class="adm-text-muted"><?= htmlspecialchars($c['phone'] ?: '—') ?></td>
          <td class="adm-truncate"><?= htmlspecialchars($c['subject'] ?: '—') ?></td>
          <td>
            <?php if (!$c['is_read']): ?>
            <span class="adm-badge unread">⚫ Unread</span>
            <?php else: ?>
            <span class="adm-badge read">✅ Read</span>
            <?php endif; ?>
          </td>
          <td class="adm-text-muted" style="white-space:nowrap;"><?= fmtDate($c['created_at']) ?></td>
          <td>
            <a href="/admin/contacts.php?view=<?= $c['id'] ?>" class="adm-btn neutral adm-btn-sm">View</a>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Quick Links -->
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem;">
  <a href="/admin/contacts.php" style="text-decoration:none;">
    <div class="adm-card" style="padding:1.5rem;cursor:pointer;transition:transform 0.2s;hover-lift;">
      <div style="font-size:2rem;margin-bottom:0.75rem;">💬</div>
      <h3 style="font-weight:700;color:var(--adm-text);margin-bottom:0.25rem;">Manage Contacts</h3>
      <p style="font-size:0.8rem;color:var(--adm-muted);">View, read, and delete contact messages</p>
    </div>
  </a>
  <a href="/admin/newsletter.php" style="text-decoration:none;">
    <div class="adm-card" style="padding:1.5rem;">
      <div style="font-size:2rem;margin-bottom:0.75rem;">📧</div>
      <h3 style="font-weight:700;color:var(--adm-text);margin-bottom:0.25rem;">Newsletter</h3>
      <p style="font-size:0.8rem;color:var(--adm-muted);">Manage subscriber list, export CSV</p>
    </div>
  </a>
  <?php if (isSuperAdmin()): ?>
  <a href="/admin/users.php" style="text-decoration:none;">
    <div class="adm-card" style="padding:1.5rem;">
      <div style="font-size:2rem;margin-bottom:0.75rem;">👥</div>
      <h3 style="font-weight:700;color:var(--adm-text);margin-bottom:0.25rem;">Admin Users</h3>
      <p style="font-size:0.8rem;color:var(--adm-muted);">Add, edit, and manage admin accounts</p>
    </div>
  </a>
  <a href="/admin/settings.php" style="text-decoration:none;">
    <div class="adm-card" style="padding:1.5rem;">
      <div style="font-size:2rem;margin-bottom:0.75rem;">⚙️</div>
      <h3 style="font-weight:700;color:var(--adm-text);margin-bottom:0.25rem;">Site Settings</h3>
      <p style="font-size:0.8rem;color:var(--adm-muted);">Edit site info, contact details, SMTP</p>
    </div>
  </a>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
