<?php

/**
 * Template Name: Crédito PYME
 *
 * Page template for the Crédito PYME product page.
 * Assign this template to your "Crédito PYME" page in the WordPress admin.
 */

use TAW\Core\Block\BlockRegistry;

// Queue all blocks BEFORE get_header() so assets land in <head>
BlockRegistry::queue(
    'hero_standard',
    'image_gallery',
    'content_block--benefits',
    'content_block--characteristics_pyme',
    'content_block--steps_pyme',
    'content_block--cat_info',
    'legales',
    'contact_cta'
);

get_header();
?>

<?php BlockRegistry::render('hero_standard'); ?>

<?php BlockRegistry::render('image_gallery'); ?>

<?php BlockRegistry::render('content_block--benefits'); ?>

<?php BlockRegistry::render('content_block--characteristics_pyme'); ?>

<?php BlockRegistry::render('content_block--steps_pyme'); ?>

<?php BlockRegistry::render('content_block--cat_info'); ?>

<?php BlockRegistry::render('legales'); ?>

<?php BlockRegistry::render('contact_cta'); ?>

<?php get_footer(); ?>
