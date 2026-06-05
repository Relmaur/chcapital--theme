/**
 * PostGrid Block Script — videoModal Alpine component
 *
 * Registers a reusable Alpine component used by any section or archive page
 * that renders video cards. The component manages a fullscreen iframe modal.
 *
 * Supports both first-load (alpine:init) and Swup late-load (window._alpineStarted)
 * registration patterns.
 */

const registerVideoModal = () => {
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
};

if (window._alpineStarted) {
    registerVideoModal();
    // This script may have loaded after Alpine.initTree already ran on the new
    // content (SwupHeadPlugin injects scripts asynchronously). Re-initialize any
    // [x-data="videoModal"] elements that were skipped due to the timing gap.
    document.querySelectorAll('[x-data="videoModal"]').forEach(el => {
        Alpine.destroyTree(el);
        Alpine.initTree(el);
    });
} else {
    document.addEventListener('alpine:init', registerVideoModal);
}
