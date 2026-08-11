<?php
$pageTitle = 'FAQ | VortexSoft Title Services LLC';
$metaDescription = 'Answers to frequently asked questions about VortexSoft title search services, turnaround times, pricing, security, and integrations.';
require_once __DIR__ . '/../includes/header.php';
?>
<main>
<section class="section" style="background:linear-gradient(135deg,#f8f7ff 0%,#fff5f5 100%);padding-top:5rem;">
  <div class="container text-center">
    <div class="section-eyebrow">FAQ</div>
    <h1 class="section-title">Frequently Asked <span class="gradient-text">Questions</span></h1>
    <p class="section-subtitle mt-3">Everything you need to know about working with VortexSoft</p>
  </div>
</section>
<section class="section" style="padding-top:2rem;">
  <div class="container" style="max-width:860px;">
    <?php $categories = [
      ['cat'=>'📋 Services','faqs'=>[
        ['q'=>'What title services do you provide?','a'=>'We provide comprehensive title services including Current Owner Search, Two Owner Search, Full Chain of Title, O&E Reports, REO/Foreclosure searches, Tax Certificate Processing, Municipal Lien Searches, Title Commitment Typing, Settlement Services, and Title Curative work across all 50 states.'],
        ['q'=>'Do you cover all 50 US states?','a'=>'Yes. VortexSoft has established relationships with county recorders, field abstractors, and courthouse access across all 50 US states, enabling consistent delivery nationwide.'],
        ['q'=>'What is your standard turnaround time?','a'=>'Our standard turnaround for most ground searches is 24–48 business hours. Rush delivery (same-day or next-morning) is available for urgent orders.'],
      ]],
      ['cat'=>'💻 Technology','faqs'=>[
        ['q'=>'Which software platforms do you integrate with?','a'=>'We integrate with Resware, Qualia, RamQuest, SoftPro, TitleExpress, and can also interface with custom client platforms via API, SFTP, or direct portal access.'],
        ['q'=>'Can you integrate directly with our internal system?','a'=>'Yes. Our technology team can set up custom integrations, including direct API connections, automated order routing, and file-based delivery pipelines.'],
      ]],
      ['cat'=>'🔒 Security','faqs'=>[
        ['q'=>'How do you protect our client data?','a'=>'VortexSoft is ISO 27001:2013 certified for information security. All data is transferred via encrypted channels (TLS/SSL), stored in access-controlled environments, and handled under strict data governance policies.'],
        ['q'=>'Are you HIPAA compliant?','a'=>'Yes. For our Healthcare BPO and RCM services, we maintain full HIPAA compliance with BAA agreements, audit trails, and encrypted PHI handling.'],
      ]],
      ['cat'=>'💰 Pricing','faqs'=>[
        ['q'=>'How is your pricing structured?','a'=>'We operate on a variable cost model — you pay per transaction/order with no setup fees, no minimum volumes, and no long-term contracts required. Volume discounts are available.'],
        ['q'=>'Is there a minimum order requirement?','a'=>'No. You can start with a single order and scale up as needed. Our model is designed to flex with your business volume.'],
      ]],
    ]; foreach ($categories as $cat): ?>
    <h2 style="font-size:1.2rem;font-weight:800;color:var(--brand-navy);margin:2.5rem 0 1rem;"><?= $cat['cat'] ?></h2>
    <div class="faq-list mb-8">
      <?php foreach ($cat['faqs'] as $faq): ?>
      <div class="faq-item">
        <button class="faq-question" type="button">
          <?= $faq['q'] ?>
          <svg class="faq-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
        </button>
        <div class="faq-answer"><div class="faq-answer-inner"><?= $faq['a'] ?></div></div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
    <div class="cta-banner mt-8 animate-on-scroll">
      <h2>Still have questions?</h2>
      <p>Our team is available 24/7 to help with any questions about our services.</p>
      <div class="cta-actions">
        <a href="/contact" class="btn-white">Contact Us</a>
        <a href="tel:+13072050681" class="btn-white" style="background:transparent;color:#fff;border:2px solid rgba(255,255,255,0.5);">📞 Call Now</a>
      </div>
    </div>
  </div>
</section>
</main>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
