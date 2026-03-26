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

    <header id="masthead" class="site-header fixed top-0 left-0 w-full z-50 border-b border-b-primary" role="banner">
        <?php (new Menu())->render(); ?>

        <div class="social-media absolute top-[calc(100%+0.75rem)] right-[50%] translate-x-[50%] sm:translate-x-0 sm:right-3 w-auto p-2 bg-primary rounded shadow-lg opacity-25 hover:opacity-100 transition-opacity">
            <?php echo (new TAW\Blocks\Atoms\SocialMedia\SocialMedia())->render(); ?>
        </div>

    </header><!-- #masthead -->

    <main id="content" class="site-main" role="main">