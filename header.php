<?php

use TAW\Blocks\Molecules\Menu\Menu;

// Queue Menu assets before wp_head() so the <link> lands in <head>.
(new Menu())->enqueueAssets();

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <?php if (is_singular() && pings_open(get_queried_object())) : ?>
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php endif; ?>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <!-- <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'taw-theme'); ?></a> -->

    <header id="masthead" class="fixed top-0 left-0 z-50 w-full shadow-sm site-header" role="banner">
        <?php (new Menu())->render(); ?>

        <div class="social-media absolute top-[calc(100%+0.75rem)] right-3 w-auto p-2 bg-white rounded shadow-lg opacity-25 hover:opacity-100 transition-opacity border border-gray-100 sm:block hidden">
            <?php echo (new TAW\Blocks\Molecules\SocialMedia\SocialMedia())->render([
                'icon_color' => 'text-primary',
            ]); ?>
        </div>

    </header><!-- #masthead -->

    <script>
        (function() {
            var header = document.getElementById('masthead');
            if (!header) return;

            var lastWidth = null;

            function sync() {
                document.documentElement.style.setProperty('--header-height', header.getBoundingClientRect().height + 'px');
            }

            // Deliberately NOT called immediately: app.css (which carries the
            // header's real Tailwind padding/sizing utilities) loads
            // asynchronously, so a measurement taken before it applies would
            // read a too-small height and overwrite critical.scss's accurate
            // static --header-height default with a worse one — trading the
            // original large 0px-to-real jump for a smaller but still visible
            // one. critical.scss's default is already close to correct, so
            // this only needs to nudge it to the exact value once everything
            // has settled.
            window.addEventListener('load', sync, {
                once: true
            });

            // Keep in sync if the header changes height (e.g. mobile ↔ desktop breakpoint).
            // Gated on width so the mobile scroll-hide animation (height-only, see
            // Blocks/Molecules/Menu) doesn't retrigger this on every animation frame
            // and yank the page's padding-top along with it.
            if (window.ResizeObserver) {
                new ResizeObserver(function() {
                    var width = header.getBoundingClientRect().width;
                    if (width === lastWidth) return;
                    lastWidth = width;
                    sync();
                }).observe(header);
            } else {
                window.addEventListener('resize', sync, {
                    passive: true
                });
            }
        })();
    </script>

    <main id="content" class="site-main" role="main">