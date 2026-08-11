<?php
/**
 * Admin — Admin Users Management (Superadmin only)
 */
require_once dirname(__DIR__) . '/config/app.php';
require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once __DIR__ . '/includes/auth.php';

// Only superadmin can access
if (!isSuperAdmin()) {
    setFlash('error', 'Access denied. Superadmin role required.');
    redirect('/admin/');
}

$db = getDB();

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && verifyCsrfToken()) {
    $action = $_POST['action'] ?? '';

    if ($action === 'create') {
        $name  = sanitize($_POST['name'] ?? '');
        $email = sanitize($_POST['email'] ?? '');
        $role  = in_array($_POST['role'] ?? '', ['superadmin','admin']) ? $_POST['role'] : 'admin';
        $pass  = $_POST['password'] ?? '';

        if (strlen($name) < 2 || !isValidEmail($email) || strlen($pass) < 8) {
            setFlash('error', 'Invalid input. Name must be ≥2 chars, valid email, password ≥8 chars.');
        } else {
            try {
                $hash = password_hash($pass, PASSWORD_BCRYPT, ['cost' => 12]);
                $db->prepare('INSERT INTO vts_admins (name, email, password, role) VALUES (?,?,?,?)')->execute([$name, $email, $hash, $role]);
                setFlash('success', "Admin account created for $email.");
            } catch (PDOException $e) {
                setFlash('error', 'Email already exists or DB error.');
            }
        }
    } elseif ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id === (int)$_SESSION['admin_id']) {
            setFlash('error', 'You cannot delete your own account.');
        } else {
            $db->prepare('DELETE FROM vts_admins WHERE id = ?')->execute([$id]);
            setFlash('success', 'Admin account deleted.');
        }
    } elseif ($action === 'reset_password') {
        $id   = (int)($_POST['id'] ?? 0);
        $pass = $_POST['new_password'] ?? '';
        if (strlen($pass) < 8) {
            setFlash('error', 'New password must be at least 8 characters.');
        } else {
            $hash = password_hash($pass, PASSWORD_BCRYPT, ['cost' => 12]);
            $db->prepare('UPDATE vts_admins SET password = ? WHERE id = ?')->execute([$hash, $id]);
            setFlash('success', 'Password reset successfully.');
        }
    }
    redirect('/admin/users.php');
}

$admins = $db->query('SELECT id, name, email, role, last_login, created_at FROM vts_admins ORDER BY id ASC')->fetchAll();

$adminTitle = 'Admin Users';
$adminPage  = 'users';
require_once __DIR__ . '/includes/admin_header.php';
?>

<div class="adm-flex-between adm-mb-6">
  <div>
    <h1 style="font-size:1.25rem;font-weight:800;">Admin Users</h1>
    <p class="adm-text-muted">Manage admin accounts and roles</p>
  </div>
</div>

<!-- Create Admin Form -->
<div class="adm-card adm-mb-6">
  <div class="adm-card-header">
    <h2 class="adm-card-title">➕ Create New Admin Account</h2>
  </div>
  <div class="adm-card-body">
    <form method="POST">
      <?= csrfInput() ?>
      <input type="hidden" name="action" value="create">
      <div class="adm-form-grid" style="margin-bottom:1rem;">
        <div class="adm-form-group" style="margin:0;">
          <label class="adm-label">Full Name</label>
          <input type="text" name="name" class="adm-input" placeholder="Full Name" required>
        </div>
        <div class="adm-form-group" style="margin:0;">
          <label class="adm-label">Email Address</label>
          <input type="email" name="email" class="adm-input" placeholder="admin@vortexsofttitles.com" required>
        </div>
        <div class="adm-form-group" style="margin:0;">
          <label class="adm-label">Password (min. 8 chars)</label>
          <input type="password" name="password" class="adm-input" placeholder="Secure password" required minlength="8">
        </div>
        <div class="adm-form-group" style="margin:0;">
          <label class="adm-label">Role</label>
          <select name="role" class="adm-select">
            <option value="admin">Admin</option>
            <option value="superadmin">Super Admin</option>
          </select>
        </div>
      </div>
      <button type="submit" class="adm-btn primary">Create Admin Account</button>
    </form>
  </div>
</div>

<!-- Admins Table -->
<div class="adm-card">
  <div class="adm-card-header">
    <h2 class="adm-card-title">All Admin Accounts (<?= count($admins) ?>)</h2>
  </div>
  <div class="adm-table-wrap">
    <table class="adm-table">
      <thead>
        <tr><th>#</th><th>Name</th><th>Email</th><th>Role</th><th>Last Login</th><th>Created</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php foreach ($admins as $a): ?>
        <tr>
          <td class="adm-text-muted"><?= $a['id'] ?></td>
          <td style="font-weight:600;"><?= htmlspecialchars($a['name']) ?> <?= $a['id'] === (int)$_SESSION['admin_id'] ? '<span class="adm-badge active" style="font-size:0.65rem;">You</span>' : '' ?></td>
          <td><a href="mailto:<?= htmlspecialchars($a['email']) ?>" style="color:#93c5fd;font-size:0.875rem;"><?= htmlspecialchars($a['email']) ?></a></td>
          <td><span class="adm-badge <?= $a['role'] ?>"><?= ucfirst($a['role']) ?></span></td>
          <td class="adm-text-muted"><?= $a['last_login'] ? fmtDate($a['last_login']) : 'Never' ?></td>
          <td class="adm-text-muted"><?= date('M j, Y', strtotime($a['created_at'])) ?></td>
          <td>
            <?php if ($a['id'] !== (int)$_SESSION['admin_id']): ?>
            <div class="adm-flex">
              <form method="POST" onsubmit="return (pass=prompt('New password (min 8 chars):')) && this.elements['new_password'].value=pass || false;" style="display:inline;">
                <?= csrfInput() ?>
                <input type="hidden" name="action" value="reset_password">
                <input type="hidden" name="id" value="<?= $a['id'] ?>">
                <input type="hidden" name="new_password" value="">
                <button type="submit" class="adm-btn neutral adm-btn-sm">🔑 Reset Pass</button>
              </form>
              <form method="POST" onsubmit="return confirm('Delete admin account for <?= addslashes($a['name']) ?>?');" style="display:inline;">
                <?= csrfInput() ?>
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= $a['id'] ?>">
                <button type="submit" class="adm-btn danger adm-btn-sm">🗑 Delete</button>
              </form>
            </div>
            <?php else: ?>
            <span class="adm-text-muted">Current user</span>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
