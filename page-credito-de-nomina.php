<?php
/**
 * Template Name: Crédito de Nómina
 *
 * Page template for the Crédito de Nómina product page.
 * Assign this template to your "Crédito de Nómina" page in the WordPress admin.
 */

use TAW\Core\Block\BlockRegistry;

// Queue all blocks BEFORE get_header() so assets land in <head>
BlockRegistry::queue(
    'hero_standard',
    'content_block--company_benefits',
    'content_block--employee_benefits',
    'content_block--characteristics',
    'content_block--requirements',
    'content_block--steps',
    'testimonials',
    'content_block--cat_info',
    'faqs',
    'contact_cta'
);

get_header();
?>

<?php BlockRegistry::render('hero_standard'); ?>

<?php BlockRegistry::render('content_block--company_benefits'); ?>

<?php BlockRegistry::render('content_block--employee_benefits'); ?>

<?php BlockRegistry::render('content_block--characteristics'); ?>

<?php BlockRegistry::render('content_block--requirements'); ?>

<?php BlockRegistry::render('content_block--steps'); ?>

<?php BlockRegistry::render('testimonials'); ?>

<?php BlockRegistry::render('content_block--cat_info'); ?>

<?php BlockRegistry::render('faqs'); ?>

<?php BlockRegistry::render('contact_cta'); ?>

<?php get_footer(); ?>
