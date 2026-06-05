import PhotoSwipeLightbox from 'photoswipe/lightbox'

/**
 * Idempotent PhotoSwipe init — same pattern as LightboxImage/script.js.
 * data-pswp-ready prevents double-initialisation when both scripts load.
 */
function initPhotoSwipe() {
  document.querySelectorAll('[data-pswp-gallery]:not([data-pswp-ready])').forEach(gallery => {
    gallery.setAttribute('data-pswp-ready', '')
    new PhotoSwipeLightbox({
      gallery,
      children: 'a[data-pswp-src]',
      pswpModule: () => import('photoswipe'),
    }).init()
  })
}

// First load — guard handles both normal load and Swup script injection (readyState is already 'complete').
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initPhotoSwipe)
} else {
  initPhotoSwipe()
}
// Swup page swap — DOMContentLoaded does not re-fire after a Swup navigation,
// so app.js dispatches this custom event from its page:view hook instead.
document.addEventListener('taw:page-view', initPhotoSwipe)
