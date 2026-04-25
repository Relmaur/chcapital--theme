<?php
/**
 * Template Name: About Us — Nosotros
 *
 * Page template for the Nosotros / About Us page.
 * Assign this template to your "Nosotros" page in the WordPress admin.
 */

use TAW\Core\Block\BlockRegistry;

// 1. Queue all blocks for this page BEFORE get_header()
BlockRegistry::queue(
    'hero_standard',
    'who_are_we',
    'mision_vision_values',
    'our_team',
    'strategic_allies',
    'logo_list_about'
);

// 2. get_header() triggers wp_enqueue_scripts → assets land in <head>
get_header();
?>

<?php BlockRegistry::render('hero_standard'); ?>

<?php BlockRegistry::render('who_are_we'); ?>

<?php BlockRegistry::render('mision_vision_values'); ?>

<?php BlockRegistry::render('our_team'); ?>

<?php BlockRegistry::render('strategic_allies'); ?>

<?php BlockRegistry::render('logo_list_about'); ?>

<?php get_footer(); ?>
