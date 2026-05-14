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

document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.testimonials__embla').forEach(initTestimonials)
})
