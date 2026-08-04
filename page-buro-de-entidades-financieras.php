<?php

/**
 * Template Name: Buró de Entidades Financieras
 *
 * Page template restored from the previous site (chcapital.mx) — see the
 * Legales block's default links, which point at this page's URL.
 *
 * NOTE: the archived body copy under this title is about Escrow/PDC, not
 * CONDUSEF's actual Buró de Entidades Financieras tool — a likely
 * copy-paste bug carried over faithfully from the old site. Flagged for
 * the content owner to correct; not fixed here since this is a restoration,
 * not a rewrite.
 *
 * Assign this template to the child page under "Inicio" (home) in wp-admin.
 */

use TAW\Core\Block\BlockRegistry;

// Queue all blocks BEFORE get_header() so assets land in <head>
BlockRegistry::queue(
    'hero_standard',
    'content_block--buro_entidades'
);

get_header();
?>

<?php BlockRegistry::render('hero_standard'); ?>

<?php BlockRegistry::render('content_block--buro_entidades'); ?>

<?php get_footer(); ?>
