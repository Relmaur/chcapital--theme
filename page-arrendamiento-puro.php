<?php

/**
 * Template Name: Arrendamiento Puro
 *
 * Page template for the Arrendamiento Puro product page.
 * Assign this template to your "Arrendamiento Puro" page in the WordPress admin.
 */

use TAW\Core\Block\BlockRegistry;

// Queue all blocks BEFORE get_header() so assets land in <head>
BlockRegistry::queue(
    'hero_standard',
    'image_gallery',
    'content_block--benefits',
    'content_block--characteristics',
    'content_block--steps',
    'legales',
    'contact_cta'
);

get_header();
?>

<?php BlockRegistry::render('hero_standard'); ?>

<?php BlockRegistry::render('image_gallery'); ?>

<?php BlockRegistry::render('content_block--benefits'); ?>

<?php BlockRegistry::render('content_block--characteristics'); ?>

<?php BlockRegistry::render('content_block--steps'); ?>

<?php BlockRegistry::render('legales'); ?>

<?php BlockRegistry::render('contact_cta'); ?>

<?php get_footer(); ?>
