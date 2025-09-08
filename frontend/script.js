// script.js
const form = document.getElementById('search-form');
const input = document.getElementById('imageUrl');
const navToggle = document.querySelector('.nav-toggle');
const navLinks = document.querySelector('.nav-links');

navToggle?.addEventListener('click', () => {
  const isOpen = navLinks.classList.toggle('show');
  navToggle.setAttribute('aria-expanded', String(isOpen));
});

form.addEventListener('submit', (e) => {
                e.preventDefault();
  const value = input.value.trim();

  try {
    const u = new URL(value);
    // Basic image validation
    const isImage = /\.(png|jpe?g|gif|webp|svg|bmp|ico)$/i.test(u.pathname);
    if (!isImage) throw new Error('Please paste a direct image URL.');
    // “Fake” search action: open in a new tab (placeholder for downloader logic)
    window.open(u.toString(), '_blank', 'noopener,noreferrer');
    // Blur any focused button to clear hover/active visual state
    const active = document.activeElement;
    if (active && active.tagName === 'BUTTON') {
      active.blur();
    }
  } catch {
    input.focus();
    input.setSelectionRange(0, input.value.length);
    input.classList.add('shake');
    setTimeout(() => input.classList.remove('shake'), 350);
    alert('Enter a valid direct image URL.');
  }
});

// Ensure the search button returns to normal on touch devices
document.addEventListener('touchend', (e) => {
  const target = e.target;
  if (target && target.classList && (target.classList.contains('search-button') || target.closest('.search-button'))) {
    setTimeout(() => {
      if (document.activeElement && (document.activeElement.classList?.contains('search-button'))) {
        document.activeElement.blur();
      }
    }, 0);
  }
}, { passive: true });

// Small shake animation on invalid
const style = document.createElement('style');
style.textContent = `
@keyframes shake { 10%, 90% { transform: translateX(-1px); }
  20%, 80% { transform: translateX(2px); }
  30%, 50%, 70% { transform: translateX(-4px); }
  40%, 60% { transform: translateX(4px); } }
.search input.shake { animation: shake .35s; }`;
document.head.appendChild(style);