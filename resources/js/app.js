// CSS Studio — dev only, toggled via Theme Settings → Developer Tools
if (process.env.NODE_ENV === 'development' && window.tawConfig?.cssStudioEnabled) {
  import('cssstudio').then(({ startStudio }) => startStudio());
}

// 1. Import Styles (so Vite knows to compile them)
import '../css/app.css';   // Tailwind v4 utilities
import '../scss/app.scss'; // Custom SCSS (fonts, etc.)

// 2. Import Alpine
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

// 3. Expose createMarquee globally so any block script can call it without imports
import { createMarquee } from './marquee.js';
window.createMarquee = createMarquee;

Alpine.plugin(collapse);

// 3. Expose Alpine globally so block scripts can register components via Alpine.data()
window.Alpine = Alpine;

// 4. Start Alpine on DOMContentLoaded — this fires after ALL deferred scripts
// (both ES modules and classic defer) have executed, so every block script
// has had a chance to call Alpine.data() inside its alpine:init listener.
document.addEventListener('DOMContentLoaded', () => Alpine.start());

// ── Section ornament dots ─────────────────────────────────────────

function createOrnament(position, cols, rows) {
    const wrap = document.createElement('div');
    wrap.className = `section-ornament section-ornament--${position}`;
    wrap.setAttribute('aria-hidden', 'true');
    wrap.style.setProperty('--cols', cols);
    wrap.style.setProperty('--rows', rows);

    for (let i = 0; i < cols * rows; i++) {
        const dot = document.createElement('span');
        dot.className = 'section-ornament__dot';
        dot.style.setProperty('--dur',   `${(Math.random() * 3 + 2).toFixed(2)}s`);
        dot.style.setProperty('--delay', `${(Math.random() * 5).toFixed(2)}s`);
        dot.style.setProperty('--scale', `${(Math.random() * 0.8 + 1.6).toFixed(2)}`);
        wrap.appendChild(dot);
    }
    return wrap;
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.ch-section:not(.colored)').forEach(section => {
        section.appendChild(createOrnament('tr', 8, 8));
        section.appendChild(createOrnament('bl', 5, 5));
    });
});

// ─────────────────────────────────────────────────────────────────

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