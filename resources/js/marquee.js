/**
 * Creates a continuous, interactive marquee animation on a given element.
 *
 * @param {object} options - The configuration options for the marquee.
 * @param {HTMLElement|string} options.element - The container element or a CSS selector for it.
 * @param {number} [options.speedFactor=50] - Controls the autoplay speed. Higher is faster. (Note: unit is now px/sec).
 * @param {boolean} [options.reverse=false] - If true, the marquee scrolls in reverse.
 * @param {number} [options.resumeDelay=3000] - Milliseconds to wait after user interaction before resuming autoplay.
 */
export function createMarquee(options) {
   // 1. SETUP & CONFIGURATION
   const config = {
      speedFactor: 50, // Pixels per second
      reverse: false,
      resumeDelay: 3000,
      nextSelector: null, // CSS selector for "next" navigation element(s)
      prevSelector: null, // CSS selector for "prev" navigation element(s)
      ...options,
   };

   const containerEl = typeof config.element === 'string'
      ? document.querySelector(config.element)
      : config.element;

   if (!containerEl) { console.error("Marquee container not found:", config.element); return; }
   const wrapper = containerEl.querySelector('.marquee-wrapper');
   if (!wrapper) { console.error("Marquee wrapper not found inside:", containerEl); return; }

   // --- State Variables ---
   let isDragging = false;
   let startX; // Initial mouse/touch X position
   let scrollStart; // Initial wrapper scroll position
   let currentX = 0; // The current transformX position of the wrapper
   let targetX = 0; // Target position for smooth navigation jumps
   let isNavigating = false;
   let lastFrameTime = performance.now();
   let resumeTimeout;

   // 2. DOM MANIPULATION (CLONING)
   const items = Array.from(wrapper.children);
   if (items.length <= 1) return;

   items.forEach(item => wrapper.appendChild(item.cloneNode(true)));
   const scrollWidth = wrapper.scrollWidth / 2;

   // Returns the pixel distance between two adjacent items (width + gap)
   function getItemStep() {
      const children = wrapper.children;
      if (children.length < 2) return children[0]?.offsetWidth ?? 0;
      return children[1].offsetLeft - children[0].offsetLeft;
   }

   // 3. ANIMATION LOOP (THE ENGINE)
   function animationLoop(currentTime) {
      const deltaTime = (currentTime - lastFrameTime) / 1000; // Time in seconds since last frame
      lastFrameTime = currentTime;

      if (isNavigating) {
         // Lerp smoothly towards the navigation target
         currentX += (targetX - currentX) * 0.12;
         if (Math.abs(targetX - currentX) < 0.5) {
            currentX = targetX;
            isNavigating = false;
         }
      } else if (!isDragging) {
         // Normal autoplay scroll
         const moveStep = config.speedFactor * deltaTime;
         currentX -= config.reverse ? -moveStep : moveStep;
      }

      // Loop logic: reset position when it goes past the original content width
      if (!config.reverse && currentX <= -scrollWidth) {
         currentX += scrollWidth;
         targetX += scrollWidth; // Keep target in sync
      } else if (config.reverse && currentX >= 0) {
         currentX -= scrollWidth;
         targetX -= scrollWidth;
      }

      // Apply the final transform
      wrapper.style.transform = `translateX(${currentX}px)`;

      // Continue the loop
      requestAnimationFrame(animationLoop);
   }

   // 4. NAVIGATION (next/prev selector support)
   function slideNext() {
      targetX = currentX - getItemStep();
      isNavigating = true;
      clearTimeout(resumeTimeout);
   }

   function slidePrev() {
      targetX = currentX + getItemStep();
      isNavigating = true;
      clearTimeout(resumeTimeout);
   }

   if (config.nextSelector) {
      document.querySelectorAll(config.nextSelector).forEach(el => el.addEventListener('click', slideNext));
   }
   if (config.prevSelector) {
      document.querySelectorAll(config.prevSelector).forEach(el => el.addEventListener('click', slidePrev));
   }

   // 5. EVENT HANDLERS FOR INTERACTIVITY
   function dragStart(e) {
      isDragging = true;
      clearTimeout(resumeTimeout); // Stop any pending resume
      containerEl.classList.add('is-dragging');
      startX = e.type.includes('touch') ? e.touches[0].clientX : e.clientX;
      scrollStart = currentX;

      // Add move/end listeners to the whole window for better drag experience
      window.addEventListener('mousemove', dragMove);
      window.addEventListener('touchmove', dragMove);
      window.addEventListener('mouseup', dragEnd);
      window.addEventListener('touchend', dragEnd);
      window.addEventListener('mouseleave', dragEnd); // End drag if mouse leaves window
   }

   function dragMove(e) {
      if (!isDragging) return;
      e.preventDefault(); // Prevents scrolling on touch devices
      const mouseX = e.type.includes('touch') ? e.touches[0].clientX : e.clientX;
      const walk = (mouseX - startX);
      currentX = scrollStart + walk;
   }

   function dragEnd() {
      if (!isDragging) return;
      isDragging = false;
      containerEl.classList.remove('is-dragging');

      // Normalize currentX to be within the proper range for infinite scrolling
      if (!config.reverse) {
         currentX = ((currentX % scrollWidth) + scrollWidth) % scrollWidth;
         if (currentX > 0) currentX -= scrollWidth;
      } else {
         currentX = ((currentX % scrollWidth) + scrollWidth) % scrollWidth;
         if (currentX > 0) currentX -= scrollWidth;
      }

      clearTimeout(resumeTimeout);
      resumeTimeout = setTimeout(() => {
         // The animation loop will naturally take over again
      }, config.resumeDelay);

      // Clean up global listeners
      window.removeEventListener('mousemove', dragMove);
      window.removeEventListener('touchmove', dragMove);
      window.removeEventListener('mouseup', dragEnd);
      window.removeEventListener('touchend', dragEnd);
      window.removeEventListener('mouseleave', dragEnd);
   }

   // 6. INITIALIZE
   containerEl.addEventListener('mousedown', dragStart);
   containerEl.addEventListener('touchstart', dragStart, { passive: true });

   // Prevent the browser's native image drag-and-drop behavior.
   containerEl.addEventListener('dragstart', (e) => e.preventDefault());

   // Set initial position for reverse animation
   if (config.reverse) {
      currentX = -scrollWidth;
   }

   // Start the animation loop!
   requestAnimationFrame(animationLoop);
}
