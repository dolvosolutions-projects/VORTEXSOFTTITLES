/**
 * VortexSoft Title Services — Frontend JS
 * Scroll animations, FAQ accordion, tab switcher, contact form AJAX, navbar scroll
 */

(function () {
  'use strict';

  /* ==========================================
     NAVBAR — scroll shadow + mobile toggle
  ========================================== */
  const nav = document.getElementById('mainNav');
  const hamburger = document.getElementById('navToggle');
  const mobileMenu = document.getElementById('navMobile');

  if (nav) {
    window.addEventListener('scroll', () => {
      nav.classList.toggle('scrolled', window.scrollY > 20);
    }, { passive: true });
  }

  if (hamburger && mobileMenu) {
    hamburger.addEventListener('click', () => {
      const open = mobileMenu.classList.toggle('open');
      hamburger.classList.toggle('open', open);
      hamburger.setAttribute('aria-label', open ? 'Close Menu' : 'Open Menu');
    });
    // Close on link click
    mobileMenu.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        mobileMenu.classList.remove('open');
        hamburger.classList.remove('open');
      });
    });
  }

  /* ==========================================
     SCROLL ANIMATIONS
  ========================================== */
  const animEls = document.querySelectorAll('.animate-on-scroll');
  if (animEls.length && 'IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
    animEls.forEach(el => observer.observe(el));
  } else {
    animEls.forEach(el => el.classList.add('visible'));
  }

  /* ==========================================
     FAQ ACCORDION
  ========================================== */
  document.querySelectorAll('.faq-item').forEach(item => {
    const btn = item.querySelector('.faq-question');
    if (!btn) return;
    btn.addEventListener('click', () => {
      const isOpen = item.classList.contains('open');
      // Close all
      document.querySelectorAll('.faq-item.open').forEach(other => {
        if (other !== item) other.classList.remove('open');
      });
      item.classList.toggle('open', !isOpen);
    });
  });

  /* ==========================================
     TABS (Title Services)
  ========================================== */
  document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const target = btn.dataset.tab;
      // Nav
      btn.closest('.tabs-nav').querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      // Panels
      document.querySelectorAll('.tab-panel').forEach(p => {
        p.classList.toggle('active', p.id === target);
      });
    });
  });
  // Activate first tab by default
  const firstTab = document.querySelector('.tab-btn');
  if (firstTab) firstTab.click();

  /* ==========================================
     STATS COUNTER ANIMATION
  ========================================== */
  function animateCounter(el) {
    const target = parseFloat(el.dataset.target);
    const duration = 1800;
    const start = performance.now();
    const isFloat = (target % 1 !== 0);
    function step(ts) {
      const progress = Math.min((ts - start) / duration, 1);
      const ease = 1 - Math.pow(1 - progress, 3);
      const val = target * ease;
      el.textContent = isFloat ? val.toFixed(1) : Math.floor(val).toLocaleString();
      if (progress < 1) requestAnimationFrame(step);
      else el.textContent = isFloat ? target.toFixed(1) : target.toLocaleString();
    }
    requestAnimationFrame(step);
  }

  if ('IntersectionObserver' in window) {
    const statsObs = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.querySelectorAll('[data-target]').forEach(animateCounter);
          statsObs.unobserve(entry.target);
        }
      });
    }, { threshold: 0.3 });
    document.querySelectorAll('.stats-section').forEach(el => statsObs.observe(el));
  }

  /* ==========================================
     CONTACT FORM — AJAX Submit
  ========================================== */
  const contactForm = document.getElementById('contactForm');
  if (contactForm) {
    contactForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const btn = contactForm.querySelector('.contact-form-btn');
      const successMsg = document.getElementById('formSuccess');
      const errorMsg = document.getElementById('formError');

      btn.disabled = true;
      btn.innerHTML = '<span>Sending...</span>';
      if (successMsg) successMsg.style.display = 'none';
      if (errorMsg) errorMsg.style.display = 'none';

      try {
        const formData = new FormData(contactForm);
        const res = await fetch('/contact', {
          method: 'POST',
          body: formData,
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await res.json();
        if (data.success) {
          if (successMsg) successMsg.style.display = 'block';
          contactForm.reset();
        } else {
          if (errorMsg) {
            errorMsg.textContent = data.message || 'Something went wrong. Please try again.';
            errorMsg.style.display = 'block';
          }
        }
      } catch (err) {
        if (errorMsg) {
          errorMsg.textContent = 'Network error. Please try again.';
          errorMsg.style.display = 'block';
        }
      } finally {
        btn.disabled = false;
        btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg> Send Message';
      }
    });
  }

  /* ==========================================
     NEWSLETTER FORM — AJAX Submit
  ========================================== */
  const nlForm = document.getElementById('newsletterForm');
  if (nlForm) {
    nlForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const btn = nlForm.querySelector('button[type=submit]');
      const msg = document.getElementById('nlMessage');
      btn.disabled = true;
      btn.textContent = 'Subscribing...';
      try {
        const res = await fetch('/newsletter', {
          method: 'POST',
          body: new FormData(nlForm),
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await res.json();
        if (msg) {
          msg.textContent = data.message;
          msg.style.display = 'block';
          msg.style.color = data.success ? '#22c55e' : '#ef4444';
        }
        if (data.success) nlForm.reset();
      } catch {
        if (msg) { msg.textContent = 'Error. Please try again.'; msg.style.display = 'block'; msg.style.color = '#ef4444'; }
      } finally {
        btn.disabled = false;
        btn.textContent = 'Subscribe';
      }
    });
  }

})();
