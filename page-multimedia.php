<?php

/**
 * Template Name: Multimedia
 *
 * Page template for the Multimedia hub page (/multimedia/).
 * Assign this template to the "Multimedia" page in WordPress admin.
 *
 * Sections: Hero → Videos → Noticias → Galerías → Guías
 * Each PostGrid variation pulls the 3 most recent items from its CPT
 * and shows a "Ver más" link to the CPT archive page.
 */

use TAW\Core\Block\BlockRegistry;

BlockRegistry::queue(
    'hero_standard',
    'post_grid--videos',
    'post_grid--noticias',
    'post_grid--galerias',
    'post_grid--guias'
);

get_header();
?>

<?php BlockRegistry::render('hero_standard'); ?>

<?php BlockRegistry::render('post_grid--videos'); ?>

<?php BlockRegistry::render('post_grid--noticias'); ?>

<?php BlockRegistry::render('post_grid--galerias'); ?>

<?php BlockRegistry::render('post_grid--guias'); ?>

<?php get_footer(); ?>
