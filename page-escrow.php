<?php
/**
 * Template Name: Escrow
 *
 * Page template for the Escrow service page.
 * Assign this template to your "Escrow" page in the WordPress admin.
 */

use TAW\Core\Block\BlockRegistry;

// Queue all blocks BEFORE get_header() so assets land in <head>
BlockRegistry::queue(
    'hero_standard',
    'content_block--escrow_intro',
    'content_block--escrow_benefits',
    'content_block--escrow_history',
    'content_block--escrow_realestate',
    'content_block--escrow_contract',
    'faqs',
    'contact_cta'
);

get_header();
?>

<?php BlockRegistry::render('hero_standard'); ?>

<?php BlockRegistry::render('content_block--escrow_intro'); ?>

<?php BlockRegistry::render('content_block--escrow_benefits'); ?>

<?php BlockRegistry::render('content_block--escrow_history'); ?>

<?php BlockRegistry::render('content_block--escrow_realestate'); ?>

<?php BlockRegistry::render('content_block--escrow_contract'); ?>

<?php BlockRegistry::render('faqs'); ?>

<?php BlockRegistry::render('contact_cta'); ?>

<?php get_footer(); ?>
