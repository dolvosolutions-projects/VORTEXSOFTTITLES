<?php
/**
 * VortexSoft Title Services LLC
 * Shared Header — HTML head + Navigation
 * 
 * Variables expected: $pageTitle, $metaDescription, $bodyClass
 */
$pageTitle       = $pageTitle ?? 'VortexSoft Title Services LLC';
$metaDescription = $metaDescription ?? 'VortexSoft Title Services delivers speed, accuracy, and scale for Title Companies and Lenders across all 50 states. 24/7 Global Operations.';
$currentPage     = basename($_SERVER['SCRIPT_FILENAME'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#38317F">
  <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1">
  <meta name="author" content="VortexSoft Title Services LLC">
  <meta name="geo.region" content="IN-KA">
  <meta name="geo.placename" content="Bengaluru, Karnataka, India">
  <meta name="geo.position" content="12.9141;77.6162">
  <meta name="ICBM" content="12.9141, 77.6162">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <meta name="description" content="<?= htmlspecialchars($metaDescription) ?>">

  <!-- Open Graph -->
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="VortexSoft Title Services LLC">
  <meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
  <meta property="og:description" content="<?= htmlspecialchars($metaDescription) ?>">
  <meta property="og:image" content="https://www.vortexsofttitles.com/assets/images/vts-20logo-20croped-20.jpg">
  <meta property="og:url" content="https://www.vortexsofttitles.com<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?= htmlspecialchars($pageTitle) ?>">
  <meta name="twitter:description" content="<?= htmlspecialchars($metaDescription) ?>">
  <meta name="twitter:image" content="https://www.vortexsofttitles.com/assets/images/vts-20logo-20croped-20.jpg">

  <!-- Schema.org JSON-LD -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@graph": [
      {
        "@type": "Corporation",
        "@id": "https://www.vortexsofttitles.com/#corporation",
        "name": "VortexSoft Title Services LLC",
        "url": "https://www.vortexsofttitles.com",
        "logo": "https://www.vortexsofttitles.com/assets/images/vts-20logo-20croped-20.jpg",
        "telephone": "+1-307-205-0681",
        "email": "Contact@vortexsofttitles.com",
        "description": "Global technology-enabled Real Estate Title & Settlement, Healthcare BPO, AI Data Annotation, Software Development, and STM Publishing enterprise.",
        "address": [
          {
            "@type": "PostalAddress",
            "streetAddress": "No.125, Ranganath Complex, Madiwala, HSR Layout 5th Sector",
            "addressLocality": "Bengaluru", "addressRegion": "Karnataka",
            "postalCode": "560068", "addressCountry": "IN"
          },
          {
            "@type": "PostalAddress",
            "streetAddress": "30 N Gould St Ste 100",
            "addressLocality": "Sheridan", "addressRegion": "WY",
            "postalCode": "82801", "addressCountry": "US"
          }
        ]
      }
    ]
  }
  </script>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="/assets/css/style.css">

  <!-- Favicon -->
  <link rel="icon" href="/icon-dark-32x32.png" media="(prefers-color-scheme: dark)">
  <link rel="icon" href="/icon-light-32x32 .png" media="(prefers-color-scheme: light)">
  <link rel="apple-touch-icon" href="/apple-icon.png">
</head>
<body class="<?= htmlspecialchars($bodyClass ?? '') ?>">

<!-- Navigation -->
<nav class="vts-nav" id="mainNav">
  <div class="nav-inner">
    <!-- Logo -->
    <a href="/" class="nav-logo">
      <img src="/assets/images/vts-20logo-20croped-20.jpg" alt="VortexSoft Title Services LLC" width="180" height="54">
    </a>

    <!-- Desktop Links -->
    <div class="nav-links">
      <a href="/" class="nav-link <?= ($currentPage === 'home' || $_SERVER['REQUEST_URI'] === '/') ? 'active' : '' ?>">Home</a>
      <a href="/services" class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], 'services') ? 'active' : '' ?>">Services</a>
      <a href="/about" class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], 'about') ? 'active' : '' ?>">About</a>
      <a href="/contact" class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], 'contact') ? 'active' : '' ?>">Contact Us</a>
    </div>

    <!-- CTA Button -->
    <div class="nav-cta">
      <a href="tel:+13072050681" class="btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.14 13 19.79 19.79 0 0 1 1.07 4.36 2 2 0 0 1 3.04 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21 17l.92-.08Z"/></svg>
        1-307-205-0681
      </a>
    </div>

    <!-- Mobile Hamburger -->
    <button class="nav-hamburger" id="navToggle" aria-label="Open Menu">
      <span></span><span></span><span></span>
    </button>
  </div>

  <!-- Mobile Menu -->
  <div class="nav-mobile" id="navMobile">
    <a href="/" class="nav-mobile-link">Home</a>
    <a href="/services" class="nav-mobile-link">Services</a>
    <a href="/about" class="nav-mobile-link">About</a>
    <a href="/contact" class="nav-mobile-link">Contact Us</a>
    <a href="tel:+13072050681" class="btn-primary mt-3">📞 1-307-205-0681</a>
  </div>
</nav>
<div class="nav-spacer"></div>
