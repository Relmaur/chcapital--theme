import EmblaCarousel from 'embla-carousel'
import AutoPlay from 'embla-carousel-autoplay'
import PhotoSwipeLightbox from 'photoswipe/lightbox'
import 'photoswipe/dist/photoswipe.css'

/**
 * Idempotent PhotoSwipe init — shared with LightboxImage / BlurbsGrid.
 * Uses data-pswp-ready to prevent double-initialisation.
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

function initGallery(root) {
  const viewport    = root.querySelector('.image-gallery__viewport')
  const prevBtn     = root.querySelector('.image-gallery__btn--prev')
  const nextBtn     = root.querySelector('.image-gallery__btn--next')
  const dotsWrap    = root.querySelector('.image-gallery__dots')

  if (!viewport) return

  const embla = EmblaCarousel(
    viewport,
    { loop: true, align: 'start' },
    [AutoPlay({ delay: 4000, stopOnInteraction: true })]
  )

  if (prevBtn) prevBtn.addEventListener('click', () => embla.scrollPrev())
  if (nextBtn) nextBtn.addEventListener('click', () => embla.scrollNext())

  if (dotsWrap) {
    const snapCount = embla.scrollSnapList().length

    for (let i = 0; i < snapCount; i++) {
      const btn = document.createElement('button')
      btn.type = 'button'
      btn.className = 'image-gallery__dot'
      btn.setAttribute('role', 'tab')
      btn.setAttribute('aria-label', `Imagen ${i + 1}`)
      btn.addEventListener('click', () => embla.scrollTo(i))
      dotsWrap.appendChild(btn)
    }

    const dots = [...dotsWrap.children]

    const syncDots = () => {
      const sel = embla.selectedScrollSnap()
      dots.forEach((d, i) => {
        d.classList.toggle('is-selected', i === sel)
        d.setAttribute('aria-selected', String(i === sel))
      })
    }

    embla.on('select', syncDots)
    syncDots()
  }
}

document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.image-gallery__embla').forEach(initGallery)
  initPhotoSwipe()
})
