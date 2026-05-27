// CSS Studio — dev only, toggled via Theme Settings → Developer Tools
if (process.env.NODE_ENV === 'development' && window.tawConfig?.cssStudioEnabled) {
  import('cssstudio').then(({ startStudio }) => startStudio());
}

// ── 1. Styles ─────────────────────────────────────────────────────────────────
import '../css/app.css';   // Tailwind v4 utilities
import '../scss/app.scss'; // Custom SCSS (fonts, transitions, etc.)

// ── 2. Alpine ─────────────────────────────────────────────────────────────────
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

Alpine.plugin(collapse);
window.Alpine = Alpine; // Expose globally so block scripts can call Alpine.data()

// ── 3. Marquee helper ─────────────────────────────────────────────────────────
import { createMarquee } from './marquee.js';
window.createMarquee = createMarquee;

// ── 4. Swup page transitions ──────────────────────────────────────────────────
import Swup             from 'swup';
import SwupHeadPlugin   from '@swup/head-plugin';
import SwupScrollPlugin from '@swup/scroll-plugin';
import SwupPreloadPlugin from '@swup/preload-plugin';

const swup = new Swup({
    // Only swap the main content area — header, footer, scripts stay untouched.
    containers: ['#content'],

    // Swup watches this selector for CSS transition-end events to know when
    // the exit animation is complete before swapping content.
    animationSelector: '#content',

    plugins: [
        // Updates <title>, meta tags, and canonical links from the incoming
        // page. persistAssets keeps JS/CSS already loaded so they're not
        // removed when the new page doesn't explicitly list them — prevents
        // previously-registered Alpine components from disappearing.
        new SwupHeadPlugin({ persistAssets: true }),

        // Scrolls to the top of the page after every navigation.
        new SwupScrollPlugin({ offset: 0, animateScroll: false }),

        // Preloads the target page on link hover/focus — makes the swap feel
        // near-instant on fast connections.
        new SwupPreloadPlugin(),
    ],

    // Don't intercept: hash-only links (handled by smooth-scroll below),
    // mailto/tel, external URLs, admin pages, new-tab links, or direct
    // media/file links (images, PDFs, etc.) — those must reach PhotoSwipe or
    // the browser's native handler without Swup interfering.
    // Swup already skips external origins and target="_blank" by default.
    ignoreVisit: (url) => {
        try {
            const u = new URL(url, window.location.href);
            // Same-page anchor navigation
            if (u.pathname === window.location.pathname && u.hash) return true;
            // WordPress admin / login
            if (u.pathname.startsWith('/wp-admin') || u.pathname.startsWith('/wp-login')) return true;
            // Media / file links — images, PDFs, ZIPs, etc.
            // PhotoSwipe calls e.preventDefault() on these; if Swup intercepts
            // first the lightbox never opens and the raw file is shown instead.
            if (/\.(jpe?g|png|gif|webp|avif|svg|bmp|pdf|zip|docx?|xlsx?)(\?.*)?$/i.test(u.pathname)) return true;
        } catch { return true; }
        return false;
    },
});

// ── 5. Alpine lifecycle with Swup ─────────────────────────────────────────────
//
// Swup does NOT re-run scripts that are already in the page — it only replaces
// DOM inside #content.  We must:
//   (a) destroy Alpine components in the OLD content before it is replaced
//   (b) initialize Alpine components in the NEW content after it is replaced
//
// `Alpine.destroyTree(el)` and `Alpine.initTree(el)` are available in Alpine ≥ 3.2.

swup.hooks.before('content:replace', () => {
    const content = document.getElementById('content');
    if (content) Alpine.destroyTree(content);
});

swup.hooks.on('content:replace', () => {
    // Close any open overlays (search, mobile drawer) before the new content
    // Alpine tree is initialized — prevents stale state bleeding across pages.
    document.dispatchEvent(
        new KeyboardEvent('keydown', { key: 'Escape', bubbles: true, cancelable: true })
    );

    const content = document.getElementById('content');
    if (content) Alpine.initTree(content);
});

// ── 6. Alpine start ───────────────────────────────────────────────────────────
//
// Start Alpine ONCE on first page load.  On subsequent Swup navigations
// the initTree / destroyTree calls above handle re-initialization.
//
// window._alpineStarted is used by block scripts to detect whether Alpine has
// already started (so they can call Alpine.data() directly instead of waiting
// for the 'alpine:init' event which only fires once on first load).

document.addEventListener('DOMContentLoaded', () => {
    Alpine.start();
    window._alpineStarted = true;
});

// ── 7. Progress bar ───────────────────────────────────────────────────────────
//
// A thin brand-colored bar at the top of the viewport gives instant feedback
// that the navigation was registered.  Driven by Swup hook events.

(function () {
    const bar = document.createElement('div');
    bar.className = 'vt-progress-bar';
    bar.setAttribute('aria-hidden', 'true');
    document.body.prepend(bar);

    let resetTimer = null;

    const showBar = () => {
        clearTimeout(resetTimer);
        bar.classList.remove('is-done', 'is-active');
        void bar.offsetWidth; // force reflow → restarts CSS animation
        bar.classList.add('is-active');
    };

    const completeBar = () => {
        clearTimeout(resetTimer);
        bar.classList.remove('is-active');
        bar.classList.add('is-done');
        resetTimer = setTimeout(() => bar.classList.remove('is-done'), 300);
    };

    swup.hooks.on('visit:start',  showBar);
    swup.hooks.on('page:view',    completeBar);
    // If navigation is aborted (e.g. network error), clean up the bar
    swup.hooks.on('visit:aborted', completeBar);
})();

// ── 8. Per-page DOM init ──────────────────────────────────────────────────────
//
// Code that needs to run both on first page load AND after every Swup swap.
// Scoped to the replaced container where possible to avoid touching the header.

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

function initOrnaments() {
    // Scope to #content so we don't double-add ornaments to the fixed header
    const root = document.getElementById('content') || document;
    root.querySelectorAll('.ch-section:not(.colored)').forEach(section => {
        if (section.querySelector('.section-ornament')) return; // already initialised
        section.appendChild(createOrnament('tr', 8, 8));
        section.appendChild(createOrnament('bl', 5, 5));
    });
}

document.addEventListener('DOMContentLoaded', initOrnaments);
swup.hooks.on('page:view', () => {
    initOrnaments();
    // Notify block scripts (gallery, lightbox, carousels) that new page content
    // is live so they can re-initialize without depending on DOMContentLoaded.
    document.dispatchEvent(new CustomEvent('taw:page-view'));
});

// ── 9. Smooth scroll for anchor links ────────────────────────────────────────
//
// Delegated to the document so it works after every Swup swap without
// re-registering per-element listeners.

document.addEventListener('click', (e) => {
    const link = e.target.closest('a[href^="#"]');
    if (!link) return;
    e.preventDefault();
    const targetId = link.getAttribute('href').substring(1);
    const target   = document.getElementById(targetId);
    if (target) target.scrollIntoView({ behavior: 'smooth' });
});
