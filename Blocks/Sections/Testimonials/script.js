import EmblaCarousel from 'embla-carousel'

function initTestimonials(root) {
  const viewport = root.querySelector('.testimonials__viewport')
  const prevBtn  = root.querySelector('.testimonials__btn--prev')
  const nextBtn  = root.querySelector('.testimonials__btn--next')
  const dotsWrap = root.querySelector('.testimonials__dots')

  if (!viewport) return

  const embla = EmblaCarousel(viewport, { loop: true, align: 'start' })

  if (prevBtn) prevBtn.addEventListener('click', () => embla.scrollPrev())
  if (nextBtn) nextBtn.addEventListener('click', () => embla.scrollNext())

  if (dotsWrap) {
    const snapCount = embla.scrollSnapList().length

    for (let i = 0; i < snapCount; i++) {
      const btn = document.createElement('button')
      btn.type = 'button'
      btn.className = 'testimonials__dot'
      btn.setAttribute('role', 'tab')
      btn.setAttribute('aria-label', `Testimonio ${i + 1}`)
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

function initPage() {
  // data-testimonials-ready guards against double-init; the attribute is absent
  // on server-rendered elements so it's automatically clear after every Swup swap.
  document.querySelectorAll('.testimonials__embla:not([data-testimonials-ready])').forEach(root => {
    root.setAttribute('data-testimonials-ready', '')
    initTestimonials(root)
  })
}

// First load — guard handles both normal load and Swup script injection (readyState is already 'complete').
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initPage)
} else {
  initPage()
}
// Swup navigation — taw:page-view is dispatched by app.js after every content swap.
document.addEventListener('taw:page-view', initPage)
