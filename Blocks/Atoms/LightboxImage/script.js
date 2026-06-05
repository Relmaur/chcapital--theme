import PhotoSwipeLightbox from 'photoswipe/lightbox'

/**
 * Initialise PhotoSwipe for every [data-pswp-gallery] on the page.
 * Idempotent: marks each gallery with data-pswp-ready so subsequent
 * calls (e.g. from other blocks sharing this script) are no-ops.
 */
function initPhotoSwipe() {
  document.querySelectorAll('[data-pswp-gallery]:not([data-pswp-ready])').forEach(gallery => {
    gallery.setAttribute('data-pswp-ready', '')

    const lightbox = new PhotoSwipeLightbox({
      gallery,
      children:      'a[data-pswp-src]',
      thumbSelector: 'img',
      pswpModule:    () => import('photoswipe'),
    })

    lightbox.on('uiRegister', function () {
      const pswp = lightbox.pswp

      // ── Caption ──────────────────────────────────────────────────────
      pswp.ui.registerElement({
        name:     'caption',
        order:    9,
        isButton: false,
        appendTo: 'root',
        onInit (el, pswp) {
          pswp.on('change', () => {
            const caption = pswp.currSlide.data.element?.dataset.pswpCaption
            el.className  = 'pswp__caption-text'
            el.innerHTML  = caption || ''
          })
        },
      })

      // ── Thumbnail strip ───────────────────────────────────────────────
      pswp.ui.registerElement({
        name:     'thumbs-strip',
        order:    10,
        isButton: false,
        appendTo: 'root',
        onInit (el, pswp) {
          const anchors = [...gallery.querySelectorAll('a[data-pswp-src]')]

          // Skip the strip for single-image galleries
          if (anchors.length <= 1) return

          el.className = 'pswp__thumbs-strip'
          pswp.element.classList.add('pswp--has-thumbs')

          const thumbEls = anchors.map((a, i) => {
            const srcImg  = a.querySelector('img')
            const thumbSrc = srcImg ? srcImg.src : (a.dataset.pswpSrc || a.getAttribute('href'))

            const btn = document.createElement('button')
            btn.type      = 'button'
            btn.className = 'pswp__thumb'
            btn.innerHTML = `<img src="${thumbSrc}" alt="" loading="lazy">`
            btn.addEventListener('click', () => pswp.goTo(i))
            el.appendChild(btn)
            return btn
          })

          pswp.on('change', () => {
            thumbEls.forEach((btn, i) => {
              btn.classList.toggle('pswp__thumb--active', i === pswp.currIndex)
            })
            thumbEls[pswp.currIndex]?.scrollIntoView({
              block: 'nearest', inline: 'center', behavior: 'smooth',
            })
          })
        },
      })
    })

    lightbox.init()
  })
}

// First page load
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initPhotoSwipe)
} else {
  initPhotoSwipe()
}
// Swup page swap — DOMContentLoaded does not re-fire after a Swup navigation,
// so app.js dispatches this custom event from its page:view hook instead.
document.addEventListener('taw:page-view', initPhotoSwipe)
