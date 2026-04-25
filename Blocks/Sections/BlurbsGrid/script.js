import PhotoSwipeLightbox from 'photoswipe/lightbox'
import 'photoswipe/dist/photoswipe.css'

/**
 * Idempotent PhotoSwipe init — same pattern as LightboxImage/script.js.
 * data-pswp-ready prevents double-initialisation when both scripts load.
 */
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-pswp-gallery]:not([data-pswp-ready])').forEach(gallery => {
    gallery.setAttribute('data-pswp-ready', '')
    new PhotoSwipeLightbox({
      gallery,
      children: 'a[data-pswp-src]',
      pswpModule: () => import('photoswipe'),
    }).init()
  })
})
