<?php

/**
 * Template Name: Buró de Entidades Financieras
 *
 * Page template restored from the previous site (chcapital.mx) — see the
 * Legales block's default links, which point at this page's URL.
 *
 * Assign this template to the child page under "Inicio" (home) in wp-admin.
 */

use TAW\Core\Block\BlockRegistry;

// Queue all blocks BEFORE get_header() so assets land in <head>
BlockRegistry::queue(
    'hero_standard',
    'content_block--buro_entidades',
    'logo_list'
);

get_header();
?>

<?php BlockRegistry::render('hero_standard'); ?>

<?php BlockRegistry::render('content_block--buro_entidades'); ?>

<?php BlockRegistry::render('logo_list'); ?>

<?php get_footer(); ?>
