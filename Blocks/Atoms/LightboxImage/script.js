import PhotoSwipeLightbox from 'photoswipe/lightbox'
import 'photoswipe/dist/photoswipe.css'

/**
 * Initialise PhotoSwipe for every [data-pswp-gallery] on the page.
 * Idempotent: marks each gallery with data-pswp-ready so subsequent
 * calls (e.g. from other blocks sharing this script) are no-ops.
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

document.addEventListener('DOMContentLoaded', initPhotoSwipe)
