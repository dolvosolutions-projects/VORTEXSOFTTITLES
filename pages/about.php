<?php
$pageTitle = 'About VortexSoft Title Services LLC | Global Title & BPO Enterprise';
$metaDescription = 'VortexSoft Title Services LLC is an ISO 27001:2013 certified global BPO enterprise based in Bengaluru, India with US presence in Sheridan, Wyoming. Learn our story.';
require_once __DIR__ . '/../includes/header.php';
?>
<main>
<section class="section" style="background:linear-gradient(135deg,#f8f7ff 0%,#fff5f5 100%);padding-top:5rem;">
  <div class="container text-center">
    <div class="section-eyebrow">Our Story</div>
    <h1 class="section-title">About <span class="gradient-text">VortexSoft Title Services</span></h1>
    <p class="section-subtitle mt-3">A global technology-enabled enterprise built on precision, trust, and scale</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div style="display:grid;grid-template-columns:1fr;gap:3rem;" class="about-main-grid">
      <div class="animate-on-scroll">
        <div class="section-eyebrow">Who We Are</div>
        <h2 class="section-title" style="font-size:2rem;margin-bottom:1.25rem;">Precision Title Services, <span class="gradient-text">Global Scale</span></h2>
        <p style="color:var(--text-muted);line-height:1.8;margin-bottom:1.25rem;">VortexSoft Title Services LLC is a wholly owned subsidiary of <strong>Vortexsoft Innovations Pvt. Ltd.</strong> — a global IT &amp; BPO enterprise operating from delivery centers in <strong>Bengaluru (HSR Layout, Karnataka)</strong> and <strong>Pune (Maharashtra)</strong>, India, with a US presence in <strong>Sheridan, Wyoming</strong>.</p>
        <p style="color:var(--text-muted);line-height:1.8;margin-bottom:1.5rem;">Founded to solve the title industry's biggest challenge — rising fixed costs and unpredictable volume — VortexSoft delivers a true variable-cost model backed by experienced professionals, proprietary workflows, and enterprise-grade security.</p>
        <div class="cert-badges">
          <span class="cert-badge"><span class="cert-badge-dot"></span>ISO 27001:2013 Certified</span>
          <span class="cert-badge"><span class="cert-badge-dot"></span>HIPAA Compliant</span>
          <span class="cert-badge"><span class="cert-badge-dot"></span>ISO 9001:2015</span>
          <span class="cert-badge"><span class="cert-badge-dot"></span>6+ Years</span>
        </div>
      </div>
      <div>
        <div class="difference-cards animate-on-scroll">
          <?php $vals = [
            ['icon'=>'🎯','title'=>'Our Mission','desc'=>'To deliver technology-powered title and settlement services that reduce cost, accelerate closings, and drive growth for our clients.'],
            ['icon'=>'🌟','title'=>'Our Vision','desc'=>'To be the most trusted global title services partner — combining human expertise with AI-enhanced workflows.'],
            ['icon'=>'🤝','title'=>'Our Values','desc'=>'Accuracy first. Client obsession. Transparent operations. Continuous innovation. People-first culture.'],
          ]; foreach ($vals as $v): ?>
          <div class="diff-card">
            <span class="diff-icon"><?= $v['icon'] ?></span>
            <h3><?= $v['title'] ?></h3>
            <p><?= $v['desc'] ?></p>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Stats -->
<section class="stats-section">
  <div class="container">
    <div class="stats-grid">
      <div class="stat-card"><div class="stat-number"><span data-target="6">6</span>+</div><div class="stat-label">Years in Business</div></div>
      <div class="stat-card"><div class="stat-number"><span data-target="150">150</span>+</div><div class="stat-label">Global Clients</div></div>
      <div class="stat-card"><div class="stat-number"><span data-target="200">200</span>+</div><div class="stat-label">Professionals</div></div>
      <div class="stat-card"><div class="stat-number"><span data-target="50">50</span></div><div class="stat-label">US States Covered</div></div>
    </div>
  </div>
</section>

<!-- Global Presence -->
<section class="section" style="background:#fff;">
  <div class="container">
    <div class="text-center mb-12 animate-on-scroll">
      <div class="section-eyebrow">Our Locations</div>
      <h2 class="section-title">Global <span class="gradient-text">Delivery Centers</span></h2>
    </div>
    <div class="info-grid animate-on-scroll">
      <?php $offices = [
        ['flag'=>'🇮🇳','country'=>'India HQ — Bengaluru','addr'=>'No.125, Ranganath Complex, Madiwala, HSR Layout 5th Sector, Bengaluru 560068, Karnataka','role'=>'Primary Development & Operations Center'],
        ['flag'=>'🇮🇳','country'=>'India Office 2 — Pune','addr'=>'Vadgaon Budruk, Pune, Maharashtra 411041','role'=>'Secondary Operations'],
        ['flag'=>'🇺🇸','country'=>'United States — Sheridan, WY','addr'=>'30 N Gould St Ste 100, Sheridan, WY 82801','role'=>'US Registered Entity & Client Liaison'],
      ]; foreach ($offices as $o): ?>
      <div class="info-card">
        <div class="info-icon" style="background:rgba(56,49,127,0.1);font-size:1.5rem;"><?= $o['flag'] ?></div>
        <div>
          <h4><?= $o['country'] ?></h4>
          <p><?= $o['addr'] ?></p>
          <p style="font-size:0.78rem;color:var(--brand-navy);font-weight:600;margin-top:0.25rem;"><?= $o['role'] ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="section" style="background:var(--brand-light);">
  <div class="container">
    <div class="cta-banner animate-on-scroll">
      <h2>Ready to Partner with VortexSoft?</h2>
      <p>Join 150+ title companies and lenders who trust us with their most critical workflows.</p>
      <div class="cta-actions">
        <a href="/contact" class="btn-white">Contact Our Team</a>
        <a href="/services" class="btn-white" style="background:transparent;color:#fff;border:2px solid rgba(255,255,255,0.5);">Explore Services</a>
      </div>
    </div>
  </div>
</section>
</main>
<style>@media(min-width:1024px){.about-main-grid{grid-template-columns:1.2fr 1fr!important;}}</style>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
