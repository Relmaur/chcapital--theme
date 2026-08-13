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

            // Run immediately — the header is the last thing parsed at this point,
            // so this happens before the browser paints anything below it. The
            // previous version of this script lived in footer.php gated on
            // 'load', which delayed the --header-height flip from 0px to its
            // real value until every image/font on the page had finished
            // downloading — a multi-second-late layout shift (measured CLS ~1.8).
            sync();

            // Re-sync after full load in case a web font swap (font-display: swap)
            // or the async app.css finishing load altered the header's final height.
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