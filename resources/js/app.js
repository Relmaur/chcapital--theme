// 1. Import Styles (so Vite knows to compile them)
import '../css/app.css';   // Tailwind v4 utilities
import '../scss/app.scss'; // Custom SCSS (fonts, etc.)

// 2. Import Alpine
import Alpine from 'alpinejs';

// 3. Expose Alpine globally so block scripts can register components via Alpine.data()
window.Alpine = Alpine;

// 4. Start Alpine on DOMContentLoaded — this fires after ALL deferred scripts
// (both ES modules and classic defer) have executed, so every block script
// has had a chance to call Alpine.data() inside its alpine:init listener.
document.addEventListener('DOMContentLoaded', () => Alpine.start());

// All anchor links must be smoothly scrolled to, even if the browser doesn't support CSS scroll-behavior: smooth
// (e.g. Safari on macOS). This is needed for the "Learn More" link in the Hero block, and any future anchor links.
document.addEventListener('DOMContentLoaded', () => {
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();
            const targetId = link.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
});