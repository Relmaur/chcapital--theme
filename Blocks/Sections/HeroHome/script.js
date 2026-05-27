// Register the heroSlider Alpine component.
//
// We support two loading scenarios:
//  1. First page load   → 'alpine:init' fires → we register before Alpine starts.
//  2. Swup navigation   → Alpine already started (window._alpineStarted is set)
//     → register directly via Alpine.data() so Alpine.initTree() picks it up.

const registerHeroSlider = () => {
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
};

window._alpineStarted
    ? registerHeroSlider()
    : document.addEventListener('alpine:init', registerHeroSlider);
