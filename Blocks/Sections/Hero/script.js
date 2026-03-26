document.addEventListener('alpine:init', () => {
    Alpine.data('heroSlider', ({ total, interval = 5000 }) => ({
        current: 0,

        init() {
            if (total > 1) {
                setInterval(() => {
                    this.current = (this.current + 1) % total;
                }, interval);
            }
        },
    }));
});
