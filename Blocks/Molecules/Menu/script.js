/**
 * Menu Block Script
 */

document.addEventListener('alpine:init', () => {
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
});
