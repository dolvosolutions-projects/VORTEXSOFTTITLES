<?php
/**
 * VortexSoft Title Services — Admin Login Page
 * URL: /admin/login.php
 */

require_once dirname(__DIR__) . '/config/app.php';
require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/includes/functions.php';

// Already logged in → redirect to dashboard
if (isAdminLoggedIn()) {
    redirect('/admin/');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF check
    if (!verifyCsrfToken()) {
        $error = 'Invalid request. Please try again.';
    } else {
        $email    = sanitize($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // Rate limiting: max 5 attempts per IP per 15 minutes
        $ipKey    = 'login_attempts_' . md5(getClientIP());
        $attempts = $_SESSION[$ipKey]['count'] ?? 0;
        $lastAttempt = $_SESSION[$ipKey]['time'] ?? 0;

        if ($attempts >= 5 && (time() - $lastAttempt) < 900) {
            $error = 'Too many login attempts. Please wait 15 minutes.';
        } else {
            if (!isValidEmail($email) || empty($password)) {
                $error = 'Please enter a valid email and password.';
            } else {
                try {
                    $db   = getDB();
                    $stmt = $db->prepare('SELECT * FROM vts_admins WHERE email = ? LIMIT 1');
                    $stmt->execute([$email]);
                    $admin = $stmt->fetch();

                    if ($admin && password_verify($password, $admin['password'])) {
                        // Success — reset rate limit
                        unset($_SESSION[$ipKey]);

                        // Regenerate session ID
                        session_regenerate_id(true);

                        // Set session
                        $_SESSION['admin_id']   = $admin['id'];
                        $_SESSION['admin_name'] = $admin['name'];
                        $_SESSION['admin_email']= $admin['email'];
                        $_SESSION['admin_role'] = $admin['role'];

                        // Update last login
                        $db->prepare('UPDATE vts_admins SET last_login = NOW() WHERE id = ?')->execute([$admin['id']]);

                        redirect('/admin/');
                    } else {
                        // Track failed attempts
                        $_SESSION[$ipKey] = ['count' => $attempts + 1, 'time' => time()];
                        $error = 'Invalid email or password. Please try again.';
                    }
                } catch (Exception $e) {
                    error_log('Login error: ' . $e->getMessage());
                    $error = 'A server error occurred. Please try again.';
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow">
  <title>Admin Login — VortexSoft Title Services</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body class="admin-body" style="display:block;">

<div class="adm-login-wrap">
  <div class="adm-login-card">
    <div class="adm-login-logo">
      <img src="/assets/images/vts-20logo-20croped-20.jpg" alt="VortexSoft Title Services">
      <h1>Admin Panel</h1>
      <p>Sign in to manage VortexSoft Title Services</p>
    </div>

    <?php if ($error): ?>
    <div class="flash-msg" style="background:rgba(239,68,68,0.15);color:#f87171;border:1px solid rgba(239,68,68,0.25);">
      ⚠ <?= htmlspecialchars($error) ?>
    </div>
    <?php endif; ?>

    <form method="POST" action="/admin/login.php" novalidate>
      <?= csrfInput() ?>

      <div class="adm-form-group">
        <label class="adm-label" for="login-email">Email Address</label>
        <input
          type="email"
          id="login-email"
          name="email"
          class="adm-input"
          placeholder="admin@vortexsofttitles.com"
          value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
          required
          autocomplete="email"
        >
      </div>

      <div class="adm-form-group">
        <label class="adm-label" for="login-password">Password</label>
        <div style="position:relative;">
          <input
            type="password"
            id="login-password"
            name="password"
            class="adm-input"
            placeholder="••••••••"
            required
            autocomplete="current-password"
          >
          <button
            type="button"
            onclick="togglePwd()"
            style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--adm-muted);cursor:pointer;font-size:0.8rem;"
          >Show</button>
        </div>
      </div>

      <button type="submit" class="adm-login-btn">
        Sign In to Admin Panel
      </button>
    </form>

    <p style="text-align:center;margin-top:1.5rem;font-size:0.75rem;color:var(--adm-muted);">
      <a href="/" style="color:var(--adm-muted);">← Back to Website</a>
    </p>
  </div>
</div>

<script>
function togglePwd() {
  const f = document.getElementById('login-password');
  const btn = f.nextElementSibling;
  if (f.type === 'password') { f.type = 'text'; btn.textContent = 'Hide'; }
  else { f.type = 'password'; btn.textContent = 'Show'; }
}
</script>
</body>
</html>
