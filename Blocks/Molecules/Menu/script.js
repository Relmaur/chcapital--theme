/**
 * Menu Block Script
 */

document.addEventListener('alpine:init', () => {
    Alpine.data('Menu', () => ({
        open: false,
        mobileOpen: false,
        query: '',
        results: [],
        loading: false,
        _timer: null,

        init() {
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
