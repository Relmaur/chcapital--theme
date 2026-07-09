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

// ── 4. Embla & PhotoSwipe ─────────────────────────────────────────────────────
//
// Imported here so app.js owns all block DOM initialization. This eliminates
// the timing race where a block's script.js hasn't loaded yet when page:view
// fires — app.js is always present and always runs the init on every navigation.
import EmblaCarousel    from 'embla-carousel';
import AutoPlay         from 'embla-carousel-autoplay';
import PhotoSwipeLightbox from 'photoswipe/lightbox';

// ── 5. Swup page transitions ──────────────────────────────────────────────────
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

        // Scrolls to the top of the page after every navigation. Cross-page
        // links that carry a hash (e.g. /escrow/#contact-cta from another
        // page) animate smoothly; plain top-of-page navigation still snaps
        // instantly so regular page changes don't feel sluggish.
        new SwupScrollPlugin({
            offset: 0,
            animateScroll: { betweenPages: false, samePageWithHash: true, samePage: true },
        }),

        // Preloads the target page on link hover/focus — makes the swap feel
        // near-instant on fast connections.
        new SwupPreloadPlugin(),
    ],

    // Don't intercept: hash-only links (handled by smooth-scroll below),
    // mailto/tel, external URLs, admin pages, new-tab links, or direct
    // media/file links (images, PDFs, etc.) — those must reach PhotoSwipe or
    // the browser's native handler without Swup interfering.
    // Swup already skips external origins and target="_blank" by default.
    ignoreVisit: (url, { el } = {}) => {
        try {
            const u = new URL(url, window.location.href);
            // Same-page anchor navigation
            if (u.pathname === window.location.pathname && u.hash) return true;
            // WordPress admin bar links (Edit, Edit Visually, Exit Editor, etc.)
            if (el?.closest('#wpadminbar')) return true;
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

// ── 6. Alpine lifecycle with Swup ─────────────────────────────────────────────
//
// Swup does NOT re-run scripts that are already in the page — it only replaces
// DOM inside #content.  We must:
//   (a) destroy Alpine components in the OLD content before it is replaced
//   (b) initialize Alpine components in the NEW content after it is replaced
//
// `Alpine.destroyTree(el)` and `Alpine.initTree(el)` are available in Alpine ≥ 3.2.

// Block scripts register Embla/other teardown here; cleared after each navigation.
window._tawCleanup = new Set();

swup.hooks.before('content:replace', () => {
    window._tawCleanup.forEach(fn => fn());
    window._tawCleanup.clear();

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

// ── 7. Alpine components ──────────────────────────────────────────────────────
//
// Register shared Alpine components here so they are always available,
// regardless of which block scripts have loaded. This avoids a Swup race
// condition where Alpine.initTree(content) fires on content:replace before
// the block's script.js has been injected and executed by SwupHeadPlugin.

Alpine.data('videoModal', () => ({
    isOpen:   false,
    embedUrl: '',

    openVideo(url) {
        this.embedUrl = url;
        this.isOpen   = true;
        document.documentElement.style.overflow = 'hidden';
    },

    close() {
        this.isOpen   = false;
        this.embedUrl = '';
        document.documentElement.style.overflow = '';
    },
}));

// ── 8. Alpine start ───────────────────────────────────────────────────────────
//
// Start Alpine ONCE on first page load.  On subsequent Swup navigations
// the initTree / destroyTree calls above handle re-initialization.

document.addEventListener('DOMContentLoaded', () => {
    Alpine.start();
    window._alpineStarted = true;
});

// ── 8. Progress bar ───────────────────────────────────────────────────────────
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

// ── 9. Per-page DOM init ──────────────────────────────────────────────────────
//
// ALL block DOM initialisation lives in the functions below so that it runs on
// every page view (DOMContentLoaded + every Swup page:view) without depending
// on individual block scripts having loaded.  Block scripts keep their own
// taw:page-view listeners as a safety fallback, but the guards (data-*-ready /
// data-pswp-ready) prevent any double-initialisation.

// ── Ornaments ─────────────────────────────────────────────────────────────────

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
    const root = document.getElementById('content') || document;
    root.querySelectorAll('.ch-section:not(.colored)').forEach(section => {
        if (section.querySelector('.section-ornament')) return;
        section.appendChild(createOrnament('tr', 8, 8));
        section.appendChild(createOrnament('bl', 5, 5));
    });
}

// ── Image gallery (Embla) ─────────────────────────────────────────────────────

function initGalleries() {
    document.querySelectorAll('.image-gallery__embla:not([data-gallery-ready])').forEach(root => {
        const viewport = root.querySelector('.image-gallery__viewport');
        if (!viewport) return;

        const prevBtn  = root.querySelector('.image-gallery__btn--prev');
        const nextBtn  = root.querySelector('.image-gallery__btn--next');
        const dotsWrap = root.querySelector('.image-gallery__dots');

        const embla = EmblaCarousel(
            viewport,
            { loop: true, align: 'start' },
            [AutoPlay({ delay: 4000, stopOnInteraction: true })]
        );

        if (prevBtn) prevBtn.addEventListener('click', () => embla.scrollPrev());
        if (nextBtn) nextBtn.addEventListener('click', () => embla.scrollNext());

        if (dotsWrap) {
            const snapCount = embla.scrollSnapList().length;
            for (let i = 0; i < snapCount; i++) {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'image-gallery__dot';
                btn.setAttribute('role', 'tab');
                btn.setAttribute('aria-label', `Imagen ${i + 1}`);
                btn.addEventListener('click', () => embla.scrollTo(i));
                dotsWrap.appendChild(btn);
            }
            const dots = [...dotsWrap.children];
            const syncDots = () => {
                const sel = embla.selectedScrollSnap();
                dots.forEach((d, i) => {
                    d.classList.toggle('is-selected', i === sel);
                    d.setAttribute('aria-selected', String(i === sel));
                });
            };
            embla.on('select', syncDots);
            syncDots();
        }

        root.setAttribute('data-gallery-ready', '');
        window._tawCleanup.add(() => embla.destroy());
    });
}

// ── Testimonials (Embla) ──────────────────────────────────────────────────────

function initTestimonials() {
    document.querySelectorAll('.testimonials__embla:not([data-testimonials-ready])').forEach(root => {
        const viewport = root.querySelector('.testimonials__viewport');
        if (!viewport) return;

        const prevBtn  = root.querySelector('.testimonials__btn--prev');
        const nextBtn  = root.querySelector('.testimonials__btn--next');
        const dotsWrap = root.querySelector('.testimonials__dots');

        const embla = EmblaCarousel(viewport, { loop: true, align: 'start' });

        if (prevBtn) prevBtn.addEventListener('click', () => embla.scrollPrev());
        if (nextBtn) nextBtn.addEventListener('click', () => embla.scrollNext());

        if (dotsWrap) {
            const snapCount = embla.scrollSnapList().length;
            for (let i = 0; i < snapCount; i++) {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'testimonials__dot';
                btn.setAttribute('role', 'tab');
                btn.setAttribute('aria-label', `Testimonio ${i + 1}`);
                btn.addEventListener('click', () => embla.scrollTo(i));
                dotsWrap.appendChild(btn);
            }
            const dots = [...dotsWrap.children];
            const syncDots = () => {
                const sel = embla.selectedScrollSnap();
                dots.forEach((d, i) => {
                    d.classList.toggle('is-selected', i === sel);
                    d.setAttribute('aria-selected', String(i === sel));
                });
            };
            embla.on('select', syncDots);
            syncDots();
        }

        root.setAttribute('data-testimonials-ready', '');
        window._tawCleanup.add(() => embla.destroy());
    });
}

// ── PhotoSwipe lightbox ───────────────────────────────────────────────────────

function initPhotoSwipe() {
    document.querySelectorAll('[data-pswp-gallery]:not([data-pswp-ready])').forEach(gallery => {
        gallery.setAttribute('data-pswp-ready', '');

        const lightbox = new PhotoSwipeLightbox({
            gallery,
            children:      'a[data-pswp-src]',
            thumbSelector: 'img',
            pswpModule:    () => import('photoswipe'),
        });

        lightbox.on('uiRegister', function () {
            const pswp = lightbox.pswp;

            // Caption
            pswp.ui.registerElement({
                name: 'caption', order: 9, isButton: false, appendTo: 'root',
                onInit(el) {
                    pswp.on('change', () => {
                        const caption = pswp.currSlide.data.element?.dataset.pswpCaption;
                        el.className = 'pswp__caption-text';
                        el.innerHTML = caption || '';
                    });
                },
            });

            // Thumbnail strip
            pswp.ui.registerElement({
                name: 'thumbs-strip', order: 10, isButton: false, appendTo: 'root',
                onInit(el) {
                    const anchors = [...gallery.querySelectorAll('a[data-pswp-src]')];
                    if (anchors.length <= 1) return;

                    el.className = 'pswp__thumbs-strip';
                    pswp.element.classList.add('pswp--has-thumbs');

                    const thumbEls = anchors.map((a, i) => {
                        const srcImg   = a.querySelector('img');
                        const thumbSrc = srcImg ? srcImg.src : (a.dataset.pswpSrc || a.getAttribute('href'));
                        const btn      = document.createElement('button');
                        btn.type      = 'button';
                        btn.className = 'pswp__thumb';
                        btn.innerHTML = `<img src="${thumbSrc}" alt="" loading="lazy">`;
                        btn.addEventListener('click', () => pswp.goTo(i));
                        el.appendChild(btn);
                        return btn;
                    });

                    pswp.on('change', () => {
                        thumbEls.forEach((btn, i) => btn.classList.toggle('pswp__thumb--active', i === pswp.currIndex));
                        thumbEls[pswp.currIndex]?.scrollIntoView({ block: 'nearest', inline: 'center', behavior: 'smooth' });
                    });
                },
            });
        });

        lightbox.init();
    });
}

// ── Strategic Allies (marquee) ────────────────────────────────────────────────

function initStrategicAllies() {
    document.querySelectorAll('.strategic-allies__marquee:not([data-marquee-ready])').forEach(el => {
        el.setAttribute('data-marquee-ready', '');
        createMarquee({ element: el, speedFactor: 20 });
    });
}

// ── Changing Numbers (count-up on scroll) ─────────────────────────────────────

const _cnObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        const el     = entry.target;
        const target = parseInt(el.dataset.target, 10);
        const prefix = el.dataset.prefix ?? '';
        const suffix = el.dataset.suffix ?? '';
        const start  = performance.now();
        const DURATION = 1800;

        _cnObserver.unobserve(el);
        (function step(now) {
            const progress = Math.min((now - start) / DURATION, 1);
            const eased    = 1 - Math.pow(1 - progress, 3);
            el.textContent = prefix + Math.round(eased * target) + suffix;
            if (progress < 1) requestAnimationFrame(step);
        })(start);
    });
}, { threshold: 0.3 });

function initChangingNumbers() {
    document.querySelectorAll('.changing_numbers .number[data-target]:not([data-cn-ready])').forEach(el => {
        el.setAttribute('data-cn-ready', '');
        _cnObserver.observe(el);
    });
}

// ── Run everything ────────────────────────────────────────────────────────────

function initAll() {
    initOrnaments();
    initGalleries();
    initTestimonials();
    initPhotoSwipe();
    initStrategicAllies();
    initChangingNumbers();
}

document.addEventListener('DOMContentLoaded', initAll);

swup.hooks.on('page:view', () => {
    initAll();
    // Notify block scripts that still listen to this event (Alpine components,
    // any third-party integrations added later).
    document.dispatchEvent(new CustomEvent('taw:page-view'));
});

// ── 10. Smooth scroll for anchor links ───────────────────────────────────────
//
// Delegated to the document so it works after every Swup swap without
// re-registering per-element listeners. Matches both bare "#id" hrefs and
// full-path links that resolve to the current page (e.g. "/escrow/#contact-cta"
// typed into a CTA button field) — ignoreVisit above already keeps Swup from
// intercepting either form, so this is what actually performs the scroll.

document.addEventListener('click', (e) => {
    const link = e.target.closest('a[href]');
    if (!link) return;

    const href = link.getAttribute('href');
    if (!href || href === '#') return;

    let url;
    try {
        url = new URL(href, window.location.href);
    } catch {
        return;
    }

    const samePath = url.pathname.replace(/\/$/, '') === window.location.pathname.replace(/\/$/, '');
    if (!samePath || !url.hash) return;

    const target = document.getElementById(decodeURIComponent(url.hash.substring(1)));
    if (!target) return;

    e.preventDefault();
    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
});
