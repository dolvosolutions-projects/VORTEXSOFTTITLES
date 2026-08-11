<?php
/**
 * Admin — Contact Submissions Management
 */
require_once dirname(__DIR__) . '/config/app.php';
require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once __DIR__ . '/includes/auth.php';

$db = getDB();

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && verifyCsrfToken()) {
    $action = $_POST['action'] ?? '';
    $id     = (int)($_POST['id'] ?? 0);

    if ($action === 'mark_read' && $id > 0) {
        $db->prepare('UPDATE vts_contacts SET is_read = 1 WHERE id = ?')->execute([$id]);
        setFlash('success', 'Marked as read.');
    } elseif ($action === 'mark_unread' && $id > 0) {
        $db->prepare('UPDATE vts_contacts SET is_read = 0 WHERE id = ?')->execute([$id]);
        setFlash('success', 'Marked as unread.');
    } elseif ($action === 'delete' && $id > 0) {
        $db->prepare('DELETE FROM vts_contacts WHERE id = ?')->execute([$id]);
        setFlash('success', 'Contact submission deleted.');
    } elseif ($action === 'delete_all') {
        $db->exec('DELETE FROM vts_contacts');
        setFlash('success', 'All submissions deleted.');
    }
    redirect('/admin/contacts.php');
}

// Export CSV
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    $rows = $db->query('SELECT id, name, email, phone, subject, message, ip_address, is_read, created_at FROM vts_contacts ORDER BY created_at DESC')->fetchAll();
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="vortexsoft_contacts_' . date('Y-m-d') . '.csv"');
    $f = fopen('php://output', 'w');
    fputcsv($f, ['ID','Name','Email','Phone','Subject','Message','IP','Read','Date']);
    foreach ($rows as $r) {
        fputcsv($f, [$r['id'],$r['name'],$r['email'],$r['phone'],$r['subject'],$r['message'],$r['ip_address'],$r['is_read'] ? 'Yes' : 'No',$r['created_at']]);
    }
    fclose($f);
    exit;
}

// View single contact
$viewContact = null;
if (isset($_GET['view']) && ($vid = (int)$_GET['view'])) {
    $stmt = $db->prepare('SELECT * FROM vts_contacts WHERE id = ?');
    $stmt->execute([$vid]);
    $viewContact = $stmt->fetch();
    if ($viewContact && !$viewContact['is_read']) {
        $db->prepare('UPDATE vts_contacts SET is_read = 1 WHERE id = ?')->execute([$vid]);
    }
}

// Pagination
$page   = max(1, (int)($_GET['page'] ?? 1));
$search = sanitize($_GET['q'] ?? '');
$filter = sanitize($_GET['filter'] ?? '');

$where = '1=1';
$params = [];
if ($search) {
    $where  .= ' AND (name LIKE ? OR email LIKE ? OR subject LIKE ?)';
    $params  = array_merge($params, ["%$search%", "%$search%", "%$search%"]);
}
if ($filter === 'unread') { $where .= ' AND is_read = 0'; }
if ($filter === 'read')   { $where .= ' AND is_read = 1'; }

$total = $db->prepare("SELECT COUNT(*) FROM vts_contacts WHERE $where");
$total->execute($params);
$pag   = paginate((int)$total->fetchColumn(), ADMIN_PER_PAGE, $page);

$stmt  = $db->prepare("SELECT * FROM vts_contacts WHERE $where ORDER BY created_at DESC LIMIT ? OFFSET ?");
$stmt->execute(array_merge($params, [ADMIN_PER_PAGE, $pag['offset']]));
$contacts = $stmt->fetchAll();

$adminTitle = 'Contact Submissions';
$adminPage  = 'contacts';
require_once __DIR__ . '/includes/admin_header.php';
?>

<!-- Header row -->
<div class="adm-flex-between adm-mb-6" style="flex-wrap:wrap;gap:1rem;">
  <div>
    <h1 style="font-size:1.25rem;font-weight:800;">Contact Submissions</h1>
    <p class="adm-text-muted"><?= number_format($pag['total']) ?> total submissions</p>
  </div>
  <div class="adm-flex" style="gap:0.75rem;flex-wrap:wrap;">
    <a href="?export=csv" class="adm-btn neutral">⬇ Export CSV</a>
    <form method="POST" onsubmit="return confirm('Delete ALL submissions?');" style="display:inline;">
      <?= csrfInput() ?>
      <input type="hidden" name="action" value="delete_all">
      <button type="submit" class="adm-btn danger">🗑 Delete All</button>
    </form>
  </div>
</div>

<!-- Search & Filter -->
<div class="adm-card adm-mb-4">
  <div class="adm-card-body" style="padding:1rem;">
    <form method="GET" style="display:flex;gap:0.75rem;flex-wrap:wrap;align-items:center;">
      <input type="text" name="q" value="<?= htmlspecialchars($search) ?>" placeholder="Search by name, email, subject..." class="adm-input" style="max-width:320px;">
      <select name="filter" class="adm-select" style="max-width:160px;">
        <option value="">All</option>
        <option value="unread" <?= $filter==='unread' ? 'selected' : '' ?>>Unread Only</option>
        <option value="read" <?= $filter==='read' ? 'selected' : '' ?>>Read Only</option>
      </select>
      <button type="submit" class="adm-btn primary">Search</button>
      <?php if ($search || $filter): ?><a href="/admin/contacts.php" class="adm-btn neutral">Clear</a><?php endif; ?>
    </form>
  </div>
</div>

<?php if ($viewContact): ?>
<!-- Single Contact View -->
<div class="adm-card adm-mb-4" style="border-top:3px solid var(--adm-navy);">
  <div class="adm-card-header">
    <h2 class="adm-card-title">📨 Message from <?= htmlspecialchars($viewContact['name']) ?></h2>
    <a href="/admin/contacts.php" class="adm-btn neutral adm-btn-sm">← Back</a>
  </div>
  <div class="adm-card-body">
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem;margin-bottom:1.5rem;">
      <div><div class="adm-label">Name</div><div style="color:var(--adm-text);font-weight:600;"><?= htmlspecialchars($viewContact['name']) ?></div></div>
      <div><div class="adm-label">Email</div><div><a href="mailto:<?= htmlspecialchars($viewContact['email']) ?>" style="color:#93c5fd;"><?= htmlspecialchars($viewContact['email']) ?></a></div></div>
      <div><div class="adm-label">Phone</div><div style="color:var(--adm-text);"><?= htmlspecialchars($viewContact['phone'] ?: 'N/A') ?></div></div>
      <div><div class="adm-label">Subject</div><div style="color:var(--adm-text);"><?= htmlspecialchars($viewContact['subject'] ?: 'N/A') ?></div></div>
      <div><div class="adm-label">IP Address</div><div class="adm-text-muted"><?= htmlspecialchars($viewContact['ip_address']) ?></div></div>
      <div><div class="adm-label">Received</div><div class="adm-text-muted"><?= fmtDate($viewContact['created_at']) ?></div></div>
    </div>
    <div class="adm-label">Message</div>
    <div style="background:var(--adm-surface2);border-radius:8px;padding:1.25rem;color:var(--adm-text);line-height:1.7;white-space:pre-wrap;margin-top:0.5rem;"><?= htmlspecialchars($viewContact['message']) ?></div>
    <div class="adm-flex adm-mt-4" style="gap:0.75rem;flex-wrap:wrap;">
      <a href="mailto:<?= htmlspecialchars($viewContact['email']) ?>" class="adm-btn primary">📧 Reply via Email</a>
      <form method="POST" style="display:inline;">
        <?= csrfInput() ?>
        <input type="hidden" name="id" value="<?= $viewContact['id'] ?>">
        <input type="hidden" name="action" value="<?= $viewContact['is_read'] ? 'mark_unread' : 'mark_read' ?>">
        <button type="submit" class="adm-btn neutral"><?= $viewContact['is_read'] ? 'Mark Unread' : 'Mark Read' ?></button>
      </form>
      <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this submission?');">
        <?= csrfInput() ?>
        <input type="hidden" name="id" value="<?= $viewContact['id'] ?>">
        <input type="hidden" name="action" value="delete">
        <button type="submit" class="adm-btn danger">🗑 Delete</button>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- Contacts Table -->
<div class="adm-card">
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
          <th>Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($contacts)): ?>
        <tr><td colspan="8" style="text-align:center;color:var(--adm-muted);padding:2.5rem;">No contact submissions found.</td></tr>
        <?php else: ?>
        <?php foreach ($contacts as $c): ?>
        <tr style="<?= !$c['is_read'] ? 'background:rgba(108,99,255,0.04);' : '' ?>">
          <td class="adm-text-muted">#<?= $c['id'] ?></td>
          <td style="font-weight:<?= !$c['is_read'] ? '700' : '500' ?>;"><?= htmlspecialchars($c['name']) ?></td>
          <td><a href="mailto:<?= htmlspecialchars($c['email']) ?>" style="color:#93c5fd;font-size:0.8rem;"><?= htmlspecialchars($c['email']) ?></a></td>
          <td class="adm-text-muted"><?= htmlspecialchars($c['phone'] ?: '—') ?></td>
          <td class="adm-truncate adm-text-muted"><?= htmlspecialchars($c['subject'] ?: '—') ?></td>
          <td>
            <?php if (!$c['is_read']): ?><span class="adm-badge unread">⚫ Unread</span>
            <?php else: ?><span class="adm-badge read">✅ Read</span><?php endif; ?>
          </td>
          <td class="adm-text-muted" style="white-space:nowrap;"><?= date('M j, Y', strtotime($c['created_at'])) ?></td>
          <td>
            <div class="adm-flex">
              <a href="?view=<?= $c['id'] ?>" class="adm-btn neutral adm-btn-sm">View</a>
              <form method="POST" style="display:inline;">
                <?= csrfInput() ?>
                <input type="hidden" name="id" value="<?= $c['id'] ?>">
                <input type="hidden" name="action" value="<?= $c['is_read'] ? 'mark_unread' : 'mark_read' ?>">
                <button type="submit" class="adm-btn success adm-btn-sm"><?= $c['is_read'] ? 'Unread' : 'Read' ?></button>
              </form>
              <form method="POST" style="display:inline;" onsubmit="return confirm('Delete?');">
                <?= csrfInput() ?>
                <input type="hidden" name="id" value="<?= $c['id'] ?>">
                <input type="hidden" name="action" value="delete">
                <button type="submit" class="adm-btn danger adm-btn-sm">🗑</button>
              </form>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <?php if ($pag['total_pages'] > 1): ?>
  <div class="adm-pagination">
    <?php for ($i = 1; $i <= $pag['total_pages']; $i++): ?>
    <a href="?page=<?= $i ?>&q=<?= urlencode($search) ?>&filter=<?= urlencode($filter) ?>"
       class="adm-page-btn <?= $i === $pag['current'] ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>
  </div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
