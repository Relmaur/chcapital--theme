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

window._alpineStarted
    ? registerVideoModal()
    : document.addEventListener('alpine:init', registerVideoModal);
