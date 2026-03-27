/**
 * StrategicAllies Block Script
 * Initializes the marquee on each .strategic-allies__marquee container found on the page.
 */

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.strategic-allies__marquee').forEach((el) => {
        createMarquee({
            element: el,
            speedFactor: 20,
        });
    });
});
