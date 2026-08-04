<?php

/**
 * Template Name: Quién Regula y Supervisa
 *
 * Page template for the "¿Quién regula y supervisa a las instituciones
 * financieras?" legal/regulatory page. Restored from the previous site
 * (chcapital.mx) — see the Legales block's default links, which point at
 * this page's URL.
 * Assign this template to the child page under "Inicio" (home) in wp-admin.
 */

use TAW\Core\Block\BlockRegistry;

// Queue all blocks BEFORE get_header() so assets land in <head>
BlockRegistry::queue(
    'hero_standard',
    'content_block--regulacion_cnbv',
    'content_block--regulacion_condusef',
    'cta',
    'content_block--regulacion_pasos'
);

get_header();
?>

<?php BlockRegistry::render('hero_standard'); ?>

<?php BlockRegistry::render('content_block--regulacion_cnbv'); ?>

<?php BlockRegistry::render('content_block--regulacion_condusef'); ?>

<?php BlockRegistry::render('cta'); ?>

<?php // BlockRegistry::render('content_block--regulacion_pasos'); ?>

<?php get_footer(); ?>
