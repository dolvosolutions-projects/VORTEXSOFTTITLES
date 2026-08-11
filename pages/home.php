<?php
/**
 * VortexSoft Title Services LLC — Homepage
 */
$pageTitle = 'VortexSoft Title Services LLC | Real Estate Title & Settlement Services';
$metaDescription = 'VortexSoft Title Services delivers speed, accuracy, and scale for Title Companies and Lenders across all 50 states. 24/7 global operations with ISO 27001 & HIPAA certified delivery.';
require_once __DIR__ . '/../includes/header.php';
?>

<!-- ===== HERO SECTION ===== -->
<section class="vts-hero" id="home">
  <div class="hero-bg-shapes">
    <div class="hero-shape hero-shape-1"></div>
    <div class="hero-shape hero-shape-2"></div>
    <div class="hero-shape hero-shape-3"></div>
  </div>
  <div class="hero-grid"></div>
  <div class="hero-content">
    <div class="hero-badge">
      <span class="hero-badge-dot"></span>
      Comprehensive Title &amp; Mortgage Solutions
    </div>
    <h1 class="hero-title">
      Unlock Seamless<br>
      <span class="gradient-text">Title Operations</span>
    </h1>
    <p class="hero-subtitle">Maximize Profits with VortexSoft's Title Services</p>
    <div class="hero-desc">
      While all your revenue is realized at closing, all your costs are tied up in title services.
      Why opt for a high <strong>fixed cost model</strong> when you can choose a <strong>variable cost model</strong>
      with a strategic partner like VortexSoft?
    </div>
    <div class="hero-pills">
      <div class="hero-pill"><span class="hero-pill-icon">💰</span> Reduce Costs</div>
      <div class="hero-pill"><span class="hero-pill-icon">⚡</span> Increase Efficiency</div>
      <div class="hero-pill"><span class="hero-pill-icon">📈</span> Maximize Profits</div>
      <div class="hero-pill"><span class="hero-pill-icon">🌐</span> 24/7 Operations</div>
    </div>
    <div class="hero-actions">
      <a href="/contact" class="btn-navy">Get Started Today →</a>
      <a href="/services" class="btn-secondary">Explore Services</a>
    </div>
  </div>
</section>

<!-- ===== STATS SECTION ===== -->
<section class="stats-section">
  <div class="container">
    <div class="stats-grid">
      <div class="stat-card animate-on-scroll">
        <div class="stat-number"><span data-target="6" class="stat-accent">6</span>+</div>
        <div class="stat-label">Years in Business</div>
      </div>
      <div class="stat-card animate-on-scroll">
        <div class="stat-number"><span data-target="150">150</span>+</div>
        <div class="stat-label">Global Clients</div>
      </div>
      <div class="stat-card animate-on-scroll">
        <div class="stat-number"><span data-target="200">200</span>+</div>
        <div class="stat-label">Experienced Staff</div>
      </div>
      <div class="stat-card animate-on-scroll">
        <div class="stat-number"><span data-target="50">50</span></div>
        <div class="stat-label">All States Covered</div>
      </div>
    </div>
  </div>
</section>

<!-- ===== WHAT MAKES US DIFFERENT ===== -->
<section class="section" style="background:#fff;">
  <div class="container">
    <div class="text-center mb-12 animate-on-scroll">
      <div class="section-eyebrow">Our Difference</div>
      <h2 class="section-title">Why Title Companies Choose <span class="gradient-text">VortexSoft</span></h2>
      <p class="section-subtitle mt-3">A tech-enabled, compliance-first partner that scales with your business</p>
    </div>
    <div class="difference-cards">
      <?php
      $diffs = [
        ['icon'=>'🎯','title'=>'End-to-End Expertise','desc'=>'Complete title support from searches to post-closing — one seamless partner for your entire workflow.'],
        ['icon'=>'⚡','title'=>'Speed with Accuracy','desc'=>'Average 24–48 hour turnaround on ground searches. Faster delivery without sacrificing compliance.'],
        ['icon'=>'🔧','title'=>'Technology-Driven','desc'=>'Seamless integration with Resware, Qualia, RamQuest, SoftPro, and custom client platforms.'],
        ['icon'=>'🤝','title'=>'Client-Focused','desc'=>'Dedicated points of contact, proactive updates, and transparent status reporting — no surprises.'],
        ['icon'=>'🔒','title'=>'Security First','desc'=>'ISO 27001:2013 certified information security. Your data is protected with enterprise-grade protocols.'],
        ['icon'=>'📊','title'=>'Variable Cost Model','desc'=>'Pay only for what you use. Convert fixed overhead into a flexible, scalable cost structure.'],
      ];
      foreach ($diffs as $d): ?>
      <div class="diff-card animate-on-scroll">
        <span class="diff-icon"><?= $d['icon'] ?></span>
        <h3><?= $d['title'] ?></h3>
        <p><?= $d['desc'] ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ===== SERVICES OVERVIEW ===== -->
<section class="section" style="background:var(--brand-light);">
  <div class="container">
    <div class="text-center mb-12 animate-on-scroll">
      <div class="section-eyebrow">Core Services</div>
      <h2 class="section-title">Comprehensive <span class="gradient-text">Title Solutions</span></h2>
      <p class="section-subtitle mt-3">End-to-end title support backed by experienced professionals</p>
    </div>
    <div class="services-grid">
      <?php
      $services = [
        ['icon'=>'🔍','title'=>'Title Search & Abstracting','desc'=>'Current Owner, Full Search, Two Owner, O&E Reports, REO/Foreclosure, Lien & Judgment Searches, Field Abstractor Management.'],
        ['icon'=>'🏦','title'=>'Tax Services','desc'=>'Property Tax Reports, Municipal Lien Searches, Code Violation Reports, Tax Certificate Processing for the banking and title industries.'],
        ['icon'=>'⚖️','title'=>'Attorney Services','desc'=>'Attorney Opinion Letters, Legal Status Reviews, Title Legal Opinions, Compliance Verification.'],
        ['icon'=>'⌨️','title'=>'Typing Services','desc'=>'Title Commitments, Document Preparation, Policy Typing, ALTA-Compliant Documents.'],
        ['icon'=>'🤝','title'=>'Settlement Services','desc'=>'Closing Document Preparation, Disbursement Services, Wire Transfer Verification, Post-Closing Support.'],
        ['icon'=>'🔧','title'=>'Title Curative','desc'=>'Issue Identification, Document Retrieval, Legal Resolution Support, Clearance Verification.'],
      ];
      foreach ($services as $svc): ?>
      <div class="service-card animate-on-scroll">
        <div class="service-icon"><?= $svc['icon'] ?></div>
        <div>
          <h3 class="service-title"><?= $svc['title'] ?></h3>
          <p class="service-desc"><?= $svc['desc'] ?></p>
        </div>
        <a href="/services" class="btn-secondary" style="font-size:0.85rem;padding:0.5rem 1.25rem;margin-top:auto;">Learn More →</a>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ===== HOW IT WORKS ===== -->
<section class="section" style="background:#fff;">
  <div class="container">
    <div class="text-center mb-12 animate-on-scroll">
      <div class="section-eyebrow">Our Process</div>
      <h2 class="section-title">How <span class="gradient-text">VortexSoft</span> Works</h2>
    </div>
    <div class="process-steps">
      <?php
      $steps = [
        ['n'=>'01','title'=>'Submit Order','desc'=>'Place your title order via email, portal, or integrated platform.'],
        ['n'=>'02','title'=>'Research & Search','desc'=>'Our specialists retrieve and analyze public records.'],
        ['n'=>'03','title'=>'Quality Review','desc'=>'Multi-level QC check for accuracy and compliance.'],
        ['n'=>'04','title'=>'24–48hr Delivery','desc'=>'Completed report delivered to your system on time.'],
      ];
      foreach ($steps as $s): ?>
      <div class="process-step animate-on-scroll">
        <div class="process-number"><?= $s['n'] ?></div>
        <h3><?= $s['title'] ?></h3>
        <p><?= $s['desc'] ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ===== PROMISE SECTION ===== -->
<section class="section" style="background:linear-gradient(135deg,#38317F 0%,#1c1845 100%);">
  <div class="container">
    <div class="text-center mb-12 animate-on-scroll">
      <div class="section-eyebrow" style="background:rgba(255,255,255,0.15);color:#fff;">Our Guarantee</div>
      <h2 class="section-title" style="color:#fff;">The VortexSoft <span style="color:var(--brand-red);">Promise</span></h2>
    </div>
    <div class="promise-grid animate-on-scroll">
      <?php
      $promises = [
        ['icon'=>'✅','title'=>'Zero Compromise on Accuracy','desc'=>'Every report goes through multi-layer QC before delivery.'],
        ['icon'=>'⏰','title'=>'On-Time, Every Time','desc'=>'24–48 hour standard turnaround, rush orders available.'],
        ['icon'=>'🔐','title'=>'Bank-Grade Data Security','desc'=>'ISO 27001:2013 & SOC 2 aligned protocols.'],
        ['icon'=>'📞','title'=>'Dedicated Support','desc'=>'Your own point of contact available around the clock.'],
      ];
      foreach ($promises as $p): ?>
      <div class="promise-item">
        <div class="promise-icon"><?= $p['icon'] ?></div>
        <div>
          <h4><?= $p['title'] ?></h4>
          <p><?= $p['desc'] ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ===== SECONDARY ENTERPRISE SERVICES ===== -->
<section class="enterprise-section" id="secondary-enterprise-services">
  <div class="container">
    <div class="text-center mb-12 animate-on-scroll">
      <div class="section-eyebrow">Vortexsoft Group Ecosystem</div>
      <h2 class="section-title">Secondary &amp; Enterprise <span class="gradient-text">Group Services</span></h2>
      <p class="section-subtitle mt-3">Beyond our primary Title &amp; Settlement flagship, Vortexsoft Group delivers 65+ specialized enterprise services to 150+ global clients.</p>
    </div>
    <div class="enterprise-grid mb-8">
      <?php
      $cards = [
        ['bg'=>'#E31E25','badge_bg'=>'#38317F','badge'=>'HEALTHCARE BPO','title'=>'Healthcare BPO & Revenue Cycle (RCM)','desc'=>'Full-lifecycle HIPAA-compliant RCM, medical coding (ICD-10, CPT, HCPCS), billing, denial management, and prior authorization.','items'=>['Medical Coding (ICD-10-CM, CPT-4)','Revenue Cycle & AR Recovery','Claims Denial Management','Provider Credentialing & Prior Auth'],'link'=>'https://www.vortexsoftinnovations.com/service.php','link_color'=>'#38317F'],
        ['bg'=>'#38317F','badge_bg'=>'#E31E25','badge'=>'AI & AUTOMATION','title'=>'AI & Intelligent Automation','desc'=>'Autonomous AI agents, IDP (OCR/NLP), RPA workflow automation, and high-precision AI data annotation.','items'=>['Agentic AI Workflows & LLM','Intelligent Document Processing','3D LiDAR & Image Annotation','Robotic Process Automation (RPA)'],'link'=>'https://www.vortexsoftinnovations.com/service.php','link_color'=>'#E31E25'],
        ['bg'=>'#38317F','badge_bg'=>'#38317F','badge'=>'SOFTWARE & ERP','title'=>'Custom Software & Enterprise ERP','desc'=>'Tailored software, web/mobile platforms, ERP/SAP consulting, CRM/HRMS portals, microservices.','items'=>['Full-Stack Web & Mobile Engineering','Enterprise ERP & SAP Customization','CRM, HRMS & Business Portals','Cloud Modernization & APIs'],'link'=>'https://www.vortexsoftinnovations.com/service.php','link_color'=>'#38317F'],
        ['bg'=>'#E31E25','badge_bg'=>'#38317F','badge'=>'DIGITAL MARKETING','title'=>'Digital Marketing & MarTech','desc'=>'Data-driven SEO, PPC/Google Ads, social media management, and automated lead generation funnels.','items'=>['SEO & Local SEO Optimization','PPC Campaigns & Google Ads','Social Media Marketing & Brand Growth','Lead Generation Automation & Email'],'link'=>'https://www.vortexsoftinnovations.com/digital-marketing-service/index.php','link_color'=>'#E31E25'],
        ['bg'=>'#38317F','badge_bg'=>'#38317F','badge'=>'STM PUBLISHING','title'=>'STM Publishing & Media Prepress','desc'=>'Academic journal typesetting, ePUB3/XML conversion, Alt-Text writing, WCAG 2.1 AA compliance.','items'=>['Journal & STM Book Typesetting','ePUB3, Fixed Layout & XML','Alt-Text & Image Description','WCAG 2.1 AA PDF Accessibility'],'link'=>'https://www.vortexsoftinnovations.com/service.php','link_color'=>'#38317F'],
        ['bg'=>'#E31E25','badge_bg'=>'#E31E25','badge'=>'FINANCIAL BPO','title'=>'Accounting & Financial BPO','desc'=>'End-to-end bookkeeping, payroll, accounts payable/receivable, ledger reconciliation, audit & tax support.','items'=>['Full-Cycle Bookkeeping & Ledger','Payroll & Statutory Compliance','Accounts Payable & Receivable','Financial Audit & Tax Filing'],'link'=>'https://www.vortexsoftinnovations.com/service.php','link_color'=>'#E31E25'],
      ];
      foreach ($cards as $card): ?>
      <div class="enterprise-card animate-on-scroll">
        <div class="enterprise-card-header">
          <div class="enterprise-icon" style="background:<?= $card['bg'] ?>;font-size:1.5rem;">🔷</div>
          <span class="enterprise-badge" style="background:<?= $card['badge_bg'] ?>"><?= $card['badge'] ?></span>
        </div>
        <h3 class="enterprise-title"><?= $card['title'] ?></h3>
        <p class="enterprise-desc"><?= $card['desc'] ?></p>
        <ul class="enterprise-list">
          <?php foreach ($card['items'] as $item): ?>
          <li><?= $item ?></li>
          <?php endforeach; ?>
        </ul>
        <a href="<?= $card['link'] ?>" target="_blank" rel="noopener" class="enterprise-link" style="color:<?= $card['link_color'] ?>">Learn More →</a>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="enterprise-banner animate-on-scroll">
      <div>
        <span class="enterprise-banner-badge">VORTEXSOFT GROUP GLOBAL DIRECTORY</span>
        <h3>Need full enterprise IT, Healthcare, AI or Marketing solutions?</h3>
        <p>Explore all 65+ specialized offerings delivered across our global delivery centers in Bengaluru, Pune, and Wyoming, USA.</p>
      </div>
      <a href="https://www.vortexsoftinnovations.com/service.php" target="_blank" rel="noopener" class="enterprise-banner-btn">Visit Vortexsoft Group Portal ↗</a>
    </div>
  </div>
</section>

<!-- ===== CTA SECTION ===== -->
<section class="section" style="background:var(--brand-light);">
  <div class="container">
    <div class="cta-banner animate-on-scroll">
      <h2>Ready to Streamline Your Title Operations?</h2>
      <p>Join 150+ Title Companies and Lenders who trust VortexSoft for their critical title workflow needs.</p>
      <div class="cta-actions">
        <a href="/contact" class="btn-white">Get a Free Consultation</a>
        <a href="tel:+13072050681" class="btn-white" style="background:transparent;color:#fff;border:2px solid rgba(255,255,255,0.5);">📞 1-307-205-0681</a>
      </div>
    </div>

    <!-- AEO Entity Block -->
    <div class="aeo-fact-block mt-8 animate-on-scroll">
      <div class="aeo-fact-header">
        <span class="aeo-badge">VERIFIED ENTITY KNOWLEDGE BASE</span>
        <span class="aeo-cert">ISO 27001:2013 &amp; HIPAA CERTIFIED ENTERPRISE</span>
      </div>
      <h4 class="aeo-title">About VortexSoft Title Services LLC &amp; Vortexsoft Group</h4>
      <p class="aeo-text">
        <strong>VortexSoft Title Services LLC</strong> (a member of <strong>Vortexsoft Group / Vortexsoft Innovations Pvt. Ltd.</strong>)
        is an ISO 27001:2013 and ISO 9001:2015 certified global IT and Business Process Outsourcing (BPO) enterprise
        operating from dual delivery centers in <strong>Bengaluru (HSR Layout, Karnataka)</strong> and <strong>Pune (Maharashtra), India</strong>,
        with U.S. presence in <strong>Sheridan, Wyoming</strong>. VortexSoft delivers 24/7 title search, commitment typing,
        mortgage origination support, and 65+ secondary enterprise services to 150+ global clients.
      </p>
      <div class="aeo-pills">
        <div class="aeo-pill">✓ 24/7 Global Operations</div>
        <div class="aeo-pill">✓ ISO 27001 &amp; HIPAA</div>
        <div class="aeo-pill">✓ 150+ Global Clients</div>
        <div class="aeo-pill">✓ 200+ Experienced Staff</div>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
