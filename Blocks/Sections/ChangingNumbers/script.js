/**
 * ChangingNumbers Block Script
 *
 * Animates each number from 0 to its target value when it scrolls into view.
 */

const DURATION = 1800; // ms

function animateNumber(el) {
    const target  = parseInt(el.dataset.target, 10);
    const prefix  = el.dataset.prefix ?? '';
    const suffix  = el.dataset.suffix ?? '';
    const start   = performance.now();

    function step(now) {
        const elapsed  = now - start;
        const progress = Math.min(elapsed / DURATION, 1);
        // ease-out cubic
        const eased    = 1 - Math.pow(1 - progress, 3);
        const current  = Math.round(eased * target);

        el.textContent = prefix + current + suffix;

        if (progress < 1) {
            requestAnimationFrame(step);
        }
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

document.querySelectorAll('.changing_numbers .number[data-target]').forEach((el) => {
    observer.observe(el);
});
