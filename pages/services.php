<?php
$pageTitle = 'Title & Mortgage Services | VortexSoft Title Services LLC';
$metaDescription = 'Comprehensive title search, tax services, settlement, mortgage support, and curative services for all 50 US states. Tech-enabled delivery with 24-48hr turnaround.';
require_once __DIR__ . '/../includes/header.php';
?>
<main>
<!-- Hero -->
<section class="section" style="background:linear-gradient(135deg,#f8f7ff 0%,#fff5f5 100%);padding-top:5rem;">
  <div class="container text-center">
    <div class="section-eyebrow">What We Offer</div>
    <h1 class="section-title">Comprehensive <span class="gradient-text">Title & Mortgage Services</span></h1>
    <p class="section-subtitle mt-3">End-to-end title support — from search to post-closing — delivered with precision across all 50 states.</p>
  </div>
</section>

<!-- Tabs: Title Services -->
<section class="section" style="padding-top:2rem;">
  <div class="container" id="title-search">
    <div class="text-center mb-8 animate-on-scroll">
      <div class="section-eyebrow">Primary Services</div>
      <h2 class="section-title">Title Search &amp; <span class="gradient-text">Abstracting Services</span></h2>
    </div>
    <div class="tabs-nav" role="tablist">
      <button class="tab-btn" data-tab="tab-search" role="tab" aria-selected="true">🔍 Title Search</button>
      <button class="tab-btn" data-tab="tab-tax" role="tab">🏦 Tax Services</button>
      <button class="tab-btn" data-tab="tab-attorney" role="tab">⚖️ Attorney</button>
      <button class="tab-btn" data-tab="tab-typing" role="tab">⌨️ Typing</button>
      <button class="tab-btn" data-tab="tab-settlement" role="tab">🤝 Settlement</button>
      <button class="tab-btn" data-tab="tab-curative" role="tab">🔧 Curative</button>
    </div>

    <!-- Title Search Tab -->
    <div class="tab-panel" id="tab-search" role="tabpanel">
      <div class="tab-content-wrap">
        <div class="tab-content-grid">
          <div>
            <h3 style="font-size:1.35rem;font-weight:800;margin-bottom:1rem;color:var(--text-primary);">Title Search &amp; Abstract Services</h3>
            <p style="color:var(--text-muted);margin-bottom:1.5rem;line-height:1.7;">Our title specialists leverage nationwide courthouse partnerships and digital record access to deliver fast, accurate title searches — all 50 states covered.</p>
            <div class="cert-badges">
              <span class="cert-badge"><span class="cert-badge-dot"></span>All 50 States</span>
              <span class="cert-badge"><span class="cert-badge-dot"></span>24-48hr Standard</span>
              <span class="cert-badge"><span class="cert-badge-dot"></span>Rush Available</span>
            </div>
          </div>
          <div class="tab-items-grid">
            <?php $items = ['Current Owner Search','Two Owner Search','Full Chain Search','O&E Report','REO/Foreclosure Search','Lien & Judgment Search','Municipal Lien Search','Field Abstractor Mgmt','UCC/Fixture Filing','Subdivision Report']; foreach ($items as $item): ?>
            <div class="tab-item"><div class="tab-item-icon">📄</div><?= $item ?></div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Tax Services Tab -->
    <div class="tab-panel" id="tab-tax" role="tabpanel">
      <div class="tab-content-wrap">
        <div class="tab-content-grid">
          <div>
            <h3 style="font-size:1.35rem;font-weight:800;margin-bottom:1rem;">Tax Services</h3>
            <p style="color:var(--text-muted);margin-bottom:1.5rem;line-height:1.7;">Complete property tax reporting and municipal lien searches to keep your transactions compliant and clear of tax encumbrances.</p>
          </div>
          <div class="tab-items-grid">
            <?php $items = ['Property Tax Report','Tax Cert Processing','Code Violation Report','Municipal Lien Search','Tax Status Verification','HOA Status Letter']; foreach ($items as $item): ?>
            <div class="tab-item"><div class="tab-item-icon">🏛️</div><?= $item ?></div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Attorney Tab -->
    <div class="tab-panel" id="tab-attorney" role="tabpanel">
      <div class="tab-content-wrap">
        <h3 style="font-size:1.35rem;font-weight:800;margin-bottom:1rem;">Attorney Opinion Services</h3>
        <p style="color:var(--text-muted);line-height:1.7;">Expert attorney opinion letters, legal status reviews and compliance verification for complex title scenarios.</p>
      </div>
    </div>

    <!-- Typing Tab -->
    <div class="tab-panel" id="tab-typing" role="tabpanel">
      <div class="tab-content-wrap">
        <div class="tab-content-grid">
          <div>
            <h3 style="font-size:1.35rem;font-weight:800;margin-bottom:1rem;" id="typing-services">Typing Services</h3>
            <p style="color:var(--text-muted);line-height:1.7;">ALTA-compliant title commitment typing and document preparation with rapid turnaround.</p>
          </div>
          <div class="tab-items-grid">
            <?php $items = ['Title Commitments','Title Policies','ALTA Schedules A&B','Gap Endorsements','Document Prep']; foreach ($items as $item): ?>
            <div class="tab-item"><div class="tab-item-icon">📝</div><?= $item ?></div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Settlement Tab -->
    <div class="tab-panel" id="tab-settlement" role="tabpanel">
      <div class="tab-content-wrap">
        <div class="tab-content-grid">
          <div>
            <h3 style="font-size:1.35rem;font-weight:800;margin-bottom:1rem;" id="settlement-services">Settlement Services</h3>
            <p style="color:var(--text-muted);line-height:1.7;">Full pre- and post-closing settlement support to keep your transactions on time.</p>
          </div>
          <div class="tab-items-grid">
            <?php $items = ['Closing Doc Prep','Disbursement Svc','Wire Verification','Post-Closing','Escrow Accounting','CD/HUD Prep']; foreach ($items as $item): ?>
            <div class="tab-item"><div class="tab-item-icon">🏠</div><?= $item ?></div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Curative Tab -->
    <div class="tab-panel" id="tab-curative" role="tabpanel">
      <div class="tab-content-wrap">
        <h3 style="font-size:1.35rem;font-weight:800;margin-bottom:1rem;">Title Curative Services</h3>
        <p style="color:var(--text-muted);line-height:1.7;">From issue identification to legal resolution — we clear title defects that stand in the way of your closing.</p>
      </div>
    </div>
  </div>
</section>

<!-- Mortgage Services -->
<section class="section" style="background:var(--brand-light);" id="mortgage-services">
  <div class="container">
    <div class="text-center mb-12 animate-on-scroll">
      <div class="section-eyebrow">Lending Support</div>
      <h2 class="section-title">Mortgage <span class="gradient-text">Support Services</span></h2>
      <p class="section-subtitle mt-3">Comprehensive back-office support for mortgage lenders and servicers</p>
    </div>
    <div class="services-grid">
      <?php $msvc = [
        ['icon'=>'📋','t'=>'Loan Processing','d'=>'Document gathering, income verification, property research, and loan file pre-underwriting review.'],
        ['icon'=>'✅','t'=>'Underwriting Support','d'=>'AUS findings review, condition clearing, title review, and compliance documentation.'],
        ['icon'=>'🏁','t'=>'Closing Support','d'=>'Closing disclosure prep, CD validation, settlement statement prep, and closing package review.'],
        ['icon'=>'📂','t'=>'Post-Closing','d'=>'Document retrieval, shipping, recording, final policy delivery, and trailing document management.'],
        ['icon'=>'🔄','t'=>'Servicing Support','d'=>'Payment processing, escrow analysis, ARM adjustments, and payoff statement generation.'],
        ['icon'=>'📊','t'=>'Quality Control','d'=>'Pre/post-fund QC audits, TRID compliance checks, and regulatory review.'],
      ]; foreach ($msvc as $s): ?>
      <div class="service-card animate-on-scroll">
        <div class="service-icon"><?= $s['icon'] ?></div>
        <h3 class="service-title"><?= $s['t'] ?></h3>
        <p class="service-desc"><?= $s['d'] ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Benefits -->
<section class="section" style="background:#fff;">
  <div class="container">
    <div class="text-center mb-12 animate-on-scroll">
      <div class="section-eyebrow">Why Choose Us</div>
      <h2 class="section-title">Service <span class="gradient-text">Benefits</span></h2>
    </div>
    <div class="benefits-grid">
      <?php $benefits = [
        ['icon'=>'⚡','t'=>'24-48hr Turnaround','d'=>'Standard ground search delivered within 24–48 hours. Rush delivery available for same-day needs.'],
        ['icon'=>'🔒','t'=>'ISO 27001 Certified','d'=>'Enterprise information security protocols protecting all your client data.'],
        ['icon'=>'🤖','t'=>'Tech-Enabled','d'=>'Integrated with Resware, Qualia, RamQuest, SoftPro and custom client systems.'],
        ['icon'=>'🌎','t'=>'All 50 States','d'=>'Deep expertise across every state\'s recording and title requirements.'],
        ['icon'=>'📞','t'=>'24/7 Support','d'=>'Dedicated account managers and around-the-clock operational support.'],
        ['icon'=>'💰','t'=>'Variable Cost','d'=>'Pay only for what you use — no fixed overheads or long-term commitments.'],
      ]; foreach ($benefits as $b): ?>
      <div class="benefit-card animate-on-scroll">
        <div class="benefit-icon" style="font-size:1.5rem;"><?= $b['icon'] ?></div>
        <h3><?= $b['t'] ?></h3>
        <p><?= $b['d'] ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- FAQ -->
<section class="section" style="background:var(--brand-light);">
  <div class="container">
    <div class="text-center mb-12 animate-on-scroll">
      <div class="section-eyebrow">FAQ</div>
      <h2 class="section-title">Frequently Asked <span class="gradient-text">Questions</span></h2>
    </div>
    <div class="faq-list" style="max-width:800px;margin:0 auto;">
      <?php $faqs = [
        ['q'=>'What states do you cover?','a'=>'VortexSoft covers all 50 US states for title search, abstracting, and related services through our network of county courthouse access and field abstractors.'],
        ['q'=>'What is your typical turnaround time?','a'=>'Standard turnaround is 24–48 hours for most title searches. Rush orders (same-day or next-morning) are available for an additional fee.'],
        ['q'=>'Which software platforms do you integrate with?','a'=>'We integrate seamlessly with Resware, Qualia, RamQuest, SoftPro, and custom client portals via API or file-based delivery.'],
        ['q'=>'How do you ensure data security?','a'=>'All data is handled under ISO 27001:2013 certified security protocols with encrypted transfers, access controls, and no offshore data residency outside secured facilities.'],
        ['q'=>'Can we scale up quickly during peak volume?','a'=>'Yes — our flexible staffing model allows rapid scaling. Clients have successfully ramped from 50 to 500+ orders per week within days.'],
        ['q'=>'What is your pricing model?','a'=>'We operate on a variable cost model — you pay per order/transaction. No setup fees, no minimum volumes, and no long-term commitments required.'],
      ]; foreach ($faqs as $faq): ?>
      <div class="faq-item">
        <button class="faq-question" type="button">
          <?= $faq['q'] ?>
          <svg class="faq-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
        </button>
        <div class="faq-answer"><div class="faq-answer-inner"><?= $faq['a'] ?></div></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="section" style="background:#fff;">
  <div class="container">
    <div class="cta-banner animate-on-scroll">
      <h2>Ready to Outsource Your Title Operations?</h2>
      <p>Talk to a specialist today and get a custom quote for your volume.</p>
      <div class="cta-actions">
        <a href="/contact" class="btn-white">Get a Free Consultation</a>
        <a href="tel:+13072050681" class="btn-white" style="background:transparent;color:#fff;border:2px solid rgba(255,255,255,0.5);">📞 1-307-205-0681</a>
      </div>
    </div>
  </div>
</section>
</main>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
