<?php
/**
 * Newsletter Signup — GET renders form, POST handles AJAX subscribe
 */
if (!defined('ROOT_PATH')) {
    require_once dirname(__DIR__) . '/config/app.php';
    require_once dirname(__DIR__) . '/config/database.php';
    require_once dirname(__DIR__) . '/includes/functions.php';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    header('Content-Type: application/json');
    if (!verifyCsrfToken()) {
        echo json_encode(['success'=>false,'message'=>'Invalid request.']); exit;
    }
    $email = sanitize($_POST['email'] ?? '');
    $name  = sanitize($_POST['name'] ?? '');
    if (!isValidEmail($email)) {
        echo json_encode(['success'=>false,'message'=>'Please enter a valid email address.']); exit;
    }
    try {
        $db = getDB();
        $db->prepare('INSERT INTO vts_newsletter (email, name) VALUES (?,?) ON DUPLICATE KEY UPDATE is_active=1')->execute([$email, $name]);
        echo json_encode(['success'=>true,'message'=>'Thank you for subscribing! Welcome to the VortexSoft community.']);
    } catch (Exception $e) {
        echo json_encode(['success'=>false,'message'=>'Something went wrong. Please try again.']);
    }
    exit;
}

$pageTitle = 'Newsletter | VortexSoft Title Services LLC';
$metaDescription = 'Subscribe to the VortexSoft newsletter for the latest updates on title services, industry news, and technology innovations.';
require_once __DIR__ . '/../includes/header.php';
?>
<main>
<section class="section" style="background:linear-gradient(135deg,#38317F 0%,#1c1845 100%);min-height:70vh;display:flex;align-items:center;">
  <div class="container text-center">
    <div class="section-eyebrow" style="background:rgba(255,255,255,0.15);color:#fff;">Stay Informed</div>
    <h1 class="section-title" style="color:#fff;margin-bottom:1.25rem;">Subscribe to Our <span style="color:var(--brand-red);">Newsletter</span></h1>
    <p style="color:rgba(255,255,255,0.8);max-width:560px;margin:0 auto 2.5rem;line-height:1.7;">Get the latest updates on title services, regulatory changes, technology innovations, and industry insights from the VortexSoft team.</p>
    <form id="newsletterForm" style="max-width:520px;margin:0 auto;">
      <?= csrfInput() ?>
      <div style="display:grid;gap:0.75rem;margin-bottom:1rem;">
        <input type="text" name="name" class="form-input" placeholder="Your Full Name" style="border-radius:8px;">
        <input type="email" name="email" class="form-input" placeholder="Your Email Address" required style="border-radius:8px;">
      </div>
      <button type="submit" class="btn-primary" style="width:100%;justify-content:center;padding:1rem;">Subscribe Now</button>
      <div id="nlMessage" style="display:none;margin-top:1rem;font-weight:600;padding:0.75rem;border-radius:8px;background:rgba(255,255,255,0.1);"></div>
    </form>
    <p style="color:rgba(255,255,255,0.5);font-size:0.8rem;margin-top:1.5rem;">No spam, unsubscribe anytime. We respect your privacy.</p>
  </div>
</section>
</main>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
