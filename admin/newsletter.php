<?php
/**
 * VortexSoft Title Services — Admin Newsletter Subscribers
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
    if ($action === 'deactivate' && $id) {
        $db->prepare('UPDATE vts_newsletter SET is_active = 0 WHERE id = ?')->execute([$id]);
        setFlash('success', 'Subscriber deactivated.');
    } elseif ($action === 'activate' && $id) {
        $db->prepare('UPDATE vts_newsletter SET is_active = 1 WHERE id = ?')->execute([$id]);
        setFlash('success', 'Subscriber activated.');
    } elseif ($action === 'delete' && $id) {
        $db->prepare('DELETE FROM vts_newsletter WHERE id = ?')->execute([$id]);
        setFlash('success', 'Subscriber deleted.');
    }
    redirect('/admin/newsletter.php');
}

// Export CSV
if (isset($_GET['export'])) {
    $rows = $db->query('SELECT id, email, name, is_active, subscribed_at FROM vts_newsletter ORDER BY subscribed_at DESC')->fetchAll();
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="vortexsoft_newsletter_' . date('Y-m-d') . '.csv"');
    $f = fopen('php://output', 'w');
    fputcsv($f, ['ID', 'Email', 'Name', 'Active', 'Subscribed At']);
    foreach ($rows as $r) {
        fputcsv($f, [$r['id'], $r['email'], $r['name'], $r['is_active'] ? 'Yes' : 'No', $r['subscribed_at']]);
    }
    fclose($f); exit;
}

$page  = max(1, (int)($_GET['page'] ?? 1));
$total = (int)$db->query('SELECT COUNT(*) FROM vts_newsletter')->fetchColumn();
$pag   = paginate($total, ADMIN_PER_PAGE, $page);
$subs  = $db->prepare('SELECT * FROM vts_newsletter ORDER BY subscribed_at DESC LIMIT ? OFFSET ?');
$subs->execute([ADMIN_PER_PAGE, $pag['offset']]);
$subs  = $subs->fetchAll();

$activeCount = (int)$db->query('SELECT COUNT(*) FROM vts_newsletter WHERE is_active=1')->fetchColumn();

$adminTitle = 'Newsletter Subscribers';
$adminPage  = 'newsletter';
require_once __DIR__ . '/includes/admin_header.php';
?>

<div class="adm-flex-between adm-mb-6" style="flex-wrap:wrap;gap:1rem;">
  <div>
    <h1 style="font-size:1.25rem;font-weight:800;">Newsletter Subscribers</h1>
    <p class="adm-text-muted"><?= $activeCount ?> active / <?= $total ?> total</p>
  </div>
  <a href="?export=csv" class="adm-btn neutral">⬇ Export CSV</a>
</div>

<div class="adm-card">
  <div class="adm-table-wrap">
    <table class="adm-table">
      <thead>
        <tr><th>#</th><th>Email</th><th>Name</th><th>Status</th><th>Subscribed</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php if (empty($subs)): ?>
        <tr><td colspan="6" style="text-align:center;color:var(--adm-muted);padding:2rem;">No subscribers yet.</td></tr>
        <?php else: foreach ($subs as $s): ?>
        <tr>
          <td class="adm-text-muted">#<?= $s['id'] ?></td>
          <td><?= htmlspecialchars($s['email']) ?></td>
          <td><?= htmlspecialchars($s['name'] ?: '—') ?></td>
          <td><span class="adm-badge <?= $s['is_active'] ? 'active' : 'inactive' ?>"><?= $s['is_active'] ? 'Active' : 'Inactive' ?></span></td>
          <td class="adm-text-muted"><?= date('M j, Y', strtotime($s['subscribed_at'])) ?></td>
          <td>
            <div class="adm-flex">
              <form method="POST" style="display:inline;">
                <?= csrfInput() ?>
                <input type="hidden" name="id" value="<?= $s['id'] ?>">
                <input type="hidden" name="action" value="<?= $s['is_active'] ? 'deactivate' : 'activate' ?>">
                <button type="submit" class="adm-btn neutral adm-btn-sm"><?= $s['is_active'] ? 'Deactivate' : 'Activate' ?></button>
              </form>
              <form method="POST" style="display:inline;" onsubmit="return confirm('Delete subscriber?');">
                <?= csrfInput() ?>
                <input type="hidden" name="id" value="<?= $s['id'] ?>">
                <input type="hidden" name="action" value="delete">
                <button type="submit" class="adm-btn danger adm-btn-sm">🗑</button>
              </form>
            </div>
          </td>
        </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
  <?php if ($pag['total_pages'] > 1): ?>
  <div class="adm-pagination">
    <?php for ($i = 1; $i <= $pag['total_pages']; $i++): ?>
    <a href="?page=<?= $i ?>" class="adm-page-btn <?= $i === $pag['current'] ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>
  </div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
