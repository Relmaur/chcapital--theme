/**
 * Menu Block Script
 *
 * The Menu component lives in the site header which is OUTSIDE #content —
 * Swup never replaces it, so this script runs once and stays alive for the
 * whole session. We still use the same dual-registration pattern as other
 * block scripts for consistency.
 */

const registerMenu = () => {
    Alpine.data('Menu', () => ({
        open: false,
        mobileOpen: false,
        topHidden: false,
        query: '',
        results: [],
        loading: false,
        _timer: null,
        _lastScrollY: 0,
        _scrollTicking: false,

        init() {
            this._lastScrollY = window.scrollY;
            this._onScroll = () => {
                if (this._scrollTicking) return;
                this._scrollTicking = true;
                requestAnimationFrame(() => {
                    if (window.innerWidth >= 640) {
                        this._scrollTicking = false;
                        return;
                    }
                    const current    = window.scrollY;
                    const delta      = current - this._lastScrollY;
                    const nearBottom = current + window.innerHeight >= document.documentElement.scrollHeight - 60;

                    if (!nearBottom) {
                        if (delta > 5 && current > 60) {
                            this.topHidden = true;
                        } else if (delta < -5) {
                            this.topHidden = false;
                        }
                    }

                    this._lastScrollY   = current;
                    this._scrollTicking = false;
                });
            };
            window.addEventListener('scroll', this._onScroll, { passive: true });

            this.$watch('open', (val) => {
                if (val) {
                    this.$nextTick(() => this.$refs.searchInput?.focus());
                    document.body.style.overflow = 'hidden';
                } else if (!this.mobileOpen) {
                    document.body.style.overflow = '';
                }
            });

            this.$watch('mobileOpen', (val) => {
                if (val) {
                    document.body.style.overflow = 'hidden';
                } else if (!this.open) {
                    document.body.style.overflow = '';
                }
            });

            this.$watch('query', (val) => {
                clearTimeout(this._timer);
                this._timer = setTimeout(() => this.search(val), 350);
            });

            window.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    if (this.open) this.closeSearch();
                    if (this.mobileOpen) this.mobileOpen = false;
                }
            });
        },

        closeSearch() {
            this.open = false;
            this.query = '';
            this.results = [];
        },

        async search(query) {
            const labels = {
                post:       'Entrada de Blog',
                page:       'Página',
                attachment: 'Archivo',
                category:   'Categoría',
                tag:        'Etiqueta',
            };

            this.loading = true;
            try {
                const params = new URLSearchParams({ search: query, type: 'post', subtype: 'post,page', per_page: 8 });
                const res    = await fetch(`/wp-json/wp/v2/search?${params}`);

                if (!res.ok) throw new Error(res.statusText);
                const data   = await res.json();
                this.results = data.map(r => ({ ...r, subtype: labels[r.subtype?.toLowerCase()] ?? r.subtype }));
            } catch {
                this.results = [];
            } finally {
                this.loading = false;
            }
        },
    }));
};

window._alpineStarted
    ? registerMenu()
    : document.addEventListener('alpine:init', registerMenu);

// ── Active trail — Swup sync ──────────────────────────────────────────────────
//
// The menu is outside #content so Swup never re-renders it. The PHP
// isInActiveTrail() result is baked into classes at first load only.
// After every Swup navigation we re-evaluate active state in JS by comparing
// each link's pathname against window.location.pathname.

function updateActiveTrail() {
    const current = window.location.pathname;

    // Returns true if `link` is the current page or an ancestor of it.
    function inTrail(link) {
        // ── Bug 1: hash-only hrefs ────────────────────────────────────────────
        // href="#" is a common WordPress pattern for dropdown-trigger items that
        // have no page of their own. link.href resolves to the full current URL,
        // so new URL(link.href).pathname === current — making every such item
        // appear active. We must check the RAW attribute, not the resolved link.href.
        const raw = link.getAttribute('href') || '';
        if (!raw || raw === '#' || raw.startsWith('#')) return false;

        try {
            // ── Bug 2: trailing slash normalisation ───────────────────────────
            // WordPress often adds trailing slashes: '/servicios/'.
            // path + '/' would be '/servicios//', which never prefix-matches
            // '/servicios/credito-pyme/'. Strip before comparing.
            const path = new URL(link.href).pathname.replace(/\/$/, '');
            const norm = current.replace(/\/$/, '');

            // Home: exact match only — '/' would otherwise match every page.
            if (path === '') return norm === '';
            return norm === path || norm.startsWith(path + '/');
        } catch { return false; }
    }

    // ── Desktop: top-level links ──────────────────────────────────────────────
    // Iterate the wrapper div so we can inspect children when the parent is a
    // '#' dropdown-trigger with no real URL of its own.
    document.querySelectorAll('#site-navigation .relative').forEach(container => {
        const link = container.querySelector(':scope > a.menu__item');
        if (!link) return;

        const raw = link.getAttribute('href') || '';
        const isHashParent = !raw || raw === '#' || raw.startsWith('#');

        // '#' parent: active when any child page is in the trail.
        // Real-URL parent: use the standard inTrail check.
        const active = isHashParent
            ? [...container.querySelectorAll('.submenu a.menu__item')].some(child => inTrail(child))
            : inTrail(link);

        link.classList.toggle('opacity-100',       active);
        link.classList.toggle('font-semibold',     active);
        link.classList.toggle('opacity-85',        !active);
        link.classList.toggle('hover:opacity-100', !active);
        active
            ? link.setAttribute('aria-current', 'page')
            : link.removeAttribute('aria-current');
    });

    // ── Desktop: child (submenu) links ────────────────────────────────────────
    document.querySelectorAll('#site-navigation .submenu a.menu__item').forEach(link => {
        const active = inTrail(link);
        link.classList.toggle('bg-gray-100', active);
        active
            ? link.setAttribute('aria-current', 'page')
            : link.removeAttribute('aria-current');
    });

    // ── Mobile: top-level links ───────────────────────────────────────────────
    // Same logic: '#' parents are active if a child sublink is in the trail.
    document.querySelectorAll('.mobile-drawer-panel__item').forEach(item => {
        const link = item.querySelector('.mobile-drawer-panel__link');
        if (!link) return;

        const raw = link.getAttribute('href') || '';
        const isHashParent = !raw || raw === '#' || raw.startsWith('#');

        const active = isHashParent
            ? [...item.querySelectorAll('.mobile-drawer-panel__sublink')].some(child => inTrail(child))
            : inTrail(link);

        link.classList.toggle('is-active', active);
        active
            ? link.setAttribute('aria-current', 'page')
            : link.removeAttribute('aria-current');
    });

    // ── Mobile: child (sublink) links ─────────────────────────────────────────
    document.querySelectorAll('.mobile-drawer-panel__sublink').forEach(link => {
        const active = inTrail(link);
        link.classList.toggle('is-active', active);
        active
            ? link.setAttribute('aria-current', 'page')
            : link.removeAttribute('aria-current');
    });
}

// Runs after every Swup content swap (dispatched by app.js page:view hook).
document.addEventListener('taw:page-view', updateActiveTrail);
