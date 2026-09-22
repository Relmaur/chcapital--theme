<?php

/**
 * Template Name: Aviso de Privacidad
 *
 * Full Aviso de Privacidad Integral page — the long-form legal text linked
 * from the privacy consent checkbox tooltip (ContactForm) and the footer's
 * "Aviso de Privacidad" link (inc/options.php: footer_legal_privacy).
 *
 * Assign this template to the child page under "Inicio" (home) in wp-admin.
 */

use TAW\Core\Block\BlockRegistry;

// Queue all blocks BEFORE get_header() so assets land in <head>
BlockRegistry::queue(
    'hero_standard',
    'legal_document'
);

get_header();
?>

<?php BlockRegistry::render('hero_standard'); ?>

<?php BlockRegistry::render('legal_document'); ?>

<?php get_footer(); ?>
