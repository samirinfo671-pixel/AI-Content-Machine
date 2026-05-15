// ===========================
// THE AI CONTENT MACHINE
// Landing Page JavaScript
// ===========================

// FAQ Toggle
function toggleFaq(el) {
  const isOpen = el.classList.contains('open');
  document.querySelectorAll('.faq-item.open').forEach(item => item.classList.remove('open'));
  if (!isOpen) el.classList.add('open');
}

// Scroll Animations (Intersection Observer)
const observerOptions = { threshold: 0.12, rootMargin: '0px 0px -40px 0px' };
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.style.opacity = '1';
      entry.target.style.transform = 'translateY(0)';
      observer.unobserve(entry.target);
    }
  });
}, observerOptions);

document.querySelectorAll(
  '.feature-card, .pain-card, .bundle-item, .testimonial-card, .faq-item, .buy-card'
).forEach(el => {
  el.style.opacity = '0';
  el.style.transform = 'translateY(28px)';
  el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
  observer.observe(el);
});

// Sticky CTA Button (show after scrolling past hero)
const heroCta = document.getElementById('hero-cta');
let stickyCta = null;

window.addEventListener('scroll', () => {
  const heroBottom = document.querySelector('.hero').getBoundingClientRect().bottom;
  // ONLY show on Desktop (handled by window.innerWidth check)
  if (heroBottom < 0 && window.innerWidth > 768) {
    if (!stickyCta) {
      stickyCta = document.createElement('a');
      stickyCta.href = '#buy';
      stickyCta.id = 'sticky-cta';
      stickyCta.textContent = '🚀 Get Instant Access — $27';
      Object.assign(stickyCta.style, {
        position: 'fixed', bottom: '24px', left: '50%',
        transform: 'translateX(-50%)',
        background: 'linear-gradient(135deg, #F59E0B, #EF4444)',
        color: '#fff',
        fontFamily: "'Poppins', sans-serif",
        fontWeight: '700', fontSize: '16px',
        padding: '14px 32px', borderRadius: '50px',
        textDecoration: 'none', zIndex: '999',
        boxShadow: '0 8px 40px rgba(245,158,11,0.6)',
        animation: 'pulse 2s infinite',
        whiteSpace: 'nowrap',
        transition: 'opacity 0.3s, transform 0.3s'
      });
      document.body.appendChild(stickyCta);
    }
    stickyCta.style.opacity = '1';
    stickyCta.style.pointerEvents = 'auto';
  } else {
    if (stickyCta) {
      stickyCta.style.opacity = '0';
      stickyCta.style.pointerEvents = 'none';
    }
  }
});

// Countdown Timer (urgency for launch price)
function startCountdown() {
  const existing = document.querySelector('.countdown');
  if (!existing) return;

  // 48 hour countdown stored in sessionStorage
  let endTime = sessionStorage.getItem('countdownEnd');
  if (!endTime) {
    endTime = Date.now() + 48 * 60 * 60 * 1000;
    sessionStorage.setItem('countdownEnd', endTime);
  }

  const update = () => {
    const remaining = parseInt(endTime) - Date.now();
    if (remaining <= 0) {
      document.querySelector('.countdown').innerHTML = '<strong>Offer Expired</strong>';
      return;
    }
    const h = Math.floor(remaining / 3600000);
    const m = Math.floor((remaining % 3600000) / 60000);
    const s = Math.floor((remaining % 60000) / 1000);
    document.querySelector('.countdown').innerHTML =
      `⏳ Launch price expires in: <strong>${String(h).padStart(2,'0')}:${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}</strong>`;
  };
  update();
  setInterval(update, 1000);
}

// Add countdown to buy section
window.addEventListener('DOMContentLoaded', () => {
  const buyCard = document.querySelector('.buy-card');
  if (buyCard) {
    const cd = document.createElement('div');
    cd.className = 'countdown';
    cd.style.cssText = `
      background: rgba(124,58,237,0.15);
      border: 1px solid rgba(124,58,237,0.3);
      border-radius: 10px;
      padding: 10px 20px;
      font-size: 14px;
      color: #A78BFA;
      margin-bottom: 16px;
      text-align: center;
    `;
    buyCard.querySelector('.btn-buy').before(cd);
    startCountdown();
  }
});

// Smooth scroll for all anchor links
document.querySelectorAll('a[href^="#"]').forEach(link => {
  link.addEventListener('click', e => {
    const target = document.querySelector(link.getAttribute('href'));
    if (target) {
      e.preventDefault();
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  });
});

// Track buy button clicks (basic analytics)
document.querySelectorAll('#main-buy-btn, #hero-cta, .btn-msb').forEach(btn => {
  btn.addEventListener('click', () => {
    console.log('[AI Content Machine] Buy button clicked:', btn.id || 'mobile-sticky');
    // The tracking is also handled in the HTML onclick event for the main button
  });
});

// ===========================
// STUNNING EXTRAS LOGIC
// ===========================

// 1. 3D Hover Effect for Hero Book
const hero = document.querySelector('.hero');
const bookCover = document.querySelector('.book-cover');

if (hero && bookCover) {
  hero.addEventListener('mousemove', (e) => {
    const rect = hero.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    
    // Calculate rotation based on mouse position relative to center
    const centerX = rect.width / 2;
    const centerY = rect.height / 2;
    
    const rotateY = ((x - centerX) / centerX) * 15; // Max 15 deg
    const rotateX = ((centerY - y) / centerY) * 15; // Max 15 deg
    
    bookCover.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY - 10}deg)`; // -10 is base Y rotation
  });
  
  hero.addEventListener('mouseleave', () => {
    bookCover.style.transform = `rotateX(0deg) rotateY(-10deg)`;
  });
}

// 2. Mobile Sticky Buy Bar Visibility
const mobileStickyBar = document.querySelector('.mobile-sticky-bar');
if (mobileStickyBar) {
  window.addEventListener('scroll', () => {
    const heroBottom = document.querySelector('.hero').getBoundingClientRect().bottom;
    // Show only when scrolled past the hero and on mobile screens
    if (heroBottom < 0 && window.innerWidth <= 768) {
      mobileStickyBar.classList.add('visible');
    } else {
      mobileStickyBar.classList.remove('visible');
    }
  });
}

// 3. Social Proof Toast Generator
const toast = document.getElementById('social-toast');
const toastName = document.getElementById('toast-name');
const toastTime = document.getElementById('toast-time');

const firstNames = ['James', 'Sarah', 'Michael', 'Emma', 'David', 'Jessica', 'Alex', 'Amanda', 'Chris', 'Ashley', 'Ryan', 'Emily', 'John', 'Samantha', 'Matt', 'Megan', 'Joshua', 'Hannah'];
const times = ['Just now', '1 minute ago', '2 minutes ago', '4 minutes ago', '10 minutes ago', 'Just now'];

function showRandomToast() {
  if (!toast || window.innerWidth <= 768) return; // Don't show on mobile
  
  // Pick random name and time
  const randomName = firstNames[Math.floor(Math.random() * firstNames.length)];
  const randomTime = times[Math.floor(Math.random() * times.length)];
  
  toastName.textContent = randomName;
  toastTime.textContent = randomTime;
  
  // Show toast
  toast.classList.add('show');
  
  // Hide after 4 seconds
  setTimeout(() => {
    toast.classList.remove('show');
  }, 4000);
}

// 4. Dynamic Scarcity & Live Visitors
function initDynamicUrgency() {
  const scarcityText = document.querySelector('.scarcity-text strong');
  const scarcityFill = document.querySelector('.scarcity-fill');
  const heroStats = document.querySelector('.hero-stats');
  
  if (!scarcityText || !scarcityFill) return;

  // Initial values
  let copiesLeft = 14;
  let visitors = Math.floor(Math.random() * 20) + 35; // 35-55 visitors

  // Create Visitor Counter Element
  const visitorCount = document.createElement('div');
  visitorCount.className = 'visitor-counter';
  visitorCount.innerHTML = `🔥 <span id="v-num">${visitors}</span> people are viewing this offer right now`;
  Object.assign(visitorCount.style, {
    fontSize: '13px', color: '#A78BFA', fontWeight: '600',
    marginTop: '12px', opacity: '0', transition: 'opacity 0.5s'
  });
  if (heroStats) heroStats.after(visitorCount);
  setTimeout(() => visitorCount.style.opacity = '1', 1000);

  // Update visitors every 5-10 seconds
  setInterval(() => {
    const change = Math.floor(Math.random() * 5) - 2; // -2 to +2
    visitors = Math.max(31, visitors + change);
    const vNum = document.getElementById('v-num');
    if (vNum) {
      vNum.textContent = visitors;
      vNum.style.color = '#fff';
      setTimeout(() => vNum.style.color = '#A78BFA', 500);
    }
  }, 7000);

  // Decrease copies left every 2-5 minutes
  setInterval(() => {
    if (copiesLeft > 3) {
      copiesLeft--;
      scarcityText.textContent = `${copiesLeft} copies`;
      // Update progress bar
      const percentage = (copiesLeft / 50) * 100;
      scarcityFill.style.width = `${percentage}%`;
    }
  }, Math.random() * 120000 + 120000);
}

// Initialize everything
window.addEventListener('DOMContentLoaded', () => {
  initDynamicUrgency();
  
  // Start toast cycle after a delay
  setTimeout(() => {
    showRandomToast();
    setInterval(() => {
      showRandomToast();
    }, Math.floor(Math.random() * 13000) + 12000);
  }, 5000);
});

/**
 * Handle Buy Button Click (Loading & Tracking)
 */
function handleBuyClick(e) {
  const btn = document.getElementById('main-buy-btn');
  const loader = document.getElementById('buy-loader');
  const form = document.getElementById('checkout-form');

  if (form.checkValidity()) {
    // 1. Show Loading State
    btn.classList.add('loading');
    loader.style.display = 'block';

    // 2. Fire Ads Tracking
    trackPurchaseEvent();

    // 3. Submit Form (Delay slightly to ensure tracking fires)
    setTimeout(() => {
      form.submit();
    }, 400);
  } else {
    // Standard browser validation will show if email is missing
    form.reportValidity();
  }
}

/**
 * Legacy Tracking Function
 */
function trackPurchaseEvent() {
  console.log("💰 [Tracking] Purchase Intent Fired");
  if (typeof fbq === 'function') fbq('track', 'InitiateCheckout', { content_name: 'The AI Content Machine Bundle', value: 27.00, currency: 'USD' });
  if (typeof ttq === 'function') ttq.track('InitiateCheckout');
}
