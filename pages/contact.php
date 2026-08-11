<?php
/**
 * VortexSoft Title Services LLC — Contact Page
 * Handles both GET (render form) and POST (AJAX submit)
 */

// Load dependencies if not already loaded (direct access)
if (!defined('ROOT_PATH')) {
    require_once dirname(__DIR__) . '/config/app.php';
    require_once dirname(__DIR__) . '/config/database.php';
    require_once dirname(__DIR__) . '/config/mail.php';
    require_once dirname(__DIR__) . '/includes/functions.php';
}

// ===== HANDLE AJAX POST =====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    header('Content-Type: application/json');

    // CSRF
    if (!verifyCsrfToken()) {
        echo json_encode(['success' => false, 'message' => 'Invalid request token. Please refresh and try again.']);
        exit;
    }

    // Sanitize inputs
    $name    = sanitize($_POST['name'] ?? '');
    $email   = sanitize($_POST['email'] ?? '');
    $phone   = sanitize($_POST['phone'] ?? '');
    $subject = sanitize($_POST['subject'] ?? '');
    $message = sanitize($_POST['message'] ?? '');

    // Validate
    $errors = [];
    if (strlen($name) < 2)    $errors[] = 'Name must be at least 2 characters.';
    if (!isValidEmail($email)) $errors[] = 'Please enter a valid email address.';
    if (strlen($message) < 10) $errors[] = 'Message must be at least 10 characters.';

    if ($errors) {
        echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
        exit;
    }

    // Save to database
    $saved = false;
    try {
        $db   = getDB();
        $stmt = $db->prepare(
            'INSERT INTO vts_contacts (name, email, phone, subject, message, ip_address) VALUES (?, ?, ?, ?, ?, ?)'
        );
        $saved = $stmt->execute([$name, $email, $phone, $subject, $message, getClientIP()]);
    } catch (Exception $e) {
        error_log('Contact DB error: ' . $e->getMessage());
    }

    // Send notification email to admin
    $adminHtml = "
    <html><body style='font-family:Inter,sans-serif;background:#f4f5f7;padding:2rem;'>
    <div style='max-width:600px;margin:0 auto;background:#fff;border-radius:12px;padding:2rem;border-top:4px solid #E31E25;'>
      <h2 style='color:#38317F;margin-bottom:1rem;'>📬 New Contact Form Submission</h2>
      <table style='width:100%;border-collapse:collapse;'>
        <tr><td style='padding:8px 0;font-weight:600;color:#2E2E2E;width:100px;'>Name:</td><td style='color:#64748B;'>" . htmlspecialchars($name) . "</td></tr>
        <tr><td style='padding:8px 0;font-weight:600;color:#2E2E2E;'>Email:</td><td style='color:#64748B;'><a href='mailto:" . htmlspecialchars($email) . "'>" . htmlspecialchars($email) . "</a></td></tr>
        <tr><td style='padding:8px 0;font-weight:600;color:#2E2E2E;'>Phone:</td><td style='color:#64748B;'>" . htmlspecialchars($phone ?: 'N/A') . "</td></tr>
        <tr><td style='padding:8px 0;font-weight:600;color:#2E2E2E;'>Subject:</td><td style='color:#64748B;'>" . htmlspecialchars($subject ?: 'N/A') . "</td></tr>
        <tr><td style='padding:8px 0;font-weight:600;color:#2E2E2E;vertical-align:top;'>Message:</td><td style='color:#64748B;white-space:pre-wrap;'>" . htmlspecialchars($message) . "</td></tr>
      </table>
      <p style='margin-top:1.5rem;padding-top:1rem;border-top:1px solid #eee;font-size:0.8rem;color:#A5A0A3;'>
        Submitted on " . date('M j, Y g:i A') . " from IP: " . getClientIP() . "
      </p>
    </div></body></html>";
    sendMail(SITE_EMAIL, 'VortexSoft Title Services', '📬 New Contact: ' . ($subject ?: 'Website Inquiry'), $adminHtml, $email);

    // Auto-reply to user
    $replyHtml = "
    <html><body style='font-family:Inter,sans-serif;background:#f4f5f7;padding:2rem;'>
    <div style='max-width:600px;margin:0 auto;background:#fff;border-radius:12px;padding:2rem;border-top:4px solid #38317F;'>
      <img src='https://www.vortexsofttitles.com/assets/images/vts-20logo-20croped-20.jpg' alt='VortexSoft' style='height:48px;margin-bottom:1.5rem;'>
      <h2 style='color:#38317F;'>Thank You, " . htmlspecialchars($name) . "!</h2>
      <p style='color:#64748B;line-height:1.7;'>We've received your message and a member of our team will reach out within <strong>24 hours</strong>.</p>
      <p style='color:#64748B;line-height:1.7;'>For urgent matters, call us directly at <strong><a href='tel:+13072050681' style='color:#E31E25;'>1-307-205-0681</a></strong></p>
      <div style='margin:1.5rem 0;padding:1rem;background:#F4F5F7;border-radius:8px;'>
        <strong style='color:#2E2E2E;'>Your message:</strong>
        <p style='color:#64748B;margin-top:0.5rem;'>" . htmlspecialchars($message) . "</p>
      </div>
      <p style='font-size:0.8rem;color:#A5A0A3;border-top:1px solid #eee;padding-top:1rem;margin-top:1.5rem;'>
        &copy; " . date('Y') . " VortexSoft Title Services LLC | 30 N Gould St Ste 100, Sheridan, WY 82801
      </p>
    </div></body></html>";
    sendMail($email, $name, 'We Received Your Message — VortexSoft Title Services', $replyHtml);

    echo json_encode(['success' => true, 'message' => 'Your message has been sent! We\'ll get back to you within 24 hours.']);
    exit;
}

// ===== RENDER CONTACT PAGE =====
$pageTitle = 'Contact Us | VortexSoft Title Services LLC';
$metaDescription = 'Get in touch with VortexSoft Title Services. Call 1-307-205-0681 or send us a message. We respond within 24 hours.';
require_once __DIR__ . '/../includes/header.php';
?>

<main>
<!-- Hero -->
<section class="section" style="background:linear-gradient(135deg,#f8f7ff 0%,#fff5f5 100%);padding-top:5rem;">
  <div class="container text-center">
    <div class="section-eyebrow">Contact Us</div>
    <h1 class="section-title">Tell Us About Your <span class="gradient-text">Requirements</span></h1>
    <p class="section-subtitle mt-3">We are ready to solve. We just need some of your time!</p>
  </div>
</section>

<!-- Contact Grid -->
<section class="section" style="padding-top:2rem;">
  <div class="container">
    <div style="display:grid;grid-template-columns:1fr;gap:3rem;" class="contact-main-grid">
      <!-- Left Info -->
      <div>
        <h2 style="font-size:1.5rem;font-weight:800;margin-bottom:1.5rem;color:var(--text-primary);">Get in Touch</h2>
        <div class="info-grid mb-8">
          <div class="info-card">
            <div class="info-icon" style="background:rgba(56,49,127,0.1);">📞</div>
            <div>
              <h4>Call Us</h4>
              <p><a href="tel:+13072050681" style="color:var(--brand-navy);font-weight:600;">1-307-205-0681</a></p>
              <p style="font-size:0.8rem;color:var(--text-muted);">24/7 Available</p>
            </div>
          </div>
          <div class="info-card">
            <div class="info-icon" style="background:rgba(227,30,37,0.1);">📧</div>
            <div>
              <h4>Email Us</h4>
              <p><a href="mailto:Contact@vortexsofttitles.com" style="color:var(--brand-red);">Contact@vortexsofttitles.com</a></p>
              <p style="font-size:0.8rem;color:var(--text-muted);">Reply within 24 hours</p>
            </div>
          </div>
          <div class="info-card">
            <div class="info-icon" style="background:rgba(56,49,127,0.1);">📍</div>
            <div>
              <h4>🇺🇸 US Office</h4>
              <p style="font-size:0.875rem;color:var(--text-muted);">30 N Gould St Ste 100, Sheridan, WY 82801</p>
            </div>
          </div>
          <div class="info-card">
            <div class="info-icon" style="background:rgba(227,30,37,0.1);">📍</div>
            <div>
              <h4>🇮🇳 India HQ</h4>
              <p style="font-size:0.875rem;color:var(--text-muted);">No.125, Ranganath Complex, HSR Layout 5th Sector, Bengaluru 560068</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Right: Contact Form -->
      <div>
        <div class="contact-form-wrap">
          <h2 style="font-size:1.35rem;font-weight:800;margin-bottom:1.5rem;color:var(--text-primary);">Send Us a Message</h2>
          <form id="contactForm" novalidate>
            <?= csrfInput() ?>
            <div class="contact-grid mb-4">
              <div class="form-group">
                <label class="form-label" for="contact-name">Your Name *</label>
                <input type="text" id="contact-name" name="name" class="form-input" placeholder="John Smith" required>
              </div>
              <div class="form-group">
                <label class="form-label" for="contact-email">Email Address *</label>
                <input type="email" id="contact-email" name="email" class="form-input" placeholder="john@company.com" required>
              </div>
            </div>
            <div class="contact-grid mb-4">
              <div class="form-group">
                <label class="form-label" for="contact-phone">Phone Number</label>
                <input type="tel" id="contact-phone" name="phone" class="form-input" placeholder="+1 (555) 000-0000">
              </div>
              <div class="form-group">
                <label class="form-label" for="contact-subject">Subject</label>
                <input type="text" id="contact-subject" name="subject" class="form-input" placeholder="Title Search Inquiry">
              </div>
            </div>
            <div class="form-group mb-6">
              <label class="form-label" for="contact-message">Message *</label>
              <textarea id="contact-message" name="message" class="form-textarea" placeholder="Tell us about your title services needs..." rows="5" required></textarea>
            </div>
            <button type="submit" class="contact-form-btn" id="submitContactBtn">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
              Send Message
            </button>
            <div class="form-success" id="formSuccess">
              ✅ Thank you! Your message has been sent. We'll reply within 24 hours.
            </div>
            <div class="form-error-msg" id="formError"></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
</main>

<style>
@media (min-width: 1024px) {
  .contact-main-grid { grid-template-columns: 1fr 1.4fr !important; }
}
</style>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
