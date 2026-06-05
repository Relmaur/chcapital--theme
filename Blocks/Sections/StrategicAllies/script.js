/**
 * StrategicAllies Block Script
 * Initializes the marquee on each .strategic-allies__marquee container found on the page.
 *
 * data-marquee-ready guards against double-init on rapid taw:page-view fires;
 * the attribute is absent on server-rendered elements so it's automatically
 * clear after every Swup content swap.
 */

function initStrategicAllies() {
    document.querySelectorAll('.strategic-allies__marquee:not([data-marquee-ready])').forEach((el) => {
        el.setAttribute('data-marquee-ready', '');
        createMarquee({
            element: el,
            speedFactor: 20,
        });
    });
}

// First load — guard handles both normal load and Swup script injection (readyState is already 'complete').
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initStrategicAllies);
} else {
    initStrategicAllies();
}
// Swup navigation — taw:page-view is dispatched by app.js after every content swap.
document.addEventListener('taw:page-view', initStrategicAllies);
