/**
 * ChangingNumbers Block Script
 *
 * Animates each number from 0 to its target value when it scrolls into view.
 *
 * The IntersectionObserver is created once and reused across Swup navigations.
 * initChangingNumbers() finds any unregistered elements (no data-cn-ready) and
 * adds them to the observer. It runs:
 *   1. Immediately on first load (module executes after DOM is parsed).
 *   2. After every Swup content swap via the custom taw:page-view event.
 */

const DURATION = 1800; // ms

function animateNumber(el) {
    const target = parseInt(el.dataset.target, 10);
    const prefix = el.dataset.prefix ?? '';
    const suffix = el.dataset.suffix ?? '';
    const start  = performance.now();

    function step(now) {
        const elapsed  = now - start;
        const progress = Math.min(elapsed / DURATION, 1);
        // ease-out cubic
        const eased    = 1 - Math.pow(1 - progress, 3);
        const current  = Math.round(eased * target);

        el.textContent = prefix + current + suffix;

        if (progress < 1) requestAnimationFrame(step);
    }

    requestAnimationFrame(step);
}

const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        animateNumber(entry.target);
        observer.unobserve(entry.target);
    });
}, { threshold: 0.3 });

function initChangingNumbers() {
    // :not([data-cn-ready]) prevents double-observing on rapid taw:page-view
    // fires; the attribute is absent on server-rendered elements so the guard
    // is automatically cleared after every Swup content swap.
    document.querySelectorAll('.changing_numbers .number[data-target]:not([data-cn-ready])').forEach((el) => {
        el.setAttribute('data-cn-ready', '');
        observer.observe(el);
    });
}

// First load — ES modules are deferred so the DOM is ready here.
initChangingNumbers();

// Swup navigation — DOMContentLoaded does not re-fire; taw:page-view is
// dispatched by app.js from its page:view hook after every content swap.
document.addEventListener('taw:page-view', initChangingNumbers);
