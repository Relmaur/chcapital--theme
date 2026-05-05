<?php

/**
 * Template Name: Fideicomisos
 *
 * Page template for the Fideicomisos product page.
 * Assign this template to your "Fideicomisos" page in the WordPress admin.
 */

use TAW\Core\Block\BlockRegistry;

// Queue all blocks BEFORE get_header() so assets land in <head>
BlockRegistry::queue(
    'hero_standard',
    'blurbs_grid',
    'faqs'
);

get_header();
?>

<?php BlockRegistry::render('hero_standard'); ?>
<?php BlockRegistry::render('blurbs_grid'); ?>
<?php BlockRegistry::render('faqs'); ?>
<?php BlockRegistry::render('contact_cta'); ?>

<?php get_footer(); ?>
